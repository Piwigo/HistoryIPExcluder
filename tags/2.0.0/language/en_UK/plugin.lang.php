<?php
global $lang;

$lang['HIPE_admin_title'] = 'NBC History IP Excluder';
$lang['HIPE_description'] = 'This plugin allows to exclude from the history and statistics of IP or IP ranges. <br>Its activation blocks record in the table of IP *_history specified in the table below.';
$lang['HIPE_admin_section1'] = 'IP Exclusion';
$lang['HIPE_admin_description1'] = 'Enter the complete IP or IP ranges to exclude (one per line) in the box below. To specify an IP range, use the wildcard character "%".<br>Example : 74.6.1.2 or 74.6.%';
$lang['HIPE_save_config']='Configuration saved.';
$lang['HIPE_CleanHist']='Clean History';

$lang['HIPE_admin_section2'] = 'Queries on history table';
$lang['HIPE_admin_section3'] = 'Result of the historic request';
$lang['HIPE_IPByMember'] = 'IPs by member';
$lang['HIPE_IPByMember_description'] = 'Show the IPs used by members, sorted by IP';
$lang['HIPE_OnlyGuest'] = 'Only Guests IPs';
$lang['HIPE_OnlyGuest_description'] = 'Show the IPs only used by Guests and the number of times it\'s found in the history table, sorted by the number of times';
$lang['HIPE_IPnoGuest'] = '';
$lang['HIPE_IPnoGuest_description'] = '';

$lang['HIPE_IPForMember'] = 'IPs for a member';
$lang['HIPE_IPForMember_description'] = 'Search and displays the IPs associated with a registered user (sorted by IP)';
$lang['HIPE_MemberForIp'] = 'Members for one IP';
$lang['HIPE_MemberForIp_description'] = 'Search and display users attached to one IP (sorted by name)';

$lang['HIPE_resquet_ok'] = 'Request OK.';
$lang['HIPE_hist_cleaned'] = 'Cleaning of the history table done.';

$lang['IP_geolocalisation'] = 'Geolocalisation';
?>