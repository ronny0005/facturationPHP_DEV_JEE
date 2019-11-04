<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_etat.js?d=<?php echo time(); ?>"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
include("enteteParam.php");
?>
<div id="milieu">
    <div class="container">

<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<form action="indexMVC.php?module=5&action=4" method="GET">
    <div class="form-group col-lg-2" >
            <label>Début</label>
            <input type="hidden" value="<?php echo $_SESSION["DE_No"];?>" id="de_no" />
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="4" name="action"/>
            <input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" />
    </div>
    <div class="form-group col-lg-2" >
        <label>Fin</label>
        <input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" />
    </div>
    <div class="form-group col-lg-3" >
        <label>Centre</label>
        <select class="form-control" name="depot" id="depot">
            <?php
            $depotClass = new DepotClass(0);
            if($admin==0){
                $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
                if(sizeof($rows)>1){
                    echo"<option value='0'";
                    if(0==$depot_no) echo " selected";
                    echo ">Tous</option>";
                }
            }
            else {
                echo"<option value='0'";
                if(0==$depot_no) echo " selected";
                echo ">Tous</option>";
                $depotClass = new DepotClass(0);
                $rows = $depotClass->all();
            }
            if($rows==null){
            }else{
                foreach($rows as $row){
                    echo "<option value=".$row->DE_No."";
                    if($row->DE_No==$depot_no) echo " selected";
                    echo ">".$row->DE_Intitule."</option>";
                }
            }
            ?>
    </select>
    </div>
    <div class="form-group col-lg-3" >
        <label>Famille</label>
        <select class="form-control" id="famille" name="famille"><option value="0">Tous</option>
        <?php
        $familleClass = new FamilleClass(0);
        $rows = $familleClass->all();
        if($rows==null){
        }else{
            foreach($rows as $row){
                echo "<option value=".$row->FA_CodeFamille."";
                if(isset($_GET["famille"]) && $row->FA_CodeFamille==$famille) echo " selected";
                echo ">".$row->FA_Intitule."</option>";
            }
        }
        ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Article</label>
        <select  class="form-control" id="articledebut" name="articledebut"><option value="0">Tous</option>
            <?php
            $articleClass = new ArticleClass(0);
            $rows = $articleClass->getShortList();
            foreach($rows as $row){
                echo "<option value=".$row->AR_Ref."";
                if(isset($_GET["articledebut"]) && $row->AR_Ref==$articledebut) echo " selected";
                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
            }
            ?>
        </select>
        <label>à</label>
        <select  class="form-control" id="articlefin" name="articlefin"><option value="0">Tous</option>
            <?php
            $articleClass = new ArticleClass(0);
            $rows = $articleClass->getShortList();
            foreach($rows as $row){
                echo "<option value=".$row->AR_Ref."";
                if(isset($_GET["articlefin"]) && $row->AR_Ref==$articlefin) echo " selected";
                echo ">".$row->AR_Ref." - ".$row->AR_Design."</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Type</label>
        <select name="do_type" id="do_type" class="form-control">
            <option value="2" <?php if($do_type==2) echo "selected"; ?>>TI</option>
            <option value="7" <?php if($do_type==7) echo "selected"; ?>>TI + FC </option>
            <option value="6" <?php if($do_type==6) echo "selected"; ?>>TI + FC + FA</option>
            <option value="3" <?php if($do_type==3) echo "selected"; ?>>TI + FC + FA + BL</option>
        </select>
    </div>
    <div class="form-group col-lg-2" >
        <label>Rupture par agence</label>
        <input style="margin:auto" name="rupture" class="checkbox" id="rupture" type="checkbox" value="1" <?php if($rupture==1) echo "checked";?> />
    </div>
    <div class="form-group col-lg-3">
        <input type="submit" id="valider" class="btn btn-primary" value="Valider"/>
        <input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportStatArticleParAgence.php?type=mvtStock&datedeb=$datedeb&datefin=$datefin&depot=$depot_no&rupture=$rupture&articledebut=".$articledebut."&articlefin=".$articlefin."&famille=".$famille."&do_type=".$do_type."')\""; ?> />
    </div>
</form>

<?php

    $totalCANetHTG=0;
    $totalPrecompteG=0;
    $totalCANetTTCG=0;
    $totalQteVendueG=0;
    $totalMargeG=0;

//    $result=$objet->db->requete($objet->depot());
//    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($admin==0){
        $rows = $depotClass->getDepotUserPrincipal($_SESSION["id"]);
    }
    else {
        $depotClass = new DepotClass(0);
        $rows = $depotClass->all();
    }
    foreach($rows as $row){
        if(($rupture==0 && $cmp==0)|| $rupture==1){
            if($depot_no==0 || $depot_no==$row->DE_No){
                $val=0;
                if($rupture==1 || $depot_no==$row->DE_No){
                 echo "<div style='clear:both'><h3 style='text-align:center'>".$row->DE_Intitule."</h3></div>";
                 $val=$row->DE_No;
                }

        $result=$objet->db->requete($objet->stat_articleParAgence($val, $objet->getDate($datedeb),$objet->getDate($datefin),$famille,$articledebut,$articlefin,$do_type,$_SESSION["id"]));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $canetht=0;
        $canetttc=0;
        $precompte=0;
        $qte=0;
        $marge=0;
        $margeca=0;
        $classe="";

?>
<table id="tabletri" class="table table-striped table-bordered" cellspacing="0">
    <thead>
        <tr>
            <th>Référence</th>
            <th>Désignation</th>
            <th>CA Net HT</th>
            <th>Precompte</th>
            <th>CA Net TTC</th>
            <?php if($flagPxRevient==0) echo "<th>% de Marge</th>"; ?>
            <th>Quantités vendues</th>
            <?php if($flagPxRevient==0) { echo "<th>Marge</th>";} ?>
        </tr>
    </thead>
    <?php
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $i++;
                if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>";
                echo "<td>".$row->AR_Ref."</td>"
                ."<td>".$row->AR_Design."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->TotCAHTNet,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->PRECOMPTE,2))."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->TotCATTCNet,2))."</td>";
                if($flagPxRevient==0) echo "<td>".ROUND($row->PourcMargeHT,2)."</td>";
                echo"<td>".$objet->formatChiffre(ROUND($row->TotQteVendues,2))."</td>";
                if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre(ROUND($row->TotPrxRevientU,2))."</td>";}
                echo "</tr>";
                $canetht=$canetht+ROUND($row->TotCAHTNet,2);
                $canetttc=$canetttc+ROUND($row->TotCATTCNet,2);
                $precompte=$precompte+ROUND($row->PRECOMPTE,2);
                $qte=$qte+ROUND($row->TotQteVendues,2);
                $marge=$marge+ROUND($row->TotPrxRevientU,2);
                $totalCANetHTG=$totalCANetHTG+ROUND($row->TotCAHTNet,2);
                $totalPrecompteG=$totalPrecompteG+ROUND($row->PRECOMPTE,2);
                $totalCANetTTCG=$totalCANetTTCG+ROUND($row->TotCATTCNet,2);
                $totalQteVendueG=$totalQteVendueG+ROUND($row->TotQteVendues,2);
                $totalMargeG=$totalMargeG+ROUND($row->TotPrxRevientU,2);
            }
            $totmargepourc=0;
            if($canetht>0)$totmargepourc=ROUND($marge/$canetht*100,2);
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>";
        echo "<td>Total</td><td></td><td>".$objet->formatChiffre($canetht)."</td><td>".$objet->formatChiffre($precompte)."</td><td>".$objet->formatChiffre($canetttc)."</td>";
        if($flagPxRevient==0) echo "<td>".$objet->formatChiffre($totmargepourc)."</td>";
        echo "<td>".$objet->formatChiffre($qte)."</td>";
        if($flagPxRevient==0) { echo "<td>".$objet->formatChiffre($marge)."</td>"; }
        echo "</tr>";
        }

    ?>
