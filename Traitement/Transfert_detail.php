<?php
$login = "";
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/ComptetClass.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ArticleClass.php");
    $objet = new ObjetCollector();
    $login = $_SESSION["login"];
    $mobile = "";
}
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$modif=0;
$client = "";
$totalht=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
  
// Création de l'entete de document
if($_GET["acte"] =="ajout_entete"){
    $entete=$_GET["do_piece"];
    $result=$objet->db->requete($objet->getAllinfoClientByCTNum("41TRANSFERTDETAIL"));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $affaire="";
    if(isset($_GET["affaire"])) $affaire = $_GET["affaire"];
    if($rows==null){
        $ncompte = strtoupper("41TRANSFERTDETAIL");
        $type = 0;
        $intitule = "TREANSFERT DETAILS";
        $adresse = "";
        $compteg = "4110000";
        $codePostal = "";
        $depot = "0";
        $region= "";
        $ville= "";
        $nsiret= "";
        $identifiant= "";
        $tel= "";
        $catcompta= 1;
        $cattarif= 1;
        $ct_numP="";
        $result=$objet->db->requete($objet->createClientMin($ncompte,$intitule,$compteg,$adresse,$codePostal,$ville,$region,$nsiret,'',$ncompte,'0',$cattarif,$catcompta,$depot,$tel,'0',$type,$identifiant,"0",""));
        $result=$objet->db->requete($objet->getAllinfoClientByCTNum($ncompte));
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows!=null){
            $ct_numP=$rows[0]->CT_Num;
            if($rows[0]->CT_Type!=1)
                $result=$objet->db->requete($objet->createFLivraison($rows[0]->CT_Num,$rows[0]->CT_Intitule,$rows[0]->CT_Adresse,$rows[0]->CT_Complement,$rows[0]->CT_CodePostal,$rows[0]->CT_Ville,$rows[0]->CT_CodeRegion,$rows[0]->N_Expedition,$rows[0]->N_Condition,$rows[0]->CT_Telecopie,$rows[0]->CT_EMail,$rows[0]->CT_Pays,$rows[0]->CT_Contact,$rows[0]->CT_Telephone));   
            $result=$objet->db->requete($objet->creationComptetg($rows[0]->CT_Num,$rows[0]->CG_NumPrinc));     
        }
    }
//Sortie
    $docentete = new DocEnteteClass(0);
    $do_piece= $docentete->addDocenteteTransfertDetailProcess($entete,4,41,$_GET["date"], $_GET["reference"], $_GET["depot"], 0, 0,0,$affaire);
    //$objet->addDocenteteTransfertDetailProcess($entete,4,41,$_GET["date"], $_GET["reference"], $_GET["depot"], 0, 0,0,$affaire);
//Entree
    $docentete->addDocenteteTransfertDetailProcess($do_piece,4,40,$_GET["date"], $_GET["reference"], $_GET["collaborateur"], 0, 0,1,$affaire);
