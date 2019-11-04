
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/script_etat.js"></script>
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
<form action="indexMVC.php?module=5&action=10" method="GET">
    <table style="margin-bottom: 20px">
    <thead>
        <tr>
            <td style="width:100px;vertical-align: middle">D&eacute;but :</td>
            <input type="hidden" value="5" name="module"/>
            <input type="hidden" value="10" name="action"/>
            <td><input type="text" class="form-control" name="datedebut" style="width : 100px" value="<?php echo $datedeb; ?>" id="datedebut" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:95px;vertical-align: middle">Fin :</td>
            <td><input type="text" class="form-control" name="datefin"  style="width : 100px" value="<?php echo $datefin; ?>" id="datefin" placeholder="Date" /></td>
            <td style="padding-left: 10px;width:60px;vertical-align: middle"> Centre :</td>
            <td style="padding-left: 10px;width:200px;">
                <select class="form-control" name="depot" id="depot">
                    <?php
                    $depotClass = new DepotClass(0);
                    if($admin==0){
                        $rows = $depotClass->getDepotUser($_SESSION["id"]);
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
            </td>
            <td style="padding-left:30px"><input type="submit" id="valider" class="btn btn-primary" value="Valider"/></td>
            <td style="padding-left:30px"><input type="submit"  class="btn btn-primary" value="Imprimer" <?php  echo "onClick=\"window.open('./export/exportEtatDette.php?datedebut=".$datedeb."&datefin=".$datefin."&amp;depot=".$depot_no."')\""; ?>/></td>
        </tr>
</table>
</form>
<?php 
    $result=$objet->db->requete($objet->depot());     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        foreach($rows as $row){
            $val_depot=$row->DE_No;
            if($depot_no==0 || $depot_no==$row->DE_No){
            
            echo "<h4 style='text-align: center'>".$row->DE_Intitule."</h4>";
       
?><table id="table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="text-transform: uppercase">
            <th>Numéro client</th>
            <th>Nom client</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $etatList = new EtatClass();
    $result=$objet->db->requete($etatList->etatDette($val_depot,$objet->getDate($datedeb), $objet->getDate($datefin),'',''));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $qte=0; 
        $cumul=0;
        $dlprix=0;
        $cumulPrix=0;
        $somMnt=0;
        $classe="";
        $ref="";
        if($rows==null){
            echo "<tr><td colspan='3'>Aucun élément trouvé ! </td></tr>";
        }else{
            foreach ($rows as $row){
                $somMnt=$somMnt+ROUND($row->MONTANT,2);
                $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
                echo "<tr class='eqstock $classe'>"
                ."<td><a href='indexMVC.php?action=17&module=5&DE_No=$val_depot&CT_Num=".$row->CT_NUM."&datedebut=$datedeb&datefin=$datefin'>".$row->CT_NUM."</a></td>"
                ."<td>".$row->CT_Intitule."</td>"
                ."<td>".$objet->formatChiffre(ROUND($row->MONTANT,2))."</td>"
                . "</tr>";
            }
        echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'><td colspan='2' >Total</td><td>".$objet->formatChiffre($somMnt)."</td></tr>";
        }
        
    ?>
        </tbody>
    </table>
        <?php 
        }
        
        }
    }
        ?>
