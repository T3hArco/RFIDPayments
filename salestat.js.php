<?php

include "class/Database.class.php";

$db = new \pos\Database("localhost", "root", "root", "ehackb_pos");
$salesByHour = $db->getDbObject()->query("SELECT purchasedate, SUM(amount) FROM sales GROUP BY DAY(purchasedate), HOUR(purchasedate);");
$cumul = 0;

foreach ($salesByHour as $sale) {
    $data[] = "['Cijfer om " . $sale[0] . "', $sale[1], $sale[2]]";
    $cumul += $sale[2];
}

?>
var chart = new Highcharts.Chart({
    title: {
        text: 'Totale omzet',
        x: -20 //center
    },
    subtitle: {
        text: 'Pintjes!',
        x: -20
    },
    xAxis: {
        tickInterval: 1,
        labels: {
            enabled: false
        },
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Omzet in EUR'
        }
    },
    tooltip: {
        valueSuffix: ' EUR'
    },
    legend: {
        enabled: true
    },
    chart: {
        renderTo: 'totalChart',
        type: 'column'
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Omzet',
        data: [<?php echo join($data, ',') ?>]
    }, {
        type: 'line',
        name: 'Lijn',
        data: [<?php echo join($data, ',') ?>],
        marker: {
            enabled: false
        },
        states: {
            hover: {
                lineWidth: 0
            }
        }
    }]
});