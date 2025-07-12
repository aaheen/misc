<?php
/*
  Mod Manager 15

  The Modparser class extends Modbase and is extended by 
  other MM classes that need parse table data: Modvalidator, 
  Modlister, Modinstaller, Modremover and Modeditor.

  Modparser analyzes a mod config file and creates a table 
  containing instructions and their associated data. If a 
  fatal parse error occurs, Modparser returns a global error 
  array ($this->parse_error) with details.

  A parse table is an array containing rows of MM instruction
  "datapacks", each one containing the name of an instruction, 
  configuration file line number, arguments, and flag (if any).  
  Modvalidator will add status codes and validation error 
  lines (if any) to the parse table datapacks for the benefit 
  of the Modlister class.

  Public Method:
    parse();
*/

require_once 'classes/modbase.class.php';

#[AllowDynamicProperties]
class modparser extends modbase
{
  function __construct($objinits)
  {
    parent::__construct($objinits);
  }

  protected $modname;
  protected $modversion;
  protected $open_target;
  protected $is_target;
  protected $is_parameter = false;
  public $parse_error = array();
  protected $parse_table = array();

  # Creates a protected parse table ($this->parse_table) 
  # containing MM instruction datapacks. Table may be 
  # empty if there are fatal parsing errors.

  public function parse(string $cfgpath): bool
  {
    if($this->instantiation_error){
      return false;
    }
    $this->cfgpath = $cfgpath;
    $this->cfgfile = pathinfo($cfgpath, PATHINFO_BASENAME);
    $this->is_target = false;
    $this->parse_error = array();
    $this->parse_table = array();

    /* Set these up for the listing in case they are missing from the cfg file */
    $this->modname = "[{$this->admtext['missing']}]";
    $this->version = "[???]";

    /* Begin processing the cfg file. The WHILE loop controls exit from
    ** processing with a BREAK when finished or if errors are encountered.
    */
    while (true) {
      $buffer = "";

      /* Read in the mod configuration file */
      $buffer = $this->read_cfgfile($cfgpath);

      if (!empty($this->parse_error)) break;

      /****************************************************************
      A token is an array containing the name of a directive, line
      number where found in the cfg file, an argument string and
      a "blob" - that is, content from the end of the directive
      argument string to the beginning of the next directive. Each
      token will be converted into a "directive datapack" (array).

      Token map
      $token['line'] -- directive line number from mod cfg file
      $token['name'] -- name of directive, e.g., 'version'
      $token['args'] -- everything between the first colon (:) and the
                        arguments terminator (%)
      $token['blob'] -- everything between the arguments terminator and the
                        beginning of the next directive.
       *****************************************************************/
      $tokens = $this->get_tokens($buffer);

      if (!empty($this->parse_error)) break;

      // Remove (// or #) comments from blob -- do this in get tokens

      /***************************************************************
      MAIN PARSING ROUTINE
        Process tokens into directive datapacks and add them to the
        parse table for output to executive Mod Manager classes.
       ***************************************************************/
      for ($i = 0; isset($tokens[$i]); $i++) {
        /* If %exit: is encountered, stop processing tokens and finalize
        ** the parse table. Useful for conditional directives and for testing.
        ** Gets gobbled prior to dictionary checks so not necessary to add
        ** to Modbase::proclist.*/
        if ($tokens[$i]['name'] == 'exit') {
          break;
        }

        /* If this is a file modifier and the %location is missing
        ** we have a critical error and must stop processing.the cfg. */
        if (in_array($tokens[$i]['name'], $this->file_modifiers)) {
          if ($tokens[($i - 2)]['name'] != "location") {
            $this->parse_error['line'] = $tokens[$i]['line'];
            $this->parse_error['tag']  = 'p' . __LINE__ . ' %location :';
            $this->parse_error['text'] = self::MISSING;
            return false;
          }
        }

        /* Lookup directive by name and get its processing function. */
        if (isset($this->proclist[$tokens[$i]['name']])) {
          /* PHP allows assignment of a function name to a variable
          ** and then executing the "variaable" with arguments, so get
          ** the function name associated with this directive from
          ** $proclist.
          */

          $function = $this->proclist[$tokens[$i]['name']];

          /* Bypass delimiter directives (e.g. %end:%) that require no
          ** processing and are not needed in the parse table.
          */
          if ($function == 'no_op') continue;

          # Add parser prefix to function name from $proclist
          $function = 'p' . $function;

          /* Use the function to construct a directive datapack from
          ** this token. */
          $datapack = $this->$function($tokens, $i);

          /* Parsing Error result? Emit and stop parsing. */
          if (!empty($this->parse_error)) break;

          /* If conditional directive, jump to token label at index $i
          ** to continue processing.
          */
          if (!empty($datapack['goto'])) $i = $datapack['goto'];

          /* Add this directive datapack to the parse table. */
          if (!empty($datapack)) $this->parse_table[] = $datapack;

          continue; // to the next token
        } else { // Directive name not found in proclist
          $this->parse_error['line'] = $tokens[$i]['line'];
          $this->parse_error['tag']  = 'p' . __LINE__ . ' %' . $tokens[$i]['name'] . ':';
          $this->parse_error['text'] = self::TAGUNK;
          break; // abandon further processing
        }
      } // token processing loop

      break;
    } // Parse table assembly loop

    if (!empty($this->parse_error))
      return false;

    $this->required_tags_check($this->parse_table);

    if (!empty($this->parse_error))
      return false;

    /* Mod configuration file exists, has content, but no mm directives. */
    if (empty($this->parse_error) && empty($this->parse_table)) {
      $this->parse_error['line'] = ':::';
      $this->parse_error['tag']  = 'p' . __LINE__ . ' ' . $this->cfgfile;
      $this->parse_error['text'] = self::UNXEND;
      return false;
    }
    return true;
  } // End of parse function

