<?php
$protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
$flagProtected = $protection->protectedType("famille");
$flagSuppr = $protection->SupprType("famille");
$flagNouveau = $protection->NouveauType("famille");
$objet = new ObjetCollector();

?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche famille
    </h3>
</section>

<?php
    $ref = "";
    $design = "";
    $cl_no1 = 0;
    $cl_no2 = 0;
    $cl_no3 = 0;
    $cl_no4 = 0;
    $famille = new FamilleClass(0);
    if(isset($_GET["FA_CodeFamille"])){
        $objet = new ObjetCollector();
        $famille = new FamilleClass($_GET["FA_CodeFamille"]);
            $ref = $famille->FA_CodeFamille;
            $design = $famille->FA_Intitule;
            $cl_no1 = $famille->CL_No1;
            $cl_no2 = $famille->CL_No2;
            $cl_no3 = $famille->CL_No3;
            $cl_no4 = $famille->CL_No4;
    }
?>
    <div class="err" id="add_err"></div>    
        <script src="js/script_creationFamille.js?d=<?php echo time(); ?>"></script>
    <form action="indexMVC.php?module=3&action=1" method="GET">
        <div class="row">
            <div class="col-lg-6" >
                <input type="hidden" value="3" name="module"/>
                <input type="hidden" value="1" name="action"/>
                <label for="inputfirstname" class="control-label"> Code : </label>
                <input maxlength="11" onkeyup="this.value=this.value.replace(' ','')" type="text" value="<?php echo $ref; ?>" name="reference" class="form-control only_alpha_num" id="reference" placeholder="Référence" <?php if(isset($_GET["FA_CodeFamille"])) echo "disabled"; ?>/>
                <input type="hidden" value="<?= (isset($_GET["FA_CodeFamille"])) ? $famille->cbMarq : 0 ; ?>" name="cbMarqFamille" class="form-control" id="cbMarqFamille"  />
            </div>
            <div class="col-lg-6" >
                <label for="inputfirstname" class="control-label"> Intitulé     : </label>
                <input maxlength="35" type="text" value="<?php echo $design; ?>"  name="designation" class="form-control" id="designation" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?> />
            </div>
        
            <div class="row mt-3">

            <div class="col-lg-2">
                <fieldset style="float:left" class="entete">
                    <legend class="entete">Catalogue</legend>

                    Niveau 1 : <select id="catalniv1" class="form-control" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <option value="0"></option>
                    <?php
                        $catalogue = new F_CatalogueClass(0);
                        $rows = $catalogue->getCatalogue(0);
                        foreach ($rows as $row) {
                            echo "<option value='{$row->CL_No}'";
                            if ($row->CL_No == $cl_no1) echo " selected";
                            echo ">{$row->CL_Intitule}</option>";
                        }
                      ?>
                </select>
                Niveau 2 :
                <select id="catalniv2" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                <option value="0"></option>
                <?php
                        $rows = $catalogue->getCatalogueByCL(1,$cl_no1);
                        foreach ($rows as $row){
                        echo "<option value='{$row->CL_No}'";
                                if($row->CL_No==$cl_no2) echo " selected";
                                echo">{$row->CL_Intitule}</option>";
                        }
                  ?>
                </select>
                Niveau 3 :
                <select id="catalniv3" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                    <option value="0"></option>
                    <?php
                        $rows = $catalogue->getCatalogueByCL(2,$cl_no2);
                        foreach ($rows as $row){
                            echo "<option value='{$row->CL_No}'";
                            if($row->CL_No==$cl_no3) echo " selected";
                            echo">{$row->CL_Intitule}</option>";
                        }
                    ?>
                </select>
                Niveau 4 :
                <select id="catalniv4" class="form-control" <?php if($cl_no1!=0) if(!$flagProtected) echo "disabled"; else echo""; else echo "disabled";?>>
                    <option value="0"></option>
                    <?php
                        $rows = $catalogue->getCatalogueByCL(3, $cl_no3);
                        foreach ($rows as $row) {
                            echo "<option value='{$row->CL_No}'";
                            if ($row->CL_No == $cl_no4) echo " selected";
                            echo ">{$row->CL_Intitule}</option>";
                        }
                    ?>
                </select>

                </fieldset>
            </div>
        <?php
        $taxe1 =" - ";$taxe2 =" - ";$taxe3 =" - ";$cgnum=" - ";$cgnuma=" - ";
        $libtaxe1 ="";$libtaxe2 ="";$libtaxe3 ="";$libcgnum="";$libcgnuma="";
        $taux1 =0;$taux2 =0;$taux3 =0;
        $famille = new FamilleClass(0);
        $rows = $famille->getCatComptaByCodeFamille($ref,1,0);
        if($rows!=null){
            if($rows[0]->Taxe1!="")
                $taxe1 =$rows[0]->Taxe1;

            if($rows[0]->Taxe2!="")
                $taxe2 =$rows[0]->Taxe2;

            if($rows[0]->Taxe3!="")
                $taxe3 =$rows[0]->Taxe3;

            if($rows[0]->CG_Num!="")
                $cgnum=$rows[0]->CG_Num;
            if($rows[0]->CG_NumA!="")
                $cgnuma=$rows[0]->CG_NumA;
            $libtaxe1 =$rows[0]->TA_Intitule1;$libtaxe2 =$rows[0]->TA_Intitule2;$libtaxe3 =$rows[0]->TA_Intitule3;
            $libcgnum=$rows[0]->CG_Intitule;$libcgnuma=$rows[0]->CG_IntituleA;
            $taux1 =$rows[0]->TA_Taux1;$taux2 =$rows[0]->TA_Taux2;$taux3 =$rows[0]->TA_Taux3;
        }
        ?>
        <div class="col-lg-6">
        <table id="table_compteg" class="table" style="width:500px;float:left;margin-left:100px">
            <thead>
            <tr style="background-color: #dbdbed;"><th>
                    <select name="p_catcompta" id="p_catcompta" class="form-control" <?php if(!$flagProtected) echo "disabled"; ?>>
                        <?php
                        $pcatcompta = new P_CatComptaClass(0);
                        $rows = $pcatcompta->getCatComptaVente();
                        foreach ($rows as $row) {
                            echo "<option value='{$row->idcompta}V'>{$row->marks}</option>";
                        }
                        $rows = $pcatcompta->getCatComptaAchat();
                        foreach ($rows as $row) {
                            echo "<option value='{$row->idcompta}A'>{$row->marks}</option>";
                        }
                        ?>
                    </select>
                </th><th>Compte/Code</th><th>Intitulé</th><th>Taux</th></tr>
            </thead>
            <tbody>
            <tr><td id='libCompte'>Compte général</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $cgnum; ?></td><td id="intituleCompte"><?php echo $libcgnum; ?></td><td id="valCompte"></td></tr>
            <tr><td id='libCompte'>Section analytique</td><td id="codeCompte" style='text-decoration: underline;color:blue'></td><td id="intituleCompte"></td><td id="valCompte"></td></tr>
            <tr><td id='libCompte'>Code taxe 1</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe1; ?></td><td id="intituleCompte"><?php echo $libtaxe1; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux1); ?></td></tr>
            <tr><td id='libCompte'>Code taxe 2</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe2; ?></td><td id="intituleCompte"><?php echo $libtaxe2; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux2); ?></td></tr>
            <tr><td id='libCompte'>Code taxe 3</td><td id="codeCompte" style='text-decoration: underline;color:blue'><?php echo $taxe3; ?></td><td id="intituleCompte"><?php echo $libtaxe3; ?></td><td id="valCompte"><?php echo $objet->formatChiffre($taux3); ?></td></tr>
            </tbody>
        </table>
        <div id="formSelectCompte" style="width:500px;float:left;margin-left:100px">
                <div class="">
                    <label id="labelCode">Code</label>
                    <select class="form-control" id="CodeSelect<?php if(!$flagProtected) echo "disabled"; ?>" name="CodeSelect" <?php if(!$flagProtected) echo "disabled"; ?>>
                    </select>
                </div>
            </div>
        </div>
    </div>
        <input style="float: left;clear: both;" type="button" id="ajouter" name="<?php if(isset($_GET["AR_Ref"])) echo "modifier"; else echo "ajouter"; ?>" class="btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
    </form>

        