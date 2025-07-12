<?php
/*
**  Mod Manager 15 Mod Installer Class
**
**  Public Methods:
**    $this->install( $cfgpath );
**    $this->batch_install( $cfgpathlist );
**
**  This version refactors the previous code to make it more efficient
**  and easier to maintain.
**
**  Graphically we build Modlister and Modinstaller as follows:
**  Modbase -> Modparser -> Modvalidator -> Modlister
**  Modbase -> Modparser -> Modinstaller
**
**  Modlister has already determined the installation status of each
**  mod before displaying it, so we do not validate it again before
**  installing it here.
**
**  Modinstaller takes the parse_table and pulls off directive
**  datapacks one-by-one, and copies or modifies files as directed.
**
*/

require_once 'classes/modparser.class.php';

/** @package  */
#[AllowDynamicProperties]
class modinstaller extends modparser
{
  public function __construct($objinits)
  {
    parent::__construct($objinits);
  }

  // INITIALIZE STATUS DATA FOR LOGGING AND STATUS COMPUTATIONS
  protected $locations_required = 0;
  protected $locations_installed = 0;
  protected $newdirs_required = 0;
  protected $newdirs_created = 0;
  protected $newdirs_excused = 0;
  protected $newfiles_required = 0;
  protected $newfiles_created = 0;
  protected $newfiles_excused = 0;
  protected $copyfiles_required = 0;
  protected $copyfiles_copied = 0;
  protected $copyfiles_excused = 0;
  protected $statstring = '';
  protected $num_errors = 0;

  protected $active_target_file = '';
  protected $target_file_contents = '';
  protected $istarget = false;
  protected $mod_status = '';

