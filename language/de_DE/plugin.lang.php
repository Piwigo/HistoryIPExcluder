<?php
$lang['HIPE_description'] = 'Diese Erweiterung erlaubt es, einzelne IP Adressen oder Adressbereiche von der Erfassung im Verlauf und den Statistiken auszuschließen. <br>Wird die Erweiterung aktiviert, werden die unten angegebenen IP Adressen nicht in die *_history Tabellen übernommen.';
$lang['HIPE_admin_section1'] = 'IP-Ausschluss';
$lang['HIPE_admin_description1'] = 'Die auszuschließende IP Adresse oder den auszuschließenden Adressbereich in das Feld unten eingeben (Pro Zeile ein Eintrag) . Benutzen Sie das Stellvertretersymbol »%«, um Adressbereiche einzugeben.<br>Beispiel: 74.6.1.2 oder 74.6.%';
$lang['HIPE_save_config']='Einstellungen gespeichert.';
$lang['HIPE_CleanHist'] = 'Verlauf löschen';

$lang['HIPE_admin_section2'] = 'Abfragen in der Verlaufs-Tabelle';
$lang['HIPE_admin_section3'] = 'Ergebnis der Abfrage';
$lang['HIPE_IPByMember'] = 'IP Adressen nach Mitgliedern';
$lang['HIPE_IPByMember_description'] = 'IP-Adressen anzeigen, die von Mitgliedern benutzt werden (nach IP Adresse sortiert)';
$lang['HIPE_OnlyGuest'] = 'Nur Gast-IP-Adressen';
$lang['HIPE_OnlyGuest_description'] = 'IP-Adressen von Gastbenutzern anzeigen und die Anzahl der Einträge in der Verlaufs-Tabelle anzeigen (sortiert nach der Anzahl der Einträge)';

$lang['HIPE_IPForMember'] = 'IP Adressen eines Mitglieds';
$lang['HIPE_IPForMember_description'] = 'IP-Adressen anzeigen, die von einem registrierten Mitglied verwendet werden (nach IP Adressen sortiert)';
$lang['HIPE_MemberForIp'] = 'Einer IP Adresse zugeordnete Mitglieder';
$lang['HIPE_MemberForIp_description'] = 'IP-Adressen anzeigen, die einer IP Adresse zugeordnet sind (sortiert nach Name)';

$lang['HIPE_resquet_ok'] = 'Abfrage erfolgreich ausgeführt.';
$lang['HIPE_hist_cleaned'] = 'Die Einträge wurden aus der Verlaufs-Tabelle entfernt.';

$lang['IP_geolocalisation'] = 'Geolokalisierung';

// --------- Starting below: New or revised $lang ---- from version 2.1.0
$lang['HIPE_version'] = ' - Version: ';
// --------- End: New or revised $lang ---- from version 2.1.0

// --------- Starting below: New or revised $lang ---- from version 2.1.1
$lang['HIPE_IPBlacklist_title'] = 'Registrierungs-Sperrliste';
$lang['HIPE_IPBlacklisted'] = 'Registrierung von gesperrten IP-Adressen verhindern (Blacklist)';
$lang['Error_HIPE_BlacklistedIP'] = 'Fehler! Ihre IP Adresse wurde gesperrt, Sie können sich nicht registrieren. Kontaktieren Sie den Administrator, um weitere Informationen zu erhalten.';
// --------- End: New or revised $lang ---- from version 2.1.1
$lang['submit'] = 'Übermitteln';