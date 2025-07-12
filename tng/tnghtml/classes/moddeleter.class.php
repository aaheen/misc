<?php
/*
  Mod Manager 15 deleter class

  Instantiated by admin_modhandler.php when it gets an instruction from modlister
    to delete a mod configuration file.

  Methods:
    public function delete_mod( $cfgpath );
    public function batch_delete( $cfgpathlist );

  Revised -- Change in behavior:
    Now it only deletes a support folder if it exists in the mods directory AND
    has exactly the same name_version as the cfg file being deleted. Moddeleter no
    longer opens the mod file to get the support folder path from copyfile directives.
    This protects a support file with a generic name or version number which may be
    used by multiple versions of the same mod.
*/

require_once 'begin.php';
require_once 'classes/modbase.class.php';

#[AllowDynamicProperties]
class moddeleter extends modbase
{
  protected $mod_status = '';

  function __construct($objinits)
  {
    parent::__construct($objinits);
  }

  public function delete_mod(string $cfgpath): bool
  {
    $success = false;

    /* This is for the section header of the log. */
    $this->modname = pathinfo($cfgpath, PATHINFO_BASENAME);

    $rel_cfg_filepath = $this->modspath . '/' . pathinfo($cfgpath, PATHINFO_BASENAME);

    /* Start logging the deletion event. */
    $this->new_logevent("{$this->admtext['deleting']} <strong>$rel_cfg_filepath</strong>");

    $support_foldername = pathinfo($cfgpath, PATHINFO_FILENAME);
    $abs_support_folderpath = $this->rootpath . $this->modspath . "/" . $support_foldername;
    $rel_support_folderpath = $this->modspath . '/' . $support_foldername;  // Short version for log

    while (true) {
      if (file_exists($cfgpath)) {

        if (!unlink($cfgpath))
        //if( !true )
        {
          $this->add_logevent("<span class=\"hilighterr msgbold\"> D:" . __LINE__ . " {$this->admtext['cantdel']} {$this->admtext['file']} $rel_cfg_filepath</span>");
          $this->mod_status = self::CANTDEL;
          $success = false;
          break;
        } else {
          $this->add_logevent("<span class=\"msgapproved\">$rel_cfg_filepath {$this->admtext['filedel']}</span>");
          $this->mod_status = self::FILEDEL;
          $success = true;
        }
      } else {
        /* Mod file not found - this should never happen. Inspect the value of
        ** $cfgpath coming in, and trace it back to the admin_modhandler where it
        ** came from.
        */
        $this->add_logevent("<span class=\"hilighterr msgbold\"> D:" . __LINE__ . " {$this->admtext['file']} $rel_cfg_filepath {$this->admtext['missing']}</span>");
        $success = false;
        break;
      }

      if (!empty($this->delete_support)) {
        $this->add_logevent("<strong>{$this->admtext['allowdeletesupport']}</strong>");

        /* Attempt to delete a support folder with the same name as that of the mod
        ** configuration file.
        */
        if (file_exists($abs_support_folderpath) && is_dir($abs_support_folderpath)) {
          if ($this->delete_folder($abs_support_folderpath)) {
            $this->add_logevent("<span class=\"msgapproved\">$rel_support_folderpath {$this->admtext['folder']} {$this->admtext['deleted']}");
            break;
          } else {
            /* Folder may not have been emptied of files for some reason. Check the
            ** contents of the support folder and trace the destroy_folder() function.
            */
            $this->add_logevent("D:" . __LINE__ . " " . $this->admtext['cantdel'] . ' ' . $this->admtext['folder'] . ' ' . $rel_support_folderpath);
            break;
          }
        } else {
          $this->add_logevent("<span class=\"msgapproved\">$rel_support_folderpath {$this->admtext['folder']} {$this->admtext['nomatches']}");
        }
      }
      break;
    } // while(true)

    $this->write_eventlog();

    /* This determines whether admin_handler returns to the mod listing, or
    ** goes to the error log.
    */
    return $success;
  }
  /**********************************************************************
SUPPORTING FUNCTIONS
   **********************************************************************/
  public function batch_delete(array $cfgpathlist): bool
  {
    foreach ($cfgpathlist as $cfgpath) {
      if (!$this->delete_mod($cfgpath)) {
        $this->batch_error = true;
      };
    }
    return !$this->batch_error;
  }

  function delete_folder(string $dir): bool
  {
    if (!is_dir($dir) || is_link($dir))
      return unlink($dir);

    foreach (scandir($dir) as $file) {
      if ($file == "." || $file == "..") continue;
      if (!$this->delete_folder($dir . "/" . $file)) {
        chmod($dir . "/" . $file, 0777);
        if (!$this->delete_folder($dir . "/" . $file)) return false;
      }
    }
    return rmdir($dir);
  }
} // moddeleter class

function new_moddeleter(): moddeleter
{
  require __DIR__ . '/mmobjinits.php';
  $objinits['classID'] = 'deleter';
  return new moddeleter($objinits);
}