//    $objet->addDocenteteTransfertDetailProcess($entete,4,40,$_GET["date"], $_GET["reference"], $_GET["collaborateur"], 0, 0,1,$affaire);
    $result=$objet->db->requete($objet->lastDOPieceByDE_No($_GET["depot"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if ($rows!=null) {
        $entete = $rows[0]->DO_Piece;
        $cbMarq = $rows[0]->cbMarq;
    }
    $data = array('entete' => $entete,'cbMarq' => $cbMarq);
    echo json_encode($data);
}
// mise à jour de la référence
if( $_GET["acte"] =="liste_article"){
    $entete=$_GET["entete"];
    $result=$objet->db->requete($objet->getLigneTransfert_detail($entete));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

// mise à jour de la référence
if( $_GET["acte"] =="liste_article_source"){
    $depot=$_GET["depot"];
    $result=$objet->db->requete($objet->getAllArticleDispoByArRef($depot));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}

//ajout article 
if($_GET["acte"] =="ajout_ligne"|| $_GET["acte"] =="modif"){
    
    if($_GET["quantite"]!=""){
        $qte=$_GET["quantite"];
        $qte_dest=$_GET["quantite_dest"];
        $aqte=$_GET["ADL_Qte"];
        $aqte_dest=$_GET["ADL_Qte_dest"];
        $ref_article = $_GET["designation"];
        $ref_article_dest = $_GET["designation_dest"];
        $prix = $_GET["prix"];
        $prix_dest = $_GET["prix_dest"];
        $Aprix = $_GET["APrix"];
        $Aprix_dest = $_GET["APrix_dest"];
        $remise = $_GET["remise"];
        $cbMarq =  $_GET["cbMarq"];
        $id_sec =  $_GET["id_sec"];
        $collaborateur = $_GET["collaborateur"];
        $entete = $_GET["entete"];
        $depot = $_GET["depot"];
        $type_rem="P";
        $type_remise = 0;
        $typefac = $_GET["type_fac"];
        $cbMarqEntete = $_GET["cbMarqEntete"];
        $machine = $_GET["machineName"];
        $user = $_GET["userName"];
        if($_GET["acte"] =="ajout_ligne"){
            $docligne = new DocLigneClass(0);
            $objet->addDocligneTransfertDetailProcess(4,41,$ref_article,$prix,"41TRANSFERTDETAIL",$entete,$qte,"3",$depot,$login);
            $var2= $objet->addDocligneTransfertDetailProcess(4,40,$ref_article_dest,$prix_dest,"41TRANSFERTDETAIL",$entete,$qte_dest,"1",$collaborateur,$login);
            //$docligne->addDocligneTransfertDetailProcess(4,40,$cbMarqEntete,$ref_article, $prix, $qte, "1", $depot, $machine,$user,$mobile);
            //$var2 = $docligne->addDocligneTransfertDetailProcess(4,41,$cbMarqEntete,$ref_article, $prix, $qte, "3", $depot, $machine,$user,$mobile);
            echo json_encode($var2);
            $result=$objet->db->requete($objet->isStock($depot, $ref_article));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null)
                    $objet->db->requete($objet->insertF_ArtStock($ref_article,$depot,-($prix*$qte),-1*$qte));
                else 
                    $objet->db->requete($objet->updateArtStock($depot,$ref_article,-1*$qte,-($prix*$qte)));
            
            $result=$objet->db->requete($objet->isStock($collaborateur, $ref_article_dest));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null)
                    $objet->db->requete($objet->insertF_ArtStock($ref_article_dest,$collaborateur,($prix_dest*$qte_dest),$qte_dest));
                else 
                   $objet->db->requete($objet->updateArtStock($collaborateur,$ref_article_dest,$qte_dest,($prix_dest*$qte_dest)));
        }else{
            $objet->modifDocligneFactureMagasin($entete,$ref_article,$qte,$cbMarq,$prix,4,41,$login,$typefac);
            $objet->modifDocligneFactureMagasin($entete,$ref_article_dest,$qte_dest,$id_sec,$prix_dest,4,40,$login,$typefac);
            $result=$objet->db->requete($objet->isStock($depot, $ref_article));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null)
                    $objet->db->requete($objet->insertF_ArtStock($ref_article,$depot,(($Aprix*$aqte)-($prix*$qte)),($aqte-$qte)));
                else 
                    $objet->db->requete($objet->updateArtStock($depot,$ref_article,($aqte-$qte),(($Aprix*$aqte)-($prix*$qte))));
            
            $result=$objet->db->requete($objet->isStock($collaborateur, $ref_article_dest));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null)
                    $objet->db->requete($objet->insertF_ArtStock($ref_article_dest,$collaborateur,(($prix_dest*$qte_dest)-($Aprix_dest*$aqte_dest)),(-$aqte_dest+$qte_dest)));
                else 
                   $objet->db->requete($objet->updateArtStock($collaborateur,$ref_article_dest,(-$aqte_dest+$qte_dest),(($prix_dest*$qte_dest)-($Aprix_dest*$aqte_dest))));
            $result=$objet->db->requete($objet->lastLigneBycbMarqTrsftDetail($cbMarq,$id_sec));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($rows);    
        }
    }
}

if($_GET["acte"] =="liste_article_depot"){
$depot_no = $_GET["depot"];
$result=$objet->db->requete($objet->getAllArticleDispoByArRef($depot_no));     
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null)
    echo json_encode($rows);
}
//suppression d'article
if($_GET["acte"] =="suppr"){
    $docligne = new DocLigneClass($_GET["id"]);
    $docligne_sec = new DocLigneClass($_GET["id_sec"]);
    $result=$objet->db->requete($objet->getLigneFactureElementByCbMarq($_GET["id"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $AR_PrixAch = $rows[0]->DL_CMUP; 
    $DL_Qte = $rows[0]->DL_Qte; 
    $AR_Ref = $rows[0]->AR_Ref; 
    $DE_No = $rows[0]->DE_No; 
    $result=$objet->db->requete($objet->updateArtStock($DE_No,$AR_Ref,+$DL_Qte,+($AR_PrixAch*$DL_Qte)));
    $result=$objet->db->requete($objet->getLigneFactureElementByCbMarq($_GET["id_sec"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    $AR_PrixAch = $rows[0]->DL_CMUP; 
    $DL_Qte = $rows[0]->DL_Qte; 
    $AR_Ref = $rows[0]->AR_Ref; 
    $DE_No = $rows[0]->DE_No; 
    $result=$objet->db->requete($objet->updateArtStock($DE_No,$AR_Ref,-$DL_Qte,-($AR_PrixAch*$DL_Qte)));

    $docligne->delete();
    $docligne_sec->delete();

//    $DE_No = $_GET["DE_No"];
//    $DE_No_dest = $_GET["DE_No_dest"];
//    $AR_Ref = $_GET["AR_Ref"];
//    $DL_Qte = $_GET["DL_Qte"];
//    $AR_PrixAch = $_GET["AR_PrixAch"];
//        
//    echo $objet->updateArtStock($DE_No,$AR_Ref,+$DL_Qte,+($AR_PrixAch*$DL_Qte));
//    $result=$objet->db->requete($objet->updateArtStock($DE_No,$AR_Ref,+$DL_Qte,+($AR_PrixAch*$DL_Qte)));
//                                          
//    $result=$objet->db->requete($objet->updateArtStock($DE_No_dest,$AR_Ref,-$DL_Qte,-($AR_PrixAch*$DL_Qte)));

}

?>