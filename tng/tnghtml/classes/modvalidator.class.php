<?php
/*
  Mod Manager 15 Modvalidator Class

  construction Modbase -> Modparser -> Modvalidator

  Class extends modparser.  It validates all directives from a
  mod configuration file and calculates a final status for the
  mod, putting the results for each directive datapack in the last
  two columns of the parse table -- 'statkey' and 'eline'.

  Eline contains the line number from the validator script where an
  error was generated. It appears in the Modlister as Exxx to help users
  pinpoint the location of the error.

  The statkey is a binary flag. In effect, each bit of the
  flag represents a condition such as "installed" or "optional",
  and bits are combined (added together) to completely describe
  the result of testing a single directive.

  Programmers are spared the binary math with our predifined constants
  to set each bit, for example, self::NOTINST + self::OPTIONAL.
  Computers find this very fast and very efficient.

  A non-OOP PHP function has been included to initialize and create a
  modvalidator object. It injects TNG configuration, Mod Manager options and
  language support data into the new object during instantiation and passes
  the new object back to the caller.

  Public Methods:
    validate();     // validates parse table
    check_status() // returns $mm_data array
    check_status(true); // as above + creates mm_data.php file containing $mm_data_array

    Following public methods are used when validating a single mod cfg file.
    get_modname(); // returns name of mod from last mod evaluated
    get_modversion(); // returns version of last mod evaluated
    get_modstatus_header() // returns status of last mod evaluated

  PHP function:
    new_modvalidator();
*/

include_once 'classes/modparser.class.php';

#[AllowDynamicProperties]
class modvalidator extends modparser
{
  function __construct($objinits)
  {
    parent::__construct($objinits);
  }

  protected $parameters = 0;
  protected $num_errors = 0;
  protected $num_required = 0;
  protected $mods_required = 0;
  protected $copies_required = 0;
  protected $newfiles_required = 0;
  protected $newdirs_required = 0;
  protected $num_installed = 0;
  protected $mods_installed = 0;
  protected $copies_installed = 0;
  protected $newfiles_installed = 0;
  protected $newdirs_installed = 0;
  protected $provisional_errors = 0;
  protected $modstatus_header = '';
  protected $status_string = '';
  protected $warning = '';
  protected $sysmsg;
  protected $target_file_contents = '';
  protected $active_target_file = '';
  protected $is_target = false;

  protected $description = '';
  protected $note = '';
  protected $private = '';
  protected $wikipage = '';

  public $mmdata = array();

  /* The validation $statkey is a bit-wise flag intended to store the
    ** complete status of a directive (not to be confused with a Mod status).
    ** It is constructed using predefined constants, each representing
    ** a power of 2, thereby each one setting a single bit in the $statkey.
    ** Statkey constants can be added together in any number in any
    ** order and will always produce a unique key.
    **
    ** Modlister uses the $statkey flag to assemble a fully informed
    ** status panel entry for each directive within a mod config file.
    **
    ** Note: Error conditions will always produce odd numbered keys.
    ** For example self::vBADTARGET + self::vERROR == 257.
    */
  const vERROR = 1;
  const vOPTIONAL = 2;
  const vPROTECTED = 4;
  const vPROVISIONAL = 8;
  const vNOTINST = 16;
  const vINSTALLED = 32;

  const vLOCCODE = 64;
  const vCFGCODE = 128;

  const vBADTARGET = 256;
  const vNOTUNIQUE = 512;
  const vMISSING = 1024;

  const vTGTFILE = 2048;
  const vCFGFILE = 4096;
  const vSRCFILE = 8192;
  const vDSTFOLDER = 16384;

  const vPARTINST = 32768; /* vinsert only */
  const vVERSION = 65536;

  const vBYPASSED = 131072;
  const vNOWRITE =  262144;
  const vNOCONTENT =  524288;
  const vVERIFIED = 1048576;
  const vNOFRAG = 2097152;

  # Test all instructions in mod parse table and return
  # the table with validation results added.
  /**
   * @param string $cfgfile 
   * @return array (either updated parse table or empty-error)
   */
  public function validate(string $cfgfile): array
  {
    # This occurs when we have bad injection values
    # in the constructor.
    if($this->instantiation_error){
      return array();
    }
    $this->cfgfile = $cfgfile;
    $this->cfgpath = $this->rootpath . $this->modspath . '/' . $cfgfile;

    $modspath = $this->verify_modspath($this->modspath);
    if (is_numeric($modspath)) {
      return array();
    }

    $this->init_class_properties();

    $this->parse($this->cfgpath);

    /* Mod config file processing loop */
    while (true) {
      if (!empty($this->parse_error))
        break;

      /*************************************************************
          VALIDATE PARSE TABLE DIRECTIVES AND ADD STATUS TO TABLE
       *************************************************************/
      for ($i = 0; isset($this->parse_table[$i]); $i++) {
        $directive_name = $this->parse_table[$i]['name'];

        /* The location directive processes all file editing directives.*/
        if (in_array($directive_name, $this->file_modifiers))
          continue;

        /* PHP allows assignment of a function name to a variable
            ** and then executing the "variaable" with arguments. We get the
            ** function name associated with the current directive from
            ** the $proclist in Modbase.
            */
        $function = $this->proclist[$directive_name];

        # Add validation function prefix
        $function = 'v' . $function;

        $refj = $i; // record the current state of the index $i

        /***********************************************************/
        /* Use preset function to set status of this directive.
            **
            ** ALL FUNCTIONS MUST RETURN $i OR MODVALIDATOR WILL CRASH!
            */
        $i = $this->$function($i);
        /***********************************************************/

        /* Prevent infinite looping if index $i comes back corrupted */
        if ($i < $refj) {
          $this->parse_error['line'] = $i;
          $this->parse_error['tag']  = 'V' . __LINE__ .
            ' <strong>Index </strong>';
          $this->parse_error['text'] = 'errors';
        }

        /* Status Error result? Emit and stop validating. */
        if (!empty($this->parse_error)) {
          break;
        }
      }
      break;
    } // while(true) - mod config file processing loop

    $this->set_modstatus_header();

    $this->collect_status($cfgfile);

    return $this->parse_table;
  } // validate()

