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

if(strcmp($_GET["acte"],"addReglement") == 0){
    $reglement = new ReglementClass(0,$objet->db);
    $mobile=0;
    if(isset($_GET["mobile"]))
        $mobile=1;
    $jo_num = $_GET["journal"];
    $rg_no_lier = $_GET["RG_NoLier"];
    $ct_num = $_GET['client'];
    $ca_no = $_GET["caisse"];
    $boncaisse = $_GET["boncaisse"];
    $libelle = $_GET['libelleRec'];
    $caissier = $_GET['caissier'];
    $date = $objet->getDate($_GET['dateRec']);
    $modeReglementRec = $_GET["mode_reglementRec"];
    $montant = str_replace(" ","",$_GET['montantRec']);
    $impute = $_GET['impute'];
    $RG_Type = $_GET['RG_Type'];
    $typeRegl = $_GET["typeRegl"];
    $type = $_GET["type"];
    $dateReglementEntete_deb = $_GET["dateReglementEntete_deb"];
    $dateReglementEntete_fin = $_GET["dateReglementEntete_fin"];
    $reglement->addReglement($mobile,$jo_num,$rg_no_lier,$ct_num
        ,$ca_no,$boncaisse ,$libelle ,$caissier
        ,$date,$modeReglementRec,$montant,$impute,$RG_Type,true,$typeRegl);
    $valAction = 2;
    if($typeRegl=="Fournisseur")
        $valAction = 4;
    if($typeRegl=="Collaborateur")
        $valAction = 5;
    header("Location: ../indexMVC.php?module=1&action=$valAction&typeRegl=$typeRegl&caissier=$caissier&client=$ct_num&dateReglementEntete_deb=$dateReglementEntete_deb&dateReglementEntete_fin=$dateReglementEntete_fin&mode_reglement=$modeReglementRec&journal=$jo_num&caisse=$ca_no&type=$type");
}



?>
