<?php
/*
Plugin Name: NBC History IP Excluder
Version: 2.0.0
Description: Permet l'exclusion d'une IP ou d'une plage d'IP de l historique - Excludes one IP or a range of IP from the history. plugin directement derive de Stats Ip Excluder de Eric 
Plugin URI: http://phpwebgallery.net/ext/extension_view.php?eid=147
Author: Nicco, Eric
Author URI: http://gallery-nicco.no-ip.org - http://www.infernoweb.net
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (!defined('HIPE_DIR')) define('HIPE_DIR' , basename(dirname(__FILE__)));
if (!defined('HIPE_PATH')) define('HIPE_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

load_language('plugin.lang', HIPE_PATH);

add_event_handler('pwg_log_allowed', 'HIPE_IP_Filtrer');
add_event_handler('get_admin_plugin_menu_links', 'HIPE_admin_menu');

/* Set the administration panel of the plugin */
function HIPE_admin_menu($menu)
{
  array_push($menu,
    array(
      'NAME' => 'History IP Excluder',
      'URL' => get_admin_plugin_menu_link(HIPE_PATH.'admin/HIPE_admin.php')
    )
  );
    
  return $menu;
}


function HIPE_IP_Filtrer($do_log)
{
  global $conf;

  $conf_HIPE = explode("," , $conf['nbc_HistoryIPExcluder']);

  if (!$do_log)
    return $do_log;
  else
  {
    $IP_Client = explode('.', $_SERVER['REMOTE_ADDR']);
  
    foreach ($conf_HIPE as $Exclusion)
    {
      $IP_Exclude = explode('.', $Exclusion);
  
      if (
        (($IP_Client[0] == $IP_Exclude[0]) or ($IP_Exclude[0] == '%')) and
        (!isset($IP_Exclude[1]) or ($IP_Client[1] == $IP_Exclude[1]) or ($IP_Exclude[1] == '%')) and
        (!isset($IP_Exclude[2]) or ($IP_Client[2] == $IP_Exclude[2]) or ($IP_Exclude[2] == '%')) and
        (!isset($IP_Exclude[3]) or ($IP_Client[3] == $IP_Exclude[3]) or ($IP_Exclude[3] == '%'))
      )
      {
        $do_log = false;
      }    
    }
     
    return $do_log;
  }
}
?>