  /**
   * @param bool $create_mm_datafile 
   * @param string $cfgpath 
   * @return array ($mmdata all-mod status array - empty if error) 
   */
  public function check_status(bool $create_mm_datafile = false, string $cfgpath = ''): array
  {
    # This occurs when we have bad injection values
    # in the constructor.
    if($this->instantiation_error){
      return array();
    }
    $modspath = $this->verify_modspath($this->modspath);
    if (is_numeric($modspath)) {
      return array();
    }

    if (empty($cfgpath)) {
      $modlist = $this->get_modfile_names();

      /* If get_modlisting failed (mods empty, missing, etc), return empty list */
      if (!empty($this->sysmsg)) {
        return array();
      }
    } else {
      $modlist[] = $cfgpath;
    }

    foreach ($modlist as $modfile) {
      $this->validate($modfile);
    }

    if ($create_mm_datafile) {
      $this->output_mm_data();
    }

    return $this->mmdata;
  } // check_status

  /***************************************************************
    MOD MANAGER DIRECTIVE FUNCTIONS
   ***************************************************************/
  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_author(int $i): int
  {
    # If arg2 is given, valdiate as url.
    $datapack = $this->parse_table[$i];

    if (!empty($datapack['arg2'])) {
      # URL will not validate if it contains spaces
      $datapack['arg2'] = trim($datapack['arg2']);
      $url = str_replace(" ", "&nbsp;", $datapack['arg2']);
      if (!$this->validate_url($url)) {
        $this->parse_error['line'] = $datapack['line'];
        $this->parse_error['tag']  = 'v' . __LINE__ . ' %author arg2';
        # Index into $admtext array
        $this->parse_error['text'] = self::BADCHAR;
      } else {
        $datapack['arg2'] = $url;
      }
    }
    return $i;
  }

  private function v_choices(int $i): int
  {
    return $i;
  }

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_copyfile(int $i): int
  {
    /*  %copyfile directive datapack map ($parse_table[$i])
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == copyfile or copyfile2
    **  $datapack['arg1'] == full server path to source file
    **  $datapack['arg2'] == full server path to destination file
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == flag (if any)
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == empty, will be filled here
    **  $datapack['eline'] == error line, will be filled if error
    */

    /* Get datapack from parse table and breakout validation items */
    $datapack = $this->parse_table[$i];
    $flag = $datapack['flag'];
    $srcpath = $datapack['arg1'];
    $destpath = $datapack['arg2'];

    $this->num_required++;    // total ops required
    $this->copies_required++; // total copies required

    while (true) {
      /* The SOURCE file must exist. */
      if (!file_exists($srcpath) || is_dir($srcpath)) {
        $this->num_errors++;
        $datapack['statkey'] =
          self::vERROR + self::vSRCFILE + self::vMISSING;
        $datapack['eline'] = __LINE__;
        break;
      }

      if (file_exists($destpath)) {
        $datapack['statkey'] = self::vINSTALLED;
        $this->num_installed++;
        $this->copies_installed++;

        if ($flag == self::FLAG_PROTECTED) {
          /* In place and nothing further required */
          $this->num_required--;
          $this->num_installed--;
          $this->copies_required--;
          $this->copies_installed--;
          $datapack['statkey'] += self::vPROTECTED;
        } elseif ($flag == self::FLAG_OPTIONAL) {
          $datapack['statkey'] += self::vOPTIONAL;
        } elseif ($flag == self::FLAG_PROVISIONAL) {
          $datapack['statkey'] += self::vPROVISIONAL;
        }
        break;
      }

      $thefolder = pathinfo($destpath, PATHINFO_DIRNAME);
      if (!file_exists($thefolder) || !is_dir($thefolder)) {
        $datapack['statkey'] =
          self::vDSTFOLDER + self::vMISSING;

        if ($flag == self::FLAG_PROVISIONAL) {
          $this->num_required--;
          $this->provisional_errors++;
          $datapack['statkey'] += self::vPROVISIONAL;
        } else {
          /* The destination folder for the copyfile does not exist
          **  and the copyfile is not flagged as provisional.*/
          $this->num_errors++;
          $datapack['statkey'] += self::vERROR;
          $datapack['eline'] = __LINE__;
        }
        break;
      }

      /* Copied file does not exist yet. */
      $datapack['statkey'] = self::vNOTINST;

      if ($flag == self::FLAG_OPTIONAL) {
        $datapack['statkey'] += self::vOPTIONAL;
        break;
      }

      if ($flag == self::FLAG_PROTECTED) {
        $datapack['statkey'] += self::vPROTECTED;
        break;
      }

      if ($flag == self::FLAG_PROVISIONAL) {
        $datapack['statkey'] += self::vPROVISIONAL;
        break;
      }
      break;
    } // while

    /* Return datapack to parse table */
    $this->parse_table[$i] = $datapack;

    return $i;
  } // _copyfile()

  private function v_desc(int $i): int
  {
    return $i;
  }

  private function v_description(int $i): int
  {
    return $i;
  }

  private function v_fileexists(int $i): int
  {
    return $i;
  }

  private function v_goto(int $i): int
  {
    return $i;
  }

