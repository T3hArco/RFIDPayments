<?php

define("bitmaster", true);

if(!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['admin'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

if(!isset($_GET['act']))
	$_GET['act'] = "";

if($_GET['act'] == "register" && isset($_POST['register'])) {
	echo "Handling off registration here. Yay";
}

switch($_GET['act']) {
	case 'createuser':
		include("abits/createuser.php");
		break;

	case 'deluser':
		include("abits/deluser.php");
		break;

	case 'moduser':
		include("abits/moduser.php");
		break;

	case 'logfile':
		include("abits/log.php");
		break;

	default:
		echo "Ongeldige actie.";
		break;
}