</table>
<?php
            }
        }
        $cmp++;
    }
if($rupture==1){
        $pourMarge = 0;
        if($totalCANetHTG!=0)
        $pourMarge = $totalMargeG/$totalCANetHTG;
?>
<table>
    <tr style='background-color: #46464be6;color: white;font-weight: bold;'>
        <td style="padding:10px">CA Net HT : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetHTG); ?></td>
        <td style="padding:10px">Precompte : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalPrecompteG); ?></td>
        <td style="padding:10px">CA Net TTC : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalCANetTTCG); ?></td>
        <td style="padding:10px">Quantités vendues : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalQteVendueG); ?></td>
        <?php if( $flagPxRevient==0){ ?>
        <td style="padding:10px">Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($totalMargeG); ?></td>
        <td style="padding:10px">% de Marge : </td>
        <td style="padding:10px"><?php echo $objet->formatChiffre($pourMarge); ?></td>
        <?php } ?>
    </tr>
</table>
<?php
}
?>

        <div style="width:500px;float:left;height:300px;margin-right: 20px" id="chartContainer"></div>
        <div style="width:500px;float:right;height:300px" id="chartContainer2"></div>
<script type="text/javascript">

    $(function () {

                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "theme1",
                    zoomEnabled: true,
                    animationEnabled: true,
                    title: {
                        text: "Chiffre d'affaire par agence",
                        fontWeight: "normal",
                        fontSize: 20,
                        fontFamily: 'Tahoma'
                    },
                    subtitles: [
                        {
                            text: ""
                        }
                    ]
                    ,
                    data:[

                             <?php $objet->stat_articleParAgenceByMonthGraph($depot_no, $datedeb, $datefin, $famille,$article); ?>
                    ]

                });
                chart.render();

                var chart2 = new CanvasJS.Chart("chartContainer2",
                {
                        title:{
                                text: "Répartition du CA par agence",
                                fontWeight: "normal",
                                fontSize: 20,
                                fontFamily: 'Tahoma'
                        },
                        animationEnabled: true,
                        legend:{
                                verticalAlign: "center",
                                horizontalAlign: "left"
                        },
                        theme: "theme2",
                        data: [
                        <?php $objet->stat_articleParAgenceByMonthGraph2($depot_no, $datedeb, $datefin, $famille,$article); ?>
                        ]
                });
                chart2.render();
            });
</script>