  # File modifier functions called by %location: and not from $proclist.

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_insert(int $i): int
  {
    /*  %insert directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == insert:before or insert:after
    **  $datapack['arg1'] == code to be inserted into the target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == empty, will be filled here
    **  $datapack['eline'] == empty, may be filled here
    */

    $location_datapack = $this->parse_table[$i];

    /* Trim spaces and tabs from each end of the
    ** Location code block to avoid 'bad target' errors
    ** in leading whitespace. */

    $location_block = trim($location_datapack['arg1'], " \t");

    /* Point to the %insert directive with its code block
    ** immediately following the %location directive */
    $i++;

    $insert_datapack = $this->parse_table[$i];
    $insertion_block = $insert_datapack['arg1'];

    /* Main processing loop - break out when status is resolved */
    while (true) {
      /* %insert directive logic for modvalidator:
      **
      ** $num_locstr  $num_newstr  status
      ** ----------------------------------
      **                  1       'installed'
      **    0                     'badtarget'
      **   >1                     'location notunique'
      **                 >1       'new string notunique'
      **                  0       'notinst' (installable)
      */

      /* Check for empty location code - cannot install */
      if (empty(trim($location_block))) {
        /* There is no code between the location directive and
        ** the %end:% tag. */
        $this->num_errors++;
        $insert_datapack['statkey'] =
          self::vLOCCODE + self::vNOCONTENT + self::vERROR; //1
        $insert_datapack['eline'] = __LINE__;
        break;
      }

//echo basename(__FILE__),': ',__LINE__,'<pre>';print_r([$this->parse_table, $location_block]);
      /* Get the counts. */
      $num_locstr = substr_count(
        $this->target_file_contents,
        $location_block
      );
//echo basename(__FILE__),': ',__LINE__,'<pre>';print_r([$num_locstr, $this->target_file_contents]);exit;
      

      $num_newstr = substr_count(
        $this->target_file_contents,
        $insertion_block
      );

      if ($num_newstr == 1) {
        $this->num_installed++;
        $this->mods_installed++;
        $insert_datapack['statkey'] =
          self::vINSTALLED; //3
        break;
      }

      if ($num_locstr == 0) {
        /* The insertion code was not found and now the target
        ** location code is not found either. Assume this mod
        ** insertion was not installed and the target code is bad.
        ** Compare the mod location text against the target file.
        ** Pay special attention to leading whitespace differences.*/
        $this->num_errors++;
        $insert_datapack['statkey'] =
          self::vBADTARGET + self::vERROR; //4
        $insert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_locstr > 1) {
        /* The location code has been found more than once in the
         ** target file. Left over garbage from previous
         ** installs/uninstalls may be to blame,or the target code is
         ** truly not unique. Check the target file. If you suspect
         ** garbage, get a fresh copy of the target file from the TNG
         ** package or wherever it came from.*/
        $this->num_errors++;
        $insert_datapack['statkey'] =
          self::vLOCCODE + self::vNOTUNIQUE + self::vERROR; //5
        $insert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_newstr > 1) {
        /* The mod insertion code has been found more than once in the
        ** target file. Left over garbage from previous
        ** installs/uninstalls may be to blame. Try refreshing the
        ** target file.*/
        $this->num_errors++;
        $insert_datapack['statkey'] =
          self::vCFGCODE + self::vNOTUNIQUE + self::vERROR; //6
        $insert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_newstr == 0) {
        $insert_datapack['statkey'] =
          self::vNOTINST; //7
        break;
      }

      /* Processing should never reach this point. If it does check
      ** both of the string counts to see what happened. Check for
      ** leftover mod garbage in the target file.*/
      $this->num_errors++;
      $insert_datapack['statkey'] =
        self::vERROR; //8
      $insert_datapack['eline'] = __LINE__;
      break;
    } // while(true)

    /* Return updated datapack to parse table */
    $this->parse_table[$i] = $insert_datapack;
    return $i;
  } // _insert()

  private function v_label(int $i): int
  {
    return $i;
  }

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_location(int $i): int
  {
    /*  %location directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == location
    **  $datapack['arg1'] == code to be found in the target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == empty, will be filled here
    **  $datapack['eline'] == empty, may be filled here
    */

    /* A file editing directive always follows %location
    ** in the parse table. Get the name for the dispatcher.*/

    $directive_name = $this->parse_table[($i + 1)]['name'];

    while (true) {
      /* Target file must be open to operate on it.*/
      if (!$this->is_target) {
        break;
      }

      $datapack = $this->parse_table[$i];

      $this->num_required++;
      $this->mods_required++;

      /* Call the file editing directive function to finish
      ** breaking out and validating the location.*/
      $function = $this->proclist[$directive_name];

      # Add the validator function prefix
      $function = 'v' . $function;

      if (!is_string($function)) {
        $this->parse_error['line'] = $this->parse_table[$i + 1]['line'];
        $this->parse_error['tag']  = 'V' . __LINE__ .
          " <strong>$directive_name </strong>";
        $this->parse_error['text'] = 'tagunk';
        $i++;
        break;
      }

      /* Dispatch to modifier function for final processing.*/
      $i = $this->$function($i);
      break;
    } //while

    return $i;
  } // _location()

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_mkdir(int $i): int
  {
    /*  %mkdir directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == mkdir
    **  $datapack['arg1'] == directory (folderpath) to be created
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == if any, optinal @
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == empty, will be filled here
    **  $datapack['eline'] == empty, may be filled here
    */

    $datapack = $this->parse_table[$i];

    $dest_path = $datapack['arg1'];

    $this->num_required++;
    $this->newdirs_required++;

    // REPORT ON EXISTENCE OF FOLDER
    if (!file_exists($dest_path)) {
      $datapack['statkey'] =
        self::vNOTINST; //1
    } else {
      $this->num_installed++;
      $this->newdirs_installed++;
      $datapack['statkey'] =
        self::vINSTALLED; //2
    }

    $this->parse_table[$i] = $datapack;

    return $i;
  } // _mkdir()

