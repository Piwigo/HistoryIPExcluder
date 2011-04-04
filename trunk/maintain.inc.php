<?php

if (!defined('HIPE_PATH')) define('HIPE_PATH' , PHPWG_PLUGINS_PATH.basename(dirname(__FILE__)).'/');

include_once (HIPE_PATH.'include/functions.inc.php');

function plugin_install()
{
  global $conf;
  
// Set plugin parameters
  $default= array();

	$query = '
SELECT param
  FROM '.CONFIG_TABLE.'
WHERE param = "HistoryIPExcluder"
;';
  $count = pwg_db_num_rows(pwg_query($query));
  
  if ($count == 0)
  {
    $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("HistoryIPExcluder","","History IP Excluder parameters");
';
      
    pwg_query($q);
  }

// Set plugin config
  $plugin =  HIPE_infos(HIPE_PATH);
  $version = $plugin['version'];

  $default = array (
    'Blacklist' => "0",
    'Version'=> $version,
  );

	$query = '
SELECT param
  FROM '.CONFIG_TABLE.'
WHERE param = "HistoryIPConfig"
;';
  $count = pwg_db_num_rows(pwg_query($query));
  
  if ($count == 0)
  {
    $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("HistoryIPConfig","'.addslashes(serialize($default)).'","History IP Excluder options");
';
    pwg_query($q);
  }
}


function plugin_activate()
{
  global $conf;
  
/* Check for upgrade from 2.0.0 to 2.0.1 */
/* *************************************** */
	$query = '
SELECT param
  FROM '.CONFIG_TABLE.'
WHERE param = "nbc_HistoryIPExcluder"
;';
  $count = pwg_db_num_rows(pwg_query($query));
  
	if ($count == 1)
	{
  /* upgrade from version 2.0.0 to 2.0.1  */
  /* ************************************ */
		upgrade_200();
	}

	$query = '
SELECT param
  FROM '.CONFIG_TABLE.'
WHERE param = "HistoryIPConfig"
;';
  $count = pwg_db_num_rows(pwg_query($query));

	if ($count == 0)
	{
  /* upgrade from version 2.1.0 to 2.1.1  */
  /* ************************************ */
		upgrade_210();
	}

  /* upgrade from version 2.1.1 to 2.2.0 */
  /* *********************************** */
  $HIPE_Config = unserialize($conf['HistoryIPConfig']);
  if ($HIPE_Config['Version'] == '2.1.1')
  {
    upgrade_211();
  }

  /* upgrade from version 2.2.0 to 2.2.1 */
  /* *********************************** */
  $HIPE_Config = unserialize($conf['HistoryIPConfig']);
  if ($HIPE_Config['Version'] == '2.2.0')
  {
    upgrade_220();
  }
}


function plugin_uninstall()
{
  global $conf;

  if (isset($conf['HistoryIPExcluder']))
  {
    $q = '
DELETE FROM '.CONFIG_TABLE.'
WHERE param="HistoryIPExcluder" LIMIT 1;
';

    pwg_query($q);
  }
  if (isset($conf['HistoryIPConfig']))
  {
    $q = '
DELETE FROM '.CONFIG_TABLE.'
WHERE param="HistoryIPConfig" LIMIT 1;
';

    pwg_query($q);
  }  
}


function upgrade_200()
{
  global $conf;
  
  $q = '
UPDATE '.CONFIG_TABLE.'
SET param = "HistoryIPExcluder"
WHERE param = "nbc_HistoryIPExcluder"
;';
  pwg_query($q);

  $q = '
UPDATE '.CONFIG_TABLE.'
SET comment = "History IP Excluder parameters"
WHERE comment = "Parametres nbc History IP Excluder"
;';
  pwg_query($q);

  upgrade_210();
}

function upgrade_210()
{
  global $conf;
  
  $default = array (
    'Blacklist' => "0",
    'Version'=> "2.1.1",
  );

  $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("HistoryIPConfig","'.addslashes(serialize($default)).'","History IP Excluder options");
';
      
  pwg_query($q);
}

function upgrade_211()
{
  global $conf;

// Update plugin version
  $query = '
SELECT value
  FROM '.CONFIG_TABLE.'
WHERE param = "HistoryIPConfig"
;';
  $result = pwg_query($query);
  
  $conf_HIPE = pwg_db_fetch_assoc($result);
    
  $Newconf_HIPE = unserialize($conf_HIPE['value']);
  
  $Newconf_HIPE['Version'] = '2.2.0';
  
  $update_conf = serialize($Newconf_HIPE);

  $query = '
UPDATE '.CONFIG_TABLE.'
SET value="'.addslashes($update_conf).'"
WHERE param="HistoryIPConfig"
LIMIT 1
;';

	pwg_query($query);

  // Create new HIPE entry in plugins table 
  $query = '
INSERT INTO '.PLUGINS_TABLE.' (id, state, version)
VALUES ("HistoryIPExcluder","active","2.2.0")
;';
  
  pwg_query($query);

  // Delete old plugin entry in plugins table 
  $query = '
DELETE FROM '.PLUGINS_TABLE.'
WHERE id="nbc_HistoryIPExcluder"
LIMIT 1
;';
  
  pwg_query($query);

  // rename directory
  if (!rename(PHPWG_PLUGINS_PATH.'nbc_HistoryIPExcluder', PHPWG_PLUGINS_PATH.'HistoryIPExcluder'))
  {
    die('Fatal error on plugin upgrade process : Unable to rename directory ! Please, rename manualy the plugin directory name from ../plugins/nbc_HistoryIPExcluder to ../plugins/HistoryIPExcluder.');
  }
}


function upgrade_220()
{
  global $conf;

// Update plugin version
  $query = '
SELECT value
  FROM '.CONFIG_TABLE.'
WHERE param = "HistoryIPConfig"
;';
  $result = pwg_query($query);
  
  $conf_HIPE = pwg_db_fetch_assoc($result);
    
  $Newconf_HIPE = unserialize($conf_HIPE['value']);
  
  $Newconf_HIPE['Version'] = '2.2.1';
  
  $update_conf = serialize($Newconf_HIPE);

  $query = '
UPDATE '.CONFIG_TABLE.'
SET value="'.addslashes($update_conf).'"
WHERE param="HistoryIPConfig"
LIMIT 1
;';

	pwg_query($query);
}
?>