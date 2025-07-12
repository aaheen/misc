<?php
/*
   Mod Manager 12 Mod Remover Class

   Public Methods:
      $this->remove( $cfgpath );
      $this->batch_remove( $cfgpathlist );

      In this module, file modifier functions are not called directly, they
      are called by the %location: directive and thus have a different set
      of arguments than other directive functions.
*/

require_once 'classes/modparser.class.php';

/** @package  */
#[AllowDynamicProperties]
class modremover extends modparser
{
  protected $locations_found = 0;
  protected $locations_removed = 0;
  protected $copyfiles_found = 0;
  protected $copyfiles_removed = 0;
  protected $copyfiles_protected = 0;
  protected $newfiles_found = 0;
  protected $newfiles_removed = 0;
  protected $newfiles_protected = 0;
  protected $directories_found = 0;
  protected $directories_protected = 0;
  protected $directories_removed = 0;
  protected $directories_not_empty = 0;
  protected $mod_status = '';

  protected $files_removed = 0;
  protected $num_errors = 0;

  public function __construct($objinits)
  {
    parent::__construct($objinits);
  }

  const REMOVED  = 'removed';

  protected $active_target_file = '';
  protected $target_file_contents = '';
  protected $is_target = false;

  public function remove(string $cfgpath): bool
  {
    $this->cfgpath = $cfgpath;
    $this->cfgfile = $cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
    $this->parse_error = array();
    $this->mod_status = '';
    $newdirs = array();

    /* Get the parse table for this mod.*/
    $this->parse($cfgpath);

    /* Arrange the directives in best order for removal.*/
    $this->arrange_parse_table($this->parse_table);

    /* Starg logging the removal event.*/
    $this->new_logevent("{$this->admtext['removing']} <strong>$cfgpath</strong>");

    if (empty($this->parse_table) && empty($this->parse_error)) {
      $this->mod_status = self::CANTPROC;
      $this->add_logevent("<span class='msgerror'> R:" . __LINE__ . " parse table {$this->admtext['missing']}</span>");
      $this->write_eventlog($error = true);
      return false;
    }

    // HANDLE FATAL ERROR
    if (!empty($this->parse_error)) {
      $this->modname = $cfgfile;
      $this->mod_status = self::ERRORS;
      $idx = $this->parse_error['text'];
      $this->add_logevent("<span class='msgerror'>$cfgfile</span> <span class='hilighterr msgbold'> R:" . __LINE__ . " {$this->admtext[$idx]}</span>");
      $this->write_eventlog();
      return false;
    }

    // INITIALIZE STATUS DATA
    $this->init_properties();

    /*************************************************************
      PROCESS PARSE TABLE DIRECTIVES TO INSTALL CURRENT MOD
        Each $this->parse_table[$i] is a single directive datapack.
     *************************************************************/
    for ($i = 0; isset($this->parse_table[$i]); $i++) {
      /* File modifiers are processed by %location and should never show up here.
      ** If file modifiers are found here it is because they did not have an
      ** associated location directive and would not have been installed anyway. */
      if (in_array($this->parse_table[$i]['name'], $this->file_modifiers))
        continue;

      /* PHP allows assignment of a function name to a variable
      ** and then executing the "variaable" with arguments. That lets
      ** us get the function name associated with this directive from
      ** $proclist found in the modparser.class.php.
      */
      $function = $this->proclist[$this->parse_table[$i]['name']];

      /***********************************************************/
      /* Use custom function to set status of this directive.
      ** If a function processes more than one tag it will advance
      ** index $i to skip the table entries already processed.
      */

      $j = $i; /* For debugging */

      # Add Modremover function prefix
      $function = 'r' . $function;

      /* Dispatcher - send directive datapack for processing */
      $i = $this->$function($i);

      /* We pass the the $i index to processing functions and
      ** allow them to change it so the processing can skip over
      ** directives specified by conditional testing.
      **
      ** Debug: prevent bad behavior during modremover development;
      ** if the $i index gets unset or reset back to zero by a faulty
      ** function return, it will cause an infinite loop. Kill it.*/
      if ($i < $j) {
        echo basename(__FILE__), ': ', __LINE__, '<pre>';
        print_r($this->cfgpath);
        echo '<br />';
        echo basename(__FILE__), ': ', __LINE__, '<pre>';
        print_r("Index Error - \$i=$i < \$j=$j<br />");
        echo basename(__FILE__), ': ', __LINE__, '<br/>';
        var_dump($this->parse_table[$j]);
        exit;
      }
    } /* Main modremover processing loop */

    /*************************************************************
      DONE PROCESSING - FLUSH LAST BUFFER BACK TO TARGET FILE
     *************************************************************/
    if (!empty($this->active_target_file) && !empty($this->target_file_contents)) {
      if (false === $this->write_file_buffer(
        $this->active_target_file,
        $this->target_file_contents
      )) {
        $this->num_errors++;
        $logstring = "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantwrite']} %target:</span><span class='tgtfile'>$this->active_target_file</span><span class='tag'>%</span>&nbsp;";
        $this->add_logevent($logstring);
      }
    }

    /*************************************************************
      COMPILE INFORMATION FOR THE MM REMOVAL LOG ENTRY
     *************************************************************/
    if (!$this->num_errors) {
      /* If all the stats add up we are removed */
      if (
        $this->copyfiles_removed == ($this->copyfiles_found - $this->copyfiles_protected)
        && ($this->newfiles_removed == ($this->newfiles_found - $this->newfiles_protected))
        && ($this->locations_removed == $this->locations_found)
        && ($this->directories_removed == ($this->directories_found - $this->directories_not_empty))
      ) {
        $status = self::MODREM;
        $class = "class='msgapproved'";
      } else // they don't add up //
      {
        $status = self::ERRORS;
        $class = "class='msgerror'";
        $this->batch_error = true;
      }
    } else {
      $status = self::ERRORS;
      $class = "class='msgerror'";
      $this->batch_error = true;
    }

    /* Summarize number of modifications, files, newfiles and directories removed. */
    $this->add_logevent("<span class='msgbold'>{$this->admtext['toterrors']}:</span> $this->num_errors");

    if (!empty($this->locations_found)) {
      $locations = sprintf(
        '%d %s &nbsp;&nbsp; %d %s',
        $this->locations_found,
        '%location:',
        $this->locations_removed,
        $this->admtext['removed']
      );
      $this->add_logevent($locations);
    }

    if (!empty($this->copyfiles_found)) {
      $copyfiles = sprintf(
        '%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s',
        $this->copyfiles_found,
        '%copyfile:',
        $this->copyfiles_removed,
        $this->admtext['removed'],
        $this->copyfiles_protected,
        $this->admtext['protected']
      );
      $this->add_logevent($copyfiles);
    }

    if (!empty($this->newfiles_found)) {
      $newfiles = sprintf(
        '%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s',
        $this->newfiles_found,
        '%newfile:',
        $this->newfiles_removed,
        $this->admtext['removed'],
        $this->newfiles_protected,
        $this->admtext['protected']
      );
      $this->add_logevent($newfiles);
    }

    if (!empty($this->directories_found)) {
      $mkdirs = sprintf(
        '%d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s &nbsp;&nbsp; %d %s',
        $this->directories_found,
        '%mkdir:',
        $this->directories_removed,
        $this->admtext['removed'],
        $this->directories_protected,
        $this->admtext['protected'],
        $this->directories_not_empty,
        $this->admtext['cantrem']
      );
      $this->add_logevent($mkdirs);
    }

    $this->add_logevent("{$this->admtext['status']}: <span $class>{$this->admtext[$status]}</span>");

    $this->mod_status = $status;
    $this->write_eventlog();

    /* Determines if modhandler opens the Log to view errors -- see mod options. */
    return ($status == self::MODREM);
  } // remove()