  private function v_name(int $i): int
  {
    return $i;
  }

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_newfile(int $i): int
  {
    /*  %newfile directive map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == newfile
    **  $datapack['arg1'] == filepath for new file
    **  $datapack['arg2'] == content of new file
    **  $datapack['arg3'] == version number of new file
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    **  $datapack['statkey'] == status empty, will be filled here
    **  $datapack['eline'] == error line empty, may be filled here
    */

    /* Get datapack from parse table and break out validaton elements */
    $datapack = $this->parse_table[$i];
    $destpath = $datapack['arg1'];
    $content = $datapack['arg2'];
    $version = $datapack['arg3'];
    $flag = $datapack['flag'];

    $this->num_required++;
    $this->newfiles_required++;

    while (true) {
      /* If the file exists, verify it is the correct version */
      if (file_exists($destpath) && is_file($destpath)) {
        $newfile_content = file_get_contents($destpath);
        if (preg_match("#%version:([^%]+)%#", $newfile_content, $matches)) {
          unset($newfile_content);
          if ($matches[1] == $version) {
            $this->num_installed++;
            $this->newfiles_installed++;
            $datapack['statkey'] =
              self::vINSTALLED; //2

            if ($flag == self::FLAG_PROTECTED) {
              $this->num_required--;
              $this->newfiles_required--;
              $datapack['statkey'] +=
                self::vPROTECTED; //1
            }
            break;
          }
        }
      }

      /* Correct file does not exist at this point */

      // Match cfg internal fileversions
      if (!preg_match("#%version:" . $version . "%#", $content)) {
        /* MM requires that the internal version number for the newfile
        ** matches the external version given in the mod.
        ** If you get this error visually check version numbers
        ** to see that the developer has updated them.
        */
        $this->num_errors++;
        $datapack['statkey'] =
          self::vVERSION + self::vERROR; //3
        $datapack['eline'] = __LINE__;
        break;
      }

      /* Handle missing destination folder */
      $thefolder = pathinfo($destpath, PATHINFO_DIRNAME);
      if (!file_exists($thefolder) || !is_dir($thefolder)) {
        /* We hold this provisional because the mod may
        ** create the missing directory with %mkdir, or it
        ** may use an assisting script to create it prior to
        ** installation. */
        if ($flag == self::FLAG_PROVISIONAL) {
          $this->num_required--;
          $this->newfiles_required--;
          $this->provisional_errors++;
          $datapack['statkey'] =
            self::vDSTFOLDER + self::vMISSING + self::vPROVISIONAL; //4
          break;
        } else {
          // Folder missing -- error
          $this->num_errors++;
          $datapack['statkey'] =
            self::vDSTFOLDER + self::vMISSING + self::vERROR; //5
          $datapack['eline'] = __LINE__;
          break;
        }
        break;
      }

      $datapack['statkey'] =
        self::vNOTINST; //6
      break;
    } //while

    /* Return updated datapack to the parse_table */
    $this->parse_table[$i] = $datapack;

    return $i;
  } // _newfile()

  private function v_note(int $i): int
  {
    return $i;
  }

  private function v_parameter(int $i): int
  {
    $this->parameters++;
    return $i;
  } //_parameter()

  private function v_private(int $i): int
  {
    return $i;
  }

  private function v_range(int $i): int
  {
    return $i;
  }