  # Install a Mod Manager mod 
  /**
   * @param string $cfgpath 
   * @return bool (success)
   */
  public function install(string $cfgpath): bool
  {
    # This occurs when we have bad injection values
    # in the constructor (see Modbase).  This error
    # should be caught in Modlister except when
    # called by another script like admin_mod_analyzer.
    if ($this->instantiation_error) {
      throw new UnexpectedValueException("");
    }
    $this->cfgpath = $cfgpath;
    $this->cfgfile = $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
    $this->parse_error = array();
    $this->mod_status = '';

    /* Set the $this->parse_table for this mod. */
    $this->parse($cfgpath);

    /* Start logging the mod installation. */
    $this->new_logevent("{$this->admtext['installing']} <strong>$cfgpath</strong>");

    if (empty($this->parse_table) && empty($this->parse_error)) {
      $this->mod_status = self::CANTINST;
      $this->add_logevent("<span class='msgerror'>parse table {$this->admtext['missing']}</span>");
      $this->write_eventlog($error = true);
      return false;
    }

    /* Handle fatal error if one exists. */
    if (!empty($this->parse_error)) {
      $this->modname = $cfgfile;
      $this->mod_status = self::ERRORS;
      $idx = $this->parse_error['text'];
      $this->add_logevent("<span class='msgerror'>$cfgfile</span> <span class='hilighterr msgbold'>{$this->admtext[$idx]}</span>");
      $this->write_eventlog();
      return false;
    }

    /* Arrange the parse table directives in logical order for installation. */
    $this->parse_table = $this->arrange_parse_table($this->parse_table);

    $this->init_properties();

    /*************************************************************
      PROCESS THE PARSE TABLE DIRECTIVES TO INSTALL CURRENT MOD
        Each $this->parse_table[$i] is a single directive datapack.
     *************************************************************/
    for ($i = 0; isset($this->parse_table[$i]); $i++) {
      /* PHP allows assignment of a function name to a variable
      ** and then executing the "variable" with arguments. That lets
      ** us get the function name associated with this directive from
      ** $proclist found in the modbase.class.php.
      */
      $function = $this->proclist[$this->parse_table[$i]['name']];

      /***********************************************************
        DISPATCHER 
      ***********************************************************/ 
      /* 
      ** ALL FUNCTIONS MUST RETURN $i OR MODLISER WILL CRASH!
      */
      $refj = $i; /* For debugging */

      # Add Modinstaller function prefix
      $function = 'i' . $function;

      $i = $this->$function($i);
      /***********************************************************/

      /* We pass the the $i index to processing functions and
      ** allow them to change it so the processing can skip over
      ** directives specified by conditional testing.
      **
      ** Debug: prevent bad behavior during modinstaller development;
      ** if the $i index gets unset or reset back to zero by a faulty
      ** function return, it will cause an infinite loop. So don't allow it.*/
      if ($i < $refj) {
        $this->num_errors++;
        $logstring = "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['cantinst']} Dispatcher: </span><span class='tgtfile'>Index error!</span>&nbsp;";
        $this->add_logevent($logstring);
        $this->write_eventlog();
        return false;
      }
    } /* Main modinstaller processing loop */

    /*************************************************************
      DONE PROCESSING - FLUSH LAST BUFFER BACK TO TARGET FILE
     *************************************************************/
    if (!empty($this->active_target_file) && !empty($this->target_file_contents)) {
      if (false === $this->write_file_buffer($this->active_target_file, $this->target_file_contents)) {
        $this->num_errors++;
        $logstring = "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['cantwrite']} %target:</span><span class='tgtfile'>$this->active_target_file</span><span class='tag'>%</span>&nbsp;";
        $this->add_logevent($logstring);
      }
    }

    /*************************************************************
      COMPILE STATS FOR THE MM PROCESSING LOG
     *************************************************************/
    if (!$this->num_errors) {
      /* Compute the final statistics */
      if (
        $this->copyfiles_required == ($this->copyfiles_copied + $this->copyfiles_excused)
        && ($this->newfiles_required == ($this->newfiles_created + $this->newfiles_excused)
          && ($this->locations_required == $this->locations_installed)
          && ($this->newdirs_required == $this->newdirs_created))
      ) {
        if (
          $this->copyfiles_copied == 0
          && $this->copyfiles_excused == 0
          && $this->newfiles_created == 0
          && $this->newfiles_excused == 0
          && $this->locations_installed == 0
        ) {
          $status = self::OK2INST;
          $class = "class='msgapproved'";
        } else {
          $status = self::INSTALLED;
          $class = "class='msgapproved'";
        }
      }
    } else {
      $status = self::ERRORS;
      $class = "class='msgerror'";
      $this->batch_error = true;
    }

    $this->add_logevent("<span class='msgbold'>{$this->admtext['toterrors']}:</span> $this->num_errors");

    $installed = strtolower($this->admtext['installed']);

    if (!empty($this->locations_required)) {
      $locations = sprintf('%d %s &nbsp;&nbsp; %d %s',  $this->locations_required, '%location:', $this->locations_installed, $installed);
      $this->add_logevent($locations);
    }

    if (!empty($this->copyfiles_required)) {
      $copyfiles = sprintf('%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s', $this->copyfiles_required, '%copyfile:', $this->copyfiles_copied, $installed, $this->copyfiles_excused,  $this->admtext['protected']);
      $this->add_logevent($copyfiles);
    }

    if (!empty($this->newfiles_required)) {
      $newfiles = sprintf('%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s', $this->newfiles_required, '%newfile:', $this->newfiles_created, $installed, $this->newfiles_excused,       $this->admtext['protected']);
      $this->add_logevent($newfiles);
    }

    if (!empty($this->newdirs_required)) {
      $mkdirs = sprintf('%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s', $this->newdirs_required, '%mkdir:', $this->newdirs_created, $installed, $this->newdirs_excused, $this->admtext['protected']);
      $this->add_logevent($mkdirs);
    }

    $this->add_logevent("{$this->admtext['status']}: <span $class>{$this->admtext[$status]}</span>");

    $this->mod_status = $status;
    $this->write_eventlog();
    return ($status == self::OK2INST || $status == self::INSTALLED);
  } // install()

