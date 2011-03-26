<?php

load_language('plugin.lang', HIPE_PATH);

function HIPE_infos($dir)
{
  $path = $dir;

  $plg_data = implode( '', file($path.'main.inc.php') );
  if ( preg_match("|Plugin Name: (.*)|", $plg_data, $val) )
  {
    $plugin['name'] = trim( $val[1] );
  }
  if (preg_match("|Version: (.*)|", $plg_data, $val))
  {
    $plugin['version'] = trim($val[1]);
  }
  if ( preg_match("|Plugin URI: (.*)|", $plg_data, $val) )
  {
    $plugin['uri'] = trim($val[1]);
  }
  if ($desc = load_language('description.txt', $path.'/', array('return' => true)))
  {
    $plugin['description'] = trim($desc);
  }
  elseif ( preg_match("|Description: (.*)|", $plg_data, $val) )
  {
    $plugin['description'] = trim($val[1]);
  }
  if ( preg_match("|Author: (.*)|", $plg_data, $val) )
  {
    $plugin['author'] = trim($val[1]);
  }
  if ( preg_match("|Author URI: (.*)|", $plg_data, $val) )
  {
    $plugin['author uri'] = trim($val[1]);
  }
  if (!empty($plugin['uri']) and strpos($plugin['uri'] , 'extension_view.php?eid='))
  {
    list( , $extension) = explode('extension_view.php?eid=', $plugin['uri']);
    if (is_numeric($extension)) $plugin['extension'] = $extension;
  }
// IMPORTANT SECURITY !
  $plugin = array_map('htmlspecialchars', $plugin);

  return $plugin ;
}
?>