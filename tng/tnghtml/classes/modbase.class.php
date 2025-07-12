<?php
/*
   Mod Manager 15 modbase class

   This class contains fundamental constants, data and functons
   needed by other mod manager processing classes.

   It provides file reading and writing as well as status logging services.

   Data:
      Common data

   Public Methods:
      get_modfile_names
      get_modlist_sorted
*/

class modbase
{

  const YES = "1";
  const NO = "0";

  const NOERR       =  0;
  const ERROR       = -1;
  const WARNING     = -2;

  /* Parse table flags */
  const FLAG_OPTIONAL     = '@';
  const FLAG_NOFOUL       = '^';
  const FLAG_PROVISIONAL  = '^';
  const FLAG_PROTECTED    = '~';

  /* File buffer status flags */
  const BYPASS   = '1';
  const NOFILE   = '2';
  const NOWRITE  = '3';
  const ISEMPTY  = '4';
  const NOFOUL   = '5';
  const PROVISIONAL = '5';

  /* File state flags */
  const NOPATH = "-1";
  const NOREAD = "-2";
  const NOMODS =  "1";

  /* Mod Listing sort flags */
  const NAMECOL = "0";
  const FILECOL = "1";

  /* Mod listing filter flags */
  const F_ALL = 0;
  const F_READY = 1;
  const F_INSTALLED = 2;
  const F_CLEAN = 3;
  const F_BADCFG = 4;
  const F_SELECT = 5;

  /* Mod operation flags */
  const INSTALL = 1;
  const REMOVE = 2;
  const DELETE = 3;
  const CLEANUP = 4;
  const EDITP = 5;
  const UPDATEP = 6;
  const RESTOREP = 7;

  /* Path construction flags */
  const ROOT_DIR    = 0;
  const MODS_DIR    = 1;

  /* Language indexes $into admtext. */
  const BADCHAR     = 'badchar';
  const BADVERSION  = 'badversion';
  const BOMFOUND    = 'bomfound';
  const CANTDEL     = 'cantdel';
  const CANTINST    = 'cantinst';
  const CANTPROC    = 'cantproc';
  const CANTUPD     = 'cantupd';
  const DEFVAL      = 'defval';
  const EMPTYFILE   = 'emptyfile';
  const ERRORS      = 'errors';
  const FILEDEL     = 'filedel';
  const FILEPERMS   = 'fileperms';
  const FORMAT      = 'format';
  const INSTALLED   = 'installed';
  const LINE        = 'line';
  const MISSFILE    = 'missfile';
  const MISSING     = 'missing';
  const MODREM      = 'modrem';
  const NOACCESS    = 'noaccess';
  const NOACT       = 'noact';
  const NOCFGFILE   = 'nocfgfile';
  const NOCOMPS     = 'nocomps';
  const NODESC      = 'nodesc';
  const NOEND       = 'noend';
  const NOLOCATION  = 'nolocation';
  const NOPARAM     = 'noparam';
  const NOSOURCE    = 'srcfilemissing';
  const NOTARGET    = 'notarget';
  const NOTWRITE    = 'notwrite';
  const NOTINST     = 'notinst';
  const OK2INST     = 'ok2inst';
  const PARTINST    = 'partinst';
  const REQTAG      = 'reqtag';
  const TAGNOTERM   = 'tagnoterm';
  const TAGUNK      = 'tagunk';
  const UNXEND      = 'unxend';
  const UPDATED     = 'updated';

  public $instantiation_error = 0;

  protected $eventlog = '';
  protected $num_errors = 0;
  protected $provisional_errors = 0;

  public $classID = '';
  protected $mod_status = '';

  /* Initializers from modobjinits.php */
  protected $rootpath = '';
  protected $subroot = '';
  protected $extspath = '';
  protected $options = array();
  protected $modspath = '';
  protected $modname = '';
  protected $version = '';
  protected $tng_version = '';
  protected $int_version = 0;
  protected $time_offset = 0;
  protected $sitever = 'standard';
  protected $currentuserdesc = '';
  protected $admtext = array();
  protected $tngdomain = '';

  protected $sysmsg = '';

  /* Options */
  public    $sortby;
  protected $modlogfile = 'modmgrlog.txt';
  protected $maxloglines = 2000;
  protected $delete_partial = false;
  protected $delete_installed = false;
  protected $show_affected_files = true;
  protected $show_AFnewfile = true;
  protected $show_AFfilecopies = true;
  protected $delete_support = 0;
  protected $show_updates = 0;
  protected $show_developer = 0;
  protected $show_analyzeractions = 0;
  protected $show_analyzer = 0;
  protected $compress_names = 0;
  protected $redirect2log = 0;
  protected $compress_log = 0;

