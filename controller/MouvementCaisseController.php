<?php

//require 'Send/class.phpmailer.php';
$CA_Num="-1";
$objet = new ObjetCollector();
$flagDateMvtCaisse = 0;

$datedeb= date("dmy");
$datefin= date("dmy");
$ca_no=-1;
$type=-1;
$protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
$flagCtrlTtCaisse = $protection->PROT_CTRL_TT_CAISSE;
$flagDateMvtCaisse = $protection->PROT_DATE_MVT_CAISSE;
$flagAffichageValCaisse = $protection->PROT_AFFICHAGE_VAL_CAISSE;

$admin=0;
if($protection->PROT_Right==1)
    $admin=1;

$caisse = new CaisseClass(0);
if($admin==0){
    $isPrincipal = 1;
    $rows = $caisse->getCaisseDepot($_SESSION["id"]);
    foreach($rows as $row)
        if($row->IsPrincipal==2)
            $ca_no = $row->CA_No;
}else{
    $rows = $caisse->listeCaisseShort();
}

if($ca_no==-1)
    if(sizeof($rows)>0)
        $ca_no = $rows[0]->CA_No;

$creglement = new ReglementClass(0);
$datapost = 0;
$modif= 0;
if(isset($_POST["RG_Modif"]))
    $modif = $_POST["RG_Modif"];

if(isset($_POST["dateReglementEntete_deb"])) {
    $datedeb = $_POST["dateReglementEntete_deb"];
    $datapost=1;
}
if(isset($_POST["dateReglementEntete_fin"]))
    $datefin = $_POST["dateReglementEntete_fin"];

if(isset($_POST["caisseComplete"]))
    $ca_no = $_POST["caisseComplete"];

if(isset($_POST["type_mvt_ent"]))
    $type = $_POST["type_mvt_ent"];