  /**
   * @param array $cfgpathlist 
   * @return bool 
   */
  public function batch_install(array $cfgpathlist): bool
  {
    include 'classes/modvalidator.class.php';
    foreach ($cfgpathlist as $cfgpath) {
      /*
      # Validator just requires mod file name.
      $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);

      # Validate next mod in list to verify that status has not changed.
      $oVal = new_modvalidator($cfgfile);
      $mm_data = $oVal->check_status(false, $cfgfile);

      # 0 == okay to install
      if( $mm_data['status'] != 0 ) return;
*/
      if (!$this->install($cfgpath)) {
        $this->batch_error = true;
      };
    }
    return !$this->batch_error;
  }

  /*************************************************************
    MM DIRECTIVE/INSTRUCTION PROCESSORS
      A table in Modbase provides the name of each valid 
      MM instruction and a universal function name for
      processing the instruction.  

      Functions are named the same as the instructon, 
      but with a leading underscore. Extending classes
      such as this add a unique class prefix to avoid 
      violating the Liskov Substitution Principle -
      using the same name, but different number and type
      of arguments in extending classes.

      Some functions, for example _insert(), may or may not be
      called directly by the DISPATCHER. In Modlister, the 
      optag functions are called by l_location().
   *************************************************************/

  private function i_author($i)
  {
    return $i;
  }

  private function i_choices($i)
  {
    return $i;
  }

  /**
   * @param int $i (index into parse table) 
   * @return int (parse table index)
   */
  private function i_copyfile(int $i): int
  {
    /*  %copyfile directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == copyfile or copyfile2
    **  $datapack['arg1'] == full server path to source file
    **  $datapack['arg2'] == full server path to destination file
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == flag (if any) optional or protected
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    /* Break out the datapack to simplify processing.*/
    $copyfile_datapack = $this->parse_table[$i];

    $line = $copyfile_datapack['line'];
    $flag = $copyfile_datapack['flag'];

    $copyop = $copyfile_datapack['name']; /* Copyfile or copyfile2 */

    $source_path = $copyfile_datapack['arg1'];
    $source_file = pathinfo($source_path, PATHINFO_BASENAME);

    $destination_path = $copyfile_datapack['arg2'];
    $dest_path = str_replace($this->rootpath, '', $destination_path);

    $logstring = "{$this->admtext['line']} $line: %<span class='tag'>$copyop:</span>";
    $logstring .= "<span class='tgtfile'>$flag$dest_path</span>%&nbsp;";

    $this->copyfiles_required++;

    while (true) {
      if (!file_exists($source_path)) {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['srcfilemissing']}</span>";
        break;
      }

      if (is_dir($source_path)) {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['folder']} - {$this->admtext['cantinst']}</span>";
        break;
      }