  protected $fix_header = 1;
  protected $use_striping = false;
  protected $stripe_after = 3;
  protected $log_full_path = true;
  protected $wikibase = "https://tng.lythgoes.net/wiki/index.php?title=";

  protected $cfgpath = '';
  protected $cfgfile = '';

  protected $batch_error = false;

  function __construct($objinits)
  {
    try {
      $this->initialize($objinits);
    } catch (Exception $e) {
      $this->instantiation_error = 1;
      error_log("Modbase Error: " .  $e->getMessage(), 0);
    }
  } // __construct

  # Sets non-fatal instantiation error flag, if any,
  # and allows extended classes to deal with them
  # gracefully.  For example a class may just pass 
  # an empty result, or it may throw an exception
  # like Modlister.
  protected function initialize($objinits)
  {
    # copy init values to data area.
    foreach ($objinits as $key => $value) {
      $this->$key = $value;
    }

    # Break out options array
    foreach ($this->options as $key => $value) {
      $this->$key = $value;
    }

    # Missing admtext array
    if(!is_array($this->admtext)) {
      throw new Exception('TNG $admtext array Missing, line:' . __LINE__);
    }

    ##unset($this->tng_version); // testing only
    # Missing TNG version Error
    if (!is_string($this->tng_version)) {
      throw new Exception("TNG {$this->admtext['version']}: {$this->admtext['missing']}, line:" . __LINE__);
    } else {
      $this->int_version = $this->version2integer($this->tng_version);
    }

    # Missing $rootpath (can't find log)
    if(!is_string($this->rootpath)) {
      throw new Exception("TNG \$rootpath {$this->admtext['missing']}, line:" . __LINE__); 
    }

    # Missing $subroot
    if(!is_string($this->subroot)) {
      throw new Exception("TNG \$subroot {$this->admtext['missing']}, line:" . __LINE__); 
    }

    # Missing $modspath
    if(empty($this->modspath)) {
      throw new Exception("TNG \$modspath {$this->admtext['missing']}, line:" . __LINE__); 
    }

    # Missing $extspath
    if(empty($this->extspath)) {
      throw new Exception("TNG \$exts {$this->admtext['missing']}, line:" . __LINE__); 
    }

    # Missing $time_offset
    if(!is_string($this->time_offset)) {
      throw new Exception("TNG \$time_offset {$this->admtext['missing']}, line:" . __LINE__); 
    }

      # Missing $sitever
    if(!is_string($this->sitever)) {
      throw new Exception("TNG \$sitever {$this->admtext['missing']}, line:" . __LINE__); 
    }    

    # Add a couple missing text items
    if (!empty($this->admtext['error'])) {
      $this->admtext['error'] = "<span class=\"msgerror\"><strong>{$this->admtext['error']}</strong></span>";
    }
    if (!empty($this->admtext['okay'])) {
      $this->admtext['okay'] = "<span class=\"msgapproved\"><strong>{$this->admtext['okay']}</strong></span>";
    }

    # If visitor is mobile don't use fixed headers.
    if ($this->sitever == 'mobile') $this->fix_header = 0;
  }
  #***********************************************************************
  # BUFFERS
  #***********************************************************************

  /**
   * @param string $buffer
   * @return string (updated buffer)
   */
  protected function fix_eol(string $buffer): string
  {
    return preg_replace("#(?:\r\n|\r\r\n|[\r\n])#", "\r\n", $buffer);
  }

  # Remove spaces or tabs immediately in front of line terminating
  # CRLF that might prevent  a target match.
  /**
   * @param string $buffer
   * @return string (updated buffer)
   */
  protected function remove_hidden_whitespace(string $buffer): string
  {
    return preg_replace("#[ \t]*\r\n#", "\r\n", $buffer);
  }