  #***************************************************************
  # PRIVATE FUNCTIONS TO TURN PRIMATIVE TOKENS INTO DATAPACKS
  # Each function returns a directive.
  #***************************************************************
  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @return array (datapack) 
   */
  private function p_author(array $tokens, int $i): array
  {
    /* Simple directive with one or two arguments.
    ** Returns a directive datapack. Individual author
    ** records will be combined in the mod listing.
    */
    $datapack = $this->simple2($tokens, $i);

    if (empty($datapack['arg1'])) {
      # Set parse_error - will cause parsing of this 
      # mod to stop/end and emit error.
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %author args';
      # Index into $admtext array
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    return $datapack;
  }

  /**
   * @param mixed $tokens 
   * @param mixed $i (index into tokens) 
   * @return array (datapack)
   */
  private function p_choices(array $tokens, int $i): array
  {
    # Parameter must be open
    if (!$this->is_parameter) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%choices';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    # Next token must be a 'desc'
    if ($tokens[$i + 1]['name'] != 'desc') {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%desc';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    $datapack = $this->simple1($tokens, $i);

    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %choices args';
      # Index into $admtext array
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    return $datapack;
  }

  /**
   * @param array $tokens 
   * @param int $i 
   * @return array (datapack) 
   */
  private function p_copyfile(array $tokens, int $i): array
  {
    /*  %copyfile directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == copyfile or copyfile2
    **  $datapack['arg1'] == full server path to source file
    **  $datapack['arg2'] == full server path to destination file
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == flag (if any)
    **  $datapack['goto'] == empty (not a conditional directive)
    */

    $datapack = $this->simple2($tokens, $i);

    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' ' . $datapack['name'];
      $this->parse_error['text'] = self::NOSOURCE;
      return array();
    }

    /* Use full server path for source file copy. */
    $datapack['arg1'] = $this->resolve_file_path(
      $datapack['arg1'],
      self::MODS_DIR
    );

    /* Use full server path for destination file copy. */
    if (!empty($datapack['arg2'])) {
      $datapack['arg2'] = $this->resolve_file_path($datapack['arg2']);
    } else {
      /* Should never happen, but...
      ** Destination file missing - copy file to root using same name as
      ** source file. */
      $datapack['arg2'] = $this->rootpath .
        pathinfo($datapack['arg1'], PATHINFO_BASENAME);
    }

    return $datapack;
  } // _copyfile()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_desc(array $tokens, int $i): array
  {
    /*  %desc directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == desc
    **  $datapack['arg1'] == description including default value in parens
    **  $datapack['arg2'] == default value for preceding %parameter directive
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    */

    # Verify that the associated parameter is present
    if (!$this->is_parameter) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%range';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    $datapack = $this->simple1($tokens, $i);

    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %desc arg';
      # Index into $admtext array
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    /* Get get all parenthetical expressions from arg1 */
    preg_match_all(
      "#\(([^\)]*)\)#sm",
      $datapack['arg1'],
      $matches,
      PREG_SET_ORDER
    );

    /* Use data from the LAST set of parens inside the desc for the
    ** default value.
    */
    $arg2 = end($matches);

    if (isset($arg2[1])) {
      $datapack['arg2'] = $arg2[1];
    }

    $this->is_parameter = false;

    return $datapack;
  } // _desc()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_description(array $tokens, int $i): array
  {
    $tokens[$i]['args'] = $this->resolve_path_vars($tokens[$i]['args']);

    $datapack = $this->simple1($tokens, $i);
    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %description arg';
      # Index into $admtext array
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    /* Allow % inside mod description without terminating the text. */
    $datapack['arg1'] = str_replace("\%", '&#037;', $datapack['arg1']);

    return $datapack;
  }

  # We are processing $tokens in order and creating parse table directive
  # records. When conditionally testing for a file, if the file exists we
  # jump over tokens and begin processing again from the label given in the
  # %fileexists args.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_fileexists(array $tokens, int $i):array
  {
    /*  %fileexists directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == fileexists
    **  $datapack['arg1'] == filename to be tested
    **  $datapack['arg2'] == label to jump to if file exists
    **  $datapack['arg3'] == message - parse table information only
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == $tokens array index to jump to continue
    **  processing
    */

    /* For modremover, a conditional jump such as this one is ignored -
    ** modremover will get a parse table with all possible installs for
    ** removal.
    */
    if (!empty($this->classID) && $this->classID == 'remover') return array();

    $datapack = $this->simple2($tokens, $i);

    /* Must have exactly two arguments: a file name and a goto label. */
    if (!$datapack['arg1'] || !$datapack['arg2']) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag'] = 'p' . __LINE__ . ' %fileexists: args';
      $this->parse_error['text'] = self::ERRORS;
      return array();
    }

    $filepath = trim($datapack['arg1']);
    $filepath = ltrim($filepath, " /");

    /* make the path absolute:
    ** $filepath = $this->rootpath.$filepath;*/
    $datapack['arg1'] = $filepath = $this->resolve_file_path($filepath);

    $label = $datapack['arg2'];

    $n = $this->find_label($tokens, $i, $label);
    if (!empty($this->parserr))
      return array();

    if (!file_exists($filepath)) {
      $datapack['arg2'] = 'false';
      $datapack['arg3'] = lcfirst($this->admtext['text_continue']);
      return $datapack;
    }

    /* Set the segments table index to continue
     * processing from the label, skipping directives
     * in between. */
    $datapack['arg2'] = 'true';
    $datapack['arg3'] = 'goto line ' . $tokens[$n]['line'] . ' (' . $label . ')';

    /*  The segments table "for-loop" will increment past the label.
     *  To include the label in the parse table, back up the segment
     *  pointer (index) to just before the 'goto' label. */
    $datapack['goto'] = $n - 1;
    return $datapack;
  } // fileexists()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_goto(array $tokens, int $i): array
  {
    /*  %goto directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == goto
    **  $datapack['arg1'] == name of label to jump to
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == message - parse table information only
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == index of label to goto
    */
    /*  Modremover class ignores conditional jumps. */
    if (!empty($this->classID) && $this->classID == 'remover') return array();

    /* goto is a simple directive with one argument - label name */
    $datapack = $this->simple1($tokens, $i);

    /* Must have exactly one argument */
    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag'] = 'p' . __LINE__ .
        ' %goto label arg';
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    $label = $datapack['arg1'];

    $n = $this->find_label($tokens, $i, $label);
    if (!empty($this->parserr))
      return array();

    /* Display the line number and label for the goto jump */
    $datapack['arg3'] = 'goto line ' . $tokens[$n]['line'] . ' (' . $label . ')';

    /* don't skip next cfg segment */
    $datapack['goto'] = $n - 1;

    return $datapack;
  } // goto()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @return array ($datapack)
   */
  private function p_insert(array $tokens, int $i): array
  {
    /* Returns 'insert' optag directive with code block as arg1 */
    return $this->file_editor($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_label(array $tokens, int $i): array
  {
    $aValid = array('-', '_');
    if (!ctype_alnum(str_replace($aValid, '', $tokens[$i]['args']))) {
      //$this->labels[$tokens[$i]['args']] = $i;
      /* Label name has non-alphanumeric character.
      ** Case 1: an extra colon was inserted in the
      ** %label Directive -- %label:done:%
      ** The second colon would become part of the
      **name -- invalid character. */
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' %label [<strong>' . $tokens[$i]['args'] . '</strong>] ';
      $this->parse_error['text'] = 'badchar';
      return array();
    }
    return $this->simple1($tokens, $i);
  }

  private function p_location(array $tokens, int $i)
  {
    /*  %location directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == location
    **  $datapack['arg1'] == code/text in target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    */
    /* Requires an open (buffered) target file. */
    if (!$this->is_target) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' %location:';
      $this->parse_error['text'] = self::NOTARGET; // index into admtext[]
      return array();
    }

    if (empty(trim($tokens[$i]['blob']))) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $tokens[$i]['name'];
      $this->parse_error['text'] = self::NOCOMPS; // index into admtext[]
      return array();
    }

    $datapack = $this->simple1($tokens, $i);
    $datapack['arg3'] = $datapack['arg1']; // This would be a note
    $datapack['arg1'] = $tokens[$i]['blob'];
    $datapack['arg1'] = substr($datapack['arg1'], 2);
    $datapack['arg1'] = substr($datapack['arg1'], 0, -2);

    /* NOT A PARSING ISSUE BUT HANDLE IT HERE TO AVOID DOING IT IN ALL
    ** CLASSES.
    **
    ** If %location code has leading blank line (CRLF) when there is none in
    ** the target file, it won't show a bad location error because the leading
    ** CRLF matches the CRLF at the end of the previous line which is not
    ** blank. So if there is a leading blank line or lines in the location
    ** code, we must prepend a CRLF to it to match the one in the previous
    ** non-blank line in order to get a valid bad target error if there
    ** is one in the listing.
    */

    /* Look ahead to verify presence of %end:% tag. */
    $i++;
    if ($tokens[$i]['name'] != 'end') {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'];
      $this->parse_error['text'] = self::NOEND;
      return array();
    }

    /* Look ahead again to see if we have a valid file modifier directive
    ** following location. Sometimes they get mistyped.
    */
    $file_modifier_directive = $tokens[$i + 1]['name'];
    if (!in_array($file_modifier_directive, $this->file_modifiers)) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'];
      $this->parse_error['text'] = self::NOACT;
      return array();
    }

