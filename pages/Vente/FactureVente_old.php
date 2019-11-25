<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptFactureVente.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
$cat_tarif=0;
$cat_compta=0;
$protected=0;
$flagNouveau = 1;
$flagProtected = 0;
$flagSuppr = 1;
$entete="";
$affaire="";
$souche="";
$co_no=0;
if($profil_commercial==1)
    $co_no= $_SESSION["CO_No"];
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete="";
$total_regle=0;
$avance=0;
$reste_a_payer = 0;
$caisse = 0;
$do_statut=2;
$cocheTransfert = 0;

if($_GET["type"]=="Devis"){
    $qte_negative=0;
}
if($_GET["type"]=="PreparationCommande"){
    $qte_negative=0;
}
if($_GET["type"]=="AchatPreparationCommande"){
    $qte_negative=0;
}

$do_imprim = 0;
$souche=0;
$co_no=0;
$depot_no=0;
$caisse=0;
    $depot_no = $_SESSION["DE_No"];
    if(isset($_GET["depot"]))
        $depot_no =$_GET["depot"];
    
    // Données liées au client
    $nomdepot="";
    // Création de l'entete de document
$isModif = 1;
$isVisu = 1;
$isLigne = 0;
    $docEntete = new DocEnteteClass(0,$objet->db);
    if(isset($_GET["cbMarq"])){
        $docEntete = new DocEnteteClass($_GET["cbMarq"],$objet->db);
        $do_imprim = $docEntete->DO_Imprim;
        $client = new ComptetClass($docEntete->DO_Tiers,$objet->db);
        $cat_tarif = $client->N_CatTarif;
        $total_regle = $docEntete->ttc;
        $avance=$docEntete->avance;
        $reste_a_payer=$docEntete->resteAPayer;
        if(sizeof($docEntete->listeLigneFacture())>1)
            $isLigne=1;
    }
    $type=$_GET["type"];
    $isModif = $docEntete->isModif($_SESSION["id"],$type);
    $isVisu = $docEntete->isVisu($_SESSION["id"],$type);
    $protected = $protection->PROT_Right;

?>
<div id="milieu">    
    <div class="container">
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="col-md-12">
    <?php
include("pages/enteteFacture.php");
?>
<?php
include("pages/ligneFacture.php");
?>
<?php
include("pages/piedFacture.php");
?>
</div>

        