  /**
   * @param string $filepath
   * @param string $flag
   * @return string (file content or non-retrieval status)
   */
  protected function read_file_buffer(string $filepath, string $flag = ''): string
  {
    $buffer = '';
    $retval = '';

    // UNCOMMENT NEXT LINE TO USE RELATIVE PATHS FOR FILE READS
    //$filepath = str_replace( $this->rootpath, '', $filepath );

    while (true) {
      /* File does not exist. */
      if (!file_exists($filepath)) {
        if ($flag == self::FLAG_OPTIONAL) {
          $retval = self::BYPASS;
          break;
        } elseif ($flag == self::FLAG_PROVISIONAL) {
          $this->provisional_errors++;
          $retval = self::PROVISIONAL;
          break;
        }

        /* "Protected" flag only applies to file copies - no need to act here. */ else {
          $this->num_errors++;
          $retval = self::NOFILE;
          break;
        }
      }

      /* Target file path is not writable. */
      $ext = pathinfo($filepath, PATHINFO_EXTENSION);
      if ($ext != 'cfg' && !is_writable($filepath)) {
        $this->num_errors++;
        $retval = self::NOWRITE;
        break;
      }

      // GET FILE CONTENTS INTO BUFFER - PROTECT FILE WITH SHARED LOCK
      $fhandle = fopen($filepath, 'rb');
      flock($fhandle, LOCK_SH);
      $buffer = $this->fix_eol(file_get_contents($filepath, false));
      $buffer = $this->remove_hidden_whitespace($buffer);
      fclose($fhandle);

      // FILE IS EMPTY
      if (empty($buffer)) {
        $this->num_errors++;
        $retval = self::ISEMPTY;
        break;
      }
      break;
    } // while(true)

    if (!empty($retval)) $buffer = $retval;
    return $buffer;
  } // read_file_buffer()

  /**
   * @param string $filepath
   * @param string $buffer
   * @return false|int
   */
  protected function write_file_buffer(string $filepath, string $buffer) // PHP7 no compound returns
  {
    /* Uncomment next line to use relative paths for file writes. */
    //$filepath = str_replace( $this->rootpath, '', $filepath );

    if (!file_exists(dirname($filepath))) {
      return false;
    }
    $fp = fopen($filepath, 'wb');
    if (!$fp) {;
      $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cannotopen']} $filepath ";
      return false;
    }
    flock($fp, LOCK_EX);
    $ret = fwrite($fp, $buffer);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $ret;
  }
  #***********************************************************************
  # LOGS
  #***********************************************************************
  /**
   * @param string $string (appends to the current log event)
   * @return string (updated log event)
   */
  protected function add_logevent(string $string): string
  {
    return $this->eventlog .= "<br />&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;" . $string;
  }

  /** @return false|int  */
  private function create_logfile()
  {
    //$rootpath = $this->rootpath;

    $content = "#### Mod Manager Log " . date("D d M Y h:i:s A", time() + (3600 * $this->time_offset)) . " ####";
    return $this->write_file_buffer($this->modlogfile, $content);
  }

  /* Begin the logging a new mod event. */
  /**
   * @param string $string (new log event text)
   * @return string (new logged event)
   */
  protected function new_logevent(string $string): string
  {
    /* Get elements for enhanced header line. */
    $datetime = date("D d M Y h:i:s A", time() + (3600 * $this->time_offset));
    if ($this->classID == 'installer')
      $operation = "<span class=\"msgbold\">{$this->admtext['install']}</span>";
    elseif ($this->classID == 'remover')
      $operation = "<span class=\"msgbold\">{$this->admtext['uninstall']}</span>";
    elseif ($this->classID == 'cleaner')
      $operation = "<span class=\"msgbold\">{$this->admtext['cleanup']}</span>";
    elseif ($this->classID == 'editor')
      $operation = "<span class=\"msgbold\">{$this->admtext['edparams']}</span>";
    elseif ($this->classID == 'deleter')
      $operation = "<span class=\"msgbold\">{$this->admtext['delete']}</span>";
    else
      $operation = '';

    $modname = $this->modname;
    $modversion = $this->version;

    $this->eventlog = $datetime . ' | ' . $operation . ' | ' . $modname . ' ' . $modversion . ' | zzzxxzzz | ' . $this->currentuserdesc . ' xxxzzxxx';
    return $this->add_logevent($string);
  }