  /* File modifier functions called by %location: and not from $proclist */
  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_replace(int $i): int
  {
    /*  %replace directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == replace
    **  $datapack['arg1'] == replacement code for location in target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == status empty, will be filled here
    **  $datapack['eline'] == error line empty, may be filled here
    */

    /* The status string ($statstring) has been started in the _location()
    ** function.  It will be completed and registered here.*/

    /* Get the datapack from the parse table */
    $location_datapack = $this->parse_table[$i];
    $location_block = $location_datapack['arg1'];

    $i++;  // point to the file modifier directive datapack

    $replace_datapack = $this->parse_table[$i];
    $replacement_block = $replace_datapack['arg1'];

    # Trim leading and trailing spaces and tabs so we insert between them
    # Have to do it in both location and replacement codeblocks.
    # We are not supposed to modify codeblocks -- is this a modification?
    # no, codeblocks must begin and end with CRLF not other whitespace.
    //$location_block = trim( $location_block, " \t" );
    //$replacement_block = trim( $replacement_block, " \t" );
    $location_block = trim($location_block, " \t");
    $replacement_block = trim($replacement_block, " \t");

    /* Main processing loop - break out when status is resolved */
    while (true) {
      /* Check for empty insertion code - cannot install */
      if (empty(trim($replacement_block))) {
        /* The %replace directive seems to be missing its
        ** replacement code.  Check the mod confuration file
        ** for missing or malformed elements.*/
        $this->num_errors++;
        $replace_datapack['statkey'] =
          self::vCFGCODE + self::vNOCONTENT + self::vERROR; //1
        $replace_datapack['eline'] = __LINE__;
        break;
      }

      /* Check for empty location code - cannot install */
      if (empty(trim($location_block))) {
        /* The location block seems to be empty.  Check the
        ** the mod confuration file for missing or malformed
        ** location code.*/
        $this->num_errors++;
        $replace_datapack['statkey'] =
          self::vLOCCODE + self::vNOCONTENT + self::vERROR; //2
        $replace_datapack['eline'] = __LINE__;
        break;
      }

      /* Replacement Logic:
      ** Count occurrences of location code ($num_locstr) and replacement code
      ** ($num_newstr) in target file buffer and determine status according
      ** to number of each:
      **
      ** $num_locstr  $num_newstr  status
      ** ----------------------------------
      **                  1       'installed'
      **    0                      not installed, 'badtarget'
      **   >1                      not installed, target 'notunique'
      **                 >1        not installed, replacement 'notunique'
      **                  0       'notinst'
      */

      $num_newstr = substr_count($this->target_file_contents, $replacement_block);
      $num_locstr = substr_count($this->target_file_contents, $location_block);

      # How do we know the replacement strings has not been installed yet, but
      # duplicates an existing string in the target file?
      # We can only be sure if the location block is not found.
      # If the location string is found, the replacement will duplicate.
      # So we should verify no location string before declaring this installed.

      if ($num_newstr == 1) {
        $this->num_installed++;
        $this->mods_installed++;
        $replace_datapack['statkey'] =
          self::vINSTALLED; //3
        break;
      }

      if ($num_newstr > 1) {
        /* Replacement code is in quasi-installed state. There is more
        ** than one ocurrance in the target file and is most likely
        ** caused by garbage left in the target file from prevous mod
        ** installations.  This could be a Mod Manager issue. Clean up
        ** the target file and carefully install and uninstall the mod
        ** while inspecting each result.*/
        $this->num_errors++;
        $replace_datapack['statkey'] =
          self::vCFGCODE + self::vNOTUNIQUE + self::vERROR; //6
        $replace_datapack['eline'] = __LINE__;
        break;
      }

      # Replacement string is not installed, so check target file location.

      if ($num_locstr == 0) {
        # Target string is not found -- bad target.
        $this->num_errors++;
        $replace_datapack['statkey'] =
          self::vBADTARGET + self::vERROR; //4
        $replace_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_locstr > 1) {
        # Multiple occurrances of the location string -- not unique
        $this->num_errors++;
        $replace_datapack['statkey'] =
          self::vLOCCODE + self::vNOTUNIQUE + self::vERROR; //5;
        $replace_datapack['eline'] = __LINE__;
        break;
      }

      # So replacement string has not been installed and the target
      # string has been found.  Now we need to check the location code
      # against the target file to verify we have a complete block --
      $is_block_start = $is_block_end = false;
      if (false !== $p = strpos($this->target_file_contents, $location_block)) {
        # Travers backward from beginning of location block text in file buffer
        # until we reach the beginning of the file or a CRLF with no
        # intervening characters except spaces and tabs.
        $x = $p;
        while (true) {
          if ($x == 0) {
            $is_block_start = true;
            break;
          }

          $x--;

          if (
            $this->target_file_contents[$x] == " "
            || $this->target_file_contents[$x] == "\t"
          ) {
            continue;
          }

          if ($this->target_file_contents[$x] == "\n") {
            $is_block_start = true;
            break;
          }

          break;
        }

        if (!empty($is_block_start)) {
          # Travers forward from end of location block text in file buffer
          # until we reach the end of the file or a CRLF with no
          # intervening characters except spaces and tabs.
          $bufflen = strlen($this->target_file_contents);
          $x = $p + strlen($location_block) - 1;
          if($location_block == "\$showparents_names = 0;")
          {
          //echo basename(__FILE__),': ',__LINE__,'<pre>';print_r([$x, $bufflen]);exit;
          }          

          while (true) {
            $x++;

            if ($x >= $bufflen - 1) {
              # At end of buffer
              $is_block_end = true;
              break;
            }

            if (
              $this->target_file_contents[$x] == " "
              || $this->target_file_contents[$x] == "\t"
            ) {
              continue;
            }

            if ($this->target_file_contents[$x] == "\r") {
              $is_block_end = true;
              break;
            }

            if($x >= $bufflen-1){
              $is_block_end = true;
              break;
            }

            break;
          } // while true
        }
   
        if (empty($is_block_start) || empty($is_block_end)) {
          $this->num_errors++;
          $replace_datapack['statkey'] =
            self::vCFGCODE + self::vNOFRAG + self::vERROR; //
          $replace_datapack['eline'] = __LINE__;
          break;
        }

      } // if %location block found

      if ($num_newstr == 0) {
        $replace_datapack['statkey'] =
          self::vNOTINST; //7
        break;
      }

      /* Processing should not reach this point, so it is an unknown
      ** error. Using the mod which caused this, trace the counts
      ** through the loop.*/
      $this->num_errors++;
      $replace_datapack['statkey'] =
        self::vERROR; //8
      $replace_datapack['eline'] = __LINE__;
      break;
    } // while(true)

    /* Return the updated replace directive datapack to the parse table */
    $this->parse_table[$i] = $replace_datapack;

    return $i;
  } // _replace()

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_target(int $i): int
  {
    /*  %target directive map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == target
    **  $datapack['arg1'] == server filepath to target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == optional flag (@)
    **  $datapack['goto'] == empty
    **  $datapack['statkey'] == status empty, will fill it here
    **  $datapack['eline'] == error line empty, may be filled here
    */

    $this->active_target_file = '';
    $this->is_target   = false;

    $datapack = $this->parse_table[$i];
    $file = $datapack['arg1'];
    $flag = $datapack['flag'];

    // Function increases global error count if unable to read
    $this->target_file_contents = $this->read_file_buffer($file, $flag);

    while (true) {
      /* Note target file retrieval errors if any */
      if (is_numeric($this->target_file_contents)) {
        $code = $this->target_file_contents;

        if ($code == self::BYPASS) // OPTIONAL
        {
          if ($this->num_installed > 0) {
            $datapack['statkey'] =
              self::vMISSING + self::vOPTIONAL + self::vBYPASSED; //1
          } else {
            $datapack['statkey'] =
              self::vMISSING + self::vOPTIONAL; //2
          }
          break;
        }

        if ($code == self::PROVISIONAL) {
          if ($this->num_installed > 0) {
            /* Mod installed - no provisiona file */
            $datapack['statkey'] =
              self::vMISSING + self::vPROVISIONAL + self::vERROR; //3
            $datapack['eline'] = __LINE__;
          } else { // mod not installed - no error yet
            $datapack['statkey'] =
              self::vMISSING + self::vPROVISIONAL; //4
          }
          break;
        }

        if ($code == self::NOFILE) {
          $datapack['statkey'] =
            self::vMISSING + self::vERROR; //5
          $datapack['eline'] = __LINE__;
          break;
        }

        if ($code == self::NOWRITE) {
          $datapack['statkey'] =
            self::vNOWRITE + self::vERROR; //6
          $datapack['eline'] = __LINE__;
          break;
        }

        if ($code == self::ISEMPTY) {
          $datapack['statkey'] =
            self::vNOCONTENT + self::vERROR; //7;
          $datapack['eline'] = __LINE__;
          break;
        }
      } //is_numeric
      else {
        $datapack['statkey'] =
          self::vVERIFIED; //8 verified
        $this->is_target   = true;
        $this->active_target_file = $file;

        /* CRLF added to beginning and end of target file buffer
         * to facilitate locating target text.  Modvalidator
         * never writes buffer back out so the target file remains
         * unchanged.*/
        //$this->target_file_contents = "\r\n" . $this->target_file_contents . "\r\n";
        break;
      }
      break;
    } // while

    /* Return updated datapack to the parse table */
    $this->parse_table[$i] = $datapack;

    return $i;
  } // _target()

