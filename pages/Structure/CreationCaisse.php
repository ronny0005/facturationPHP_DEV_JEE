<?php
    $caisse_no = 0;
    $intitule = "";
    $caissier = 0;
    $jo_num = "";
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $objet = new ObjetCollector();
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("caisse");
    $flagSuppr = $protection->SupprType("caisse");
    $flagNouveau = $protection->NouveauType("caisse");
    $caisse = "";
    if(isset($_GET["CA_No"])){
        $caisse = new CaisseClass($_GET["CA_No"]);
    }
?>
<script src="js/script_creationCaisse.js?d=<?php echo time(); ?>"></script>
<?php
include("module/Menu/BarreMenu.php");
?>
<section class="bgApplication mb-3" style="margin: 0px;padding: 5px;">
    <h3 class="text-center text-uppercase" style="color: rgb(255,255,255);">
        Fiche Caisse
    </h3>
</section>

<form id="formCaisse" class="formCaisse card p-3" action="indexMVC.php?module=3&action=15" method="GET">
<fieldset class="entete">
<legend class="entete">Informations</legend>
    <div class="row">
        <div class="col-12 col-sm-4" >
            <label> Intitul&eacute; : </label>
            <input value="<?= (isset($_GET["CA_No"])) ? $_GET["CA_No"] : 0; ?>" type="hidden" name="CA_No" class="form-control" id="CA_No" <?php if(!$flagProtected) echo "disabled"; ?>/>
            <input maxlength="35" value="<?= (isset($_GET["CA_No"])) ? $caisse->CA_Intitule : ""; ?>" type="text" name="intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="col-6 col-sm-4" >
            <label> Caissier : </label>
            <select class="form-control" id="caissier" name="caissier" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0">-</option>
                <?php
                    $collaborateur = new CollaborateurClass(0);
                    foreach($collaborateur->allCaissier() as $row){
                        echo "<option value=". $row->CO_No."";
                        if(isset($_GET["CA_No"]) && $row->CO_No == $caisse->CO_NoCaissier) echo " selected";
                        echo ">{$row->CO_Nom}</option>";
                    }
                ?>
            </select>
       </div>
        <div class="col-6 col-sm-4" >
            <label> Journal : </label>
            <select class="form-control" id="journal" name="journal" <?php if(!$flagProtected) echo "disabled"; ?>>
                    <?php
                        $journalClass = new JournalClass(0);
                        foreach($journalClass->getJournauxType(2) as $row){
                            echo "<option value=".$row->JO_Num."";
                            if(isset($_GET["CA_No"]) && $row->JO_Num == $caisse->JO_Num) echo " selected";
                            echo ">{$row->JO_Intitule}</option>";
                        }
                        ?>
            </select>
        </div>
    </div>
</fieldset>

<fieldset class="entete">
<legend class="entete">Dépôt</legend>
<select class="form-control" id="depot" multiple name="depot[]" <?php if(!$flagProtected) echo " disabled "; ?> >
        <?php
        $depotCaisse = new DepotCaisseClass(0);
        $caisseVal = 0;
        if(isset($_GET["CA_No"]))
            $caisseVal=$caisse->CA_No;
        foreach($depotCaisse->getDepotCaisseSelect($caisseVal) as $row){
            echo "<option value='{$row->DE_No}'";
            if($row->Valide_Caisse==1) echo " selected";
            echo ">{$row->DE_Intitule}</option>";
        }
        ?>
</select>

</fieldset>
<div class="col-12 mt-3" >
</div>
    <input type="button" id="ajouterCaisse" name="ajouterCaisse" class="btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>

</form>
