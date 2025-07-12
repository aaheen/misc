<?php
/* Mod Manager 14 Editor for mod parameters

   Public Methods:
      $this->show_editor( $cfgpath );
      $this->update_parameter( $param = array() );
      $this->restore_parameter( $param = array() );

   Only the value of the first occurrence of a variable is now edited in each
   file. This applies to both target files and mod configuration file. Parameter
   names in mod configuration files must be unique.

  Class is included in, and managed by admin_modeditor.php
*/
// v14.0.5.1

require_once 'classes/modparser.class.php';

#[AllowDynamicProperties]
class modeditor extends modparser
{

  function __construct($objinits)
  {
    // admtext.php update needed
    $objinits['admtext']['typematch'] = 'Typematch';
    parent::__construct($objinits);
  }

  protected $cfg_file_contents = '';
  protected $is_target = false;

  protected $active_target_file = '';
  protected $target_file = '';
  protected $mod_status = '';
  protected $target_file_contents = '';

  public function show_editor(string $cfgpath): bool
  {
    $this->mod_status = '';

    /* Get a parse table for this mod. */
    $this->parse($cfgpath);

    /* Handle fatal parse error. */
    if (!empty($this->parse_error)) {
      $this->modname = $name = pathinfo($cfgpath, PATHINFO_BASENAME);
      $this->mod_status = self::ERRORS;
      $idx = $this->parse_error['text'];
      $this->add_logevent("<span class=\"msgerror\">$name</span> <span class=\"hilighterr msgbold\"> E:" . __LINE__ . " {$this->admtext[$idx]}</span>");
      $this->write_eventlog();
      return false;
    }

    /* Remove everything but target, parameter and desc directives. */
    $this->parse_table = $this->clean_parse_table($this->parse_table);

    /* Get the mod config file name from the file path. */
    $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);

    /* log the mod parameter change. */
    $this->new_logevent("{$this->admtext['editing']} <strong>$cfgpath</strong>");

    if (!$this->open_mod_file($cfgpath, $readonly = true)) {
      // Display error and exit
    }

    $params_table = array();

    # Process global, cleaned parse_table to create a parameter_datapack and
    # desc_datapack for each %parameter and %desc pair.  Then combine them into
    # a $param array for each %parameter and collect the $param arrays
    # into a local $params_table for further processing.
    for ($i = 0; isset($this->parse_table[$i]); $i++) {
      if ($this->parse_table[$i]['name'] == 'target') {
        if (!$this->open_target_file($this->parse_table[$i], $readonly = true)) {
          continue;
        }
      }
      # Create %parameter and %desc datapacks from cfg file directives
      # and use them to build a table of $param arrys for the
      # Option Edit %parameter panels.
      elseif ($this->parse_table[$i]['name'] == 'parameter') {
        if ($this->is_target) {
          $param = $this->build_param($i);
          $params_table[] = $param;
        } else {
          continue;
        }
      }
    } // $params_table

