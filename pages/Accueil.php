<?php
$etat = new EtatClass();
?>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    jQuery(function ($) {
        $(".se-pre-con").fadeOut("slow")

        $(document).ready(function () {
            $(".se-pre-con").fadeOut("slow")
        });
    })
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

$data = array(
    'labels' => $dataLabels,
    'datasets' => array(array(
        'data' =>$dataCa,
        'backgroundColor' => array('blue', 'purple', 'red', 'black', 'brown', 'pink', 'green'),
        'borderColor' => '#e5801d',
        'label' => 'Legend'
    ))
);




$options = array('responsive' => true);
$attributes = array('id' => 'example', 'width' => 500, 'height' => 500);
$Line = new ChartJS('doughnut', $data, $options, $attributes);
$Line1 = new ChartJS('bar', $data, $options, $attributes);

?>

<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">

            <?php
            $protectioncial = new ProtectionClass("","");
            $protectioncial->connexionProctectionByProtNo($_SESSION["id"]);
                if($protectioncial->PROT_Right==1){
            ?>
            <div class="card">
                <div class=""><?= $Line ?></div>
            </div>
            <div class="card">
                <div class=""><?= $Line1 ?></div>
            </div>
            <?php
                }
            ?>
            <script src="/vendor/ejdamm/chart.js-php/js/Chart.min.js"></script>
            <script src="/vendor/ejdamm/chart.js-php/js/driver.js"></script>
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
