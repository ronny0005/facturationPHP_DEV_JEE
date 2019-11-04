<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ReglementClass Extends Objet{
    //put your code here
    public $db,$RG_No,$CT_NumPayeur,$cbCT_NumPayeur,$RG_Date
    ,$RG_Reference,$RG_Libelle,$RG_Montant,$RG_MontantDev
    ,$N_Reglement,$RG_Impute,$RG_Compta,$EC_No
    ,$cbEC_No,$RG_Type,$RG_Cours,$N_Devise
    ,$JO_Num,$CG_NumCont,$cbCG_NumCont,$RG_Impaye
    ,$CG_Num,$cbCG_Num,$RG_TypeReg,$RG_Heure
    ,$RG_Piece,$cbRG_Piece,$CA_No,$cbCA_No
    ,$CO_NoCaissier,$cbCO_NoCaissier,$RG_Banque,$RG_Transfere
    ,$RG_Cloture,$RG_Ticket,$RG_Souche,$CT_NumPayeurOrig
    ,$cbCT_NumPayeurOrig,$RG_DateEchCont,$CG_NumEcart,$cbCG_NumEcart
    ,$JO_NumEcart,$RG_MontantEcart,$RG_NoBonAchat,$cbProt
    ,$cbMarq,$cbCreateur,$cbModification,$cbReplication
    ,$cbFlag,$DO_Modif,$RG_DateSage;
    public $table = 'F_CREGLEMENT';
    public $lien ="fcreglement";

    function __construct($id,$db=null)
    {
        $this->data = $this->getApiJson("/rgNo=$id");
        if($id!=0)
            $this->data = $this->getApiString("/rgNo=$id");
        if (sizeof($this->data) > 0) {
            $this->RG_No = $this->data[0]->RG_No;
            $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
            $this->RG_Date = $this->formatDate($this->data[0]->RG_Date);
            $this->RG_Reference = $this->data[0]->RG_Reference;
            $this->RG_Libelle = $this->data[0]->RG_Libelle;
            $this->RG_DateSage = $this->formatDateSage($this->data[0]->RG_Date);
            $this->RG_Montant = $this->data[0]->RG_Montant;
            $this->RG_MontantDev = $this->data[0]->RG_MontantDev;
            $this->N_Reglement = $this->data[0]->N_Reglement;
            $this->RG_Impute = $this->data[0]->RG_Impute;
            $this->RG_Compta = $this->data[0]->RG_Compta;
            $this->EC_No = $this->data[0]->EC_No;
            $this->RG_Type = $this->data[0]->RG_Type;
            $this->RG_Cours = $this->data[0]->RG_Cours;
            $this->N_Devise = $this->data[0]->N_Devise;
            $this->JO_Num = $this->data[0]->JO_Num;
            $this->CG_NumCont = $this->data[0]->CG_NumCont;
            $this->RG_Impaye = $this->data[0]->RG_Impaye;
            $this->CG_Num = $this->data[0]->CG_Num;
            $this->RG_TypeReg = $this->data[0]->RG_TypeReg;
            $this->RG_Heure = $this->data[0]->RG_Heure;
            $this->RG_Piece = $this->data[0]->RG_Piece;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->RG_Banque = $this->data[0]->RG_Banque;
            $this->RG_Transfere = $this->data[0]->RG_Transfere;
            $this->RG_Cloture = $this->data[0]->RG_Cloture;
            $this->RG_Ticket = $this->data[0]->RG_Ticket;
            $this->RG_Souche = $this->data[0]->RG_Souche;
            $this->CT_NumPayeurOrig = $this->data[0]->CT_NumPayeurOrig;
            $this->RG_DateEchCont = $this->data[0]->RG_DateEchCont;
            $this->CG_NumEcart = $this->data[0]->CG_NumEcart;
            $this->JO_NumEcart = $this->data[0]->JO_NumEcart;
            $this->RG_MontantEcart = $this->data[0]->RG_MontantEcart;
            $this->RG_NoBonAchat = $this->data[0]->RG_NoBonAchat;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->setDO_Modif();
        }
    }

    public function getReglementByClientFacture($cbMarq) {
        return $this->getApiJson("/getReglementByClientFacture&cbMarq=$cbMarq");
    }

    public function regle($cbMarq,$typeFacture,$protNo,$valideRegle,$valideRegltImprime,$mttAvance,$montantTotal,$modeReglement,$dateRglt,$libRglt){
        $this->getApiString("/regle&cbMarq=$cbMarq&typeFacture=$typeFacture&protNo=$protNo&valideRegle=$valideRegle&valideRegltImprime=$valideRegltImprime&mttAvance={$this->formatAmount($mttAvance)}&montantTotal={$this->formatAmount($montantTotal)}&modeReglement=$modeReglement&dateRglt=$dateRglt&libRglt={$this->formatString($libRglt)}");
    }

    public function formatDateSage($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('dmy');
    }

    public function setDO_Modif(){
        $query="SELECT CASE WHEN ABS(DATEDIFF(d,GETDATE(),RG_Date))>= (select PR_DelaiPreAlert
                from P_PREFERENCES) THEN 1 ELSE 0 END DO_Modif
                FROM F_CREGLEMENT
                WHERE RG_No=".$this->RG_No;
        $result= $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $this->DO_Modif=$rows[0]->DO_Modif;
    }

    public function listeReglementCaisse($datedeb,$datefin,$ca_no,$type){
        $jointure ="";
        $select = "";
        if(!isset($_SESSION))
            session_start();
        if(isset($_SESSION) && $ca_no==-1){
            $protectioncial = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
            if($protectioncial->PROT_Right!=1)
                $ca_no = "(SELECT CA_No
                        FROM Z_DEPOTUSER A
                        INNER JOIN Z_DEPOTCAISSE B ON A.DE_No = B.DE_No
                        WHERE Prot_No=".$_SESSION['id'].")";
        }

        if($this->db->flagDataOr==1){
            $jointure =" LEFT JOIN Z_REGLEMEnt_analytique ZR ON C.RG_No=ZR.RG_No ";
            $select = " CA_Num, ";
        }

         $query = "BEGIN 
                        SET NOCOUNT ON;
                    SELECT $select C.RG_No,RG_Piece,C.CA_No,CO_Nom
                          ,CA_Intitule,CO.CO_No,RG_TypeReg
                          ,RG_Banque,RG_Type,RG_Montant,CAST(RG_Date AS DATE)RG_Date
                          ,RG_Impute,RG_Libelle,Lien_Fichier
                FROM F_CREGLEMENT C
                LEFT JOIN F_CAISSE CA ON C.CA_No=CA.CA_No
                LEFT JOIN Z_REGLEMENTPIECE RG ON RG.RG_No=C.RG_No
                LEFT JOIN F_COLLABORATEUR CO ON C.CO_NoCaissier=CO.CO_No
                $jointure
                WHERE RG_Date BETWEEN '$datedeb' AND '$datefin' 
                AND ('-1' IN($ca_no) OR C.CA_No IN ($ca_no))
                AND ('-1' IN ($type) AND (RG_TypeReg IN ('2','4','3') OR (RG_TypeReg='5' AND RG_Banque=0)) 
                        OR ($type NOT IN (6,4) AND RG_TypeReg =$type) 
                        OR ($type=6 AND RG_TypeReg =4 AND RG_Banque=1)
                        OR ($type=5 AND RG_TypeReg =5 AND RG_Banque=0)
                        OR ($type=4 AND RG_TypeReg =4 AND RG_Banque=0))
                ORDER BY C.RG_No
