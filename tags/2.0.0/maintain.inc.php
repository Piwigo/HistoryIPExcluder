<?php

function plugin_install()
{
  global $conf;
  
  $default= array();

  $q = '
INSERT INTO '.CONFIG_TABLE.' (param,value,comment)
VALUES ("nbc_HistoryIPExcluder","","Parametres nbc History IP Excluder");
';
      
  pwg_query($q);
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

?>