<?php
# Included file prepares data needed to initialize 
# all Mod Manager class objects.

global $admtext, $rootpath, $tngconfig, $endrootpath, $tng_version;

# Manually set up unabmiguous include path in 
# case user has set different PHP include paths 
# that might target the wrong file. The TNG root
# is always one folder above 'classes'.
if (empty($rootpath)) { // create the rootpath
  $rootpath = dirname(__DIR__) . '/';
  $rootpath = str_replace("\\", "/", $rootpath); // normalize path for PHP
}

# Get config files
require $rootpath . 'subroot.php';
if (!empty($subroot)) {
  $subroot = rtrim($subroot, "/") . '/'; // Needs trailing forward slash
  require $subroot . 'mmconfig.php';
  require $subroot . 'config.php';
} else {
  require $rootpath . 'mmconfig.php';
  require $rootpath . 'config.php';
}

# Get MM language support
if (!isset($admtext['modlist'])) {
  $textpart = 'mods';
  $mylanguage = $_SESSION['session_language'];
  require 'languages/' . $mylanguage . '/admintext.php';
  /* Force reload cust_text.php */
  require 'languages/' . $mylanguage . '/alltext.php';
}

require $rootpath . 'version.php'; // tng version

$sitever = getSiteVersion();
$mhuser = isset($_SESSION['currentuserdesc']) ? $_SESSION['currentuser'] : "";

$objinits = array(
  'rootpath'     => $rootpath,
  'subroot'      => $subroot,
  'modspath'     => $modspath,
  'extspath'     => $extspath,
  'options'      => $options,
  'time_offset'  => $time_offset,
  'sitever'      => $sitever,
  'currentuserdesc' => $mhuser,
  'tngdomain'    => $tngdomain,
  'tng_version'  => $tng_version,
  'admtext'      => $admtext
);
