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


<section>
    <div class="container">
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-6">
                <div id="chartContainerLine" style="height: 300px; width: 100%;"></div>
            </div>
            <div class="col-md-6">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            </div>
        </div>
    </div>
</section>
<div class="col offset-xl-1">
    <div style="width: 773px;"><canvas data-bs-chart="{&quot;type&quot;:&quot;horizontalBar&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;January&quot;,&quot;February&quot;,&quot;March&quot;,&quot;April&quot;,&quot;May&quot;,&quot;June&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;Revenue&quot;,&quot;backgroundColor&quot;:&quot;#4e73df&quot;,&quot;borderColor&quot;:&quot;#4e73df&quot;,&quot;data&quot;:[&quot;4500&quot;,&quot;5300&quot;,&quot;6250&quot;,&quot;7800&quot;,&quot;9800&quot;,&quot;15000&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:true,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{&quot;display&quot;:true,&quot;fontColor&quot;:&quot;#225c32&quot;,&quot;text&quot;:&quot;TOP 5 VENTE&quot;,&quot;fontSize&quot;:&quot;28&quot;}}}"></canvas></div>
</div>
<?php
$html = file_get_contents('http://localhost:1822/Reports/powerbi/RapportCMI/pbiCmi?rs:embed=true');
echo $html;
?>
<p>
    <br>Cette application est un outil de gestion de contenu.
    <br> Elle vous permettra de gérer des factures de ventes et d'achats, ainsi que les règlements associés
    <br>
</p>