  private function v_tngversion(int $i): int
  {
    return $i;
  }

  private function v_textexists(int $i): int
  {
    return $i;
  }

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_triminsert(int $i): int
  {
    /*  %triminsert directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == replace
    **  $datapack['arg1'] == code for insertion into target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == status empty, will fill it here
    **  $datapack['eline] == error line empty, may fill it here
    */

    /* This funtion is called by _location() and not directly by the
    ** modvalidator processing loop.
    */

    $location_datapack = $this->parse_table[$i];

    /* In spite of the directive name, no trimming or modification is done
    ** to the raw code. */
    $location_code = $location_datapack['arg1'];

    $i++; // Point to the triminsert directive in the parse table

    $triminsert_datapack = $this->parse_table[$i];
    $triminsert_snip = $triminsert_datapack['arg1'];
    $triminsert_op = $triminsert_datapack['name'];

    /* Main processing loop - break out when status is resolved */
    while (true) {
      /* Check for empty insertion code - cannot install */
      if (empty(trim($triminsert_snip))) {
        /* The triminsert code appears to be missing from the mod config file.
        ** Visually inspect the mod to see if the code is truly missing.
        */
        $this->num_errors++;
        $triminsert_datapack['statkey'] =
          self::vCFGCODE + self::vNOCONTENT + self::vERROR; //1
        $triminsert_datapack['eline'] = __LINE__;
        break;
      }

      /* Combine the location code with the triminsert code for the
      ** purpose of searching the target file. If installed, they
      ** will be found together.
      */
      $composite_code = $triminsert_op == 'triminsert:before'
        ? $triminsert_snip . $location_code
        : $location_code . $triminsert_snip;

      /* Logic:
      ** Triminsert code can be quite short and by itself may generate
      ** "Not Unique" errors. So we combine the target and triminsert code
      ** and use that to determine if it has been installed or not.
      **
      ** Count occurrences of location code ($num_locstr), and composite
      ** code ($num_compstr) in target file buffer and determine status
      ** according to number of each:
      **
      ** $num_locstr  $num_compstr  status
      ** ----------------------------------
      **                  1         'installed'
      **    0                        not installed, 'badtarget'
      **   >1                        not installed, target 'not unique'
      **                 >1          not installed, composite 'not unique'
      **                  0         'notinst'
      */

      /* Get number of composite code strings in target buffer. */
      $num_compstr = substr_count($this->target_file_contents, $composite_code);

      /* Get number of location strings in target buffer. */
      $num_locstr = substr_count($this->target_file_contents, $location_code);

      if ($num_compstr == 1) {
        $this->num_installed++;
        $this->mods_installed++;
        $triminsert_datapack['statkey'] =
          self::vINSTALLED; //2
        break;
      }

      if ($num_locstr == 0) {
        /* Directive not installed and the location code was not found.
        ** Check the mod location code against the target file to see if the
        ** target file code has been changed by TNG or another mod.
        */
        $this->num_errors++;
        $triminsert_datapack['statkey'] =
          self::vBADTARGET + self::vERROR; //3
        $triminsert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_locstr > 1) {
        /* If the target code is not unique, we could have a developer
        ** error, but more likely the target file has been changed by
        ** TNG or another mod.*/
        $this->num_errors++;
        $triminsert_datapack['statkey'] =
          self::vLOCCODE + self::vNOTUNIQUE + self::vERROR; //4
        $triminsert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_compstr > 1) {
        /* Most likely this error is caused by garbage left in the
        ** target file by previous mod installs/uninstalls.
        ** Get clean copy of target file and check again for
        ** Mod Manager error or problems with the mod, by visually
        ** checking the results at each step.*/
        $this->num_errors++;
        $triminsert_datapack['statkey'] =
          self::vCFGCODE + self::vNOTUNIQUE + self::vERROR; //5
        $triminsert_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_compstr == 0) {
        $triminsert_datapack['statkey'] =
          self::vNOTINST; //6
        break;
      }

      /* Processing should never reach this point, so we have an
      ** unknown error.Start by listing the mod generating this
      ** error and looking at the counts for the loation and
      ** composite strings.  Also check the PHP logs.*/
      $this->num_errors++;
      $triminsert_datapack['statkey'] =
        self::vERROR; //7
      $triminsert_datapack['eline'] = __LINE__;
      break;
    } // while(true)

    /* Return updated datapack to the parese table */
    $this->parse_table[$i] = $triminsert_datapack;

    return $i;
  } // _triminsert()

  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_trimreplace(int $i): int
  {
    /*  %trimreplace directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == replace
    **  $datapack['arg1'] == replacement code for location in target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == status empty, will be filled here
    **  $datapack['eline'] == error line empty, may be filled here
    */

    /* The status string ($statstring) has been started in the _location()
    ** function.  It will be completed and registered here.
    **
    ** This is a Non block operation - straight replacement, one for one.*/

    $location_datapack = $this->parse_table[$i];
    $location_snip = $location_datapack['arg1'];

    $i++; // point to the trimreplace directive

    $trimreplace_datapack = $this->parse_table[$i];
    $trimreplace_snip = $trimreplace_datapack['arg1'];

    /* Main processing loop - break out when status is resolved */
    while (true) {
      /* Check for empty trimreplace code - cannot install */
      if (empty(trim($trimreplace_snip))) {
        $this->num_errors++;
        $trimreplace_datapack['statkey'] =
          self::vCFGCODE + self::vNOCONTENT + self::vERROR; //1
        $trimreplace_datapack['eline'] = __LINE__;
        break;
      }

      /* Location code is the same as the trimreplace code -- no action */
      if ($trimreplace_snip == $location_snip) {
        $this->num_required--;
        $this->mods_required--;
        $trimreplace_datapack['statkey'] =
          self::vVERIFIED; //2
        break;
      }

      /* Logic:
      **
      ** Count occurrences of location code ($num_locstr) and trimreplace code
      ** ($num_newstr) in target file buffer and determine status according
      ** to number of each:
      **
      ** $num_locstr  $num_newstr  status
      ** ----------------------------------
      **                  1       'installed'
      **    0                      not installed, 'badtarget'
      **   >1                      not installed, location 'notunique'
      **                 >1        not installed, replacement 'notunique'
      **                  0       'notinst'
      **
      ** Replacement code may contain the location code -- check for replacement code
      ** first.
      */

      /* Get number of location strings in target buffer. */
      $num_locstr = substr_count($this->target_file_contents, $location_snip);

      /* Get number of trimreplace strings in the buffer */
      $num_newstr = substr_count($this->target_file_contents, $trimreplace_snip);

      if ($num_newstr == 1) {
        $this->num_installed++;
        $this->mods_installed++;
        $trimreplace_datapack['statkey'] =
          self::vINSTALLED; //3
        break;
      }

      if ($num_locstr == 0) {
        /* Trimreplace not installed, but the target code was not
        ** found either. Most likely caused by change/update in TNG or
        ** other target file. Possibly changed by another mod.
        ** Check the target file for updates or mod conflicts.*/
        $this->num_errors++;
        $trimreplace_datapack['statkey'] =
          self::vBADTARGET + self::vERROR; //4
        $trimreplace_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_locstr > 1) {
        /* Possibly mod developer error, but more likely the target
         ** file has been changed by its author or by another mod.
         ** Check the target file for updates or mod conflicts.*/
        $this->num_errors++;
        $trimreplace_datapack['statkey'] =
          self::vLOCCODE +  self::vNOTUNIQUE + self::vERROR; //5
        $trimreplace_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_newstr > 1) {
        /* Error most likely caused by garbage left over from
        ** previous mod installs or removal. Try running with a
        ** clean copy of the target files and examine it while
        ** installing and removing the offending mod.*/
        $this->num_errors++;
        $trimreplace_datapack['statkey'] =
          self::vCFGCODE + self::vNOTUNIQUE + self::vERROR; //6
        $trimreplace_datapack['eline'] = __LINE__;
        break;
      }

      if ($num_newstr == 0) {
        $trimreplace_datapack['statkey'] =
          self::vNOTINST; //7
        break;
      }

      /* Processing should never reach this point, so we have an
      ** unknown error. While displaying only the problem mod,
      ** print out the contents of the search counts above to see
      ** how they led to this error.*/
      $this->num_errors++;
      $trimreplace_datapack['statkey'] =
        self::vERROR; //8
      $trimreplace_datapack['eline'] = __LINE__;
      break;
    } // while(true)

    /* Replace the updated trimreplace datapack in the parse table */
    $this->parse_table[$i] = $trimreplace_datapack;

    return $i;
  } // _trimreplace()