    $this->display_edit_panels($params_table);
    return true;
  } // show_editor()

  # %parameter and %desc datapacks pulled by Modeditor from the parse_table.
  # Function uses input data to build a params table from the open target file.
  # the $param data will be used to display panels in the
  # to create a $param array for use in display separate edit panels in the
  # Options Editor screen.
  /**
   * @param int $i (index into parse table)
   * @return array (param pack to display an edit panel)
   */
  protected function build_param(int $i): array
  {
    # Take $i as index into parse table, parameter line
    # Pull parameter, choices or range, and desc from parse table
    # Combine them to Build complete param pack

    $parameter_datapack = $this->parse_table[$i++];

    if ($this->parse_table[$i]['name'] == 'choices') {
      $choices_datapack = $this->parse_table[$i++];
    } elseif ($this->parse_table[$i]['name'] == 'range') {
      $range_datapack = $this->parse_table[$i++];
    }

    if ($this->parse_table[$i]['name'] == 'desc') {
      $desc_datapack = $this->parse_table[$i++];
    }

    $param = array();
    $varname = preg_quote($parameter_datapack['arg1']);

    # Search current target file for $varname as numeric value
    $numvar_reg = "#^\s*(" . $varname . "\s*=\s*)()([+-]?\d+(\.\d+)?|(\.\d+))#m";

    # Search current target file for $varname as boolean value
    $boolvar_reg = "#^\s*(" . $varname . "\s*=\s*)()(true|false);#im";

    # Search current target file for $varname as string value
    $strvar_reg = "#^\s*(" . $varname . "\\s*=\\s*([\'\"]))([\s\S]*?(?=\";|\';))\\2;#ms";

    if (!preg_match($numvar_reg, $this->target_file_contents, $matches)) {
      if (!preg_match($boolvar_reg, $this->target_file_contents, $matches)) {
        if (!preg_match($strvar_reg, $this->target_file_contents, $matches)) {
          $this->mod_status = self::ERRORS;

          $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['tgtfile']} </span> <span class=\"hilighterr msgbold\">{$this->admtext['noparam']}: {$parameter_datapack['arg1']}</span>");
          $this->mod_status = self::ERRORS;
          $this->write_eventlog();
          header("Location: admin_showmodslog.php");
          exit;
        }
      }
    }

    # Combine the datapacks into a $param pack that will be used
    # to display a panel in the Options Editor.
    $param['val'] = strlen($matches[3]) == 0 ? '' : htmlspecialchars($matches[3]);
    //$param['val'] = htmlspecialchars($matches[3]);
    $param['def'] = $desc_datapack['arg2'];
    $param['tgt'] = $this->active_target_file;
    $param['cfg'] = $this->cfgpath;
    $param['param'] = $parameter_datapack['arg1'];
    $param['quot'] = $matches[2];
    $param['label'] = $desc_datapack['arg1'];

    if ($param['quot'] == '+' || $param['quot'] == '-') {
      $param['val'] = $param['quot'] . $param['val'];
      $param['quot'] = '';
    }

    $param['choices'] = isset($choices_datapack) ? $choices_datapack['arg1'] : '';
    $param['low'] = isset($range_datapack) ? $range_datapack['arg1'] : '';
    $param['high'] = isset($range_datapack) ? $range_datapack['arg2'] : '';

    return $param;
  } // build_param()

  # $param input is from the edit form fed back to admin_modeditor.php
  # It contains additional information about the form.
  # String val arrives exactly as entered - must strip user added surrounding quotes

  /**
   * @param array $newparam (parameter datapack)
   * @return bool (success)
   */
  public function update_parameter(array $newparam): bool
  {
    /*  parameter-desc datapack map
    **  $newparam['val'] == current value of parameter in target file
    **  $newparam['mod'] == name of mod
    **  $newparam['version'] mod version
    **  $newparam['def'] == default value of paramete
    **  $newparam['tgt'] == target file path
    **  $newparam['cfg'] == mod file path
    **  $newparam['param'] == variable parameter
    **  $newparam['label'] == description detail from %desc directive
    **  $newparam['choices'] == List of acceptable inputs
    **  $newparam['low'] == lowest allowable value for numeric input
    **  $newparam['high'] == Highest allowable value for numeric input
    */

    $this->modname = $newparam['mod'];
    $this->version = $newparam['version'];
    $this->new_logevent("{$this->admtext['updparam']} {$newparam['param']}: <span class=\"msgbold\">{$newparam['tgt']}</span> {$this->admtext['formodname']} <span class=\"msgbold\">{$newparam['mod']}</span>");

    $this->cfgpath = $newparam['cfg'];
    $this->cfgfile = pathinfo($newparam['cfg'], PATHINFO_BASENAME);

    if (!is_writable($newparam['cfg'])) {
      $this->mod_status = self::ERRORS;
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cannotopen']}</span> <span class=\"hilighterr msgbold\">{$newparam['mod']}</span>");
      $this->add_logevent("{$this->admtext['fileperms']} ({$newparam['cfg']})");
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    if (!is_writable($newparam['tgt'])) {
      $this->mod_status = self::ERRORS;
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cannotopen']}</span> <span class=\"hilighterr msgbold\">{$newparam['tgt']}</span>");
      $this->add_logevent("{$this->admtext['fileperms']} ({$newparam['tgt']})");
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    $newval = trim($newparam['val']);
    $varname = preg_quote($newparam['param']); // might use '$' in file name

    /*******************************************************************
    OPEN TARGET FILE AND ANALYZE EXISTING PARAMETER
     *******************************************************************/

    # Read target file into buffer to update parameter value.
    $this->target_file_contents = $this->read_file_buffer($newparam['tgt']);

    # Capture all up to and including an opening quotation mark
    #if there is one.

    # Search current target file for $varname as numeric value
    $numvar_reg = "#^\s*(" . $varname . "\s*=\s*)()([+-]?\d+(\.\d+)?|(\.\d+))#m";

    # Search current target file for $varname as boolean value
    $boolvar_reg = "#^\s*(" . $varname . "\s*=\s*)()(true|false);#im";

    # Search current target file for $varname as string value
    $strvar_reg = "#^\s*(" . $varname . "\\s*=\\s*([\'\"]))([\s\S]*?(?=\";|\';))\\2;#ms";

    if (!preg_match($numvar_reg, $this->target_file_contents, $matches)) {
      if (!preg_match($boolvar_reg, $this->target_file_contents, $matches)) {
        if (! preg_match($strvar_reg, $this->target_file_contents, $matches)) {
          $this->mod_status = self::ERRORS;

          $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['tgtfile']} </span> <span class=\"hilighterr msgbold\">{$this->admtext['noparam']}: {$newparam['arg1']}</span>");
          $this->mod_status = self::ERRORS;
          $this->write_eventlog();
          header("Location: admin_showmodslog.php");
          exit;
        } else {
          $vartype = 'string';
          if (!is_string($newval))
            return true;
        }
      } else {
        $vartype = 'boolean';
        if (strtoupper($newval) != 'TRUE' && strtoupper($newval) != 'FALSE')
          return true;
      }
    } else {
      $vartype = "number";

      if (!is_numeric($newval))
        return true;
    }

    $searchstr = $matches[1]; // everything before the actual variable value
    $tgtquotchar = trim($matches[2]); // target file quote character, if any
    $targetval = $matches[3]; // current value to be replaced (no quotes)
    $length = strlen($targetval); // length of current value to be replaced

    if ($targetval == $newval) return true;

    /***************************************************************
    CHOICES - VALIDATE CHOICE ($newval)
     ***************************************************************/
    if (!empty($newparam['choices'])) {
      $choices = explode(",", $newparam['choices']);
      $choices[] = '!2#$%^&';  // Dummy to mark end of list + 1

      foreach ($choices as $choice) {
        $choice = trim($choice);
        if (strtoupper(trim($newval)) == strtoupper(trim($choice))) {
          $newval = $choice;
          break;
        }
      }

      if (strtoupper(trim($newval)) != strtoupper(trim($choice))) {
        return true; // Reject input without error
      } else {
        $newval = trim($choice);
      }
    } // choices
    /***************************************************************
    RANGE - VALIDATE IN RANGE ($newval)
     ***************************************************************/
    elseif (is_numeric($newparam['low']) || is_numeric($newparam['high'])) {

      # Both low and high must be numbers
      if (!is_numeric($newparam['low']) || !is_numeric($newparam['high'])) {
        $this->mod_status = self::ERRORS;
        $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['tgt']} %range {$this->admtext['errors']}</span>");
        $this->write_eventlog();
        header("Location: admin_showmodslog.php");
        exit;
      }

      # Doesn't really matter if range runs low to high or high to low.
      $low = min($newparam['low'], $newparam['high']);
      $high = max($newparam['low'], $newparam['high']);

      if ($newval < $low || $newval > $high) {
        return true;
      }
    } // range

    /***************************************************************
    STRING - ESCAPE INTERNAL QUOTES AND VALIDATE ($newval)
     ***************************************************************/
    elseif (!empty($tgtquotchar)) {
      if (strlen($newval) > 1) {
        # Honor PHP escaped quote characters
        //$newval = str_replace('\"',"&#34;", $newval);
        //$newval = str_replace("\'", "&#39;", $newval);
        $newval = preg_replace('|\\\"|m', "&#34;", $newval);
        $newval = preg_replace("|\\\'|m", "&#39;", $newval);

        if ($newval[0] == '"' && $newval[strlen($newval) - 1] == '"') {
          # Remove user provided surrounding double quotes from newval
          $newval = substr($newval, 1, -1);
        } elseif ($newval[0] == "'" && $newval[strlen($newval) - 1] == "'") {
          # # Remove user provided surrounding single quotes from newval
          $newval = substr($newval, 1, -1);
        }
      }

      if (!empty($newval)) {
        # Check newval for conflicting internal double quotes
        if ($tgtquotchar == '"') {
          while (false !== $pos = strpos($newval, "\""))
          //if( false !== $pos = strpos($newval, "\""))
          {
            $newval = substr_replace($newval, "&#34;", $pos, 1);
          }
        }

        # Check newval for conflicting internal single quotes
        if ($tgtquotchar == "'") {
          while (false !== $pos = strpos($newval, "'"))
          //if( false !== $pos = strpos($newval, "'"))
          {
            $newval = substr_replace($newval, "&#39;", $pos, 1);
          }
        }
      }
    } // string check
    /***************************************************************
    NUMBER OR BOOLEAN ($newval)
     ***************************************************************/
    # validate boolean
    else {
      if (strlen($newval) == 0) return true;

      if ($vartype == 'boolean') {
        if (
          strtoupper($newval) != 'TRUE'
          && strtoupper($newval) != 'FALSE'
        ) {
          # Abort -- the replacement is not boolean
          return true;
        }
      }

      # validate number
      elseif ($vartype == 'number') {
        if (!is_numeric($newval)) {
          # Abort -- the replacement is empty
          return true;
        }
      }

      # Unknown error
      else {
        $this->mod_status = self::ERRORS;
        $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['tgt']} %parameter {$this->admtext['errors']}</span>");
        $this->write_eventlog();
        header("Location: admin_showmodslog.php");
        exit;
      }
    }

    /*******************************************************************
    UPDATE TARGET FILE WITH NEW PARAMETER
     *******************************************************************/
    # Position pointer ($rpos) at end of the search string.
    $len = strlen($targetval);

    $rpos = strpos($this->target_file_contents, $searchstr) + strlen($searchstr);

    if ($rpos !== false) {
      $this->target_file_contents = substr_replace($this->target_file_contents, $newval, $rpos, $len);
    }
    // VERIFY TARGET FILE BUFFER HAS BEEN UPDATED
    $newvar = $searchstr . $newval;

    if (false === strpos($this->target_file_contents, $newvar)) {
      $this->mod_status = self::ERRORS;
      //$this->show_log_errors = true;
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['tgt']} %parameter:% {$newparam['param']}</span>");
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    $this->add_logevent("<span class=\"msgapproved\">{$newparam['tgt']}: {$newparam['param']} {$this->admtext['updated']}</span> ($newval)");

    /*******************************************************************
    UPDATE MOD CONFIG FILE WITH NEW PARAMETER VALUE
     *******************************************************************/
    $config_file_contents = $this->read_file_buffer($newparam['cfg']);

    /* Ensure that the variable assignment is unique in the CFG file. */
    $count = substr_count($config_file_contents, $searchstr);
    if ($count > 1) {
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['cfg']} %parameter:% {$newparam['param']}</span>");
      $this->mod_status = self::CANTUPD;
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    $ppos = strpos($config_file_contents, $searchstr);
    if ($ppos !== false) {
      $ppos += strlen($searchstr);
      $len = strlen($targetval);

      $config_file_contents = substr_replace($config_file_contents, $newval, $ppos, $len);

      /* VERIFY $VAR=VAL WAS WRITTEN TO CFG FILE BUFFER */
      $newvar = $searchstr . $newval;
      if (false === strpos($config_file_contents, $newvar)) {
        $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['cfg']} %parameter:% {$newparam['param']}</span>");
        $this->mod_status = self::CANTUPD;
        $this->write_eventlog();
        header("Location: admin_showmodslog.php");
        exit;
      }
    }

    # Next, Update the %parameter line val for backward compatibility.
    # Maintain case of the directive
    $regex = "#(%parameter:" . $varname . ":\\s*)([^%]*)%#i";
    $replacement = "\${1}" . $newval . "%";

    $config_file_contents = preg_replace($regex, $replacement, $config_file_contents);

    $newstr = '%parameter:' . stripslashes($varname) . ':' . $newval . '%';

    if (false === stripos($config_file_contents, $newstr)) {
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['cfg']} %$replacement</span>");
      $this->mod_status = self::CANTUPD;
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    } else {
      $this->add_logevent("<span class=\"msgapproved\">{$newparam['cfg']}: $replacement {$this->admtext['updated']}</span> ($newval)");
    }

    /*******************************************************************
      WRITE UPDATED BUFFERS
     *******************************************************************/
    if (!$this->write_file_buffer($newparam['tgt'], $this->target_file_contents)) {
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['tgt']} %parameter:% {$newparam['param']}</span>");
      $this->mod_status = self::CANTUPD;
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    if (!$this->write_file_buffer($newparam['cfg'], $config_file_contents)) {
      $this->add_logevent("<span class=\"msgerror\"> E:" . __LINE__ . " {$this->admtext['cantupd']}</span> <span class=\"hilighterr msgbold\">{$newparam['cfg']} %parameter:% {$newparam['param']}</span>");
      $this->mod_status = self::CANTUPD;
      $this->write_eventlog();
      header("Location: admin_showmodslog.php");
      exit;
    }

    /* If we get here -- all's good! */
    if ($count == 1) {
      $this->add_logevent("<span class=\"msgapproved\">{$newparam['cfg']}: {$newparam['param']} {$this->admtext['updated']}</span> ($newval)");
    }
    $this->mod_status = self::UPDATED;
    $this->write_eventlog();
    return true;
  } // update_parameter()

  /**
   * @param array $param (parameter datapack) 
   * @return bool 
   */
  public function restore_parameter(array $param): bool
  {
    /*  parameter-desc datapack map
    **  $param['val'] == current value of parameter in target file
    **  $param['mod'] == name of mod
    **  $param['version'] mod version
    **  $param['def'] == default value of parameter
    **  $param['tgt'] == target file path
    **  $param['cfg'] == mod file path
    **  $param['param'] == variable parameter
    **  $param['label'] == description detail from %desc directive
    */
    $param['val'] = trim($param['def'], "'\"");

    return $this->update_parameter($param);
  } // restore_parameter()

  protected function display_edit_panels($params_table)
  {
    echo "
<div class='admin-main'>
<div class='tableFixedHead'>
<table id='mmtable' class='mmtable'>
  <thead>
    <tr>
      <th class='center'>
        <div class=\"fieldnameback fieldname\">{$this->admtext['edopts']}: $this->cfgfile</div>
      </th>
    </tr>
  </thead>
  <tr>
    <td>
";

    if (!is_writable($this->cfgpath)) {
      echo "
<span style=\"color:red;\">{$this->admtext['cfgnowrite']}</span>";
      exit;
    }

    # Show the parameters editing form panels. Submitted $param array with
    # new value is POSTed back to admin_modeditor.php for processing.
    # each %parameter panel is has unique id - forme_index.

    # Don't return $param values directly because they can be confused with
    # original params in target file. We can use the TNG breakout data

    $index = 0;

    foreach ($params_table as $param) {
      $insitu = html_entity_decode($param['quot'] . $param['val'] . $param['quot']);

      // Allows MME to display exactly what was written to target file
      //$insitu = htmlspecialchars($insitu);

      $index++;
      $formindex = 'forme_' . $index;
      $relpath = str_replace($this->rootpath, '', $param['tgt']);

      echo "
<form method='post' action='' class='forme' id=$formindex>
<table class='nested'>
<tr>
  <td class=\"databack edpanel mmleftcol\" >
{$param['label']}
   </td>
   <td class=\"databack edpanel mmrightcol\">
      <div style='font-size:1.1em;'>$relpath: {$param['param']} = $insitu</div>
      <textarea style='width:75%' name=\"param[val]\">{$param['val']}</textarea>
      <input type='hidden' name='param[forme]' value='$formindex' />
      <input type=\"hidden\" name=\"param[mod]\" value=\"$this->modname\" />
      <input type=\"hidden\" name=\"param[version]\" value=\"$this->version\" />
      <input type=\"hidden\" name=\"param[def]\" value=\"{$param['def']}\" />
      <input type=\"hidden\" name=\"param[tgt]\" value=\"{$param['tgt']}\" />
      <input type=\"hidden\" name=\"param[cfg]\" value=\"{$param['cfg']}\" />
      <input type=\"hidden\" name=\"param[quot]\" value=\"{$param['quot']}\" />
      <input type=\"hidden\" name=\"param[param]\" value=\"{$param['param']}\" />
      <input type=\"hidden\" name=\"param[low]\" value=\"{$param['low']}\" />
      <input type=\"hidden\" name=\"param[high]\" value=\"{$param['high']}\" />
      <input type=\"hidden\" name=\"param[choices]\" value=\"{$param['choices']}\" />
      <div class=\"edbuttonbar\">
         <button type=\"submit\" name=\"submit\" value=\"pUpdate\">{$this->admtext['update']}</button>&nbsp;&nbsp;
         <button type=\"submit\" name=\"submit\" value=\"pRestore\">{$this->admtext['restore']}</button>&nbsp;&nbsp;
      </div>
   </td>
</tr>
</table><!-- sub mmtable-->
</form>";
    } // each parameter

    $flinka = '';
    if (!empty($_SESSION['actualmod'])) {
      $id = $_SESSION['actualmod'];
      unset($_SESSION['actualmod']);
      if (is_numeric($id)) {
        $flinka = '#flinka' . ($id - 1);
      }
    }

    echo "
<tr>
<td>
<div class='lightback edreturn'>
  <button onclick='window.location.href=\"admin_modhandler.php$flinka\";'>{$this->admtext['return']}</button>
</div>
</td>
</tr>
</table><!-- master mmtable -->
</div><!-- tableFixedHead -->
</div><!-- admin-main -->
";
    return true;
  } // display_edit_panels()

  protected function open_target_file(array $target_datapack, bool $readonly = false): bool
  {
    /*  %target directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == target
    **  $datapack['arg1'] == server filepath to target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == optional flag (@)
    **  $datapack['goto'] == empty
    */

    $line = $target_datapack['line'];
    $flag = $target_datapack['flag'];
    $target_filepath = $target_datapack['arg1'];

    /* Remove rootpath portion of target file path for log display.*/
    $display_path = $flag . str_replace($this->rootpath, '', $target_filepath);

    while (true) /* Target directive processing loop */ {
      /* If not readonly and previous target file open, save file contents before
      ** opening a new one.*/
      if (!$readonly && !empty($this->active_target_file) && !empty($this->target_file_contents)) {
        if (false === $this->write_file_buffer($this->active_target_file, $this->target_file_contents)) {
          $this->num_errors++;
          $logstring = "<span class='msgerror'>{$this->admtext['cantwrite']} %target:</span><span class='tgtfile'>$display_path  E:" . __LINE__ . "</span><span class='tag'>%</span>&nbsp;";
          $return_flag = false;
          break;
        } else {
          unset($this->target_file_contents);
        }
      }

      $logstring = "{$this->admtext['line']} $line: <span class='tag'>%target:</span><span class='tgtfile'>$display_path</span><span class='tag'>%</span>&nbsp;";

      /* init variables for new target file and contents.*/
      $this->target_file_contents = null;
      $this->active_target_file = '';

      /* Read target file contents into a processing buffer.*/
      $this->target_file_contents = $this->read_file_buffer($target_filepath, $flag);

      /* Report file errors if any.*/
      if (is_numeric($this->target_file_contents)) {
        $code = $this->target_file_contents;
        $this->target_file_contents = '';
        $this->is_target = false;

        if ($code == self::BYPASS) {
          $logstring .= "{$this->admtext['optmissing']}&nbsp;<span class='msgapproved'>{$this->admtext['bypassed']}</span>";
          break;
        } elseif ($code == self::NOFOUL) {
          $this->num_errors++;
          $logstring .= "{$this->admtext['tgtmissing']}&nbsp;<span class='msgerror'>{$this->admtext['required']}</span>";
          break;
        } elseif ($code == self::NOFILE) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> E:" . __LINE__ . " {$this->admtext['tgtmissing']}</span>";
          $return_flag = false;
          break;
        } elseif ($code == self::NOWRITE) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> E:" . __LINE__ . " {$this->admtext['notwrite']}</span>";
          $return_flag = false;
          break;
        } elseif ($code == self::ISEMPTY) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> E:" . __LINE__ . " {$this->admtext['emptyfile']}</span>";
          $return_flag = false;
          break;
        } else {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> E:" . __LINE__ . " {$this->admtext['errors']}</span>";
          $return_flag = false;
          break;
        }
      } else {
        $this->is_target = true;
        $this->active_target_file = $target_filepath;
        $logstring .= "{$this->admtext['opened']}";
      }
      break;
    } // while(true) processing loop

    $this->add_logevent($logstring);

    return $this->is_target;
  }

  protected function open_mod_file(string $cfgfile): bool
  {
    $file_state = true;

    /* Remove rootpath portion of target file path for log display.*/
    $display_path = str_replace($this->rootpath, '', $cfgfile);

    $logstring = "<span class='tag'>mod file </span><span class='tgtfile'>$display_path</span>&nbsp;";

    /* Read mod config file contents into a processing buffer.*/
    $this->cfg_file_contents = $this->read_file_buffer($cfgfile);

    /* Report file errors if any.*/
    if (is_numeric($this->cfg_file_contents)) {
      $this->cfg_file_contents = '';
      $logstring .= "<span class='msgerror'> E:" . __LINE__ . " {$this->admtext['cannotopen']} $display_path</span>";
      $file_state = false;
    } else {
      $logstring .= "{$this->admtext['opened']}";
    }

    $this->add_logevent($logstring);

    return $file_state;
  }

  /* This function removes all but target - parameter - choices - range - desc
  ** directives from parse table to simplify modeditor processing.
  */
  /** @return array (pared down parse table) */
  protected function clean_parse_table(): array
  {
    $temp_table = array();
    $target_hold = array();
    $target_set = false;

    for ($i = 0; isset($this->parse_table[$i]); $i++) {
      switch ($this->parse_table[$i]['name']) {
        case 'target':
          /* Hold target aside until we see if it has an associated parameter. */
          $target_hold = $this->parse_table[$i];
          $target_set = false;
          break;
        case 'parameter':
          if (!$target_set) {
            $temp_table[] = $target_hold;
            $target_set = true;
          }
        case 'choices':
        case 'range':
        case 'desc':
          $temp_table[] = $this->parse_table[$i];
          break;
        default:
          /* Discard the rest */
          break;;
      }
    }

    return $temp_table;
  } // clean_parse_table();

} // class modeditor

function new_modeditor(): modeditor
{
  require __DIR__ . '/mmobjinits.php';
  $objinits['classID'] = 'editor';
  return new modeditor($objinits);
}
