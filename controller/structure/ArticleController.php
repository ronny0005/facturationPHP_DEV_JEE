<?php
$ref = "";
$design = "";
$pxAch = "";
$famille = "";
$pxVtHT = "";
$pxVtTTC = "";
$pxMin="";
$pxMax="";
$ar_cond=0;
$cl_no1 = 0;
$cl_no2 = 0;
$cl_no3 = 0;
$cl_no4 = 0;
$fcl_no1 = 0;
$fcl_no2 = 0;
$fcl_no3 = 0;
$fcl_no4 = 0;
$CT_PrixTTC = 0;
$qte_gros="";
$objet = new ObjetCollector();

$result=$objet->db->requete($objet->typeArticle());
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null){
$CT_PrixTTC= $rows[0]->CT_PrixTTC;
}



if(isset($_GET["AR_Ref"])){
$article = new ArticleClass($_GET["AR_Ref"]);
$ref = $article->AR_Ref;
$design = $article->AR_Design;
$pxAch = $article->AR_PrixAch;
$famille = $article->FA_CodeFamille;
$ar_cond = $article->AR_Condition;
$pxVtHT = $article->AR_PrixVen;
$pxMin = $article->Prix_Min;
$pxMax = $article->Prix_Max;
$cl_no1 = $article->CL_No1;
$cl_no2 = $article->CL_No2;
$cl_no3 = $article->CL_No3;
$cl_no4 = $article->CL_No4;
$CT_PrixTTC= $article->AR_PrixTTC;
$qte_gros = $article->Qte_Gros;
if(isset($famille)){
$familleClass = new FamilleClass($famille);
$fcl_no1 = $familleClass->CL_No1;
$fcl_no2 = $familleClass->CL_No2;
$fcl_no3 = $familleClass->CL_No3;
$fcl_no4 = $familleClass->CL_No4;
}
}
$cbIndice=0;
$PrixTTC_Design = "HT";
if($CT_PrixTTC==1) $PrixTTC_Design = "TTC";
function valTTC($id){
if($id==1) return "TTC";
else return "HT";
}
?>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");

$flagProtected = $protection->protectedType("article");
$flagSuppr = $protection->SupprType("article");
$flagNouveau = $protection->NouveauType("article");
$flagInfoLibreArticle = $protection->NouveauType("infoLibreArticle");

?>
<div id="milieu">
    <div class="container">

        <div class="container clearfix">
            <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                <?php echo $texteMenu; ?>
            </h4>
        </div>
