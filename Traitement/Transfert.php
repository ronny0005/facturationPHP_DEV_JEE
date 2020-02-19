<?php
$login = "";
if(!isset($mobile)){
session_start();
include("../Modele/DB.php");
include("../Modele/ObjetCollector.php");
    include("../Modele/Objet.php");
    include("../Modele/LogFile.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/DepotClass.php");
    include("../Modele/ProtectionClass.php");
    include("../Send/class.phpmailer.php");
$objet = new ObjetCollector();
$login = $_SESSION["login"];
$mobile="";
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    $docLigne = new DocLigneClass(0);
        if($_GET["quantite"]!="") {
            $qte = $_GET["quantite"];
            $prix = $_GET["prix"];
            $typefac = $_GET["type_fac"];
            $remise = $_GET["remise"];
            $cbMarq = $_GET["cbMarq"];
            $id_sec = $_GET["id_sec"];
            $cbMarqEntete = $_GET["cbMarqEntete"];
            if (isset($_GET["machineName"]))
                $machine = $_GET["machineName"];
            $ref_article = $_GET["designation"];
            $docLigne->ajoutLigneTransfert($qte, $prix, $typefac, $cbMarq, $cbMarqEntete, $_SESSION["id"], $_GET["acte"], $ref_article, $machine);
        }
}

//suppression d'article
if($_GET["acte"] =="suppr"){
    $docligne = new DocLigneClass($_GET["id"], $objet->db);
    $docEntete = new DocEnteteClass($docligne->getcbMarqEntete(), $objet->db);
    if (isset($_GET["PROT_No"])) {
        $protection = new ProtectionClass("", "", $objet->db);
        $protection->connexionProctectionByProtNo($_GET["PROT_No"]);
        $isVisu = $docEntete->isVisu($protection->PROT_Administrator, $protection->protectedType("Transfert"), $protection->PROT_APRES_IMPRESSION);
        if (!$isVisu) {

            $AR_Ref = $docligne->AR_Ref;
            if ($docligne->DL_MvtStock == 3) {
                $DE_No = $docEntete->DE_No;
                $AR_PrixAch = $docligne->DL_CMUP;
                $DL_Qte = $docligne->DL_Qte;
            } else {
                $DE_No = $docEntete->DO_Tiers;
                $AR_PrixAch = $docligne->DL_CMUP;
                $DL_Qte = -$docligne->DL_Qte;
            }
            $log = new LogFile();
            $article = new ArticleClass($AR_Ref, $objet->db);
            $isStock = $article->isStock($DE_No);
            if ($isStock != null)
                $log->writeStock("suppresion", $AR_Ref, $DE_No, $isStock[0]->AS_QteSto, $isStock[0]->AS_MontSto);
            $log = new LogFile();
            $log->writeFacture("suppresion", $docEntete->DO_Type, $docEntete->DO_Piece, $DE_No, $docEntete->DO_Domaine
                , $AR_Ref, $DL_Qte, $docligne->DL_PrixUnitaire, "", $docligne->DL_MontantTTC);
            $article->updateArtStock($DE_No, $DL_Qte, $AR_PrixAch * $DL_Qte);
            $isStock = $article->isStock($DE_No);
            $log = new LogFile();
            if ($isStock != null)
                $log->writeStock("suppresion", $AR_Ref, $DE_No, $isStock[0]->AS_QteSto, $isStock[0]->AS_MontSto);

            $docligneSec = new DocLigneClass($_GET["id_sec"], $objet->db);
            $AR_Ref = $docligneSec->AR_Ref;
            if ($docligneSec->DL_MvtStock == 3) {
                $DE_No = $docEntete->DE_No;
                $AR_PrixAch = $docligneSec->DL_CMUP;
                $DL_Qte = $docligneSec->DL_Qte;
            } else {
                $DE_No = $docEntete->DO_Tiers;
                $AR_PrixAch = $docligneSec->DL_CMUP;
                $DL_Qte = -$docligneSec->DL_Qte;
            }
            $log = new LogFile();
            $article = new ArticleClass($AR_Ref, $objet->db);
            $isStock = $article->isStock($DE_No);
            if ($isStock != null)
                $log->writeStock("suppresion", $AR_Ref, $DE_No, $isStock[0]->AS_QteSto, $isStock[0]->AS_MontSto);
            $log = new LogFile();
            $log->writeFacture("suppresion", $docEntete->DO_Type, $docEntete->DO_Piece, $DE_No, $docEntete->DO_Domaine
                , $AR_Ref, $DL_Qte, $docligneSec->DL_PrixUnitaire, "", $docligneSec->DL_MontantTTC);
            $article->updateArtStock($DE_No, $DL_Qte, $AR_PrixAch * $DL_Qte);

            $log = new LogFile();
            $isStock = $article->isStock($DE_No);
            if ($isStock != null)
                $log->writeStock("suppresion", $AR_Ref, $DE_No, $isStock[0]->AS_QteSto, $isStock[0]->AS_MontSto);
            $docligneSec->delete();
            $docligne->delete();
            $docligne->deleteConfirmation();
        }
    }
}
?>