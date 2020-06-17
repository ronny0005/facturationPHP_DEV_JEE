<?php
$etat = new EtatClass();
?>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    window.onload = function () {

        var dataPoints = [];

        var chart = new CanvasJS.Chart("chartContainer",
            {
                title:{
                    text:	"CA PAR AGENCE"
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: "true",
                        legendText: "{label}",
                        indexLabelFontSize: 16,
                        indexLabel: "{label} - #percent%",
                        yValueFormatString: "# ##0",
                        dataPoints: <?= json_encode($etat->menuCaParDepotXml(20), JSON_NUMERIC_CHECK) ?>//dataPoints
                    }
                ]
            });
        chart.render()

        chart = new CanvasJS.Chart("chartContainerLine", {
            animationEnabled: true,
            title:{
                text: "Company Revenue by Year"
            },
            axisY: {
                title: "Revenue in USD",
                valueFormatString: "#0,,.",
                suffix: "mn",
                prefix: "FCFA"
            },
            data: [{
                type: "splineArea",
                color: "rgba(54,158,173,.7)",
                markerSize: 5,
                xValueFormatString: "YYYY",
                yValueFormatString: "# ##0.##",
                dataPoints: <?= json_encode($etat->menuCaParDepotXml(20), JSON_NUMERIC_CHECK) ?>
                    [
                    { x: new Date(2000, 0), y: 3289000 },
                    { x: new Date(2001, 0), y: 3830000 },
                    { x: new Date(2002, 0), y: 2009000 },
                    { x: new Date(2003, 0), y: 2840000 },
                    { x: new Date(2004, 0), y: 2396000 },
                    { x: new Date(2005, 0), y: 1613000 },
                    { x: new Date(2006, 0), y: 2821000 },
                    { x: new Date(2007, 0), y: 2000000 },
                    { x: new Date(2008, 0), y: 1397000 },
                    { x: new Date(2009, 0), y: 2506000 },
                    { x: new Date(2010, 0), y: 2798000 },
                    { x: new Date(2011, 0), y: 3386000 },
                    { x: new Date(2012, 0), y: 6704000},
                    { x: new Date(2013, 0), y: 6026000 },
                    { x: new Date(2014, 0), y: 2394000 },
                    { x: new Date(2015, 0), y: 1872000 },
                    { x: new Date(2016, 0), y: 2140000 }
                ]
            }]
        });
        chart.render();

    }
</script>
<div style="clear:both">
    <h1 class="text-uppercase text-dark mb-0" style="color: rgb(2,78,5);font-weight: bold;">Bienvenue</h1>
</div>
<?php

require 'vendor/autoload.php';
use ChartJs\ChartJS;

$dataCa = array();
$dataLabels = array();
$dataPoints = array();
$etat = new EtatClass();
$list =  $etat->menuCaParDepot($_SESSION['id']);
foreach($list as $elt) {
    array_push($dataLabels, $elt->DE_Intitule);
    array_push($dataCa, $elt->TotCATTCNet);

}

$data = [
    'labels' => $dataLabels,
    'datasets' => [[
        'data' =>$dataCa,
        'backgroundColor' => ['blue', 'purple', 'red', 'black', 'brown', 'pink', 'green'],
        'borderColor' => '#e5801d',
        'label' => 'Legend'
    ]]
];




$options = ['responsive' => true];
$attributes = ['id' => 'example', 'width' => 500, 'height' => 500];
$Line = new ChartJS('doughnut', $data, $options, $attributes);


$Line1 = new ChartJS('bar', $data, $options, $attributes);

?>

<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">


            <div class="card">
                <div class=""><?= $Line ?></div>
            </div>
            <div class="card">
                <div class=""><?= $Line1 ?></div>
            </div>
            <script src="vendor/Ejdamm/Chart.js-PHP/js/Chart.min.js"></script>
            <script src="vendor/Ejdamm/Chart.js-PHP/js/driver.js"></script>
            <script>
                (function() {
                    loadChartJsPhp();
                })();
            </script>
        </div>
    </div>
</section>
<p>
    <br>Cette application est un outil de gestion de contenu.
    <br> Elle vous permettra de gérer des factures de ventes et d'achats, ainsi que les règlements associés
    <br>
</p>