if(isset($_POST["libelle"])){
    $montant = str_replace(" ","",$_POST["montant"]);
    $login = $_SESSION["id"];
    $CA_Num="";
    if(isset($_POST["CA_Num"]))
        $CA_Num=$_POST["CA_Num"];
    $libelle = str_replace("'", "''", $_POST['libelle']);
    $rg_typereg=0;
    if(isset($_POST['rg_typereg']))
        $rg_typereg = $_POST['rg_typereg'];
    $user ="";
    if(isset($_POST["user"]))
        $user = $_POST["user"];
    if($rg_typereg==6) $libelle=$libelle;
    $caisse = new CaisseClass($_POST["CA_No"]);
    $co_nocaissier = $caisse->CO_NoCaissier;
    $ca_intitule = $caisse->CA_Intitule;
    $jo_num = $caisse->JO_Num;
    $collabClass = new CollaborateurClass($co_nocaissier);
    if($collabClass==null){
    }
    else{
        $collaborateur_caissier = $collabClass ->CO_Nom;
    }
    $cg_num = $_POST['CG_NumBanque'];
    $banque =0;
    if($rg_typereg==2) $cg_num="NULL";
    if($rg_typereg==6) {
        // Pour les vrst bancaire mettre a jour le compteur du RGPIECE
        $banque=1;
    }
    if($modif==0)
        $date = $objet->getDate($_POST['date']);
        $caNo = $_POST['CA_No'];
        if($rg_typereg!=16) {
            $rg_typeregVal = $rg_typereg;
            if($rg_typereg==6)
                $rg_typeregVal = 4;

            if($rg_typereg==6){
                $caisse = new CaisseClass($caNo);
                $creglement->setReglement('NULL', $date, $montant, $_POST["journalRec"], $cg_num, $caNo, $co_nocaissier, $date, $libelle, 0, 2, 1, $rg_typeregVal, 1, 1, $login);
                $rg_no = $creglement->insertF_Reglement();
                $creglement->setReglement('NULL', $date, $montant, $caisse->JO_Num, $cg_num, $caNo, $co_nocaissier, $date, $libelle."_".$caisse->JO_Num, 0, 2, 8, $rg_typeregVal, 1, 1, $login);
                $rg_noDest = $creglement->insertF_Reglement();
                $creglement->insertF_ReglementVrstBancaire($rg_no,$rg_noDest);
            }else{
                $creglement->setReglement('NULL', $date, $montant, $jo_num, $cg_num, $caNo, $co_nocaissier, $objet->getDate($_POST['date']), $libelle, 0, 2, 1, $rg_typeregVal, 1, $banque, $login);
                $rg_no = $creglement->insertF_Reglement();
            }
        }
        else {
            $creglement->setReglement('NULL', $date, $montant , $jo_num, $cg_num, $caNo, $co_nocaissier, $date, $libelle, 0, 2, 1, 4, 1, $banque, $login);
            $rg_no = $creglement->insertF_Reglement();
            $caisseDest = new CaisseClass($_POST['CA_No_Dest']);
            $creglement->setReglement('NULL', $date, $montant , $caisseDest->JO_Num , $cg_num, $caisseDest->CA_No, $caisseDest->CO_NoCaissier, $date, $libelle, 0, 2, 1, 5, 1, $banque, $login);
            $rg_no = $creglement->insertF_Reglement();
        }

    if($modif==0)
        if($_POST["CA_Num"]!="" && $_POST["CG_Analytique"]==1){
            $creglement->insertCaNum($rg_no,$_POST["CA_Num"]);
        }

    if($modif==0)
        if($rg_typereg == 4){
            $message='SORTIE D\' UN MONTANT DE '.$objet->formatChiffre($montant ).' POUR '.$libelle.' DANS LA CAISSE '.$ca_intitule.'  SAISI PAR '.$user.' LE '.date("d/m/Y", strtotime($objet->getDate($_POST['date'])));
            $result=$objet->db->requete($objet->getCollaborateurEnvoiMail("Mouvement de sortie"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows!=null){
                foreach($rows as $row){
                    $email=$row->CO_EMail;
                    $collab_intitule = $row->CO_Nom;
                    if(($email!="" || $email!=null)){
                        $objet->envoiMail($message,"Mouvement de sortie",$email);
                    }
                }
            }

            $result=$objet->db->requete($objet->getCollaborateurEnvoiSMS("Mouvement de sortie"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows!=null) {
                foreach($rows as $row) {
                    $telephone=$row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $message = "SORTIE DE {$objet->formatChiffre($montant)} POUR $libelle LE ".date('d/m/Y', strtotime($objet->getDate($_POST['date'])))." DANS $ca_intitule";
                        $contactD = new ContatDClass(1);
                        $contactD->sendSms($telephone, $message);
                    }
                }
            }
        }

    if($modif==0)
        if($rg_typereg == 6){
            $message="VERSEMENT BANCAIRE D'UN MONTANT DE $montant DANS LA CAISSE $ca_intitule SAISI PAR $user LE {$objet->getDate($_POST['date'])}";
            $result=$objet->db->requete($objet->getCollaborateurEnvoiMail("Versement bancaire"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows!=null) {
                foreach ($rows as $row) {
                    $email = $row->CO_EMail;
                    $collab_intitule = $row->CO_Nom;
                    $telephone = $row->CO_Telephone;
                    if (($email != "" || $email != null)) {
                        $objet->envoiMail($message, "Versement bancaire", $email);
                    }
                }
            }

            $result=$objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement bancaire"));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows!=null) {
                foreach($rows as $row) {
                    $telephone=$row->CO_Telephone;
                    if (($telephone != "" || $telephone != null)) {
                        $message="SORTIE DE $montant POUR $libelle LE {$objet->getDate($_POST['date'])} DANS $ca_intitule";
                        $contactD = new ContatDClass(1);
                        $contactD->sendSms($telephone,$message);
                    }
                }
            }
        }

    if($modif==0)
        if($rg_typereg!=2)
            $objet->incrementeCOLREGLEMENT();

    if($modif==1){
        $creglement = new ReglementClass($_POST["RG_NoLigne"]);
        $creglement->RG_Date = $objet->getDate($_POST["date"]);
        $caisse = new CaisseClass($_POST["CA_No"]);
        $creglement->JO_Num = $caisse->JO_Num;
        $creglement->CA_No = $_POST["CA_No"];
        $creglement->RG_Libelle = $_POST["libelle"];
        $creglement->CG_Num = $_POST["CG_NumBanque"];
        $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);

        if($_POST["rg_typeregModif"]==6) {
            $creglement->RG_TypeReg = 5;
            $creglement->JO_Num = $_POST["journalRec"];
        }

        if($_POST["rg_typeregModif"]==16) {
            $creglement->RG_TypeReg = 4;
            $creglement->maj_reglement();

            $creglement = new ReglementClass($_POST["RG_NoDestLigne"]);
            $creglement->RG_Date = $objet->getDate($_POST["date"]);
            $creglement->CA_No = $_POST["CA_No_Dest"];
            $caisse = new CaisseClass($_POST["CA_No_Dest"]);
            $creglement->JO_Num = $caisse->JO_Num;
            $creglement->RG_Libelle = $_POST["libelle"];
            $creglement->CG_Num = $_POST["CG_NumBanque"];
            $creglement->RG_TypeReg = 5;
            $creglement->RG_Montant = str_replace(" ", "", $_POST["montant"]);
        }
        $creglement->maj_reglement();

    }
}


?>