  /*****************************************************************
  DIRECTIVE PROCESSING FUNCTIONS

  The modremover class must contain a private function for each
  mod directive that may appear in the parse table. Functions are
  named the same as the directive, but with a leading underscore.

  The processing loop in modremover dispatches each directive in
  parse table order to its corresponding function below for removal.
   *****************************************************************/
  private function r_author($i)
  {
    return $i;
  }

  private function r_choices($i)
  {
    return $i;
  }

  /**
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function r_copyfile(int $i): int
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

    # Take some working variables from the datapack
    $line = $copyfile_datapack['line'];
    $copyfile_op = $copyfile_datapack['name'];
    $flag = $copyfile_datapack['flag'];
    $destination_path = $copyfile_datapack['arg2'];

    # shorten the absolute $destination_path 
    #to make it TNG root relative.
    $dest_path = str_replace($this->rootpath, '', $destination_path);

    # Start a log entry for this instruction.
    $logstring = "{$this->admtext['line']} $line: %<span class='tag'>$copyfile_op:</span><span class='tgtfile'>{$flag}
    $dest_path</span>%&nbsp;";

    # Instruction processing loop. For each tested
    # condition, additional text is added to the $logstring
    # above, then the loop is broken and the log is written.
    #
    # We do not allow `while` to ever repeat and become
    # an infinite loop.    
    while (true) {
      if (!file_exists($destination_path)) {
        $logstring .= "{$this->admtext['notinst']}&nbsp;<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['bypassed']}</span>";
        break;
      }

      # Final status for instruction is calculate 
      $this->copyfiles_found++;

      if ($flag == self::FLAG_PROTECTED) {
        $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['protected']}</span>";
        $this->copyfiles_protected++;
        break;
      }

      if (false === unlink($destination_path)) {
        if ($flag == self::FLAG_OPTIONAL) {
          $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['cantremok']}</span>";
          break;

          // failed to delete a copied file
          $this->num_errors++;
          $logstring .= "<span class='hilighterr msgbold'> R:" . __LINE__ . " {$this->admtext['cantdel']}</span>";
          break;
        }
      }
      // file has been successfully unlinked
      $this->copyfiles_removed++;
      $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['removed']}</span>";
      break;
    } // while(true) processing loop

    $this->add_logevent($logstring);
    return $i;
  } // _copyfile()

  private function r_desc($i)
  {
    return $i;
  }

  private function r_description($i)
  {
    return $i;
  }

  private function r_end($i)
  {
    return $i;
  }

  private function r_fileend($i)
  {
    return $i;
  }

  private function r_fileexists($i)
  {
    return $i;
  }

  private function r_fileoptional($i)
  {
    return $i;
  }

  private function r_files($i)
  {
    return $i;
  }

  private function r_fileversion($i)
  {
    return $i;
  }

  private function r_goto($i)
  {
    return $i;
  }

  /* Remove inserted code/text */
  private function r_insert(array $location_datapack, array $insert_datapack, string $logstring): bool
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