    return $datapack;
  } // _location()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array ($datapack)
   */
  private function p_mkdir(array $tokens, int $i): array
  {
    /*  $mkdir directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == mkdir
    **  $datapack['arg1'] == server path to create new directory
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == optional flag
    **  $datapack['goto'] == empty
    */
    $datapack = $this->simple1($tokens, $i);

    if (!isset($datapack['arg1'])) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'] . " arg";
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    /* Resolve file path to complete server path */
    $datapack['arg1'] = $this->resolve_file_path($datapack['arg1']);

    return $datapack;
  }  // _mkdir()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_name(array $tokens, int $i): array
  {
    //$tokens[$i]['name'] = strtolower($tokens[$i]['name']);
    $datapack = $this->simple1($tokens, $i);
    $this->modname = $datapack['arg1'];
    return $datapack;
  }

  /* Consumes %newfile and following %fileversion tokens. */
  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @return array (datapack)
   */
  private function p_newfile(array $tokens, int $i): array
  {
    /*  %newfile directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == newfile
    **  $datapack['arg1'] == filepath for new file
    **  $datapack['arg2'] == content of new file
    **  $datapack['arg3'] == version number of new file
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    */

    /* Break out single file path argument and flag */
    $datapack = $this->simple1($tokens, $i);

    if (empty($datapack['arg1'])) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'] . " path";
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    $datapack['arg1'] = $this->resolve_file_path($datapack['arg1']);

    /* Look ahead to get the file version and code block */
    $i++;

    $datapack['arg2'] = $tokens[$i]['blob'];
    /* Remove leading and trailing CRLF from code block */
    $datapack['arg2'] = substr($datapack['arg2'], 2);
    $datapack['arg2'] = substr($datapack['arg2'], 0, -2);

    $datapack['arg3'] = $tokens[$i]['args'];

    /* Verify that version number was provided in the directive */
    if (empty($datapack['arg3'])) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'] . " version";
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    return $datapack;
  } // _newfile()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_note(array $tokens, int $i): array
  {
    return $this->simple1($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into $tokens)
   * @return array (datapack)
   */
  private function p_parameter(array $tokens, int $i): array
  {
    /*  %parameter directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == parameter
    **  $datapack['arg1'] == target variable
    **  $datapack['arg2'] == target value
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    */
    /* There must be a target file in the cfg. */
    if (!$this->is_target) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %parameter';
      $this->parse_error['text'] = self::NOTARGET; // index into admtext[]
      return array();
    }

    # Next token must be a %range, %choices or %desc
    if (
      $tokens[$i + 1]['name'] != 'desc'
      && $tokens[$i + 1]['name'] != 'choices'
      && $tokens[$i + 1]['name'] != 'range'
    ) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%choices|%range|%desc';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    $this->is_parameter = true;
    return $this->simple2($tokens, $i);
  } // _parameter()

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_private(array $tokens, int $i): array
  {
    return $this->simple1($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_range(array $tokens, int $i): array
  {
    # Directive format: %range:$low:$high%

    # Parameter must be open
    if (!$this->is_parameter) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%range';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    # Next token must be a 'desc'
    if ($tokens[$i + 1]['name'] != 'desc') {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . '%desc';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return array();
    }

    return $this->simple2($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_replace(array $tokens, int $i): array
  {
    return $this->file_editor($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @return array (datapack) 
   */
  private function p_target(array $tokens, int $i): array
  {
    /*  %target directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == target
    **  $datapack['arg1'] == filepath to target file
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == optional note
    **  $datapack['flag'] == optional flag (@)
    **  $datapack['goto'] == empty
    */

    /* Can have two args - file path and optional note. */
    $datapack = $this->simple2($tokens, $i);

    $datapack['arg1'] = $this->resolve_file_path($datapack['arg1']);

    /* Move arg2 (note) to arg3 for backward compatibility. */
    if (!empty($datapack['arg2'])) {
      $datapack['arg3'] = $datapack['arg2'];
      $datapack['arg2'] = '';
    }

    /* Look ahead for fileoptional directive */
    if (isset($tokens[$i + 1])) {
      if ($tokens[$i + 1]['name'] == 'fileoptional') {
        $datapack['flag'] = self::FLAG_OPTIONAL;
      }
    }

    /* Set name of new open target globally */
    $this->open_target = $datapack['arg1'];
    $this->is_target = true;
    return ($datapack);
  } // _target()

  # We are processing $tokens in order and creating parse table directive
  # records. When conditionally testing for a TNG version, if we have the
  # correct version we jump over tokens and begin processing again from the
  # label given in the %tngversion args.

  /**
   * @param mixed $tokens 
   * @param mixed $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_tngversion($tokens, $i): array
  {
    /*  %tngversion directive map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == tngversion
    **  $datapack['arg1'] == low-range:low-range:label
    **  $datapack['arg2'] == in-range true or false message - info only
    **  $datapack['arg3'] == goto label or continue message - info only
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == $tokens processing index if test is true
    */

    /*  Modremover class ignores conditionals. */
    if (!empty($this->classID) && $this->classID == 'remover') return array();

    $datapack = $this->simple3($tokens, $i);

    /* Must have exactly three arguments - range low, range-high & label */
    if (!$datapack['arg1'] || !$datapack['arg2'] || !$datapack['arg3']) {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag'] = 'p' . __LINE__ .
        ' %tngverson args';
      $this->parse_error['text'] = self::MISSING;
      return array();
    }

    // remove dots from versions and turn into 4-digit integers
    $start = $this->version2integer($datapack['arg1']);
    $end = $this->version2integer($datapack['arg2']);

    $label = $datapack['arg3'];
    $n = $this->find_label($tokens, $i, $label);
    if (!empty($this->parserr))
      return array();

    /* Assemble arg1 */
    $datapack['arg1'] = $start . ':' . $end . ':' . $label;
    $datapack['arg2'] = '';

    /* if current TNG version is wrong - continue sequential processing */
    if ($start > $this->int_version || $end < $this->int_version) {
      $datapack['arg2'] = 'false (' . $this->tng_version . ')';
      $datapack['arg3'] = lcfirst($this->admtext['text_continue']);
      return $datapack;
    }

    /* Current TNG version is correct - goto label */
    $datapack['arg2'] = 'true (' . $this->tng_version . ')';
    $datapack['arg3'] = 'goto line ' . $tokens[$n]['line'] . ' (' . $label . ')';

    /* don't skip next cfg segment */
    $datapack['goto'] = $n - 1;
    return $datapack;
  } // _tngversion()

  # We are processing $tokens in order and creating parse table directive
  # records. When conditionally testing for existence of text in currently
  # open file, if found we jump over tokens and begin processing again from
  # the label token given in the %textexists arguments.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_textexists(array $tokens, int $i): array
  {
    /*  %textexists directive datapack map
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == textexists
    **  $datapack['arg1'] == text to search for in currently open file
    **  $datapack['arg2'] == result true or false
    **  $datapack['arg3'] == "goto label" or "continue" message - info only
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == $tokens processing index if test is true
    */

    /*  Modremover class ignores conditional jumps */
    if (!empty($this->classID) && $this->classID == 'remover') return array();

    $datapack = $this->init_tag();
    $datapack['line'] = $tokens[$i]['line'];
    $datapack['name'] = $tokens[$i]['name'];

    while (true) {
      /* Is there an %end:% directive next? */
      if ($tokens[$i + 1]['name'] != 'end') {
        $this->parse_error['line'] = $tokens[$i]['line'];
        $this->parse_error['tag']  = "P" . __LINE__ . " %textexists: ";
        $this->parse_error['text'] = self::NOEND; // index into admtext[]
        return array();
      }

      /* Must have exactly one arguments - goto label */
      if (empty($tokens[$i]['args'])) {
        $this->parse_error['line'] = $tokens[$i]['line'];
        $this->parse_error['tag'] = "P" . __LINE__ . " %textexists: label";
        $this->parse_error['text'] = self::MISSING;
        return array();
      }

      /* Is there a target file specified in cfg file? */
      if (empty($this->open_target)) {
        $this->parse_error['line'] = $tokens[$i]['line'];
        $this->parse_error['tag']  = "P" . __LINE__ . " %textexists: %target: ";
        $this->parse_error['text'] = self::MISSING; // index into admtext[]
        return array();
      }

      $label = $tokens[$i]['args'];

      /* Get index in tokens table containing this $label. */
      $n = $this->find_label($tokens, $i, $label);
      if (!empty($this->parse_error))
        return array();

      /* Assemble and add the code block removing the final CRlf */
      $datapack['arg1'] = $tokens[$i]['blob'];
      $datapack['arg1'] = substr($datapack['arg1'], 0, -2);
      $datapack['arg1'] = substr($datapack['arg1'], 2);

      /* Does target file exist? */
      if (!file_exists($this->open_target)) {
        // return textexists = false
        $datapack['arg2'] = 'false - ' . $this->admtext['tgtmissing'];
        $datapack['arg3'] = lcfirst($this->admtext['text_continue']);
        break;
      }

      $buffer = $this->read_file_buffer($this->open_target);

      /*  If target text is ambiguous the mod listing should catch it
      **  so just check for presence here.
      */
      $p = strpos($buffer, trim($datapack['arg1']));

      unset($buffer);

      if (false === $p) {
        /* Text not found */
        //$datapack['arg1'] = $datapack['arg2'];
        $datapack['arg2'] = 'false';
        $datapack['arg3'] = lcfirst($this->admtext['text_continue']);
        break;
      }

      /* Text found */
      //$datapack['arg1'] = $datapack['arg2'];
      $datapack['arg2'] = 'true';
      $datapack['arg3'] = 'goto line ' . $tokens[$n]['line'] . ' (' . $label . ')';

      /*  The segments table for-loop will increment past label.
       *  To list label in parse table, back up the segments table
       *  index.
       */
      $datapack['goto'] = $n - 1;
      break;
    } // while(true)

    return $datapack;
  } // _textexists

  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @return array (datapack)
   */
  private function p_triminsert(array $tokens, int $i): array
  {
    return $this->file_editor($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack) 
   */
  private function p_trimreplace(array $tokens, int $i): array
  {
    return $this->file_editor($tokens, $i);
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_version(array $tokens, int $i): array
  {
    return $this->simple1($tokens, $i);
  }

  # vinserted variables will have their values changed (parameters)
  # so we place the assignment statements in the datapack
  # without the assigned value.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_vinsert(array $tokens, int $i):array
  {
    $datapack = $this->file_editor($tokens, $i);

    // break down vinsert vars -- arg1 = complete arg2 = without values

    # Grab all vinsert var strings from the token, one with assigned values,
    # one without values, the latter for checking if they have been installed
    # while ignoring the actual changeable values.
    //$allvars = "#(\\$\w+\s*=\s*)(['\"]?)[\s\S]*?(?=\";|\';|;)\\2;#ms";
    $allvars = "#(\\$[a-zA-Z0-9_\'\[\]]+\s*=\s*)(['\"]?)[\s\S]*?(?=\";|\';|;)\\2;#ms";

    preg_match_all($allvars, $datapack['arg1'], $matches);
    //echo basename(__FILE__),': ',__LINE__,'<pre>';print_r($matches);exit;
    # $matches[0] contain full variable assignment statements with values
    # for installation and value replacement

    # $matches[1] contains the statements without the assignment value
    # for validation, search and removal
 
    # array of variable vinsert vars
    $vvar_arr = !empty($matches[0]) ? $matches[0] : array();
    $vvar_str = implode("\r\n", $vvar_arr);
    $datapack['arg1'] = $vvar_str;
    $datapack['arg2'] = $matches[0];
    $datapack['arg2'] = implode("\r\n", $matches[1]);

    return $datapack;
  }

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function p_wikipage(array $tokens, int $i): array
  {
    return $this->simple1($tokens, $i);
  }

  #***************************************************************
  # OTHER SUPPORTING FUNCTIONS
  #***************************************************************

  /**
   * @param string $cfgpath 
   * @return string (file contents)
   */
  private function read_cfgfile(string $cfgpath): string
  {
    $buffer = $this->read_file_buffer($cfgpath);

    /* Handle errors from cgf buffer read */
    if (is_numeric($buffer)) {
      // CFG file is missing; quit with parsing error
      if ($buffer == self::NOFILE) {
        $this->parse_error['line'] = '::';
        $this->parse_error['tag']  = 'p' . __LINE__ .
          ' ' . $this->cfgfile;
        $this->parse_error['text'] = self::NOCFGFILE; // index into admtext[]
        return ''; // leave the processing loop and return to caller
      } elseif ($buffer == self::ISEMPTY) {
        // CFG file has no content; quit with parsing error
        $this->parse_error['line'] = '::';
        $this->parse_error['tag']  = 'p' . __LINE__ .
          ' ' . $this->cfgfile;
        $this->parse_error['text'] = self::EMPTYFILE; // index into admtext[]
        return ''; // leave the processing loop and return to caller
      }
    }

    /* Deprecated and unnecessary -- delete it. */
    $buffer = str_replace('%target:files%', '', $buffer);

    /* Allows % inside info tags without terminating them. */
    //$buffer = str_replace( "\%", '&#037;', $buffer );
    //$reg = "#(^\s*%description:(.*))?(\\\\%)(.*)#s";
    //$buffer = preg_replace($reg,'\1\2&#037;\4',$buffer);

    $buffer = $this->resolve_modvars($buffer);

    /* Capture mod name for listing in case parser errors out early */
    if (preg_match( "#^\s*%name:([^%]+)%#m", $buffer, $matches )) {
      $this->modname = $matches[1];
    } else {
      $this->modname = '';
    }

    /* Capture mod version for listing in case parser errors out early */
    if (preg_match( "#^\s*%version:([^%]+)%#m", $buffer, $matches )) {
      $this->version = $matches[1];
    } else {
      $this->version = '';
    }

    return $buffer;
  } // read_cfgfile()

  /**
   * @param string $buffer (cfg file contents)
   * @return array (tokens)
   */
  private function get_tokens(string $buffer):array
  {
    /* Use a single preg_split() function to split cfg into an array of
    ** sections, each containing the directive name, arguments line, and
    ** the "blob" -
    ** the rest of the section content up to the next directive. The blob
    ** contains code from the "%location" directive and all the file
    ** content modifier directives like "%replace."
    */

    # Replace escaped percent (\%) with HTML character code.
    //$buffer = str_replace("\\%", "&#037", $buffer);

    $sections = preg_split("#^[ \t]*%(\w+):#ms", $buffer, -1, PREG_SPLIT_OFFSET_CAPTURE | PREG_SPLIT_DELIM_CAPTURE);

    /*
    ** Combine essential information from each segment into raw tokens
    ** for final processing into directive records (sub-arrays) per
    ** specific functions for each.
    */

    $tokens = array();
    for ($i = 1; isset($sections[$i]); $i += 2) {
      $token = array();
      $token['line'] = substr_count($buffer, "\n", 0, $sections[$i][1]) + 1;
      $token['name'] = strtolower($sections[$i][0]);
      $token['args'] = '';
      $token['blob'] = '';
      $blob = $sections[$i + 1][0];

      /* CHECK FOR / PREVENT DIRECTIVE TERMINATION ERROR
      ** The $sections regex above adds the directive teriminating
      ** '%' char to the blob. If the blob does not start with a '%' char
      ** we have a directive termination error.
      **
      ** If the terminated block contains a % character in its text,
      ** user can use double terminator (%%) at the end of the
      ** argument to prevent the directive text from being cut off at
      ** the first % character in the text. In other words,
      ** a double terminator takes precedenct over a single one.
      */
      if (false !== $p = strpos($blob, '%%%')) {
        /* Yes, a triple terminator to protect a double %%. */
        $token['args'] = substr($blob, 0, $p);
        $token['blob'] = substr($blob, $p + 3);
      } elseif (false !== $p = strpos($blob, '%%')) {
        $token['args'] = substr($blob, 0, $p);
        $token['blob'] = substr($blob, $p + 2);
      } elseif (false !== $p = strpos($blob, '%')) {
        $token['args'] = substr($blob, 0, $p);
        $token['blob'] = substr($blob, $p + 1);
      } else {
        $this->parse_error['line'] = $token['line'];
        $this->parse_error['tag']  = 'p' . __LINE__ .
          ' ' . $token['name'];
        $this->parse_error['text'] = self::TAGNOTERM;
        return array();
      }

      # convert escaped % (\%) characters in aguments only - not codeblocks
      $token['args'] = str_replace("\\%", "&#037", $token['args']);

      $tokens[] = $token;
    } // tokens created

    return $tokens;
  } // get_tokens()

  private function init_tag()
  {
    $datapack['line'] = '';
    $datapack['name'] = '';
    $datapack['arg1'] = '';
    $datapack['arg2'] = '';
    $datapack['arg3'] = '';
    $datapack['flag'] = '';
    $datapack['goto'] = '';
    $datapack['statkey'] = '';
    $datapack['eline'] = '';
    return $datapack;
  }

  # Parse a token as directive with only one argument.
  # Argument can contain colons.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function simple1(array $tokens, int $i):array
  {
    /* Because we assign the whole $token['args'] line to $datapack[arg1],
    ** directives like %description are allowed to contain colons without
    ** causing parsing problems.  If we were to explode the line as we do in
    ** simple2 and simple3, the description could be at least truncated, and
    ** possibly crash the mod listing.
    */
    $datapack = $this->init_tag();
    $datapack['line'] = $tokens[$i]['line'];
    $datapack['name'] = $tokens[$i]['name'];
    $datapack['arg1'] = $tokens[$i]['args'];
    $datapack['flag'] = $this->extract_flag($datapack['arg1']);
    return $datapack;
  }

  # Parse a token as directive with only two arguments. Only second
  # argument can contain colons.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function simple2(array $tokens, int $i): array
  {
    /* Use simple2 to protect colons in the second argument
    ** (for example %authors).
    ** Becuase it only splits on the first colon in the arg string, colons in
    ** the second arguments are safe (will not be split).
    */
    $datapack = $this->init_tag();
    $datapack['line'] = $tokens[$i]['line'];
    $datapack['name'] = $tokens[$i]['name'];


    $args = explode(":", $tokens[$i]['args'], 2);

    $datapack['arg1'] = isset($args[0]) ? $args[0] : '';
    $datapack['arg2'] = isset($args[1]) ? $args[1] : '';

    $datapack['flag'] = $this->extract_flag($datapack['arg1']);

    return $datapack;
  }

  # Parse a token as directive with one, two or three arguments. Only third
  # argument can contain colons.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function simple3(array $tokens, int $i): array
  {
    /* Do not use this to parse $token['args'] if the directive arguments
    ** themselves might contain text with colons (:) as they will not split
    ** correctly. Examples would include %description or %desc
    ** (use simple1()).
    */
    $datapack = $this->init_tag();
    $datapack['line'] = $tokens[$i]['line'];
    $datapack['name'] = $tokens[$i]['name'];

    $args = explode(":", $tokens[$i]['args'], 3);

    $datapack['arg1'] = isset($args[0]) ? $args[0] : '';
    $datapack['arg2'] = isset($args[1]) ? $args[1] : '';
    $datapack['arg3'] = isset($args[2]) ? $args[2] : '';

    $datapack['flag'] = $this->extract_flag($datapack['arg1']);

    return $datapack;
  }

  # File_modifiers are directives that change the content of a file.
  # They share common traits (the instruction and code to replace or
  # insert text into the file) and can all be processed using the same
  # code in this function.

  /**
   * @param array $tokens 
   * @param int $i (index into tokens)
   * @return array (datapack)
   */
  private function file_editor(array $tokens, int $i): array
  {
    /*  map for all file editing directives
    **  $datapack['line'] == line number where found in the cfg file
    **  $datapack['name'] == name of the file editing directive
    **  $datapack['arg1'] == new code to replace or be inserted
    **  $datapack['arg2'] == empty
    **  $datapack['arg3'] == empty
    **  $datapack['flag'] == empty
    **  $datapack['goto'] == empty
    */

    switch ($tokens[$i]['name']) {
      case 'insert':
      case 'vinsert':
      case 'triminsert':
        if (empty($tokens[$i]['args'])) {
          $this->parse_error['line'] = $tokens[$i]['line'];
          $this->parse_error['tag']  = 'p' . __LINE__ .
            ' ' . $tokens[$i]['name'];
          $this->parse_error['text'] = 'nocomps';
          return array();
        }

        $tokens[$i]['args'] = strtolower($tokens[$i]['args']);
        if ($tokens[$i]['args'] != 'before' && $tokens[$i]['args'] != 'after') {
          $this->parse_error['line'] = $tokens[$i]['line'];
          $this->parse_error['tag']  = 'p' . __LINE__ .
            ' ' . $tokens[$i]['name'];
          $this->parse_error['text'] = 'badchar';
          return array();
        }
      default:
        break;
    }

    $datapack = $this->simple1($tokens, $i);

    /* Check that certain file_editor directives have positional
    ** argument 'before' or 'after' */
    if (
      $datapack['name'] == 'insert' || $datapack['name'] == 'triminsert'
      || $datapack['name'] == 'vinsert'
    ) {
      if (empty($datapack['arg1'])) {
        $this->parse_error['line'] = $datapack['line'];
        $this->parse_error['tag']  = 'p' . __LINE__ .
          ' ' . $datapack['name'];
        $this->parse_error['text'] = self::NOCOMPS;
        return array();
      }
    }

    /* For backward compatibility: Combine file_editor directive name and
    ** directional indicator from token in 'name' and always place blob
    ** in 'arg1'
    */
    if (!empty($datapack['arg1'])) {
      $datapack['name'] .= ':' . $datapack['arg1'];
    }

    if (empty(trim($tokens[$i]['blob']))) {
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ . ' ' . $datapack['name'];
      $this->parse_error['text'] = self::NOCOMPS; // index into admtext[]
      return array();
    }

    /* Simple1() does not return blob.  Add blob (code to edit into
    ** target file.) */
    $datapack['arg1'] = $tokens[$i]['blob'];

    /* Remove one leading and one trailing CRLF from blob */
    $datapack['arg1'] = substr($datapack['arg1'], 2);
    $datapack['arg1'] = substr($datapack['arg1'], 0, -2);

    /* Look ahead to verify presence of an %end:% directive */
    if ($tokens[$i + 1]['name'] != 'end') {
      $this->parse_error['line'] = $datapack['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' ' . $datapack['name'];
      $this->parse_error['text'] = self::NOEND;
      return array();
    }

    return $datapack;
  } // File editor()

  /* Returns index for %label in the tokens table for parser conditional jumps */
  /**
   * @param array $tokens 
   * @param int $i (index into tokens) 
   * @param string $label 
   * @return int (index into tokens for matched label instruction)
   */
  protected function find_label(array $tokens, int $i, string $label):int
  {
    $aValid = array('-', '_');
    if (!ctype_alnum(str_replace($aValid, '', $label))) {
      /* Label name has non-alphanumeric character.
      ** Case 1: an extra colon was unintentionally inserted in the
      **    %label Directive -- %label:done:%
      **    The second colon would become part of the name -- invalid
      **    character. */
      $this->parse_error['line'] = $tokens[$i]['line'];
      $this->parse_error['tag']  = 'p' . __LINE__ .
        ' %label [<strong>' . $label . '</strong>] ';
      $this->parse_error['text'] = "badchar";
      return 0;
    } else {
      for ($k = $i + 1; isset($tokens[$k]); $k++) {
        if ($tokens[$k]['name'] == 'label') {
          if ($tokens[$k]['args'] == $label) {
            return $k;
          }
        }
      }
    }
    /* label not found. We only search from the label
    ** call, if label is placed before the call in the
    ** mod config file, it will also not be found */
    $this->parse_error['line'] = $tokens[$i]['line'];
    $this->parse_error['tag'] = 'p' . __LINE__ .
      " label: $label";
    $this->parse_error['text'] = self::MISSING;
    return 0;
  } // find_label()

  /**
   * @param array $parse_table 
   * @return array (re-arranged parse table)
   */
  protected function __arrange_table(array $parse_table):array
  {
    $new_table = array();

    // make new directories available for file copies
    for ($i = 0; isset($parse_table[$i]); $i++) {
      /* Info directives go to beginning of table.
      ** When installing mod, mkdir moves to beginning of table.
      ** When removing mod, mkdir goes after file copies so we can
      ** remove the files first (PHP rmdir cannot delete a directory with
      ** content.)
      */
      switch ($parse_table[$i]['name']) {
          // Only for installation
        case 'mkdir':
          if (isset($this->classID) && $this->classID == 'remover') {
            break;
          }
        case 'name':
        case 'version':
        case 'description':
        case 'note':
        case 'private':
        case 'author':
        case 'wikipage':
          $new_table[] = $parse_table[$i];
          $table[$i]['name'] = '';
          break;
        default:
          break;
      }
    }

    // next come file copies and newfile
    for ($i = 0; isset($parse_table[$i]); $i++) {
      if (
        $parse_table[$i]['name'] == 'copyfile' ||
        $parse_table[$i]['name'] == 'copyfile2' ||
        $parse_table[$i]['name'] == 'newfile'
      ) {
        $new_table[] = $parse_table[$i];
        $parse_table[$i]['name'] = '';
      }
      return array();
    }

    // finally all the file modifiers, mkdirs and others
    for ($i = 0; isset($parse_table[$i]); $i++) {
      if (empty($parse_table[$i]['name'])) continue;
      $new_table[] = $parse_table[$i];
    }

    return $new_table;
  }

  /**
   * @param string &$string 
   * @return string (flag-char);
   */
  private function extract_flag(string &$string):string
  {
    // look for flag anywhere in the string - should be at beginning, but...
    if ($parts = preg_match("#([@|^|~]+)#", $string, $matches, PREG_OFFSET_CAPTURE)) {
      $flag = $matches[1][0];

      /* Remove flag from string -- removes all. */
      $string = str_replace($flag, '', $string);

      return $flag;
    }
    return '';
  }

  /**
   * @param string $name (datapack/instruction name to find)
   * @param mixed $value (value of arg1)
   * @return mixed (datapack['arg1'] if found; otherwise false)
   */
  protected function find_tagname_value(string $name, $value)
  {
    foreach ($this->parse_table as $datapack) {
      if ($datapack[$name] == $value) {
        if (empty($datapack['arg1']))
          return false;
        else
          return $datapack['arg1'];
      }
    }
    return false;
  }

  /** @return bool (true if all required instructions found) */
  protected function required_tags_check():bool
  {
    if (false === $this->find_tagname_value('name', 'name')) {
      $this->parse_error['line'] = 'n/a';
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %name:';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return false;
    } elseif (false === $this->find_tagname_value('name', 'version')) {
      $this->parse_error['line'] = 'n/a';
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %version:';
      $this->parse_error['text'] = self::REQTAG; // index into admtext[]
      return false;
    } elseif (false === $this->find_tagname_value('name', 'description')) {
      $this->parse_error['line'] = 'n/a';
      $this->parse_error['tag']  = 'p' . __LINE__ . ' %description:';
      $this->parse_error['text'] = self::NOCOMPS; // index into admtext[]
      return false;
    }
    return true;
  }
} // modparser class