  /**
   * @param bool $error (sets style of log event)
   * @return bool (success)
   */
  protected function write_eventlog(bool $error = false): bool
  {
    $mod_status = $this->mod_status;
    $hlight = empty($error) ? ' highlight' : ' hilighterr';

    // if log file is missing start a new one
    if (!file_exists($this->modlogfile)) {
      if (!$this->create_logfile()) {
        $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cantwrite']} $this->modlogfile !";
        unset($this->eventlog);
        return false;
      }
    }

    /* Import existing log lines. */
    $lines = file($this->modlogfile);

    /* Add dynamic results to event log. */
    $modstat1 = "<span class=\"msgbold$hlight\">{$this->admtext[$mod_status]}</span>";
    $modstat2 = " <span class=\"hidden\">$mod_status</span>";

    $this->eventlog = str_replace("zzzxxzzz", $modstat1, $this->eventlog);
    $this->eventlog = str_replace("xxxzzxxx", $modstat2, $this->eventlog);

    /* Add new event log lines to $lines array. */
    array_unshift($lines, $this->eventlog . "\n");

    $fp = @fopen($this->modlogfile, "w");
    if (!$fp) {
      $_SESSION['err_msg'] = "{$this->admtext['checkwrite']} {$this->admtext['cannotopen']} $this->modlogfile ";
      unset($this->eventlog);
      return false;
    }

    $linecount = 0;
    foreach ($lines as $line) {
      trim($line);
      if ($line)
        fwrite($fp, $line);
      $linecount++;
      if ($linecount == $this->maxloglines) break;
    }
    flock($fp, LOCK_UN);
    fclose($fp);
    unset($this->eventlog);
    return true;
  }
  #***********************************************************************
  # MODS
  # **********************************************************************
  /**
   * @param string $modspath (site mods directory)
   * @return string modspath or abnormal status code
   */
  public function verify_modspath(string $modspath): string
  {
    /* Return reason for not finding mod names */
    if (!is_dir($modspath)) return self::NOPATH;
    if (!is_readable($modspath)) return self::NOREAD;
    if (count(scandir($modspath)) == 2) return self::NOMODS;
    return $modspath;
  }

  /** @return '-1'|'-2'|'1'|array of cfg file names  */
  public function get_modfile_names()
  {
    $modspath = $this->verify_modspath($this->modspath);
    if (is_numeric($modspath)) {
      return $modspath;
    }

    $fileNames = array();

    if ($handle = opendir($this->modspath)) {
      while (false !== ($file = readdir($handle))) {
        if (pathinfo($file, PATHINFO_EXTENSION) == 'cfg') {
          $fileNames[] = $file;
        }
      }
      closedir($handle);
      natcasesort($fileNames);
    }
    return $fileNames;
  }

  # Returns an array ($modlist) where keys = filename and values = modname
  /** @return string|array (string contains error status code) */
  public function get_modlist_sorted()
  {
    /* Get file list -- look up file names & add to list. */
    $modfiles = $this->get_modfile_names();

    /* A returned integer indicates an empty list with a notable condition */
    if (is_numeric($modfiles)) return $modfiles;

    $mod_list = array();
    foreach ($modfiles as $modfile) {
      $contents = $this->read_file_buffer($this->rootpath . $this->modspath . '/' . $modfile);

      /* Handle file access errors, if any. */
      if (is_numeric($contents)) {
        $mod_list[$modfile] = $this->admtext['noaccess'];
        continue;
      }

      // need to replace modvar:name with value if it exists.
      $contents = $this->resolve_modvars($contents);

      # grab mod name
      preg_match('#.*%name:([^%]*).*#is', $contents, $matches);

      # Create an array ($modlist) where key = filename and value = modname
      if (isset($matches[1]))
        $mod_list[$modfile] = trim($matches[1]);
      else
        $mod_list[$modfile] = '';
    }

    if (!count($mod_list)) {
      return self::NOMODS;
    }

    /* Natrually sorted by file name - re-sort by mod name. */
    if ($this->sortby == self::NAMECOL) {
      /* Use temporary array because we can't actually change file name. */
      $temp = array_map('strtolower', $mod_list);
      array_multisort($temp, SORT_ASC, SORT_STRING, $mod_list);
    }

    return $mod_list;
  }

  /* Replace modvars in buffer with values */
  /**
   * @param string $buffer
   * @return string (updated buffer)
   */
  protected function resolve_modvars(string $buffer): string
  {
    $buffer = str_ireplace("%modvar", "%modvar", $buffer);
    preg_match_all("#^\s*%modvar:(.+?):(.+?)%#im", $buffer, $matches, PREG_SET_ORDER);

    if (!empty($matches)) {
      foreach ($matches as $modvar) {
        /* Replace placeholders with values.*/
        $buffer = str_replace($modvar[1], $modvar[2], $buffer);
      }

      /* Comment out entire %modvar lines in the buffer.*/
      $buffer = preg_replace("#(%modvar:)#m", '//%modvar:', $buffer);
    }

    return $buffer;
  }

  /**
   * Set $path relative to TNG root or to mods directory
   * @param string $path
   * @param int $relative
   * @return string
   */
  protected function resolve_file_path(string $path, int $relative = self::ROOT_DIR): string
  {
    /* Leading slash unnecesary - all paths relative to tng root. */
    $path = ltrim($path, " /");
    /* set path for TNG config files. */
    if (in_array($path, $this->configs)) {
      return $this->subroot . $path;
    } elseif ($relative == self::MODS_DIR) {
      $path = $this->resolve_path_vars($path);
      return $this->rootpath . $this->modspath . '/' . $path;
    } else {
      return $this->rootpath . $this->resolve_path_vars($path);
    }
  }

