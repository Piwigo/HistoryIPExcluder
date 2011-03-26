<?php

function plugin_install()
{
  global $conf;
  
  $default= array();

  $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("HistoryIPExcluder","","History IP Excluder parameters");
';
      
  pwg_query($q);
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
  /* upgrade from branch 2.0.0 to 2.0.1 */
  /* ************************************ */
		upgrade_200();
	}
}


function plugin_uninstall()
{
  global $conf;

  if (isset($conf['nbc_HistoryIPExcluder']))
  {
    $q = '
DELETE FROM '.CONFIG_TABLE.'
WHERE param="nbc_HistoryIPExcluder" LIMIT 1;
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
}
?>