  private function v_version(int $i): int
  {
    return $i;
  }

  # Function only works with variables. Text is ignored. Additional
  # text/commentary can be added separately using the %insert directive.
  /**
   * @param int $i (parse table index)
   * @return int (parse table index)
   */
  private function v_vinsert(int $i): int
  {
    /*  %vinsert directive datapack map == $this->parse_table[$i]
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == vinsert:before or vinsert:after
    **  $datapack['arg1'] == vinsert code (variable assignments)
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty (not a conditional directive)
    **  $datapack['statkey'] == status empty, will be filled here
    **  $datapack['eline'] == error line empty, may be filled here
    */

    // Currently points to location directive in parse table
    $location_datapack = $this->parse_table[$i];
    $location_code = $location_datapack['arg1'];

    $i++; // point to vinsert directive in parse table
    $vinsert_datapack = $this->parse_table[$i];

    # Start verifying that parameters exist in the target file

    $vinserts = explode("\r\n", $vinsert_datapack['arg2']);

    $num_vinsert_vars_installed = 0;

    # We will be changing this to require vars to start on their own line
    /* In the parese_table capture all vars that start on their
    ** own line or follow a semicolon (;) when listed on a single
    ** line in the mods vinsert code.
    ** How do we know these vars are parameters?*/

    $num_vinsert_vars = count($vinserts);

    while (true) {
      foreach ($vinserts as $vinsert) {
        # Escape any special regex characters.
        $vinsert = preg_quote($vinsert);

        # Ensure vinserted vars start on it's own line so we don't
        # count vars that have been commented out.

        if (false !== preg_match_all("#^\s*" . $vinsert . "#ms", $this->target_file_contents, $matches)) {
          $count = count($matches[0]);
        } else {
          $count = 0;
        }

        if ($count > 1) {
          # This variable assignment is not unique in the target file.
          # If we don't observer uniqueness, unmodified targt file could
          # show status Partially installed.
          $this->num_errors++;
          $vinsert_datapack['statkey'] =
            self::vCFGCODE + self::vNOTUNIQUE + self::vERROR; //1
          $vinsert_datapack['eline'] = __LINE__;
          break 2;
        } elseif ($count == 1) {
          $num_vinsert_vars_installed++;
        }
      }

      if ($num_vinsert_vars_installed > 0) {
        if ($num_vinsert_vars_installed == $num_vinsert_vars) {
          /* All vinsert variabls are installed in target file. */
          $this->num_installed++;
          $this->mods_installed++;
          $vinsert_datapack['statkey'] =
            self::vINSTALLED; //2
          break;
        } elseif ($num_vinsert_vars_installed < $num_vinsert_vars) {
          $this->provisional_errors++;
          $this->num_installed++;
          $vinsert_datapack['statkey'] =
            self::vPARTINST + self::vERROR; //3
          $vinsert_datapack['eline'] = __LINE__;
          break;
        }
      } else {
        /* Vinsert variables have not been installed yet */
        $vinsert_datapack['statkey'] =
          self::vNOTINST; //4
        break;
      }
      break;
    } //while

    /* Replace the updated vinsert datapack in the parse table */
    $this->parse_table[$i] = $vinsert_datapack;

    return $i;
  } // _vinsert()

  private function v_wikipage(int $i): int
  {
    return $i;
  }


