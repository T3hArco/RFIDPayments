<?php

define("bitmaster", true);



if(!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['cashier'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

$salesByHour = $db2->getDbObject()->query("SELECT HOUR(purchasedate), SUM(amount) FROM sales GROUP BY HOUR(purchasedate)");
$totalSales = $db2->getDbObject()->query("SELECT SUM(amount) FROM sales;")->fetchAll()[0][0];

?>

<div id="totalChart" style="min-width: 310px; height: 100%; margin: 0 auto"></div>

<script type="text/javascript" src="salestat.js.php"></script>
