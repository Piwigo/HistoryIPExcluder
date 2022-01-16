<?php
/*
Plugin Name: History IP Excluder
Version: auto
Description: Permet l'exclusion d'une IP ou d'une plage d'IP de l'historique et de les blacklister à l'inscription / Excludes one IP or a range of IP from the history and to blacklist them on registration
Plugin URI: http://piwigo.org/ext/extension_view.php?eid=147
Author: Nicco, Eric
Author URI: http://gallery-nicco.no-ip.org - http://www.infernoweb.net
Has Settings: webmaster
*/

/*
:: HISTORY

1.0.x to 1.6.x		- Plugin only for PWG 1.7.x

2.0.0             - Compliance with Piwigo 2.0.x

2.1.0             - Compliance with Piwigo 2.1.x
                  - Multiple database support
                  - Removing "nbc_" prefix in plugin code and display in piwigo's plugin manager
                  - Displaying the good plugin name and current version in admin panel
                  
2.1.1             - Bug 1792 fixed (Thx to TOnin)
                  - Bug 1511 fixed - New function to blacklist excluded IPs or ranged IPs for registration

2.2.0             - Compliance with Piwigo 2.2.x
                  - Plugin directory renamed from nbc_HistoryIPExcluder to HistoryIPExcluder

2.2.1             - Bug fixed on plugin upgrade from 2.1.x version

2.2.2             - Another bug fixed on plugin upgrade from 2.2.x version

2.2.3             - Improved update mechanism. When no structural update of database is necessary, it sets the correct version number in plugin's configuration

2.3.0             - Piwigo 2.3.0 compliant (alpha release for Piwigo 2.3.0RC)
                  - Use data serialization for database storage
                  - Use pwg_db_real_escape_string() instead of addslashes()

2.4.0             - Piwigo 2.4 compliant
                  - Add pl_PL translation (thanks to larky)

2.4.1             - Add  cs_CZ translation (thanks to lanius and ZdenekMaterna)
                  - Add  ru_RU translation (thanks to nadusha)

2.4.2             - Update ru_RU translation (thanks to nadusha)

2.4.3             - Update hu_HU translation (thanks to samli)
                  - Update pl_PL translation (thanks to kuba)
                  - Update cs_CZ translation (thanks to sichr)
                  - Update el_GR translation (thanks to bas_alba)
                  - Update lv_LV translation (thanks to agrisans)
                  - Add uk_UA translation (thanks to animan)

2.4.4             - Update uk_UA, thanks to : animan
                  - Update es_ES, thanks to : jpr928
                  - Update it_IT, thanks to : virgigiole
                  - Add sk_SK, thanks to : dodo
                  - Add da_DK, thanks to : Kaare

2.5.0             - Compliance with Piwigo 2.5
                  - Add tr_TR, thanks to : LazBoy

2.5.1             - Add pt_BR, thanks to : flaviove

2.5.2             - Add pt_PT, thanks to : ddtddt & ANO

2.5.3             - Add nl_NL, thanks to : Kees Hessels
                  - Update el_GR, thanks to : bas_alba
                  - Update da_DK, thanks to : Kaare
                  - Update ru_RU, thanks to : Konve
                  - Translation keys fixed
                  - Delete unused translation keys

2.5.4             - Update es_ES, thanks to : jpr928
                  - Update tr_TR, thanks to : LazBoy
                  - Update lv_LV, thanks to : agrisans
                  - Update pt_PT, thanks to : ANO
                  - Update sk_SK, thanks to : dodo
                  - Update pl_PL, thanks to : K.S.
                  - Update it_IT, thanks to : Sugar888
                  - Update pt_BR, thanks to : glaucio
                  - Update de_DE, thanks to : fs101299
                  - Update nl_NL, thanks to : Kees Hessels

2.6.0             - Compatibility checked with Piwigo 2.6
                  - Update uk_UA, thanks to : animan
                  - Update cs_CZ, thanks to : elpresidento

2.6.1             - Fix obsolete is_adviser()

2.7.0             - Compatibility with Piwigo 2.7
                  - Update zh_CN, thanks to : dennisyan

2.7.1			  - Add nb_NO, thanks to : paulen

2.7.2			  - Update nb_NO, thanks to paulen
				  - Update de_DE, thanks to bigant
--------------------------------------------------------------------------------
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

if (!defined('HIPE_PATH')) define('HIPE_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

include_once (HIPE_PATH.'/include/functions.inc.php');


add_event_handler('loading_lang', 'HIPE_loading_lang');	  
function HIPE_loading_lang(){
  load_language('plugin.lang', HIPE_PATH);
}





// IP exclusion from logs
add_event_handler('pwg_log_allowed', 'HIPE_IP_Filtrer');

function HIPE_IP_Filtrer($do_log)
{
  global $conf;

  $conf_HIPE = explode("," , $conf['HistoryIPExcluder']);

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

/* Check users registration */
add_event_handler('register_user_check', 'HIPE_RegistrationCheck', EVENT_HANDLER_PRIORITY_NEUTRAL +2, 2);

function HIPE_RegistrationCheck($err, $user)
{
  global $errors, $conf;
  load_language('plugin.lang', HIPE_PATH);
  
  if (count($err)!=0 ) return $err;
  
  $IP_Client = explode('.', $_SERVER['REMOTE_ADDR']);
  $HIPE_Config = unserialize($conf['HistoryIPConfig']);
  $conf_HIPE = explode("," , $conf['HistoryIPExcluder']);
  
  if (isset($HIPE_Config['Blacklist']) and $HIPE_Config['Blacklist'] == true)
  {
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
        $err = l10n('Error_HIPE_BlacklistedIP');
      }
    }
    return $err;
  }
}
?>