  /**
   * Helper function to resolve $modspath and $extspath in $str
   * @param string $str
   * @return string (update string)
   */
  protected function resolve_path_vars(string $str): string
  {
    $str = str_replace('$modspath', $this->modspath, $str);
    $str = str_replace('$extspath', $this->extspath, $str);
    return $str;
  }


  /***************************************************************
  DATA
   ***************************************************************/
  /* These are TNG files that will be found together at $subroot.
  ** Important to know if modifying one of them. */
  protected $configs = array(
    'config.php',
    'customconfig.php',
    'importconfig.php',
    'logconfig.php',
    'mapconfig.php',
    'pedconfig.php',
    'mmconfig.php'
  );

  /* Associative array of directives and their processing functions.
    **
    ** The table index is directive name and the value is the associated
    ** function name. Within each class the functions must be PRIVATE
    ** to avoid name clash with other classes.
    **
    ** $proclist['description'] will return the function name '_description'.
    ** $proclist[$dirpack] will return the function name for $dirpack.
    **
    ** PHP allows a variable to be executed as a function, so $var($arg1, $arg2) will
    ** execute the function name contained in $var using arguments $arg1 and $arg2.
    ** This is how the Mod Classes will call the functions named in the table.
    **
    ** Editing directive which have 'before' and 'after' modifiers are listed here, but
    ** are pointed to the basic file_editor function.  For example insert:before
    ** just points to the '_insert' function which handles both before and after.
    **
    ** Directives with 'no_op' for the processing function are not processed
    ** by modparser derived classes, so technically, they do not need to
    ** have an associted functions in those classes. However mod parser checks
    ** this table to confirm that these directives are valid for Mod Manager.
    **
    ** Just for readability, the table directive entries should be maintained in
    ** alphabetical order.

    ** To add a new directive to Mod Manager, start with an entry here, then create
    ** the necessary functions for it in the modparser-extended classes.
    */
  protected $proclist = array(
    'author'            => '_author',
    'choices'           => '_choices',
    'copyfile'          => '_copyfile',
    'copyfile2'         => '_copyfile',
    'desc'              => '_desc',
    'description'       => '_description',
    'end'               => 'no_op',
    'exit'              => 'no_op',
    'fileend'           => 'no_op',
    'fileexists'        => '_fileexists',
    'fileoptional'      => 'no_op',
    'files'             => 'no_op',
    'fileversion'       => 'no_op',
    'goto'              => '_goto',
    'insert'            => '_insert',
    'insert:before'     => '_insert',
    'insert:after'      => '_insert',
    'label'             => '_label',
    'location'          => '_location',
    'mkdir'             => '_mkdir',
    'modvars'           => 'no_op',
    'name'              => '_name',
    'newfile'           => '_newfile',
    'note'              => '_note',
    'parameter'         => '_parameter',
    'private'           => '_private',
    'range'            => '_range',
    'replace'           => '_replace',
    'target'            => '_target',
    'tngversion'        => '_tngversion',
    'textexists'        => '_textexists',
    'triminsert'        => '_triminsert',
    'triminsert:before' => '_triminsert',
    'triminsert:after'  => '_triminsert',
    'trimreplace'       => '_trimreplace',
    'version'           => '_version',
    'vinsert'           => '_vinsert',
    'vinsert:before'    => '_vinsert',
    'vinsert:after'     => '_vinsert',
    'wikipage'          => '_wikipage'
  );

  /*
  ** This is a list of directives that modify file content.
  ** Modparser uses the short versions (insert, triminsert) and the parse table and
  ** other classes use the long versions (insert:after, triminsert:before) so both
  ** are listed.
  */
  protected $file_modifiers = array(
    'insert',
    'insert:before',
    'insert:after',
    'triminsert',
    'triminsert:before',
    'triminsert:after',
    'vinsert',
    'vinsert:before',
    'vinsert:after',
    'replace',
    'trimreplace'
  );

  #***********************************************************************
  # MISCELLANEOUS
  #***********************************************************************
  /**
   * @param string $version
   * @return string (version - only padded numbers)
   */
  protected function version2integer(string $version): string
  {
    # Split on 1str character that is not a number or a decimal point.
    $parts = preg_split("/[^0-9\.]/", $version, 2);

    # Remove decimal points.
    $vernum = str_replace(".", "", $parts[0]);

    # Pad remainder and return the new versions string.
    return str_pad($vernum, 4, "0", STR_PAD_RIGHT);
  }
} // modbase class