  /**********************************************************************
  SUPPORTING FUNCTIONS
   **********************************************************************/
  /**
   * @param string $modfile 
   * @return int modstatus code 
   */
  private function collect_status(string $modfile): int
  {
    $modstat['modfile'] = $modfile;
    $modstat['status'] = '';

    /* status codes
    ** 0 Okay to install
    ** 1 Installed
    ** 2 Partially installed
    ** 3 Cannot install
    **/

    while (true) {
      // IF PARSE ERROR COMPLAIN AND QUIT
      if (!empty($this->parse_error)) {
        //$this->num_errors++;
        $modstat['status'] = 3; // CANTINST
        break;
      }

      /* Mod uninstalled - no mkdir errors.
      ** If the only thing installed is a directory which you may not
      ** be able to remove --- show as uninstalled.*/
      if ($this->num_installed == $this->newdirs_installed) {
        $this->num_installed = 0;
        $this->newdirs_installed = 0;
      }

      if ($this->num_installed > 0 && (
        $this->num_installed < $this->num_required ||
        $this->provisional_errors > 0)) {
        $modstat['status'] = 2; // partially installed
        break;
      }

      // INSTALLED OR OK TO INSTALL - NO ERRORS
      if (!$this->num_errors) {
        if ($this->num_required > 0) {
          if ($this->num_installed == $this->num_required) {
            $modstat['status'] = 1;
            break;
          }

          if ($this->num_installed == 0) {
            $modstat['status'] = 0; // okay to install
            break;
          }
        }
      }

      // CAN'T INSTALL - WARNINGS OR ERRORS NOTED
      if (empty($modstat['status'])) {
        $modstat['status'] = 3; // can't install
      }
      break;
    } // while
    $this->mmdata[] = $modstat;
    return $modstat['status'];
  }

  public function get_modname(): string
  {
    return $this->modname;
  }

  public function get_modstatus_header(): string
  {
    return $this->modstatus_header;
  }

  public function get_modversion(): string
  {
    return $this->version;
  }

  private function init_class_properties()
  {
    $this->status_string = '';
    $this->description = $this->note = $this->private = $this->wikipage = $wikilink = '';
    $this->is_target   = false;

    // statistics
    $this->num_required = 0;
    $this->mods_required = 0;
    $this->copies_required = 0;
    $this->newfiles_required = 0;
    $this->newdirs_required = 0;

    $this->num_installed = 0;
    $this->mods_installed = 0;
    $this->copies_installed = 0;
    $this->newfiles_installed = 0;
    $this->newdirs_installed = 0;
    $this->parameters = 0;
    $this->num_errors = 0;
    $this->provisional_errors = 0;
    $this->target_file_contents = '';
    $this->active_target_file = '';
    $this->is_target = false;
    $this->warning = '';
    $this->modstatus_header = '';

    return;
  } // init_class_properties()

  /** @return array  */
  protected function output_mm_data(): array
  {
    $mm_data = "<?php
/* status codes
** 0 Okay to install
** 1 Installed
** 2 Partially installed
** 3 Cannot install
**/

\$mm_data = ";
    $mm_data .= var_export($this->mmdata, true) . ";
?>";
    if (false === file_put_contents('mm_data.php', $mm_data))
      trigger_error('Error: Unable to write mm_data file!');
    return isset($parse_table) ? $parse_table : array();
  } // output_mm_data()

  /** @return bool true  */
  private function set_modstatus_header(): bool
  {
    $this->modstatus_header = '';

    if (!empty($this->parse_error)) {
      $this->num_errors++;
      $this->modstatus_header = self::CANTINST;
    }

    // ANALYZE STATISTICS FOR STATUS (FOUR POSSIBLES)
    else {
      // Mod uninstalled - no mkdir errors
      // if the only thing installed is a directory which you may not
      // be able to remove --- show as uninstalled
      if ($this->num_installed == $this->newdirs_installed) {
        $this->num_installed = 0;
        $this->newdirs_installed = 0;
      }

      // Partially installed
      if ($this->num_installed > 0 && (
        $this->num_installed < $this->num_required ||
        $this->provisional_errors > 0)) {
        $this->num_errors += $this->provisional_errors;
        $this->modstatus_header = self::PARTINST;
      }

      // No errors - Installed or OK to Install
      elseif (!$this->num_errors) {
        if ($this->num_required > 0) {
          if ($this->num_installed == $this->num_required) {
            $this->modstatus_header = self::INSTALLED;
          } elseif ($this->num_installed == 0) {
            $this->modstatus_header = self::OK2INST;
          }
        }
      }

      // CAN'T INSTALL - WARNINGS OR ERRORS NOTED
      if (empty($this->modstatus_header)) {
        $this->modstatus_header = self::CANTINST;
      }
    }
    return true;
  } // set_modstatus_header()

  /**
   * @param string $url 
   * @return bool 
   */
  private function validate_url(string $url): bool
  {
    if ($this->isUrl($url)) {
      return true;
    } else {
      $path = parse_url($url, PHP_URL_PATH);
      $encoded_path = array_map('urlencode', explode('/', $path));
      $url = str_replace($path, implode('/', $encoded_path), $url);

      if (filter_var($url, FILTER_VALIDATE_URL)) {
        return true;
      }
    }
    return false;
  }

  /**
   * @param string $url 
   * @return bool 
   */
  private function isUrl(string $url): bool
  {
    $pattern = '%^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z0-9\x{00a1}-\x{ffff}][a-z0-9\x{00a1}-\x{ffff}_-]{0,62})?[a-z0-9\x{00a1}-\x{ffff}]\.)+(?:[a-z\x{00a1}-\x{ffff}]{2,}\.?))(?::\d{2,5})?(?:[/?#]\S*)?$%iu';

    return !empty(preg_match($pattern, trim($url)));
  }
} // Modvalidator class

/** @return modvalidator  */
function new_modvalidator(): modvalidator
{
  require __DIR__ . '/mmobjinits.php';
  $objinits['classID'] = 'validator';
  return new modvalidator($objinits);
}