      # Do not overcopy protected file.
      if (file_exists($destination_path)) {
        if ($flag == self::FLAG_PROTECTED) {
          $this->copyfiles_excused++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['protected']}</span>";
          break;
        }
      }

      if (@copy($source_path, $destination_path) === false) {
        /* Failed copy excused? */
        if ($flag == self::FLAG_OPTIONAL) {
          $this->copyfiles_excused++;
          $logstring .= "{$this->admtext['optnocopy']}&nbsp;<span class='msgapproved'>{$this->admtext['bypassed']}</span>";
          break;
        }
        /* Failed copy */ else {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['notcopied']}</span>";
          break;
        }
      } else {
        /* Copy was successful! */
        $this->copyfiles_copied++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['copied']}</span>";
        break;
      }
      break;
    } // while(true)

    $this->add_logevent($logstring);
    return $i;
  } // _copyfile

  private function i_desc($i)
  {
    return $i;
  }

  private function i_description($i)
  {
    return $i;
  }

  private function i_end($i)
  {
    return $i;
  }

  private function i_fileend($i)
  {
    return $i;
  }

  private function i_fileexists($i)
  {
    return $i;
  }

  private function i_fileoptional($i)
  {
    return $i;
  }

  private function i_files($i)
  {
    return $i;
  }

  private function i_fileversion($i)
  {
    return $i;
  }

  private function i_goto($i)
  {
    return $i;
  }

  private function i_insert(array $location_datapack, array $insert_datapack, string $logstring): bool
  {
    /*  %insert directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == insert:before or insert:after
    **  $datapack['arg1'] == text to be inserted into the target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    /*
    ** The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */
    $return_flag = true;

    $location_block = trim($location_datapack['arg1'], " \t");

    /* Trim spaces and tabs from each end of the
    ** Location snippet block to avoid unnecessary 'bad target' errors.
    */
    $location_block = trim($location_datapack['arg1'], " \t");

    /* insert:before, insert:after, vinsert:before, vinsert:after */
    $insertion_op = $insert_datapack['name'];

    $insertion_block = $insert_datapack['arg1'];

    $logstring .= "(%$insertion_op%)&nbsp;";

    /* The modlister has verified this location as not installed and having unique
    ** location code. We'll trust that and just go ahead and install the directive
    ** without testing for those things again.
    */

    /* We no longer bother users with fragment errors. We simply move the insertion
    ** point to the beginning or end of the line and provide CRLF for separation.
    */
    if (false !== $p = strpos($this->target_file_contents, $location_block)) {
      /* Position pointer for insertion. */
      if ($insertion_op == 'insert:after' || $insertion_op == 'vinsert:after') {
        /* Snip has been trimmed of spaces and tabs to avoid bad target errors if
        ** these change for some reason.  Expand from the end of the snip out to the
        ** CRLF so we don't accidentally insert our snip into the middle of the
        ** existing location block. The pointer $p will become the insertion point.
        */

        $p = $p + strlen($location_block);
        while (isset($this->target_file_contents[$p]) && $this->target_file_contents[$p] != "\r") {
          $p++;
        }

        /* Provide separation from location code block. */
        $insertion_block = "\r\n" . $insertion_block;

        /* Insert the new code into the target file */
        $this->target_file_contents = substr_replace($this->target_file_contents, $insertion_block, $p, 0);
      } elseif ($insertion_op == 'insert:before' || $insertion_op == 'vinsert:before') {
        /* Snip has been trimmed of spaces and tabs to avoid bad target errors if
        ** these change for some reason.  Expand from the start of the block back to
        ** the CRLF so we don't accidentally insert our block into the middle of the
        ** existing location block. The pointer $p will become the insertion point.
        */
        while (isset($this->target_file_contents[$p]) && $this->target_file_contents[$p] != "\n") {
          $p--;
        }
        $p++;

        $insertion_block = $insertion_block . "\r\n";

        /* Insert the new code into the target file */
        $this->target_file_contents = substr_replace($this->target_file_contents, $insertion_block, $p, 0);
      }

      /* Verify success */
      if (false !== strpos($this->target_file_contents, $insertion_block)) {
        $this->locations_installed++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['installed']}</span>";
      } else {
        /* Should never see this error, but write permissions should be checked. */
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['cantinst']}</span>";
        $this->num_errors++;
        $return_flag = false;
      }
    } else {
      /* Should never see this error since modlister already checked for a good
      ** target.
      */
      $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['badtarget']}</span>";
      $this->num_errors++;
      $return_flag = false;
    }

    $this->add_logevent($logstring);
    return $return_flag;
  } // _insert()

  private function i_label($i)
  {
    return $i;
  }

  private function i_location(int $i):int
  {
    /*  %location directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == location
    **  $datapack['arg1'] == text to be inserted into the target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    /* Target file must be open to operate on it.*/
    if (!$this->istarget) {
      /* Skip over both location and editor directives */
      return $i + 1;
    }

    /* Break out the location directive datapack from the parse table.*/
    $location_datapack = $this->parse_table[$i];
    $line = $location_datapack['line'];
    $flag = $location_datapack['flag'];

    /* A file editing directive always follows %location in the parse table.*/
    $i++;
    $modifier_datapack = $this->parse_table[$i];
    $modifier_name = $modifier_datapack['name'];

    while (true) {
      $logstring = "{$this->admtext['line']} $line: <span class='tag'>%location:%</span>&nbsp;";

      $this->locations_required++;
      /*
      // TARGET FILE NOT OPENED FOR SOME REASON - NO POINT PROCESSING LOCATIONS
      if( empty( $this->active_target_file) )
      {
        if( $flag == self::FLAG_OPTIONAL )
        {
          $this->locations_required--;
        }
        break;
      }
*/

      /* Call the appropriate file editing directive function to install the location. */
      $function = $this->proclist[$modifier_name];

      # Add Modinstaller function prefix
      $function = 'i' . $function;

      $this->$function($location_datapack, $modifier_datapack, $logstring);
      break;
    } // while

    return $i;
  }

  /**
   * @param int $i (index into parse table) 
   * @return int (parse table index)
   */
  private function i_mkdir(int $i): int
  {
    /*  %mkdir directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == mkdir
    **  $datapack['arg1'] == directory (folderpath) to be created
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == if any, optinal @
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    # Get the working datapack from the parse table.
    $mkdir_datapack = $this->parse_table[$i];

    # Extract working variables from the datapack
    $line = $mkdir_datapack['line'];
    $directory_path = $mkdir_datapack['arg1'];

    # Shorten absolute path to make it relative to the TNG root.
    $display_path = str_replace($this->rootpath, '', $directory_path);

    # Start a log string for this instruction
    $logstring = "{$this->admtext['line']} $line: <span class='tag'>%mkdir:</span><span class='tgtfile'>$display_path</span><span class='tag'>%</span>&nbsp;";

    # Stats like this are displayed in the MM log.
    # They must add up and are compared to each other 
    # to get the final status - "Installed", "Partially 
    # installed", etc. If all seems in order but the 
    # removal is deemed to be in error, check to see that these stats are
    # correctly maintained throughout processing.
    #
    # Stats are compiled in this script after the dispatcher
    # has finished processing the parse table and the final
    # open target file has been flushed -- ~line 150.
    $this->newdirs_required++;

    # Instruction processing loop. For each tested
    # condition, a log text is added to the $logstring
    # above, the loop is broken and the log is written.
    # We do not allow `while` to ever repeat and become
    # an infinite loop.
    while (true) {
      if (file_exists($directory_path)) {
        $this->newdirs_required--;
        $logstring .= "<span class='msgapproved'>{$this->admtext['exists']}</span>";
        break;
      }

      /* Create the requested directory */
      @mkdir($directory_path, 0777, true);

      if (file_exists($directory_path)) {
        $this->newdirs_created++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['created']}</span>";
        break;
      } else {
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['notcreated']}</span>";
        break;
      }
      break;
    }
    $this->add_logevent($logstring);
    return $i;
  } // mkdir()

  private function i_name($i)
  {
    return $i;
  }

  /**
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function i_newfile(int $i): int
  {
    /*  %newfile directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == newfile
    **  $datapack['arg1'] == filepath for new file
    **  $datapack['arg2'] == content of new file
    **  $datapack['arg3'] == version number of new file
    **  $datapack['flag'] == flag if any
    **  $datapack['goto'] == empty
    */

    /* Only current table entry needed so simplify code */
    $newfile_datapack = $this->parse_table[$i];

    $line = $newfile_datapack['line'];
    $flag = $newfile_datapack['flag'];

    /* Full server file path.*/
    $new_filepath = $newfile_datapack['arg1'];

    /* Short version of file name for display.*/
    $new_file = str_replace($this->rootpath, '', $new_filepath);

    $logstring = "{$this->admtext['line']} $line: <span class='tag'>%newfile:</span><span class='tgtfile'>$flag$new_file</span><span class='tag'>%</span>&nbsp;";

    $this->newfiles_required++;

    while (true) {
      /* Do no overcopy protected file */
      if (file_exists($new_filepath)) {
        if ($flag == self::FLAG_PROTECTED) {
          $this->newfiles_excused++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['protected']}</span>";
          break;
        }
      }

      $newfile_content = $newfile_datapack['arg2'];
      if (!empty($newfile_content)) {
        if (false !== $this->write_file_buffer($new_filepath, $newfile_content)) {
          $this->newfiles_created++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['created']}</span>";
          break;
        }
        // optional file not created?
        elseif ($flag == self::FLAG_OPTIONAL) {
          $this->newfiles_excused++;
          $logstring .= "{$this->admtext['optnotcreated']}&nbsp;<span class='msgapproved'>{$this->admtext['bypassed']}</span>";
          break;
        } else {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['notcreated']}</span>";
          break;
        }
      } else {
        /* No content found for new file */
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['errors']}</span>";
        break;
      }
      break;
    } // while(true)

    $this->add_logevent($logstring);
    return $i;
  } // newfile()

  private function i_note($i)
  {
    return $i;
  }

  private function i_parameter($i)
  {
    return $i;
  }

  private function i_private($i)
  {
    return $i;
  }

  private function i_range($i)
  {
    return $i;
  }

  /* Function i_replace() is called by i_location(), not by the main program DISPATCHER. */
  private function i_replace(array $location_datapack, array $replace_datapack, string $logstring): bool
  {
    /*  %replace directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == replace
    **  $datapack['arg1'] == replacement text for location in target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    $return_flag = true;

    /* The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */

    /* Modlister has already checked that the location snip is a complete
    ** block of text.  No need to do it again - use it as is.
    */
    $location_block = trim($location_datapack['arg1'], " \t");
    $replace_block = trim($replace_datapack['arg1'], " \t");

    $logstring .= "(%replace:)&nbsp;";

    /* Directive processing loop */
    while (true) {
      /*
      ** Target file code block has already been cleared for replacement by modlister,
      ** so just install and verify it here.
      */
      $this->target_file_contents = str_replace($location_block, $replace_block, $this->target_file_contents);

      /* Verify success */
      $num_newblock = substr_count($this->target_file_contents, $replace_block);

      if ($num_newblock  == 1) {
        $this->locations_installed++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['installed']}</span>";
        break;
      } else {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['notinst']}</span>";
        $return_flag = false;
        break;
      }
      /* Should never reach this point - must have found multiple replacement blocks.
      ** Check target file.
      */
      $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['errors']}</span>";
      $return_flag = false;
      break;
    } // main while true

    /* Log the results and return to the _location() function */
    $this->add_logevent($logstring);
    return $return_flag;
  } // replace()

  /**
   * @param int $i (index into parse table) 
   * @return int (parse table index) 
   */
  private function i_target(int $i): int
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

    /* Break out target directive datapack */
    $target_datapack = $this->parse_table[$i];

    $line = $target_datapack['line'];
    $flag = $target_datapack['flag'];
    $target_filepath = $target_datapack['arg1'];

    /* Remove rootpath portion of target file path for log display.*/
    $display_path = $flag . str_replace($this->rootpath, '', $target_filepath);

    while (true) /* Target directive processing loop */ {
      /* If previous target file open, save file contents before opening a new one.*/
      if (!empty($this->active_target_file) && !empty($this->target_file_contents)) {
        if (false === $this->write_file_buffer($this->active_target_file, $this->target_file_contents)) {
          $this->num_errors++;
          $logstring = "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['cantwrite']} %target:</span><span class='tgtfile'>$display_path</span><span class='tag'>%</span>&nbsp;";
          //$return_flag = false;
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
        $this->istarget = false;

        if ($code == self::BYPASS) {
          $logstring .= "{$this->admtext['optmissing']}&nbsp;<span class='msgapproved'>{$this->admtext['bypassed']}</span>";
          break;
        } elseif ($code == self::NOFOUL) {
          $this->num_errors++;
          $logstring .= " I:" . __LINE__ . " {$this->admtext['tgtmissing']}&nbsp;<span class='msgerror'>{$this->admtext['required']}</span>";
          break;
        } elseif ($code == self::NOFILE) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['tgtmissing']}</span>";
          break;
        } elseif ($code == self::NOWRITE) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['notwrite']}</span>";
          break;
        } elseif ($code == self::ISEMPTY) {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['emptyfile']}</span>";
          break;
        } else {
          $this->num_errors++;
          $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['errors']}</span>";
          break;
        }
      } else {
        $this->istarget = true;
        $this->active_target_file = $target_filepath;
        $logstring .= "{$this->admtext['opened']}";
      }
      break;
    } // while(true) processing loop

    $this->add_logevent($logstring);
    return $i;
  } // _target()

  private function i_tngversion($i)
  {
    /* No conditionals to be installed */
    return $i;
  }

  private function i_textexists($i)
  {
    /* No conditionals to be installed */
    return $i;
  }

  private function i_triminsert(array $location_datapack, array $triminsert_datapack, string $logstring): bool
  {
    /*  %triminsert directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == trimreplace:before or triminsert:after
    **  $datapack['arg1'] == text for insertion into target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    $return_flag = true;

    /* Function is called by _location(), not by the main program.
    **
    ** The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */

    $location_snip = $location_datapack['arg1'];

    $triminsert_op = $triminsert_datapack['name']; // triminsert:before or triminsert:after
    $triminsert_snip = $triminsert_datapack['arg1'];

    $logstring .= "(%$triminsert_op:)&nbsp;";

    /* Processing loop */
    while (true) {
      if (false === $p = strpos($this->target_file_contents, $location_snip)) {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['badtarget']}</span>";
        $return_flag = false;
        break; // break out of main loop and log error
      }

      /* Create composite text for testing results.*/
      if ($triminsert_op == 'triminsert:after') {
        $composite_text = $location_snip . $triminsert_snip;

        /* Move insertion point to end of the location snippet.*/
        $p += strlen($location_snip);
      } elseif ($triminsert_op == 'triminsert:before') {
        $composite_text = $triminsert_snip . $location_snip;
      }

      /* Modify the target file contents. */
      $this->target_file_contents =
        substr_replace($this->target_file_contents, $triminsert_snip, $p, 0);

      /* Test for success. */
      if (false !== strpos($this->target_file_contents, $composite_text)) {
        $this->locations_installed++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['installed']}</span>";
        break;
      } else {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['badinstall']}</span>";
        $return_flag = false;
        break;
      }

      /* Processing should never reach this location -- prevent infinite looping. */
      $this->num_errors++;
      $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['errors']}</span>";
      $return_flag = false;
      break;
    }

    $this->add_logevent($logstring);
    return $return_flag;
  }

  private function i_trimreplace(array $location_datapack, array $trimreplace_datapack, string $logstring): bool
  {
    /*  %trimreplace directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == trimreplace
    **  $datapack['arg1'] == replacement text for location in target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    $return_flag = true;

    /* Function is called by _location(), not by the main program.
    **
    ** The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */

    /* Use location code and replacement exactly as given in mod config file.
    ** Trimreplace is not a block operations.
    */
    $location_snip = $location_datapack['arg1'];

    $trimreplace_snip = $trimreplace_datapack['arg1'];

    $logstring .= "(%trimreplace:)&nbsp;";

    while (true) {
      if (false === $p = strpos($this->target_file_contents, $location_snip)) {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['badtarget']}</span>";
        $return_flag = false;
        break; // break out of main loop and log error
      }

      /* Parameters for substr_replace() */
      $start = $p;
      $length = strlen($location_snip);
      $end = ($start + $length);

      /* Modify the target file contents. */
      $this->target_file_contents =
        substr_replace($this->target_file_contents, $trimreplace_snip, $start, $length);

      /* Test for success. */
      if (false !== strpos($this->target_file_contents, $trimreplace_snip)) {
        $this->locations_installed++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['installed']}</span>";
        break;
      } else {
        $this->num_errors++;
        $logstring .= "<span class='msgerror'> I:" . __LINE__ . " {$this->admtext['badinstall']}</span>";
        $return_flag = false;
        break;
      }

      break;
    }

    $this->add_logevent($logstring);
    return $return_flag;
  } // _trimreplace()

  private function i_version($i)
  {
    return $i;
  }

  private function i_vinsert(array $location_datapack, array $vinsert_datapack, string $logstring): bool
  {

    /* Send it on to _insert() to finish installation. */
    //echo basename(__FILE__),': ',__LINE__,'<pre>';print_r($vinsert_datapack);exit;
    return $this->i_insert($location_datapack, $vinsert_datapack, $logstring);
  }

  private function i_wikipage($i)
  {
    return $i;
  }

  /*************************************************************
  SUPPORTING FUNCTIONS
   *************************************************************/
  protected function init_properties()
  {
    // INITIALIZE STATUS DATA
    $this->locations_required = 0;
    $this->locations_installed = 0;
    $this->newdirs_required = 0;
    $this->newdirs_created = 0;
    $this->newdirs_excused = 0;
    $this->newfiles_required = 0;
    $this->newfiles_created = 0;
    $this->newfiles_excused = 0;
    $this->copyfiles_required = 0;
    $this->copyfiles_copied = 0;
    $this->copyfiles_excused = 0;
    $this->statstring = '';
    $this->num_errors = 0;

    $this->active_target_file = '';
    $this->target_file_contents = '';
    $this->istarget = false;
    return;
  }

  # Order directives in the parse table 
  # to best suit installation.
  /** @return array this->parse table re-arranged */
  private function arrange_parse_table(): array
  {
    $mkdirs = array();
    $copyfiles = array();
    $others = array();

    // make new directories available for file copies
    for ($i = 0; isset($this->parse_table[$i]); $i++) {
      /* Info directives stay at the top of the table.
      ** When installing a mod mkdir comes before any file copies to it.
      ** When removing a mod we place the mkdir directives at the end of the table
      ** so that any files copied to them can be removed first -- (PHP rmdir cannot
      ** delete a directory with content.)
      */
      /* Keep info directives at beginning of table */

      switch ($this->parse_table[$i]['name']) {
          /* Remove directives that won't need to be installed */
        case 'name':
        case 'version':
        case 'description':
        case 'note':
        case 'private':
        case 'author':
        case 'wikipage':
          break;

          /* Collect the mkdir directives */
        case 'mkdir':
          $mkdirs[] = $this->parse_table[$i];
          break;

          /* Collect file copy and newfile directives */
        case 'copyfile':
        case 'copyfile2':
        case 'newfile':
          $copyfiles[] = $this->parse_table[$i];
          break;
        default:
          /* Collect all other directives in order found */
          $others[] = $this->parse_table[$i];
          break;
      }
    }

    /* Rebuild the parse table */
    $this->parse_table = array();

    foreach ($mkdirs as $mkdir)
      $this->parse_table[] = $mkdir;

    foreach ($copyfiles as $copyfile)
      $this->parse_table[] = $copyfile;

    foreach ($others as $other)
      $this->parse_table[] = $other;

    return $this->parse_table;
  } // arrange_parse_table()

} // class modinstaller

function new_modinstaller(): modinstaller 
{
  require __DIR__ . '/mmobjinits.php';
  $objinits['classID'] = 'installer';
  return new modinstaller($objinits);
}