    /* insert:before, insert:after */
    $insert_op = $insert_datapack['name'];

    /* Trim spaces and tabs from each end of the
    ** Location snippet block to avoid unnecessary 'bad target' errors.
    */
    $location_block = trim($location_datapack['arg1'], " \t");

    $insertion_block = $insert_datapack['arg1'];

    $insertion_block = $insert_op == 'insert:before'
      ? $insertion_block . "\r\n"  : "\r\n" . $insertion_block;

    $logstring .= "(%$insert_op%)&nbsp;";

    /*
    ** Modlister has already analyzed the mod file.  The mod is installed
    ** and there is no non-unique codes, so we'll trust that and just
    ** uninstall the mod without testing those things again.
    */

    if (false !== $p = strpos($this->target_file_contents, $insertion_block)) {
      $this->locations_found++;
      $len = strlen($insertion_block);
      $this->target_file_contents = substr_replace($this->target_file_contents, '', $p, $len);

      if (false === strpos($this->target_file_contents, $insertion_block)) {
        $this->locations_removed++;
        $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['removed']}</span>";
      } else {
        /* Suspect garbage duplicate entries in target file.  Cleaning the mod a
        ** second time might fix the problem.
        */
        $logstring .= "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantrem']}</span>";
        $this->num_errors++;
        $return_flag = false;
      }
    } else {
      /* Mod insertion not found - already removed. This might be the case for
      ** conditional directives or when cleaning up a partially installed mod.
      */
      $logstring .= "<span class='msgapproved'>{$this->admtext['alreadyrem']}</span>";
    }

    $this->add_logevent($logstring);

    return $return_flag;
  } // _insert()

  private function r_label($i)
  {
    return $i;
  }

  # Mod editing directives (optags) are called by this function
  /**
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function r_location(int $i): int
  {
    /*  %location directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == insert:before or insert:after
    **  $datapack['arg1'] == code to be inserted into the target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)

    /* Target file must be open to operate on it.*/
    if (!$this->is_target) {
      /* Skip over both location and editing directives */
      return $i + 1;
    }

    /* Break out the location directive datapack from the parse table.*/
    $location_datapack = $this->parse_table[$i];
    $line = $location_datapack['line'];
    $flag = $location_datapack['flag'];

    /* A file editing directive always follows %location in the parse table.*/
    $i++;
    $modifier_datapack = $this->parse_table[$i];
    $modifier_op = $modifier_datapack['name'];

    while (true) {
      $logstring = "{$this->admtext['line']} $line: <span class='tag'>%location:%</span>&nbsp;";

      /* Dispatch modifier directive for processing */
      $function = $this->proclist[$modifier_op];

      # Add Modremover function prefix.
      $function = 'r' . $function;

      $this->$function($location_datapack, $modifier_datapack, $logstring);
      break;
    } // while(true) processing loop

    return $i;
  } // _location

  /**
   * Removes directories installed by %mkdir,
   * but only if they are empty. Leaving non-empty
   * directories in place is intentional behavior,
   * not an error.
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function r_mkdir(int $i): int
  {
    /*  %mkdir directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == mkdir
    **  $datapack['arg1'] == directory (folderpath) to be created
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == @ = optional; ~ = protected
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    /* The parser automatically rearranges the parse table
    ** for removals to present instructions in logical order.
    ** %copyfile and %newfile instructions will have 
    ** already been reversed, so remove the directory(s) 
    ** if still empty.  If others have added files, 
    ** the containing directory(s) will be left alone to 
    ** prevent losing their content.
    */

    # Get the working datapack from the parse table.
    $mkdir_datapack = $this->parse_table[$i];

    # Get some working variables from the datapack
    $line = $mkdir_datapack['line'];
    $mkdir_directory = $mkdir_datapack['arg1'];
    $flag = $mkdir_datapack['flag'];

    # Use short path for removal, display and logging.
    $short_path = str_replace($this->rootpath, '', $mkdir_directory);

    # Start the log string.  Add to it below and insert it
    # in the logfile just before returning to the caller.
    $logstring = "{$this->admtext['line']} $line: %<span class='tag'>mkdir:</span><span class='tgtfile'>$short_path</span>%&nbsp;";

    # The processing loop provides a for a host of actions
    # depending on the state of the environment and 
    # requirements of the parse table datapack.
    # Breaking from the loop logs the activity
    # and returns to the caller. We ensure that 
    # we never actually (infinitely) loop.
    while (true) {
      if (!file_exists($mkdir_directory) || !is_dir($mkdir_directory)) {
        $logstring .= "\n<span class='msgapproved' style='padding-left:5em;'>&checkmark;&nbsp;$mkdir_directory {$this->admtext['alreadyrem']}</span>";
        break;
      }

      # If %mkdir folders are protected do not attempt 
      # to remove them.
      if ($flag == self::FLAG_PROTECTED) {
        # Set the processing stats.
        $this->directories_protected++;
        $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['protected']}</span>";
        break;
      }

      # Stats like this are displayed in the MM log.
      # They must add up and are compared to each other 
      # to get the final status - "Removed", "Partially 
      # installed", etc. If all seems in order but, the 
      # removal is deemed to be in error, check to see that these stats are
      # correctly maintained throughout processing.
      #
      # Stats are compiled in this script after the dispatcher
      # has finished processing the parse table and the final
      # open target file has been flushed -- ~line 150.
      $this->directories_found++;

      # remove nested directories, but only if they are empty
      $mkdir_dirs = array();
      $dirstr = $short_path;

      # Get a list of folders to be removed; 
      # if hierarchy is given, start with the deepest.
      # For example, "dir1/sub1/sub2", "dir1/sub1", "dir1"
      while (!empty(ltrim('.', $dirstr))) {
        $mkdir_dirs[] = $dirstr;
        $dirstr = pathinfo($dirstr, PATHINFO_DIRNAME);
      }

      # Even though we may remove several subdirectories,
      # it only counts as one directory (path) in the log.
      $this->directories_removed++;

      # Reiterate back up the path, 
      # directory by directory, using our list.
      foreach ($mkdir_dirs as $mkdir_dir) {
        # Only remove the targeted directory,
        # not the whole path. 
        if ($this->rrem_empty_dirs($mkdir_dir)) {
          $logstring .= "\n<span class='msgapproved' style='padding-left:5em;'>$mkdir_dir <span style='font-size:1em;color:green;'>&checkmark;&nbsp;</span>&nbsp;{$this->admtext['removed']}</span>";
          continue;
        } else {
          $this->directories_not_empty++;
          $this->directories_removed--;
          $logstring .= "\n<span class='msgapproved' style='padding-left:5em;'>$mkdir_dir  <span style='font-size:1em;color:red;'>&cross;&nbsp;</span>&nbsp;{$this->admtext['cantrem']}&nbsp;<span style='font-size:1em;'>&ne;&empty;&nbsp;</span>&nbsp;(not empty)</span>";
          break;
        }
      }
      break;
    } // processing loop
    $this->add_logevent($logstring);
    return $i;
  }

  private function r_name($i)
  {
    return $i;
  }

  /**
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function r_newfile(int $i): int
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

    while (true) {
      if (!file_exists($new_filepath)) {
        /* Not installed */
        $logstring .= "<span class='msgapproved'>{$this->admtext['alreadyrem']}</span>";
        break;
      }

      $this->newfiles_found++;

      if ($flag == self::FLAG_PROTECTED) {
        $this->newfiles_protected++;
        $logstring .= "<span class='msgapproved'>{$this->admtext['protected']}</span>";
        break;
      }

      if (false === unlink($new_filepath)) {
        $this->num_errors++;
        $logstring .= "<span class='hilighterr msgbold'> R:" . __LINE__ . " {$this->admtext['cantdel']}</span>";
        break;
      }

      $this->newfiles_removed++;
      $logstring .= "<span class='msgapproved'>{$this->admtext['removed']}</span>";
      break;
    } // while(true)

    $this->add_logevent($logstring);
    return $i;
  } // _newfile()

  private function r_note($i)
  {
    return $i;
  }

  private function r_parameter($i)
  {
    return $i;
  }

  private function r_private($i)
  {
    return $i;
  }

  private function r_range($i)
  {
    return $i;
  }

  private function r_replace(array $location_datapack, array $replace_datapack, string $logstring): bool
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

    /* Function is called by _location(), not by the main program.
    **
    ** The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */

    /* Trim spaces and tabs from each end of the
    ** Location text block to avoid 'bad target' errors. Whatever white space
    ** leads or trails the location text will remian in the file.
    */
    $location_block = trim($location_datapack['arg1'], " \t");
    $replace_block = trim($replace_datapack['arg1'], " \t");

    $logstring .= "(%replace:)&nbsp;";

    /* If replacement text is found, replace it with the original location text. */
    while (true) {
      /* Find the replacement code and remove it */
      if (false !== strpos($this->target_file_contents, $replace_block)) {
        $this->locations_found++;
        $this->target_file_contents = str_replace($replace_block, $location_block, $this->target_file_contents, $count);

        if ($count == 1) {
          $this->locations_removed++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['removed']}</span>";
          break;
        }

        $this->num_errors++;
        $logstring .= "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['errors']}</span>";
        $return_flag = false;
        break;
      }

      $logstring .= "<span class='msgapproved'>{$this->admtext['alreadyrem']}</span>";
      break;
    } // while(true) processing

    $this->add_logevent($logstring);
    return $return_flag;
  } // _replace()

  /**
   * @param int $i (index into parse table)
   * @return int (parse table index)
   */
  private function r_target(int $i): int
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

    /*
    if(!file_exists($target_filepath))
    {
      $this->active_target_file = '';
      $this->target_file_contents = '';
      $this->is_target = false;
      return $i;
    }
*/
    /* Remove rootpath portion of target file path for log display.*/
    $display_path = $flag . str_replace($this->rootpath, '', $target_filepath);

    /* Target directive processing loop - gets target file content into string buffer. */
    while (true) {
      /* If previous target file open, save file contents before opening a new one.*/
      if (!empty($this->active_target_file) && !empty($this->target_file_contents)) {
        if (false === $this->write_file_buffer($this->active_target_file, $this->target_file_contents)) {
          $this->num_errors++;
          $logstring = "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantwrite']} %target:</span><span class='tgtfile'>$display_path</span><span class='tag'>%</span>&nbsp;";
          break;
        } else {
          unset($this->target_file_contents);
        }
      }

      $logstring = "{$this->admtext['line']} $line: <span class='tag'>%target:</span><span class='tgtfile'>$display_path</span><span class='tag'>%</span>&nbsp;";

      /* init variables for new target file and contents.*/
      $this->target_file_contents = null;
      $this->active_target_file = '';
      $this->is_target = false;

      /* Read target file contents into a processing buffer.*/
      $this->target_file_contents = $this->read_file_buffer($target_filepath, $flag);

      /* Check status code from file read operation */
      if (is_numeric($this->target_file_contents)) {
        $code = $this->target_file_contents;
        $this->target_file_contents = '';

        if ($code == self::BYPASS) {
          $logstring .= "{$this->admtext['optmissing']}&nbsp;<span class='msgapproved'>{$this->admtext['bypassed']}</span>";
          break;
        } elseif ($code == self::NOFOUL) {
          $logstring .= "<span class='msgapproved'>{$this->admtext['provisional']}</span>";
          break;
        } elseif ($code == self::NOFILE) {
          $this->num_errors--;
          $logstring .= "<span class='msgapproved'>{$this->admtext['tgtmissing']}</span>";
          break;
        } elseif ($code == self::NOWRITE) {
          $this->num_errors--;
          $logstring .= "<span class='msgapproved'>{$this->admtext['notwrite']}</span>";
          break;
        } elseif ($code == self::ISEMPTY) {
          $this->num_errors--;
          $logstring .= "<span class='msgapproved'>{$this->admtext['emptyfile']}</span>";
          break;
        } else {
          $this->num_errors--;
          $logstring .= "<span class='msgapproved'>{$this->admtext['errors']}</span>";
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
    return $i;
  } // r_target

  private function r_tngversion($i)
  {
    return $i;
  }

  private function r_textexists($i)
  {
    return $i;
  }

  private function r_triminsert(array $location_datapack, array $triminsert_datapack, string $logstring): bool
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

    if ($triminsert_op == 'triminsert:after') {
      $composite_text = $location_snip . $triminsert_snip;
    } elseif ($triminsert_op == 'triminsert:before') {
      $composite_text = $triminsert_snip . $location_snip;
    }

    /* If composite replacement text is found, replace it with the original
    ** location text. */
    while (true) {

      /* Find location of the triminsert text.*/
      if (false !== $p = strpos($this->target_file_contents, $composite_text)) {
        $this->locations_found++;
        $this->target_file_contents = str_replace($composite_text, $location_snip, $this->target_file_contents, $count);

        if ($count == 1) {
          $this->locations_removed++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['removed']}</span>";
          break;
        }

        $this->num_errors++;
        $logstring .= "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantrem']}</span>";
        $return_flag = false;
        break;
      }

      $logstring .= "<span class='msgapproved'>{$this->admtext['alreadyrem']}</span>";
      break;
    } // while(true) processing loop

    $this->add_logevent($logstring);
    return $return_flag;
  } // _triminsert()

  private function r_trimreplace(array $location_datapack, array $trimreplace_datapack, string $logstring): bool
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


    /* If replacement text is found, replace it with the original location text. */
    while (true) {
      if (false !== strpos($this->target_file_contents, $trimreplace_snip)) {
        $this->locations_found++;
        $this->target_file_contents = str_replace($trimreplace_snip, $location_snip, $this->target_file_contents, $count);

        if ($count == 1) {
          $this->locations_removed++;
          $logstring .= "<span class='msgapproved'>{$this->admtext['removed']}</span>";
          break;
        }

        $this->num_errors++;
        $logstring .= "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantrem']}</span>";
        $return_flag = false;
        break;
      }

      $logstring .= "<span class='msgapproved'>{$this->admtext['alreadyrem']}</span>";
      break;
    } // while(true) processing loop

    $this->add_logevent($logstring);
    return $return_flag;
  } // _trimreplace()

  private function r_version($i)
  {
    return $i;
  }

  private function r_vinsert(array $location_datapack, array $vinsert_datapack, string $logstring): bool
  {
    /*  %vinsert directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == vinsert:before or vinsert:after
    **  $datapack['arg1'] == text to be inserted into the target file
    **  $datapack['arg2'] == list of variables assignments up to and including the '='
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    /*
    ** The log string ($logstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    */

    $vinsert_op = $vinsert_datapack['name'];
    $vinserts = explode("\r\n", $vinsert_datapack['arg2']);
    //echo basename(__FILE__),': ',__LINE__,'<pre>';print_r($vinserts);exit;
    foreach ($vinserts as $vinsert) {
      $vinsert = preg_quote($vinsert);
      //$regex = "#(^\s*".$vinsert."\s*(?:\"[^\"]*\"|\'[^\']*\'|\d+|true|false);).*$(?:\r\n|\n)?#m";
      $regex = "#^\s*" . $vinsert . ".*\r\n#m";
      $this->target_file_contents = preg_replace($regex, '', $this->target_file_contents, 1);
      $logstring .= "(%$vinsert_op%)&nbsp;";
    }

    # Check result
    $success = true;
    $this->locations_found++;

    foreach ($vinserts as $vinsert) {
      if (preg_match($regex, $this->target_file_contents)) {
        $success = false;
        break;
      }
    }

    if (!$success) {
      $this->num_errors++;
      $logstring .=  "<span class='msgerror'> R:" . __LINE__ . " {$this->admtext['cantdel']}</span>";
      $this->add_logevent($logstring);
    } else {
      $this->locations_removed++;
      $logstring .= "<span class='msgapproved'>&checkmark;&nbsp;{$this->admtext['removed']}</span>";
      $this->add_logevent($logstring);
    }
    return $success;
  } //_vinsert()

  /*************************************************************************
  SUPPORTING FUNCTIONS
   *************************************************************************/
  private function init_properties()
  {
    $this->locations_found = 0;
    $this->locations_removed = 0;
    $this->copyfiles_found = 0;
    $this->copyfiles_removed = 0;
    $this->copyfiles_protected = 0;
    $this->newfiles_found = 0;
    $this->newfiles_removed = 0;
    $this->newfiles_protected = 0;
    $this->directories_found = 0;
    $this->directories_removed = 0;
    $this->directories_not_empty = 0;
    $this->num_errors = 0;
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
          /* Remove directives that won't need to be uninstalled */
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
    foreach ($copyfiles as $copyfile)
      $this->parse_table[] = $copyfile;

    foreach ($mkdirs as $mkdir)
      $this->parse_table[] = $mkdir;

    foreach ($others as $other)
      $this->parse_table[] = $other;

    return $this->parse_table;
  } // arrange_parse_table()

  /**
   * Function Recursively removes $dir and sub-directories,
   * but only if they are empty of files. It only affects 
   * the single directory given in the $dir argument.
   * @param string $dir directory to be removed
   * @return bool - true if removed; false otherwise
   */
  private function rrem_empty_dirs($dir): bool
  {
    $item_list = array_diff(scandir($dir), array('.', '..'));
    foreach ($item_list as $item) {
      if (is_dir("$dir/$item")) {
        if (!$this->rrem_empty_dirs("$dir/$item")) {
          # directory is not devoid of files
          return false;
        } else {
          # $item is a file - bail out
          return false;
        }
      }
    }
    return @rmdir($dir);
  }

  public function batch_remove(array $cfgpathlist): bool
  {
    $this->batch_error = false;

    # Added for TNGv14.1 -- Remove mods in reverse order.
    $cfgpathlist = array_reverse($cfgpathlist, false);

    foreach ($cfgpathlist as $cfgpath) {
      if (!$this->remove($cfgpath)) {
        $this->batch_error = true;
      };
    }
    return !$this->batch_error;
  }
} // class modremover

function new_modremover(): modremover
{
  require __DIR__ . '/mmobjinits.php';
  $objinits['classID'] = 'remover';
  return new modremover($objinits);
}