END;";
        //AND (-1 IN($ca_no) OR C.CA_No IN ($ca_no))
         //       AND ((-1 = $type AND RG_TypeReg IN ('2','5','4','3')) OR RG_TypeReg =$type)
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function initVariables(){
        $this->RG_Reference="";
        $this->RG_MontantDev=0;
        $this->RG_Compta=0;
        $this->EC_No=0;
        $this->cbEC_No=NULL;
        $this->RG_Cours=0;
        $this->N_Devise=0;
        $this->CG_NumCont=null;
        $this->RG_Impaye='1900-01-01';
        $this->RG_Transfere = 0;
        $this->RG_Cloture=0;
        $this->RG_Souche=0;
        $this->CG_NumEcart=NULL;
        $this->JO_NumEcart=NULL;
        $this->RG_MontantEcart=0;
        $this->RG_NoBonAchat=0;
        $this->cbProt=0;
        $this->cbCreateur='AND';
        $this->cbReplication=0;
        $this->cbFlag=0;
    }

    public function listeTypeReglement()
    {
        $this->lien = "preglement";
        return $this->getApiJson("/all");
    }

    function getModeleReglement() {
        $this->lien ="FModeleR";
        return $this->getApiJson("/all");
    }


    public function maj_reglement(){
        if($this->CT_NumPayeur=="") {
            parent::majNull('CT_NumPayeur');
            //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CT_NumPayeur', $this->CT_NumPayeur);
            //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('RG_Date' , $this->RG_Date);
        parent::maj('RG_Reference' , $this->RG_Reference);
        parent::maj('RG_Libelle' , $this->RG_Libelle);
        parent::maj('RG_Montant' , $this->RG_Montant);
        parent::maj('RG_MontantDev' , $this->RG_MontantDev);
        parent::maj('N_Reglement' , $this->N_Reglement);
        parent::maj('RG_Impute' , $this->RG_Impute);
        parent::maj('RG_Compta' , $this->RG_Compta);
        parent::maj('EC_No' , $this->EC_No);
        parent::maj('cbEC_No' , $this->cbEC_No);
        parent::maj('RG_Type' , $this->RG_Type);
        parent::maj('RG_Cours' , $this->RG_Cours);
        parent::maj('N_Devise' , $this->N_Devise);
        parent::maj('JO_Num' , $this->JO_Num);
        if($this->CG_NumCont=="") {
            parent::majNull('CG_NumCont');
        //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CG_NumCont', $this->CG_NumCont);
        //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('RG_Impaye' , $this->RG_Impaye);
        if($this->CG_Num=="") {
            parent::majNull('CG_Num');
        //    parent::majNull('cbCG_Num');
        }
        else {
            parent::maj('CG_Num', $this->CG_Num);
        //    parent::maj('cbCG_Num', $this->CG_Num);
        }
        parent::maj('RG_TypeReg' , $this->RG_TypeReg);
        parent::maj('RG_Heure' , $this->RG_Heure);
        parent::maj('RG_Piece' , $this->RG_Piece);
        parent::maj('CA_No' , $this->CA_No);
        parent::maj('cbCA_No' , $this->cbCA_No);
        parent::maj('CO_NoCaissier' , $this->CO_NoCaissier);
        parent::maj('cbCO_NoCaissier' , $this->cbCO_NoCaissier);
        parent::maj('RG_Banque' , $this->RG_Banque);
        parent::maj('RG_Transfere' , $this->RG_Transfere);
        parent::maj('RG_Cloture' , $this->RG_Cloture);
        parent::maj('RG_Ticket' , $this->RG_Ticket);
        parent::maj('RG_Souche' , $this->RG_Souche);
        if($this->CT_NumPayeurOrig=="") {
            parent::majNull('CT_NumPayeurOrig');
            //parent::maj('CT_NumPayeurOrig' , $this->CT_NumPayeurOrig);
        }
        else {
            parent::maj('CT_NumPayeurOrig', $this->CT_NumPayeurOrig);
            //        parent::maj('CT_NumPayeurOrig' , $this->CT_NumPayeurOrig);
        }
        parent::maj('RG_DateEchCont' , $this->RG_DateEchCont);
        if($this->CG_NumEcart=="") {
            parent::majNull('CG_NumEcart');
            //    parent::majNull('cbCG_NumCont');
        }
        else {
            parent::maj('CG_NumEcart' , $this->CG_NumEcart);
            //    parent::maj('cbCG_NumCont', $this->cbCG_NumCont);
        }
        parent::maj('JO_NumEcart' , $this->JO_NumEcart);
        parent::maj('RG_MontantEcart' , $this->RG_MontantEcart);
        parent::maj('RG_NoBonAchat' , $this->RG_NoBonAchat);
        parent::maj('cbProt' , $this->cbProt);
        parent::maj('cbCreateur' , $this->userName);
        parent::maj('cbModification' , $this->cbModification);
        parent::maj('cbReplication' , $this->cbReplication);
        parent::maj('cbFlag' , $this->cbFlag);
        $this->majcbModification();
    }

    public function majcbNull()
    {
        $requete = "INSERT INTO [dbo].[F_CREGLEMENT] WHERE RG_No=".$this->RG_No;
        $this->db->query($requete);

    }

    public function supprRgltAssocie()
    {
        $requete = "BEGIN 
                        SET NOCOUNT ON;
                        DELETE FROM F_CREGLEMENT WHERE RG_No IN (   SELECT RG_No 
                                                                    FROM [Z_RGLT_BONDECAISSE] 
                                                                    WHERE RG_No_RGLT=".$this->RG_No.")
                        DELETE FROM [Z_RGLT_BONDECAISSE] WHERE RG_No_RGLT=".$this->RG_No."; END";
        $this->db->query($requete);
    }


    public function supprReglement()
    {
        $requete = "DELETE FROM F_REGLECH WHERE RG_No = ".$this->RG_No." AND RC_Montant=0;
                    DELETE FROM F_CREGLEMENT WHERE RG_No = ".$this->RG_No.";
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No = ".$this->RG_No.";
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No_RGLT = ".$this->RG_No.";";
        $this->db->query($requete);
    }

    public function remboursementRglt($date,$montant,$mobile){
        // création du remboursement
        $creglement = new ReglementClass(0);
        $creglement->initVariables();
        $creglement->RG_Date = $date;
        $creglement->RG_DateEchCont = $date;
        $creglement->JO_Num = $this->JO_Num;
        $creglement->CG_Num = $this->CG_Num;
        $creglement->CA_No = $this->CA_No;
        $creglement->CO_NoCaissier = $this->CO_NoCaissier;
        $creglement->RG_Libelle = "Remboursement N° ".$this->RG_Piece;
        $creglement->RG_Montant = -$montant;
        $creglement->RG_Impute = 1;
        $creglement->RG_Type = $this->RG_Type;
        $creglement->N_Reglement = "01";
        $creglement->RG_TypeReg=5;//$this->RG_TypeReg;
        $creglement->RG_Ticket=0;
        $creglement->RG_Banque=$this->RG_Banque;
        $creglement->CT_NumPayeur = $this->CT_NumPayeur;
        $creglement->setuserName("",$mobile);
        $rg_noRembours = $creglement->insertF_Reglement();
        //liaison du remboursement et reglement
        $this->insertZ_RGLT_BONDECAISSE($rg_noRembours,$this->RG_No);
        $this->RG_Impute = $this->isImpute()[0]->isImpute;
        $this->maj_reglement();
    }

    public function getFactureRGNo($rg_no){
        $query = "SELECT E.cbMarq,DE_Intitule,L.DO_Piece,L.DO_Ref,CAST(CAST(L.DO_Date AS DATE) AS VARCHAR(10)) AS DO_Date,CO.CT_Num,CT_Intitule, ROUND(SUM(L.DL_MontantTTC),0) AS ttc, 
                ISNULL(sum(avance),0) AS avance  
                FROM F_CREGLEMENT C
                INNER JOIN (SELECT RG_No,DO_Piece,DO_Domaine,DO_Type, SUM(RC_MONTANT) avance FROM F_REGLECH R GROUP BY RG_No,DO_Piece,DO_Domaine,DO_Type) R ON C.RG_No=R.RG_No 
                LEFT JOIN (SELECT cbMarq,DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,DO_Tiers FROM F_DOCENTETE  GROUP BY cbMarq,DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,DO_Tiers) E on R.DO_Piece=E.DO_Piece  AND R.DO_Domaine= E.DO_Domaine AND R.DO_Type=E.DO_Type
                LEFT JOIN (SELECT DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,CT_Num,SUM(DL_MontantTTC) DL_MontantTTC FROM F_DOCLIGNE L GROUP BY DO_Piece,DO_Type,DO_Domaine,DE_No,DO_Ref,DO_Date,CT_Num) L on R.DO_Piece=L.DO_Piece  AND R.DO_Domaine= L.DO_Domaine AND R.DO_Type=L.DO_Type
                LEFT JOIN F_COMPTET CO on CO.CT_Num=L.CT_Num
                LEFT JOIN F_DEPOT D on D.DE_No=(CASE WHEN L.DE_No=0 THEN E.DE_No ELSE L.DE_No END)
                WHERE C.RG_No=$rg_no
                GROUP BY E.cbMarq,DE_Intitule,L.DO_Piece,L.DO_Ref,L.DO_Date,CO.CT_Num,CT_Intitule
                UNION
                SELECT 0 cbMarq,'' AS DE_Intitule,'' AS DO_Piece,RG_Libelle AS DO_Ref,CAST(CAST(RG_Date AS DATE) AS VARCHAR(10)) AS DO_Date,CT_NumPayeur CT_Num,'' CT_Intitule, RG_Montant AS ttc,0 AS avance 
                FROM [dbo].[Z_RGLT_BONDECAISSE] A
                INNER JOIN F_CREGLEMENT B ON A.RG_No=B.RG_No
                WHERE RG_No_RGLT=$rg_no";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertZ_RGLT_BONDECAISSE($RG_No,$RG_NoLier){
        $requete ="INSERT INTO [dbo].[Z_RGLT_BONDECAISSE] VALUES ($RG_No,$RG_NoLier)";
        $this->db->query($requete);
    }

    public function insertF_Reglement(){
        $requete = "
                                BEGIN 
                SET NOCOUNT ON;
                IF NOT EXISTS (SELECT 1 FROM F_CREGLEMENT WHERE RG_Libelle = '{$this->RG_Libelle}' AND RG_Date='{$this->RG_Date}' AND RG_Montant={$this->RG_Montant} AND RG_Type={$this->RG_Type} AND RG_TypeReg = {$this->RG_TypeReg}) 
                INSERT INTO [dbo].[F_CREGLEMENT] 
                 ([RG_No],[CT_NumPayeur],[RG_Date],[RG_Reference] 
                 ,[RG_Libelle],[RG_Montant],[RG_MontantDev],[N_Reglement] 
                 ,[RG_Impute],[RG_Compta],[EC_No],[cbEC_No] 
                 ,[RG_Type],[RG_Cours],[N_Devise],[JO_Num] 
                 ,[CG_NumCont],[RG_Impaye],[CG_Num],[RG_TypeReg] 
                 ,[RG_Heure],[RG_Piece],[CA_No],[cbCA_No] 
                 ,[CO_NoCaissier],[cbCO_NoCaissier],[RG_Banque],[RG_Transfere] 
                 ,[RG_Cloture],[RG_Ticket],[RG_Souche],[CT_NumPayeurOrig] 
                 ,[RG_DateEchCont],[CG_NumEcart],[JO_NumEcart],[RG_MontantEcart] 
                 ,[RG_NoBonAchat],[cbProt],[cbCreateur],[cbModification] 
                 ,[cbReplication],[cbFlag]) 
                 VALUES 
                    (/*RG_No*/ISNULL((SELECT MAX(RG_No)+1 FROM F_CREGLEMENT),0),/*CT_NumPayeur*/";
        if($this->CT_NumPayeur=="NULL")
            $requete= $requete."" . $this->CT_NumPayeur . "";
        else if($this->CT_NumPayeur=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->CT_NumPayeur . "'";
        $requete= $requete.",/*RG_Date*/'".$this->RG_Date."',/*RG_Reference*/'".$this->RG_Reference."' 
                   ,/*RG_Libelle*/'".mb_ereg_replace("'","''",$this->RG_Libelle)."',/*RG_Montant*/ ".$this->RG_Montant."
                   ,/*RG_MontantDev*/".$this->RG_MontantDev.",/*N_Reglement*/".$this->N_Reglement."
                   ,/*RG_Impute*/".$this->RG_Impute.",/*RG_Compta*/".$this->RG_Compta."
                   ,/*EC_No*/".$this->EC_No.",/*cbEC_No*/";
                if($this->EC_No=="NULL" || $this->EC_No=="")
                    $requete= $requete."" . $this->EC_No. "";
                else
                    $requete= $requete."'" . $this->EC_No . "'";
        $requete= $requete.",/*RG_Type*/".$this->RG_Type.",/*RG_Cours*/".$this->RG_Cours."
                   ,/*N_Devise*/".$this->N_Devise.",/*JO_Num*/'".$this->JO_Num."'
                   ,/*CG_NumCont*/";

        if($this->CG_NumCont=="NULL" || $this->CG_NumCont=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->CG_NumCont . "'";
        $requete= $requete.",/*RG_Impaye*/'".$this->RG_Impaye."'
                   ,/*CG_Num*/";
        if($this->CG_Num=="NULL" || $this->CG_Num=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->CG_Num . "'";
        $requete= $requete.",/*RG_TypeReg*/ ".$this->RG_TypeReg.",
                /*RG_Heure, char(9),*/(SELECT '000' + CAST(DATEPART(HOUR, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(MINUTE, GETDATE()) as VARCHAR(2)) + CAST(DATEPART(SECOND, GETDATE()) as VARCHAR(2))),
                /*RG_Piece*/";
        if($this->RG_TypeReg==2)
            $requete= $requete."''";
        else
            $requete= $requete. "(SELECT(ISNULL((SELECT TOP 1 CR_Numero01 AS valeur FROM P_COLREGLEMENT ORDER BY cbMarq DESC),1)) as VAL)";
        $requete= $requete.",/*CA_No*/(SELECT CASE WHEN ".$this->CA_No."=0 THEN NULL ELSE " . $this->CA_No. " END),/*cbCA_No*/(SELECT CASE WHEN ".$this->CA_No."=0 THEN NULL ELSE ".$this->CA_No." END)
                   ,/*CO_NoCaissier*/(SELECT CASE WHEN ".$this->CO_NoCaissier." =0 THEN NULL ELSE " . $this->CO_NoCaissier. " END),/*cbCO_NoCaissier*/(SELECT CASE WHEN ".$this->CO_NoCaissier."=0 THEN NULL ELSE ".$this->CO_NoCaissier." END)
                   ,/*RG_Banque*/".$this->RG_Banque.",/*RG_Transfere*/".$this->RG_Transfere." 
                   ,/*RG_Cloture*/".$this->RG_Cloture.",/*RG_Ticket*/".$this->RG_Ticket."
                   ,/*RG_Souche*/".$this->RG_Souche.",/*CT_NumPayeurOrig*/";
        if($this->CT_NumPayeurOrig=="NULL" || $this->CT_NumPayeurOrig=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->CT_NumPayeurOrig . "'";

        $requete= $requete.",/*RG_DateEchCont*/'".$this->RG_DateEchCont."',/*CG_NumEcart*/";
        if($this->CG_NumEcart=="NULL" || $this->CG_NumEcart=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->CG_NumEcart . "'";

        $requete= $requete.",/*JO_NumEcart*/";
        if($this->JO_NumEcart=="NULL" || $this->JO_NumEcart=="")
            $requete= $requete."NULL";
        else
            $requete= $requete."'" . $this->JO_NumEcart . "'";
        $requete= $requete.",/*RG_MontantEcart*/".$this->RG_MontantEcart."
                   ,/*RG_NoBonAchat*/".$this->RG_NoBonAchat.",/*cbProt*/".$this->cbProt." 
                   ,/*cbCreateur*/'".$this->userName."',/*cbModification*/GETDATE()
                   ,/*cbReplication*/".$this->cbReplication.",/*cbFlag*/".$this->cbFlag.");
                IF EXISTS (SELECT 1 FROM F_CREGLEMENT WHERE RG_Libelle = '{$this->RG_Libelle}' AND RG_Date='{$this->RG_Date}' AND RG_Montant={$this->RG_Montant} AND RG_Type={$this->RG_Type} AND RG_TypeReg = {$this->RG_TypeReg}) 
                    SELECT RG_No FROM F_CREGLEMENT WHERE RG_Libelle = '{$this->RG_Libelle}' AND RG_Date='{$this->RG_Date}' AND RG_Montant={$this->RG_Montant} AND RG_Type={$this->RG_Type} AND RG_TypeReg = {$this->RG_TypeReg}
                ELSE 
                SELECT RG_No FROM F_CREGLEMENT 
                    WHERE cbMarq = (select @@IDENTITY);
                END;";
        $result= $this->db->query($requete);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        return $rows[0]->RG_No;
    }

    public function insertZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "INSERT INTO Z_REGLEMENT_ANALYTIQUE(CA_Num,RG_No,cbModification,cbCreateur) VALUES ('$CA_Num',$RG_No,GETDATE(),'".$this->userName."')";
        $this->db->query($requete);
    }

    public function majZ_REGLEMENT_ANALYTIQUE($RG_No, $CA_Num){
        $requete = "UPDATE Z_REGLEMENT_ANALYTIQUE SET CA_Num='$CA_Num',cbModification=GETDATE(),cbCreateur='".$this->userName."' WHERE RG_No = $RG_No";
        $this->db->query($requete);
    }

    public function isImpute(){
        $query ="
                SELECT A.RG_No,RG_Montant-isnull(RC_Montant,0) as MontantImpute,
                CASE WHEN RG_Montant-isnull(RC_Montant,0) = 0 THEN 1 ELSE 0 END isImpute
                FROM F_CREGLEMENT A
                LEFT JOIN (
                SELECT A.RG_No,SUM(RC_Montant) AS RC_Montant
                FROM(	SELECT RG_No,sum(RC_Montant) AS RC_Montant 
                        FROM F_REGLECH
                        GROUP BY RG_No
                UNION
                SELECT A.RG_No,SUM(ISNULL(ABS(C.RG_Montant),0)) 
                FROM F_CREGLEMENT A
                INNER JOIN Z_RGLT_BONDECAISSE B ON A.RG_No = B.RG_No_RGLT
                INNER JOIN F_CREGLEMENT C ON B.RG_No = C.RG_No
                GROUP BY A.RG_No) A GROUP BY RG_No)B ON A.RG_No = B.RG_No
                WHERE A.RG_No =".$this->RG_No;
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getReglementByClient($ct_num,$ca_no,$type,$treglement,$datedeb,$datefin,$caissier,$collab,$typeSelectRegl=0) {
        $query= "    SELECT PROT_User,
                            CASE WHEN ABS(DATEDIFF(d,GETDATE(),C.RG_Date))>= (select PR_DelaiPreAlert
                from P_PREFERENCES) THEN 1 ELSE 0 END DO_Modif,C.JO_Num,C.CO_NoCaissier,C.CT_NumPayeur,C.CG_Num,RG_Piece,ISNULL(RC_Montant,0) AS RC_Montant,C.RG_No,CAST(RG_Date as date) RG_Date,RG_Libelle,ABS(RG_Montant)RG_Montant,C.CA_No,C.CO_NoCaissier,ISNULL(CO_Nom,'')CO_Nom,ISNULL(CA_Intitule,'')CA_Intitule,RG_Impute,RG_TypeReg,N_Reglement
                    FROM F_CREGLEMENT C
                    LEFT JOIN F_CAISSE CA ON CA.CA_No=C.CA_No 
                      LEFT JOIN F_PROTECTIONCIAL Pr ON CAST(Pr.PROT_No AS VARCHAR(5)) = C.cbCreateur
                    LEFT JOIN ".$this->db->baseCompta.".dbo.F_COLLABORATEUR CO ON C.CO_NoCaissier = CO.CO_No
                    LEFT JOIN (	SELECT A.RG_No,SUM(RC_Montant) AS RC_Montant
                                FROM(	SELECT RG_No,sum(RC_Montant) AS RC_Montant 
                                        FROM F_REGLECH
                                        GROUP BY RG_No
								UNION
								SELECT A.RG_No,SUM(ISNULL(ABS(C.RG_Montant),0)) 
                                FROM F_CREGLEMENT A
                                INNER JOIN Z_RGLT_BONDECAISSE B ON A.RG_No = B.RG_No_RGLT
                                INNER JOIN F_CREGLEMENT C ON B.RG_No = C.RG_No
								GROUP BY A.RG_No
								UNION
								SELECT A.RG_No,SUM(ISNULL(ABS(RG_Montant),0)) 
								FROM F_CREGLEMENT A
                                INNER JOIN Z_RGLT_BONDECAISSE B ON A.RG_No = B.RG_No
								GROUP BY A.RG_No) A 
								GROUP BY RG_No) R ON R.RG_No=c.RG_No
			        WHERE 
			        $typeSelectRegl = RG_Type AND RG_Date BETWEEN '$datedeb' AND '$datefin' AND (-1=$type OR RG_Impute=$type)
                    AND ((''='$ct_num' AND ct_numpayeur IS NOT NULL) OR ct_numpayeur = '$ct_num' OR ('1'=$collab AND C.CO_NoCaissier='$ct_num'))
                    AND (((0=$treglement OR N_Reglement=$treglement) AND (($collab = 1 AND RG_Banque=3) OR ($collab = 0))
                    AND ('0'=$ca_no OR CA.CA_No=$ca_no)) OR ('0'<>$caissier AND C.CO_NoCaissier=$caissier AND N_Reglement='05') )
                    ORDER BY C.RG_No";
        $result = $this->db->requete($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function addCReglementFacture($cbMarqEntete, $montant,$rg_type,$mode_reglement,$caisse,$date_reglt,$lib_reglt,$date_ech,$protNo) {
        $docEntete = new DocEnteteClass($cbMarqEntete,$this->db);
        $DO_Date = $date_reglt;
        $CT_Num = $docEntete->DO_Tiers;
        $DE_No = $docEntete->DE_No;
        $CA_Num = $docEntete->CA_Num;
        $DO_Ref = $docEntete->DO_Ref;
        if(isset($_SESSION)){
            $protection = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
            $co_noProt = $protection->getCoNo();
            if($co_noProt == null)
                $CO_No = $docEntete->CO_No;
            else {
                $CO_No = $co_noProt;
            }
        }else {
            $CO_No = $docEntete->CO_No;
        }
        $cg_num = $docEntete->CG_Num;
        $DO_Devise = $docEntete->DO_Devise !="" ? $docEntete->DO_Devise : 0 ;
        $DO_Cours = $docEntete->DO_Cours !="" ? $docEntete->DO_Cours : 0 ;
        $DO_Domaine = $docEntete->DO_Domaine;
        $DO_Type = $docEntete->DO_Type;
        $caisseVal = new CaisseClass($caisse,$this->db);
        if($caisseVal->CA_No==""){
            $co_nocaissier = 0;
            $ca_no = 0;
            $jo_num = "";
        }else {
            $co_nocaissier = $caisseVal->CO_NoCaissier;
            $ca_no = $caisseVal->CA_No;
            $jo_num = $caisseVal->JO_Num;
        }
        $ticket = 0;
        if($DO_Type==30) $ticket = 1;
        $creglement = new ReglementClass(0,$this->db);
        $creglement->initVariables();
        $creglement->RG_Date = $DO_Date;
        $creglement->CT_NumPayeur = $CT_Num;
        $creglement->CA_No = $ca_no;
        $creglement->CG_Num = $cg_num;
        $creglement->RG_Reference = $DO_Ref;
        //$caisse = new CaisseClass($creglement->CA_No);
        $creglement->JO_Num = $jo_num;
        $creglement->CO_NoCaissier = $CO_No;
        $creglement->setuserName("","");
        $creglement->RG_Montant = $montant;
        $creglement->RG_Libelle = $lib_reglt;
        $creglement->RG_Impute = 1;
        $creglement->RG_Type = $rg_type;
        $creglement->N_Reglement = $mode_reglement;
        $creglement->RG_TypeReg=0;
        $creglement->RG_Ticket=$ticket;
        $creglement->RG_Banque=0;
        $creglement->N_Devise = $DO_Devise;
        $creglement->RG_Cours = $DO_Cours;
        $creglement->RG_DateEchCont=$DO_Date;
        $creglement->userName = $protNo;
        $rg_no = $creglement->insertF_Reglement();
        $this->objetCollection->incrementeCOLREGLEMENT();
        $rows = $docEntete->getDocReglByDO_Piece();
        $record = $rows;
        if(!isset($rows[0]->DR_No)){
            $result = $this->db->requete($this->objetCollection->addDocRegl($docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, 0, $mode_reglement,$date_reglt));
            $rows = $docEntete->getDocReglByDO_Piece();
        }
        $dr_no = $rows[0]->DR_No;
        $montantTTC = $docEntete->montantRegle();
        $montantTTC_regle = $docEntete->AvanceDoPiece();
        $reste_a_regler = $montantTTC - $montantTTC_regle;
        if(($reste_a_regler>=0 && $montant>$reste_a_regler) || ($reste_a_regler<0 && $montant<$reste_a_regler)){
            $result = $this->db->requete($this->objetCollection->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($reste_a_regler,2)));
        }else{
            $result = $this->db->requete($this->objetCollection->addReglEch($rg_no, $dr_no, $docEntete->DO_Domaine, $docEntete->DO_Type, $docEntete->DO_Piece, round($montant,2)));
            if($montant==$reste_a_regler){
                $this->db->requete($this->objetCollection->updateDrRegle($dr_no));
                $this->db->requete($this->objetCollection->updateImpute($rg_no));
            }
        }$this->db->requete($this->objetCollection->updateDateRegle($dr_no,$date_ech));
        return $rg_no;
    }


    public function addReglement($mobile/*$_GET["mobile"]*/,$jo_num/*$_GET["JO_Num"]*/,$rg_no_lier/*$_GET["RG_NoLier"]*/,$ct_num /*$_GET['CT_Num']*/
                                ,$ca_no/*$_GET["CA_No"]*/,$boncaisse /*$_GET["boncaisse"]*/,$libelle /*$_GET['libelle']*/,$caissier /*$_GET['caissier']*/
                                ,$date/*$_GET['date']*/,$modeReglementRec /*$_GET["mode_reglementRec"]*/
                                ,$montant /*$_GET['montant']*/,$impute/*$_GET['impute']*/,$RG_Type /*$_GET['RG_Type']*/,$afficheData=true,$typeRegl=""){
        $admin = 0;
        $limitmoinsDate = "";
        $limitplusDate = "";
        if($mobile!="")
            if(!isset($_SESSION))
                session_start();
        if(isset($_SESSION)){
            $protectionClass = new ProtectionClass($_SESSION["login"],$_SESSION["mdp"]);
            if($protectionClass->PROT_Right!=1) {
                $limitmoinsDate = date('d/m/Y', strtotime(date('Y-m-d'). " - ".$protectionClass->getDelai()." day"));
                $limitplusDate = date('d/m/Y', strtotime(date('Y-m-d'). " + ".$protectionClass->getDelai()." day"));
                $str = strtotime(date("M d Y ")) - (strtotime($date));
                $nbDay = abs(floor($str/3600/24));
                if($nbDay>$protectionClass->getDelai())
                    $admin =1;
            }
        }

        if($admin==0) {
            $cg_num = "";
            $ct_intitule = "";
            $boncaisse=0;
            $banque = 0;
            $co_no=0;
            if($boncaisse==1) {
                $co_no = $ct_num;
                $ct_num="";
                $banque = 3;
            }

            if($typeRegl=="Collaborateur"){
                $caissier = $ct_num;
                $ct_num="";
                $banque=3;
                $rg_typeN=1;
            }else{
                $result=$this->db->requete($this->objetCollection->getClientByCTNum($ct_num));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if(sizeof($rows)>0){
                    $cg_num = $rows[0]->CG_NumPrinc;
                    $ct_intitule = $rows[0]->CT_Intitule;
                    $rg_typeN = $rows[0]->CT_Type;
                }else{
                    $banque = 3;
                    $rg_typeN=2;

                }
            }
            $email="";
            $telephone="";
            $collab_intitule="";
            $caissier_intitule="";
            if($boncaisse==1)
                $caissier = $co_no;
            $rg_typereg=0;
            if($modeReglementRec=="05"){
                $banque = 2;
                $libelle = "Verst distant".$libelle;
            }

            if($modeReglementRec=="10"){
                $rg_typereg = 5;
            }

            $result=$this->db->requete($this->objetCollection->getCaisseByCA_No($ca_no));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }
            else{
                $ca_intitule = $rows[0]->CA_Intitule;
            }

            $result=$this->db->requete($this->objetCollection->getCollaborateurByCOno($caissier));
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){

            }
            else{
                $collaborateur_caissier = $rows[0]->CO_Nom;
                $email=$rows[0]->CO_EMail;
                $collab_intitule = $rows[0]->CO_Nom;
                $telephone=$rows[0]->CO_Telephone;
            }

            if($rg_no_lier==0) {
                $message = 'VERSEMENT DISTANT D\' UN MONTANT DE ' . $montant . ' AFFECTE AU COLLABORATEUR ' . $collaborateur_caissier . ' POUR LE CLIENT ' . $ct_intitule . ' A DATE DU ' . $date;
                if (($email != "" || $email != null) && $modeReglementRec == "05") {
                    $this->objetCollection->envoiMail($message, "Versement distant", $email);
                }
            }

            $creglement = new ReglementClass(0);
            $creglement->initVariables();
            $creglement->RG_Date = $date;
            $creglement->RG_DateEchCont = $date;
            $creglement->JO_Num = $jo_num;
            $creglement->CG_Num = $cg_num;
            $creglement->CA_No = $ca_no;
            $creglement->CO_NoCaissier = $caissier;
            $creglement->RG_Libelle = substr($libelle,0,34);
            $creglement->RG_Montant = $montant;
            $creglement->RG_Impute = $impute;
            $creglement->RG_Type = $rg_typeN;//$RG_Type;
            $creglement->N_Reglement = $modeReglementRec;
            $creglement->RG_TypeReg=$rg_typereg;
            $creglement->RG_Ticket=0;
            $creglement->RG_Banque=$banque;
            $creglement->CT_NumPayeur = $ct_num;
            $creglement->setuserName("",$mobile);
            $RG_NoInsert = $creglement->insertF_Reglement();


            //  $result=$objet->db->requete($objet->addCReglement($ct_num, $_GET['date'], $_GET['montant'], $jo_num, $cg_num, $ca_no, $caissier, $_GET['date'], $libelle, $_GET['impute'],$_GET['RG_Type'],$_GET['mode_reglementRec'],$rg_typereg,0,$banque,$login));

            if(($telephone!="" || $telephone!=null) && $modeReglementRec=="05"){
                $contactD = new ContatDClass(1);
                $contactD->sendSms($telephone,$message);
            }

            if($rg_no_lier==0) {
                $message = 'VERSEMENT DISTANT D\' UN MONTANT DE ' . $montant . ' AFFECTE AU COLLABORATEUR ' . $collaborateur_caissier . ' POUR LE CLIENT ' . $ct_intitule . ' A DATE DU ' . date("d/m/Y", strtotime($date));
                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiMail("Versement distant"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        if (($email != "" || $email != null) && $modeReglementRec == "05") {
                            $this->objetCollection->envoiMail($message, "Versement distant", $email);
                        }
                    }
                }

                $result = $this->db->requete($this->objetCollection->getCollaborateurEnvoiSMS("Versement distant"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    foreach ($rows as $row) {
                        //$collab_intitule = $row->CO_Nom;
                        $telephone = $row->CO_Telephone;
                        if (($telephone != "" || $telephone != null) && $modeReglementRec == "05") {
                            $contactD = new ContatDClass(1);
                            $contactD->sendSms($telephone,$message);
                        }
                    }
                }
            }

            if($rg_no_lier!=0) {
                $RG_No = 0;
                $result = $this->db->requete($this->objetCollection->lastLigneCReglement());
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    $RG_No = $rows[0]->RG_No;
                }

                $this->db->requete($this->objetCollection->insertZ_RGLT_BONDECAISSE($RG_No, $rg_no_lier));

                $CA_No = 0;
                $CO_NoCaissier = 0;

                $result = $this->db->requete($this->objetCollection->getReglementByRG_No ($rg_no_lier));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if ($rows != null) {
                    $CA_No = $rows[0]->CA_No;
                    $CO_NoCaissier = $rows[0]->CO_NoCaissier;
                    $this->db->requete($this->objetCollection->getMajCaisseRGNo($CA_No,$CO_NoCaissier,$RG_No));
                }
                $this->db->requete($this->objetCollection->updateImpute($rg_no_lier));
            }
            $this->objetCollection->incrementeCOLREGLEMENT();
            $result=$this->db->requete($this->objetCollection->lastLigneCReglement());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($afficheData)
            echo json_encode($rows);
        }
        else {
            if($afficheData)
            echo "la date doit être comprise entre $limitmoinsDate et $limitplusDate.";
        }
    }


    public function getReglementByFacture($DO_Domaine,$DO_Type,$DO_Piece){
        $query = "  SELECT A.RG_No
                    FROM F_CREGLEMENT A
                    INNER JOIN F_REGLECH B ON A.RG_No=B.RG_No
                    WHERE DO_Domaine=$DO_Domaine AND DO_Type=$DO_Type AND DO_Piece = $DO_Piece AND EC_No = 0";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new ReglementClass($resultat->RG_No);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function getListeReglementMajComptable($typeTransfert, $datedeb, $datefin,$etatPiece,$caisse){
        $rg_type =0;
        if($typeTransfert==4) $rg_type=1;

        $rg_compta = 0;
        if($etatPiece==1) $rg_compta = 1;

        $query = "SELECT RG_No
                  FROM F_CREGLEMENT
                  WHERE ('$datedeb'='' OR RG_Date>='$datedeb')
                  AND ('$datefin'='' OR RG_Date<='$datefin')
                  AND  RG_Compta = $rg_compta
                  AND RG_Type = $rg_type
                  AND ($caisse=0 OR CA_No = $caisse)";
        $result= $this->db->query($query);
        $this->list = array();
        foreach ($result->fetchAll(PDO::FETCH_OBJ) as $resultat)
        {
            $docEntete = new ReglementClass($resultat->RG_No);
            array_push($this->list,$docEntete);
        }
        return $this->list;
    }

    public function __toString() {
        return "";
    }

    public function formatDate($val){
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $val);
        return $date->format('Y-m-d');
    }

}