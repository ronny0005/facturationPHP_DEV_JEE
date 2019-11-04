<?php

    $intitule = "";
    $adresse = "";
    $compteg = "";
    $codePostal = "";
    $depot = 0;
    $co_no = 0;
    $region= "";
    $ville="";
    $nsiret="";
    $identifiant="";
    $tel="";
    $mode_reglement="";
$catcompta="";
$affaire="";
    $cattarif="";
    $MR_No=0;
    $protected = 0;
    $flagNouveau = 0;
    $flagProtected = 0;
    $flagSuppr = 0;
    $objet = new ObjetCollector();

$comptet = new ComptetClass(0);


$type = "client";
if($_GET["action"]==9) $type="fournisseur";
if($_GET["action"]==17) $type="salarie";
$ncompte = $comptet->getCodeAuto($type);
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($type=="client"){
            $flagProtected = $protection->protectedType($type);
            $flagSuppr = $protection->SupprType($type);
            $flagNouveau = $protection->NouveauType($type);
        }
        if($type=="fournisseur" || $type=="salarie"){
            $flagProtected = $protection->protectedType($type);
            $flagSuppr = $protection->SupprType($type);
            $flagNouveau = $protection->NouveauType($type);
        }

    if(isset($_GET["CT_Num"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->clientsByCT_Num($_GET["CT_Num"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
//            $mode_reglement  
            $ncompte = $rows[0]->CT_Num;
            $intitule = $rows[0]->CT_Intitule;
            $adresse = $rows[0]->CT_Adresse;
            $compteg = $rows[0]->CG_NumPrinc;
            $codePostal = $rows[0]->CT_CodePostal;
            $depot = $rows[0]->DE_No;
            $co_no = $rows[0]->CO_No;
            $region= $rows[0]->CT_CodeRegion;
            $ville= $rows[0]->CT_Ville;
            $nsiret= $rows[0]->CT_Siret;
            $identifiant= $rows[0]->CT_Identifiant;
            $tel= $rows[0]->CT_Telephone;
            $catcompta= $rows[0]->N_CatCompta;
            $cattarif= $rows[0]->N_CatTarif;
            $MR_No = $rows[0]->MR_No;
            $affaire = $rows[0]->CA_Num;
        }
        
    }
    if(isset($_GET["ajouter"]) ||isset($_GET["modifier"]) ){
        $ncompte = $_GET["CT_Num"];
        $intitule = $_GET["CT_Intitule"];
        $adresse = $_GET["CT_Adresse"];
        $compteg = $_GET["CG_NumPrinc"];
        $codePostal = $_GET["CT_CodePostal"];
        $region= $_GET["CT_CodeRegion"];
        $ville= $_GET["CT_Ville"];
        $nsiret= $_GET["CT_Siret"];
        $identifiant= $_GET["CT_Identifiant"];
        $tel= $_GET["CT_Telephone"];
        $catcompta= $_GET["N_CatCompta"];
        $cattarif= $_GET["N_CatTarif"];
        $depot= $_GET["depot"];
        $affaire = $_GET["CA_Num"];
    }
?>
<script src="js/script_creationClient.js"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    </head>
    <form id="form-creationClient" action="indexMVC.php?module=3&action=2" method="GET">
        <div><h1><?php if($type=="client") echo "Fiche client"; if($type=="fournisseur") echo "Fiche fournisseur"; if($type=="salarie") echo "Fiche salarié"; ?></h1></div>
        <div class="form-group col-lg-6" >
            <input type="hidden" id="type" name="type" type="hidden" value="<?php if($type=="fournisseur") echo "1"; if($type=="client") echo "0";if($type=="salarie") echo "2"; ?>"/>
            <input type="hidden" id="DE_No" name="DE_No" type="hidden" value="1"/>
            <label for="inputfirstname" class="control-label"> Num&eacute;ro compte : </label>
            <input maxlength="17" value="<?php echo $ncompte; ?>" style=";text-transform:uppercase" type="text" onkeyup="this.value=this.value.replace(' ','')" name="CT_Num" id="CT_Num" class="form-control only_alpha_num" placeholder="Numéro compte" <?php if(isset($_GET["CT_Num"])) echo "disabled"; ?> />
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> Intitul&eacute; : </label>
            <input maxlength="35" value="<?php echo $intitule; ?>" style="text-transform:uppercase" type="text" name="CT_Intitule" class="form-control" id="intitule" placeholder="Intitulé" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> Adresse : </label>
            <input value="<?php echo $adresse; ?>" style="" name="CT_Adresse" type="text" class="form-control" id="adresse" placeholder="Adresse" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> Compteg : </label>
            <select style="" name="CG_NumPrinc" class="form-control" id="CG_NumPrinc<?php if(!$flagProtected) echo "protected"?>" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $ctype=0;
                $cdefaut="Cl.";
                if($type=="fournisseur"){
                    $ctype=1;
                    $cdefaut="Fr.";
                }
                if($type=="salarie"){
                    $ctype=2;
                    $cdefaut="Sal.";
                }
                $result=$objet->db->requete($objet->selectDefautCompte($cdefaut));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $cdefaut=$rows[0]->T_Val01T_Compte;
                $result=$objet->db->requete($objet->getCompteg());

                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $cg_val =$cdefaut;
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->CG_Num."";
                        if((!isset($_GET["CT_Num"]) && $row->CG_Num == $cg_val)|| $compteg==$row->CG_Num) echo " selected";
                        echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> T&eacute;l&eacute;phone : </label>
            <input value="<?php echo $tel; ?>" style="" name="CT_Telephone" type="text" class="form-control only_phone_number" id="tel" placeholder="Téléphone" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> R&eacute;gion : </label>
            <input value="<?php echo $region; ?>" style="" type="text" class="form-control" name="CT_CodeRegion" id="CT_CodeRegion" placeholder="Région" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Ville : </label>
            <input value="<?php echo $ville; ?>" style=""  type="text" class="form-control" name="CT_Ville" id="CT_Ville" placeholder="ville" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> N Siret/NContrib : </label>
            <input value="<?php echo $nsiret; ?>" style="" name="CT_Siret" type="text" class="form-control" id="CT_Siret" placeholder="N° Siret" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-6" >
            <label for="inputfirstname" class="control-label"> Identifiant/RC Num :  </label>
            <input value="<?php echo $identifiant; ?>" style="" name="CT_Identifiant" type="text" class="form-control" id="CT_Identifiant" placeholder="Identifiant" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Cat Tarif : </label>
            <select style="" name="N_CatTarif"  class="form-control" name="N_CatTarif" id="cattarif" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $result=$objet->db->requete($objet->getTarif());     
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->cbIndice."";
                        if($row->cbIndice==$cattarif) echo " selected";
                        echo ">".$row->CT_Intitule."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Cat compta : </label>
            <select style="" name="N_CatCompta" class="form-control" name="N_CatCompta" id="catcompta" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php 
                if($type=="client")
                $result=$objet->db->requete($objet->getCatCompta());  
                else $result=$objet->db->requete($objet->getCatComptaAchat());  
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->idcompta."";
                        if($row->idcompta==$catcompta) echo " selected";
                        echo ">".$row->marks."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Mode de règlement : </label>
        <select style="" name="mode_reglement" class="form-control" name="mode_reglement" id="mode_reglement" <?php if(!$flagProtected) echo "disabled"; ?>>
            <option value="0"></option>
            <?php
                $objet = new ObjetCollector();   
                $result = $objet->db->requete($objet->getModeleReglement());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                $i=0;
                $classe="";
                if($rows==null){
                }else{
                    foreach ($rows as $row){
                        echo "<option value=".$row->MR_No."";
                        if($row->MR_No==$MR_No) echo " selected";
                        echo ">".$row->MR_Intitule."</option>";
                    }
                }
        ?>
        </select>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Affaire : </label>
            <select style="" name="CA_Num" class="form-control" name="CA_Num" id="CA_Num" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value=""></option>
                <?php
                $result=$objet->db->requete($objet->getAffaire());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        if($row->CA_Num!=""){
                            echo "<option value='".$row->CA_Num."'";
                            if($row->CA_Num!="" && $row->CA_Num==$affaire) echo " selected ";
                            echo ">".$row->CA_Intitule."</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Dépôt : </label>
            <select style="" name="depot" class="form-control" name="depot" id="depot" <?php if(!$flagProtected) echo "disabled"; ?>>
                <?php
                $result=$objet->db->requete($objet->depot());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->DE_No."";
                        if($row->DE_No==$depot) echo " selected";
                        echo ">".$row->DE_Intitule."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-3" >
            <label for="inputfirstname" class="control-label"> Collaborateur : </label>
            <select style="" class="form-control" name="CO_No" id="CO_No" <?php if(!$flagProtected) echo "disabled"; ?>>
                <option value="0" <?php if($co_no==0) echo " selected"; ?>></option>
                <?php
                $collab = new CollaborateurClass(0);
                $rows = $collab->all();
                if(sizeof($rows)==0){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->CO_No."";
                        if($row->CO_No==$co_no) echo " selected";
                        echo ">".$row->CO_Nom."</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div style="clear:both">
            <input type="button" id="ajouterClient" name="ajouterClient" class="btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </div>
    </form>