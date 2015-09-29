<?php

define("bitmaster", true);

if(!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['cashier'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

?>

<div id="totalChart" style="min-width: 310px; height: 100%; margin: 0 auto"></div>

<script type="text/javascript" src="salestat.js.php"></script>
