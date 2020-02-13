<?php
$login = "";
$machine_pc = "";
$latitude = 0;
$longitude = 0;
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
include("../Modele/Objet.php");
include("../Modele/DocEnteteClass.php");
include("../Modele/DocLigneClass.php");
include("../Modele/ComptetClass.php");
include("../Modele/ReglementClass.php");
include("../Modele/CaisseClass.php");
include("../Modele/ArticleClass.php");
include("../Modele/ProtectionClass.php");
include("../Modele/ContatDClass.php");
require '../Send/class.phpmailer.php';
$objet = new ObjetCollector();
$login = $_SESSION["login"];
$machine_pc = "";
$mobile="";
}

if(strcmp($_POST["acte"],"addReglement") == 0){
    $reglement = new ReglementClass(0);
    $mobile=0;
    if(isset($_GET["mobile"]))
        $mobile=1;
    $jo_num = $_POST["journal"];
    $rg_no_lier = $_POST["RG_NoLier"];
    $ct_num = $_POST['client'];
    $ca_no = $_POST["caisse"];
    $boncaisse = $_POST["boncaisse"];
    $libelle = $_POST['libelleRec'];
    $caissier = $_POST['caissier'];
    $date = $objet->getDate($_POST['dateRec']);
    $modeReglementRec = $_POST["mode_reglementRec"];
    $montant = str_replace(" ","",$_POST['montantRec']);
    $impute = $_POST['impute'];
    $RG_Type = $_POST['RG_Type'];
    $typeRegl = $_POST["typeRegl"];
    $type = $_POST["type"];
    $dateReglementEntete_deb = $_POST["dateReglementEntete_deb"];
    $dateReglementEntete_fin = $_POST["dateReglementEntete_fin"];
    $reglement->addReglement($mobile,urlencode($jo_num),$rg_no_lier,urlencode($ct_num)
        ,$ca_no,$boncaisse,urlencode($libelle),$caissier
        ,$date,$modeReglementRec,$montant,$impute,$RG_Type,true,$typeRegl);
    $valAction = 2;
    if($typeRegl=="Fournisseur")
        $valAction = 4;
    if($typeRegl=="Collaborateur")
        $valAction = 5;
    header("Location: ../indexMVC_new.php?module=1&action=$valAction&typeRegl=$typeRegl&caissier=$caissier&client=$ct_num&dateReglementEntete_deb=$dateReglementEntete_deb&dateReglementEntete_fin=$dateReglementEntete_fin&mode_reglement=$modeReglementRec&journal=$jo_num&caisse=$ca_no&type=$type");
}



?>
