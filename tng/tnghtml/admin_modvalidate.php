<?php /*//241119 08:25*/
/* Mod Manager 15
** This is a template script to read all mod files, determine their installation status
** and create an array of results in mm_data.php
**
** Updated to use built-in class initializier to create an object.
*/
  /* Uncomment these to run/test this script alone. */
  //$admin_login = true;
  //include 'begin.php';
  //include 'adminlib.php';
  //include "checklogin.php";
  //include "version.php";
  //include "classes/version.php";
  $textpart = "mods";

  // if called directly just bail
  if( empty( $mylanguage ) ) die( 'sorry' );

  include_once $mylanguage."/admintext.php";

  require_once $subroot.'mmconfig.php';

  $mhuser = isset( $_SESSION['currentuserdesc'] ) ? $_SESSION['currentuser'] : "";

  if( file_exists( 'classes/modvalidator.class.php' ) )
  {
    require 'classes/modvalidator.class.php';

    $oValidator = new_modvalidator();
    $mm_data = $oValidator->check_status(true);
    // echo basename(__FILE__),': ',__LINE__,'<pre>';print_r($mm_data);exit;
  }
  return;
?>