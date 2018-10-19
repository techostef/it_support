<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(2, "mi_karyawan", $Language->MenuPhrase("2", "MenuText"), "karyawanlist.php", -1, "", AllowListMenu('{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}karyawan'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(5, "mi_monitor_php", $Language->MenuPhrase("5", "MenuText"), "monitor.php", -1, "", AllowListMenu('{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}monitor.php'), FALSE, TRUE, "");
$RootMenu->AddMenuItem(1, "mi_ticket_support", $Language->MenuPhrase("1", "MenuText"), "ticket_supportlist.php", -1, "", AllowListMenu('{2D23B2F1-9107-4245-BBC7-F6E2C1DB634A}ticket_support'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_userlevels", $Language->MenuPhrase("4", "MenuText"), "userlevelslist.php", -1, "", IsAdmin(), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
