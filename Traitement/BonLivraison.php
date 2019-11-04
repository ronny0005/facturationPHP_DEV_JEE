<?php
if(!isset($mobile)){
    session_start();
    include("../Modele/DB.php");
    include("../Modele/Objet.php");
    include("../Modele/ObjetCollector.php");
    include("../Modele/DocEnteteClass.php");
    include("../Modele/DocLigneClass.php");
    include("../Modele/ComptetClass.php");
    include("../Modele/CaisseClass.php");
    include("../Modele/DepotClass.php");
    include("../Modele/ArticleClass.php");
    include("../Modele/FamilleClass.php");
    include("../Modele/ContatDClass.php");
    $objet = new ObjetCollector();
}

if($_GET["acte"] =="transBLFacture"){
    $cbMarqBL=$_GET["cbMarq"];
    $docEnteteBL= new DocEnteteClass($cbMarqBL);
    $conserv = $_GET["conserv_copie"];
    $type_trans= $_GET["type_trans"];
    $ref = $_GET["reference"];
    $type=$_GET["type"];
    $do_domaine=0;
    $do_type=3;
    $date_bl="";
    $type_res="Vente";
    if($type_trans==3) $type_res="BonLivraison";
    if($type=="Devis") $do_type=0;
    $resultat="";
    $enteteCbMarq = 0;
    $DE_No = 0;
    $listeArticle = $docEnteteBL->canTransform();
    if($type!="Devis" || $listeArticle == "") {
            $date_ins = $docEnteteBL->DO_Date;
            $date_bl = $docEnteteBL->DO_Date;
            $entete_bl = $docEnteteBL->DO_Piece;
            $DE_No = $docEnteteBL->DE_No;
            if ($_GET["date"] != "") {
                $date_ins = "20" . substr($_GET["date"], -2) . "-" . substr($_GET["date"], 2, 2) . "-" . substr($_GET["date"], 0, 2);
            }
            $ref_ins = $docEnteteBL->DO_Ref;
            if ($_GET["reference"] != "")
                $ref_ins = $_GET["reference"];
            $latitude = $docEnteteBL->Latitude;
            $longitude = $docEnteteBL->Longitude;
            if ($latitude == "") $latitude = 0;
            if ($longitude == "") $longitude = 0;

            $docEntete = new DocEnteteClass(0);
            $data =$docEntete->ajoutEntete($type_trans, "",
                $type_res, $date_ins, $date_ins,$docEnteteBL->CA_Num, $docEnteteBL->DO_Tiers, "",
                "", "",$docEnteteBL->DO_Coord02, $docEnteteBL->DO_Coord03, $docEnteteBL->DO_Coord04,
                $docEnteteBL->DO_Statut, $latitude, $longitude, $docEnteteBL->DE_No,$docEnteteBL->DO_Tarif, $docEnteteBL->N_CatCompta,
                $docEnteteBL->DO_Souche, $docEnteteBL->CA_No,$docEnteteBL->CO_No, $ref_ins);
            $enteteCbMarq = $data["cbMarq"];


        $rows= $docEnteteBL->listeLigneFacture();
        foreach($rows as $elt) {
            $docligne = new DocLigneClass($elt->cbMarq);
            $typeHT = $docligne->DL_TTC;
            $login = $_SESSION["login"];
            $result = $objet->db->requete($objet->isStock($docEnteteBL->DE_No, $docligne->AR_Ref));
            foreach ($rows as $row) {
                $rows_stk = $result->fetchAll(PDO::FETCH_OBJ);
                $qteStock = 0;
                if ($rows_stk != null) $qteStock = $rows_stk[0]->AS_QteSto;
                if ((ROUND($qteStock, 2) - ROUND($docligne->DL_Qte, 2) >= 0) || $type!="Devis") {
                    $AR_PrixAch = $docligne->DL_CMUP;
                    if ($conserv == 0){
                        $docligne->delete();
                    }
                    $prix = $docligne->DL_PrixUnitaire;
                    if ($docligne->DL_TTC == 1)
                        $prix = $docligne->DL_PUTTC;
                    if($type!="Devis")
                        $result = $objet->db->requete($objet->updateArtStock($docEnteteBL->DE_No, $docligne->AR_Ref, $docligne->DL_Qte, (rOUND($docligne->DL_CMUP,2) * $docligne->DL_Qte)));
                    if ($conserv == 0){
                        $docligne->ajout_ligneFacturation($docligne->DL_Qte,0,
                            $enteteCbMarq,$docEnteteBL->DE_No,$docligne->AR_Ref,$type_res,
                            0,$type_trans,$entete,0,$cat_compta,$prix,"",
                            "","",0,
                            0,0,
                            0,0,
                            "","ajout_ligne",0,0,
                            0,0);
                        $docEntete = new DocEnteteClass($enteteCbMarq);
                        $liste=$docEntete->listeLigneFacture();
                        foreach ($liste as $element){
                            $docligne = new DocLigneClass($element->cbMarq);
                            $docligne->maj("DL_PieceBL",$entete_bl);
                            $docligne->maj("DL_DateBL",$docligne->DL_DateBL);
                        }
                    }
                    else
                        $objet->addDocligneFactureProcess(3, $entete_bl, $docligne->AR_Ref, $docligne->DL_Qte, $docligne->DL_Remise01REM_Valeur,
                            $docligne->DL_Remise01REM_Type, 0, $cat_compta, $prix, 0, $type_trans, $docligne->cbCreateur,
                            $type_res, "",$enteteCbMarq,"","","");
                    $result = $objet->db->requete($objet->updateDateTransformLigne($entete_bl, $do_domaine, $type_trans, $date_bl));
                } else $resultat = $resultat . " " . $docligne->AR_Ref;
            }
            $docEnteteBL->deleteEntete();
        }
    }
    if($type=="Devis")
        echo $listeArticle;
}


?>