<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ArticleClass Extends Objet{
    //put your code here
    public $db,$AR_Ref
    ,$AR_Design
    ,$FA_CodeFamille
    ,$AR_Substitut
    ,$AR_Raccourci
    ,$AR_Garantie
    ,$AR_UnitePoids
    ,$AR_PoidsNet
    ,$AR_PoidsBrut
    ,$AR_UniteVen
    ,$AR_PrixAch
    ,$AR_Coef
    ,$AR_PrixVen
    ,$AR_PrixTTC
    ,$AR_Gamme1
    ,$AR_Gamme2
    ,$AR_SuiviStock
    ,$AR_Nomencl
    ,$AR_Stat01
    ,$AR_Stat02
    ,$AR_Stat03
    ,$AR_Stat04
    ,$AR_Stat05
    ,$AR_Escompte
    ,$AR_Delai
    ,$AR_HorsStat
    ,$AR_VteDebit
    ,$AR_NotImp
    ,$AR_Sommeil
    ,$AR_Langue1
    ,$AR_Langue2
    ,$AR_CodeEdiED_Code1
    ,$AR_CodeEdiED_Code2
    ,$AR_CodeEdiED_Code3
    ,$AR_CodeEdiED_Code4
    ,$AR_CodeBarre
    ,$AR_CodeFiscal
    ,$AR_Pays
    ,$AR_Frais01FR_Denomination
    ,$AR_Frais01FR_Rem01REM_Valeur
    ,$AR_Frais01FR_Rem01REM_Type
    ,$AR_Frais01FR_Rem02REM_Valeur
    ,$AR_Frais01FR_Rem02REM_Type
    ,$AR_Frais01FR_Rem03REM_Valeur
    ,$AR_Frais01FR_Rem03REM_Type
    ,$AR_Frais02FR_Denomination
    ,$AR_Frais02FR_Rem01REM_Valeur
    ,$AR_Frais02FR_Rem01REM_Type
    ,$AR_Frais02FR_Rem02REM_Valeur
    ,$AR_Frais02FR_Rem02REM_Type
    ,$AR_Frais02FR_Rem03REM_Valeur
    ,$AR_Frais02FR_Rem03REM_Type
    ,$AR_Frais03FR_Denomination
    ,$AR_Frais03FR_Rem01REM_Valeur
    ,$AR_Frais03FR_Rem01REM_Type
    ,$AR_Frais03FR_Rem02REM_Valeur
    ,$AR_Frais03FR_Rem02REM_Type
    ,$AR_Frais03FR_Rem03REM_Valeur
    ,$AR_Frais03FR_Rem03REM_Type
    ,$AR_Condition
    ,$AR_PUNet
    ,$AR_Contremarque
    ,$AR_FactPoids
    ,$AR_FactForfait
    ,$AR_DateCreation
    ,$AR_SaisieVar
    ,$AR_Transfere
    ,$AR_Publie
    ,$AR_DateModif
    ,$AR_Photo
    ,$AR_PrixAchNouv
    ,$AR_CoefNouv
    ,$AR_PrixVenNouv
    ,$AR_DateApplication
    ,$AR_CoutStd
    ,$AR_QteComp
    ,$AR_QteOperatoire
    ,$CO_No
    ,$AR_Prevision,$CL_No1
    ,$CL_No2
    ,$CL_No3
    ,$CL_No4
    ,$AR_Type
    ,$RP_CodeDefaut
    ,$cbMarq
    ,$cbCreateur
    ,$cbModification
    ,$Prix_Min
    ,$Prix_Max
    ,$Qte_Gros;

    public $table = 'F_ARTICLE';
    public $lien = 'farticle';

    function __construct($id,$db=null)
    {
        parent::__construct($this->table, $id, 'AR_Ref',$db);

        if($id=="") $id="%20";
        $this->data = $this->getApiJson("/getF_ArticleJSON&arRef=$id");
        if (sizeof($this->data) > 0) {
            $this->AR_Ref = $this->data[0]->AR_Ref;
            $this->AR_Design = $this->data[0]->AR_Design;
            $this->FA_CodeFamille = $this->data[0]->FA_CodeFamille;
            $this->AR_Substitut = $this->data[0]->AR_Substitut;
            $this->AR_Raccourci = $this->data[0]->AR_Raccourci;
            $this->AR_Garantie = $this->data[0]->AR_Garantie;
            $this->AR_UnitePoids = $this->data[0]->AR_UnitePoids;
            $this->AR_PoidsNet = $this->data[0]->AR_PoidsNet;
            $this->AR_PoidsBrut = $this->data[0]->AR_PoidsBrut;
            $this->AR_UniteVen = $this->data[0]->AR_UniteVen;
            $this->AR_PrixAch = $this->data[0]->AR_PrixAch;
            $this->AR_Coef = $this->data[0]->AR_Coef;
            $this->AR_PrixVen = $this->data[0]->AR_PrixVen;
            $this->AR_PrixTTC = $this->data[0]->AR_PrixTTC;
            $this->AR_Gamme1 = $this->data[0]->AR_Gamme1;
            $this->AR_Gamme2 = $this->data[0]->AR_Gamme2;
            $this->AR_SuiviStock = $this->data[0]->AR_SuiviStock;
            $this->AR_Nomencl = $this->data[0]->AR_Nomencl;
            $this->AR_Stat01 = $this->data[0]->AR_Stat01;
            $this->AR_Stat02 = $this->data[0]->AR_Stat02;
            $this->AR_Stat03 = $this->data[0]->AR_Stat03;
            $this->AR_Stat04 = $this->data[0]->AR_Stat04;
            $this->AR_Stat05 = $this->data[0]->AR_Stat05;
            $this->AR_Escompte = $this->data[0]->AR_Escompte;
            $this->AR_Delai = $this->data[0]->AR_Delai;
            $this->AR_HorsStat = $this->data[0]->AR_HorsStat;
            $this->AR_VteDebit = $this->data[0]->AR_VteDebit;
            $this->AR_NotImp = $this->data[0]->AR_NotImp;
            $this->AR_Sommeil = $this->data[0]->AR_Sommeil;
            $this->AR_Langue1 = $this->data[0]->AR_Langue1;
            $this->AR_Langue2 = $this->data[0]->AR_Langue2;
            $this->AR_CodeEdiED_Code1 = $this->data[0]->AR_CodeEdiED_Code1;
            $this->AR_CodeEdiED_Code2 = $this->data[0]->AR_CodeEdiED_Code2;
            $this->AR_CodeEdiED_Code3 = $this->data[0]->AR_CodeEdiED_Code3;
            $this->AR_CodeEdiED_Code4 = $this->data[0]->AR_CodeEdiED_Code4;
            $this->AR_CodeBarre = $this->data[0]->AR_CodeBarre;
            $this->AR_CodeFiscal = $this->data[0]->AR_CodeFiscal;
            $this->AR_Pays = $this->data[0]->AR_Pays;
            $this->AR_Frais01FR_Denomination = $this->data[0]->AR_Frais01FR_Denomination;
            $this->AR_Frais01FR_Rem01REM_Valeur = $this->data[0]->AR_Frais01FR_Rem01REM_Valeur;
            $this->AR_Frais01FR_Rem01REM_Type = $this->data[0]->AR_Frais01FR_Rem01REM_Type;
            $this->AR_Frais01FR_Rem02REM_Valeur = $this->data[0]->AR_Frais01FR_Rem02REM_Valeur;
            $this->AR_Frais01FR_Rem02REM_Type = $this->data[0]->AR_Frais01FR_Rem02REM_Type;
            $this->AR_Frais01FR_Rem03REM_Valeur = $this->data[0]->AR_Frais01FR_Rem03REM_Valeur;
            $this->AR_Frais01FR_Rem03REM_Type = $this->data[0]->AR_Frais01FR_Rem03REM_Type;
            $this->AR_Frais02FR_Denomination = $this->data[0]->AR_Frais02FR_Denomination;
            $this->AR_Frais02FR_Rem01REM_Valeur = $this->data[0]->AR_Frais02FR_Rem01REM_Valeur;
            $this->AR_Frais02FR_Rem01REM_Type = $this->data[0]->AR_Frais02FR_Rem01REM_Type;
            $this->AR_Frais02FR_Rem02REM_Valeur = $this->data[0]->AR_Frais02FR_Rem02REM_Valeur;
            $this->AR_Frais02FR_Rem02REM_Type = $this->data[0]->AR_Frais02FR_Rem02REM_Type;
            $this->AR_Frais02FR_Rem03REM_Valeur = $this->data[0]->AR_Frais02FR_Rem03REM_Valeur;
            $this->AR_Frais02FR_Rem03REM_Type = $this->data[0]->AR_Frais02FR_Rem03REM_Type;
            $this->AR_Frais03FR_Denomination = $this->data[0]->AR_Frais03FR_Denomination;
            $this->AR_Frais03FR_Rem01REM_Valeur = $this->data[0]->AR_Frais03FR_Rem01REM_Valeur;
            $this->AR_Frais03FR_Rem01REM_Type = $this->data[0]->AR_Frais03FR_Rem01REM_Type;
            $this->AR_Frais03FR_Rem02REM_Valeur = $this->data[0]->AR_Frais03FR_Rem02REM_Valeur;
            $this->AR_Frais03FR_Rem02REM_Type = $this->data[0]->AR_Frais03FR_Rem02REM_Type;
            $this->AR_Frais03FR_Rem03REM_Valeur = $this->data[0]->AR_Frais03FR_Rem03REM_Valeur;
            $this->AR_Frais03FR_Rem03REM_Type = $this->data[0]->AR_Frais03FR_Rem03REM_Type;
            $this->AR_Condition = $this->data[0]->AR_Condition;
            $this->AR_PUNet = $this->data[0]->AR_PUNet;
            $this->AR_Contremarque = $this->data[0]->AR_Contremarque;
            $this->AR_FactPoids = $this->data[0]->AR_FactPoids;
            $this->AR_FactForfait = $this->data[0]->AR_FactForfait;
            $this->AR_DateCreation = $this->data[0]->AR_DateCreation;
            $this->AR_SaisieVar = $this->data[0]->AR_SaisieVar;
            $this->AR_Transfere = $this->data[0]->AR_Transfere;
            $this->AR_Publie = $this->data[0]->AR_Publie;
            $this->AR_DateModif = $this->data[0]->AR_DateModif;
            $this->AR_Photo = $this->data[0]->AR_Photo;
            $this->AR_PrixAchNouv = $this->data[0]->AR_PrixAchNouv;
            $this->AR_CoefNouv = $this->data[0]->AR_CoefNouv;
            $this->AR_PrixVenNouv = $this->data[0]->AR_PrixVenNouv;
            $this->AR_DateApplication = $this->data[0]->AR_DateApplication;
            $this->AR_CoutStd = $this->data[0]->AR_CoutStd;
            $this->AR_QteComp = $this->data[0]->AR_QteComp;
            $this->AR_QteOperatoire = $this->data[0]->AR_QteOperatoire;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AR_Prevision = $this->data[0]->AR_Prevision;
            $this->AR_DateApplication = $this->data[0]->AR_DateApplication;
            $this->AR_CoutStd = $this->data[0]->AR_CoutStd;
            $this->AR_QteComp = $this->data[0]->AR_QteComp;
            $this->AR_QteOperatoire = $this->data[0]->AR_QteOperatoire;
            $this->CO_No = $this->data[0]->CO_No;
            $this->AR_Prevision = $this->data[0]->AR_Prevision;
            $this->CL_No1 = $this->data[0]->CL_No1;
            $this->CL_No2 = $this->data[0]->CL_No2;
            $this->CL_No3 = $this->data[0]->CL_No3;
            $this->CL_No4 = $this->data[0]->CL_No4;
            $this->AR_Type = $this->data[0]->AR_Type;
            $this->RP_CodeDefaut = $this->data[0]->RP_CodeDefaut;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbCreateur = $this->data[0]->cbCreateur;
            $this->cbModification = $this->data[0]->cbModification;
            $this->Prix_Min = $this->data[0]->Prix_Min;
            $this->Prix_Max = $this->data[0]->Prix_Max;
            $this->Qte_Gros = $this->data[0]->Qte_Gros;
        }
    }

    public function setuserName($login,$mobile){
        if(!isset($_SESSION))
            session_start();
        if($login!="")
            $this->cbCreateur = $login;
        else
            if($mobile==""){
                $this->cbCreateur = $_SESSION["id"];
            }
    }

    public function maj_article(){
        parent::maj("AR_Design" , $this->AR_Design);
        parent::maj("FA_CodeFamille" , $this->FA_CodeFamille);
        parent::maj("AR_Raccourci" , $this->AR_Raccourci);
        parent::maj("AR_Garantie" , $this->AR_Garantie);
        parent::maj("AR_UnitePoids" , $this->AR_UnitePoids);
        parent::maj("AR_PoidsNet" , $this->AR_PoidsNet);
        parent::maj("AR_PoidsBrut" , $this->AR_PoidsBrut);
        parent::maj("AR_UniteVen" , $this->AR_UniteVen);
        parent::maj("AR_PrixAch" , $this->AR_PrixAch);
        parent::maj("AR_Coef" , $this->AR_Coef);
        parent::maj("AR_PrixVen" , $this->AR_PrixVen);
        parent::maj("AR_PrixTTC" , $this->AR_PrixTTC);
        parent::maj("AR_Gamme1" , $this->AR_Gamme1);
        parent::maj("AR_Gamme2" , $this->AR_Gamme2);
    //    parent::maj("AR_SuiviStock" , $this->AR_SuiviStock);
        parent::maj("AR_Nomencl" , $this->AR_Nomencl);
        parent::maj("AR_Stat01" , $this->AR_Stat01);
        parent::maj("AR_Stat02" , $this->AR_Stat02);
        parent::maj("AR_Stat03" , $this->AR_Stat03);
        parent::maj("AR_Stat04" , $this->AR_Stat04);
        parent::maj("AR_Stat05" , $this->AR_Stat05);
        parent::maj("AR_Escompte" , $this->AR_Escompte);
        parent::maj("AR_Delai" , $this->AR_Delai);
        parent::maj("AR_HorsStat" , $this->AR_HorsStat);
        parent::maj("AR_VteDebit" , $this->AR_VteDebit);
        parent::maj("AR_NotImp" , $this->AR_NotImp);
        parent::maj("AR_Sommeil" , $this->AR_Sommeil);
        parent::maj("AR_Langue1" , $this->AR_Langue1);
        parent::maj("AR_Langue2" , $this->AR_Langue2);
        parent::maj("AR_CodeEdiED_Code1" , $this->AR_CodeEdiED_Code1);
        parent::maj("AR_CodeEdiED_Code2" , $this->AR_CodeEdiED_Code2);
        parent::maj("AR_CodeEdiED_Code3" , $this->AR_CodeEdiED_Code3);
        parent::maj("AR_CodeEdiED_Code4" , $this->AR_CodeEdiED_Code4);
        parent::maj("AR_CodeBarre" , $this->AR_CodeBarre);
        parent::maj("AR_CodeFiscal" , $this->AR_CodeFiscal);
        parent::maj("AR_Pays" , $this->AR_Pays);
        parent::maj("AR_Frais01FR_Denomination" , $this->AR_Frais01FR_Denomination);
        parent::maj("AR_Frais01FR_Rem01REM_Valeur" , $this->AR_Frais01FR_Rem01REM_Valeur);
        parent::maj("AR_Frais01FR_Rem01REM_Type" , $this->AR_Frais01FR_Rem01REM_Type);
        parent::maj("AR_Frais01FR_Rem02REM_Valeur" , $this->AR_Frais01FR_Rem02REM_Valeur);
        parent::maj("AR_Frais01FR_Rem02REM_Type" , $this->AR_Frais01FR_Rem02REM_Type);
        parent::maj("AR_Frais01FR_Rem03REM_Valeur" , $this->AR_Frais01FR_Rem03REM_Valeur);
        parent::maj("AR_Frais01FR_Rem03REM_Type" , $this->AR_Frais01FR_Rem03REM_Type);
        parent::maj("AR_Frais02FR_Denomination" , $this->AR_Frais02FR_Denomination);
        parent::maj("AR_Frais02FR_Rem01REM_Valeur" , $this->AR_Frais02FR_Rem01REM_Valeur);
        parent::maj("AR_Frais02FR_Rem01REM_Type" , $this->AR_Frais02FR_Rem01REM_Type);
        parent::maj("AR_Frais02FR_Rem02REM_Valeur" , $this->AR_Frais02FR_Rem02REM_Valeur);
        parent::maj("AR_Frais02FR_Rem02REM_Type" , $this->AR_Frais02FR_Rem02REM_Type);
        parent::maj("AR_Frais02FR_Rem03REM_Valeur" , $this->AR_Frais02FR_Rem03REM_Valeur);
        parent::maj("AR_Frais02FR_Rem03REM_Type" , $this->AR_Frais02FR_Rem03REM_Type);
        parent::maj("AR_Frais03FR_Denomination" , $this->AR_Frais03FR_Denomination);
        parent::maj("AR_Frais03FR_Rem01REM_Valeur" , $this->AR_Frais03FR_Rem01REM_Valeur);
        parent::maj("AR_Frais03FR_Rem01REM_Type" , $this->AR_Frais03FR_Rem01REM_Type);
        parent::maj("AR_Frais03FR_Rem02REM_Valeur" , $this->AR_Frais03FR_Rem02REM_Valeur);
        parent::maj("AR_Frais03FR_Rem02REM_Type" , $this->AR_Frais03FR_Rem02REM_Type);
        parent::maj("AR_Frais03FR_Rem03REM_Valeur" , $this->AR_Frais03FR_Rem03REM_Valeur);
        parent::maj("AR_Frais03FR_Rem03REM_Type" , $this->AR_Frais03FR_Rem03REM_Type);
        parent::maj("AR_Condition" , $this->AR_Condition);
        parent::maj("AR_PUNet" , $this->AR_PUNet);
        parent::maj("AR_Contremarque" , $this->AR_Contremarque);
        parent::maj("AR_FactPoids" , $this->AR_FactPoids);
        parent::maj("AR_FactForfait" , $this->AR_FactForfait);
        parent::maj("AR_DateCreation" , $this->AR_DateCreation);
        parent::maj("AR_SaisieVar" , $this->AR_SaisieVar);
        parent::maj("AR_Transfere" , $this->AR_Transfere);
        parent::maj("AR_Publie" , $this->AR_Publie);
        parent::maj("AR_DateModif" , $this->AR_DateModif);
        parent::maj("AR_Photo" , $this->AR_Photo);
        parent::maj("AR_PrixAchNouv" , $this->AR_PrixAchNouv);
        parent::maj("AR_CoefNouv" , $this->AR_CoefNouv);
        parent::maj("AR_PrixVenNouv" , $this->AR_PrixVenNouv);
        parent::maj("AR_DateApplication" , $this->AR_DateApplication);
        parent::maj("AR_CoutStd" , $this->AR_CoutStd);
        parent::maj("AR_QteComp" , $this->AR_QteComp);
        parent::maj("AR_QteOperatoire" , $this->AR_QteOperatoire);
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("AR_Prevision" , $this->AR_Prevision);
        parent::maj("AR_DateApplication" , $this->AR_DateApplication);
        parent::maj("AR_CoutStd" , $this->AR_CoutStd);
        parent::maj("AR_QteComp" , $this->AR_QteComp);
        parent::maj("AR_QteOperatoire" , $this->AR_QteOperatoire);
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("cbCO_No" , $this->cbCO_No);
        parent::maj("AR_Prevision" , $this->AR_Prevision);
        parent::maj("cbCreateur" , $this->userName);
        parent::maj("cbModification" , $this->cbModification);
        parent::maj("Prix_Min" , $this->Prix_Min);
        parent::maj("Prix_Max" , $this->Prix_Max);
        parent::maj("Qte_Gros" , $this->Qte_Gros);
        $query= "UPDATE F_ARTICLE SET  
                CL_No1=".$this->CL_No1.",cbCL_No1=(SELECT CASE WHEN ".$this->CL_No1."=0 THEN NULL ELSE ".$this->CL_No1." END),
                CL_No2=".$this->CL_No1.",cbCL_No2=(SELECT CASE WHEN ".$this->CL_No2."=0 THEN NULL ELSE ".$this->CL_No2." END),
                CL_No3=".$this->CL_No1.",cbCL_No3=(SELECT CASE WHEN ".$this->CL_No3."=0 THEN NULL ELSE ".$this->CL_No3." END),
                CL_No4=".$this->CL_No1.",cbCL_No4=(SELECT CASE WHEN ".$this->CL_No4."=0 THEN NULL ELSE ".$this->CL_No4." END),
                AR_Substitut=(SELECT CASE WHEN '".$this->AR_Substitut."'='' THEN NULL ELSE '".$this->AR_Substitut."' END)
                WHERE cbMarq=".$this->cbMarq;
        $this->db->query($query);
        $this->majcbModification();
        parent::maj("cbCreateur" , $this->cbCreateur);
    }

    public function insertArticle() {
        $query = "INSERT INTO [dbo].[F_ARTICLE] 
                    ([AR_Ref],[AR_Design],[FA_CodeFamille],[AR_Substitut],[AR_Raccourci]
                    ,[AR_Garantie],[AR_UnitePoids],[AR_PoidsNet],[AR_PoidsBrut],[AR_UniteVen] 
                    ,[AR_PrixAch],[AR_Coef],[AR_PrixVen],[AR_PrixTTC],[AR_Gamme1],[AR_Gamme2]
                    ,[AR_SuiviStock],[AR_Nomencl],[AR_Stat01],[AR_Stat02],[AR_Stat03],[AR_Stat04],[AR_Stat05] 
                    ,[AR_Escompte],[AR_Delai],[AR_HorsStat],[AR_VteDebit],[AR_NotImp],[AR_Sommeil],[AR_Langue1],[AR_Langue2],[AR_CodeEdiED_Code1]
                    ,[AR_CodeEdiED_Code2],[AR_CodeEdiED_Code3],[AR_CodeEdiED_Code4],[AR_CodeBarre],[AR_CodeFiscal],[AR_Pays] 
                    ,[AR_Frais01FR_Denomination],[AR_Frais01FR_Rem01REM_Valeur],[AR_Frais01FR_Rem01REM_Type],[AR_Frais01FR_Rem02REM_Valeur] 
                    ,[AR_Frais01FR_Rem02REM_Type],[AR_Frais01FR_Rem03REM_Valeur],[AR_Frais01FR_Rem03REM_Type],[AR_Frais02FR_Denomination] 
                    ,[AR_Frais02FR_Rem01REM_Valeur],[AR_Frais02FR_Rem01REM_Type],[AR_Frais02FR_Rem02REM_Valeur],[AR_Frais02FR_Rem02REM_Type] 
                    ,[AR_Frais02FR_Rem03REM_Valeur],[AR_Frais02FR_Rem03REM_Type],[AR_Frais03FR_Denomination],[AR_Frais03FR_Rem01REM_Valeur] 
                    ,[AR_Frais03FR_Rem01REM_Type],[AR_Frais03FR_Rem02REM_Valeur],[AR_Frais03FR_Rem02REM_Type],[AR_Frais03FR_Rem03REM_Valeur] 
                    ,[AR_Frais03FR_Rem03REM_Type],[AR_Condition],[AR_PUNet],[AR_Contremarque],[AR_FactPoids],[AR_FactForfait],[AR_DateCreation],[AR_SaisieVar] 
                    ,[AR_Transfere],[AR_Publie],[AR_DateModif],[AR_Photo],[AR_PrixAchNouv],[AR_CoefNouv],[AR_PrixVenNouv],[AR_DateApplication] 
                    ,[AR_CoutStd],[AR_QteComp],[AR_QteOperatoire],[CO_No],[cbCO_No],[AR_Prevision],[CL_No1],[cbCL_No1],[CL_No2],[cbCL_No2],[CL_No3],[cbCL_No3] 
                    ,[CL_No4],[cbCL_No4],[AR_Type],[RP_CodeDefaut],[cbProt],[cbCreateur] 
                    ,[cbModification],[cbReplication],[cbFlag],Prix_Min,Prix_Max) 
              VALUES 
                    (/*AR_Ref*/'".$this->AR_Ref."',/*AR_Design*/'".$this->AR_Design."' 
                    ,/*FA_CodeFamille*/'".$this->FA_CodeFamille."',/*AR_Substitut*/NULL,/*AR_Raccourci, varchar(7)*/NULL,/*AR_Garantie*/0 
                    ,/*AR_UnitePoids*/2,/*AR_PoidsNet*/0,/*AR_PoidsBrut*/0,/*AR_UniteVen*/(SELECT FA_UniteVen FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                   ,/*AR_PrixAch*/".$this->AR_PrixAch.",/*AR_Coef*/(SELECT FA_Coef FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_PrixVen*/".$this->AR_PrixVen.",/*AR_PrixTTC*/".$this->AR_PrixTTC." 
                    ,/*AR_Gamme1*/0,/*AR_Gamme2*/0,/*AR_SuiviStock*/(SELECT FA_SuiviStock FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Nomencl*/".$this->AR_Nomencl." 
                    ,/*AR_Stat01*/(SELECT FA_Stat01 FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Stat02*/(SELECT FA_Stat02 FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Stat03*/(SELECT FA_Stat03 FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Stat04*/(SELECT FA_Stat04 FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                   ,/*AR_Stat05*/(SELECT FA_Stat05 FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Escompte*/(SELECT FA_Escompte FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Delai*/(SELECT FA_Delai FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_HorsStat*/(SELECT FA_HorsStat FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_VteDebit*/(SELECT FA_VteDebit FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_NotImp*/(SELECT FA_NotImp FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Sommeil*/0,/*AR_Langue1*/'' 
                    ,/*AR_Langue2*/'',/*AR_CodeEdiED_Code1, varchar(35)*/'',/*AR_CodeEdiED_Code2*/'',/*AR_CodeEdiED_Code3*/'' 
                    ,/*AR_CodeEdiED_Code4*/'',/*AR_CodeBarre*/NULL,/*AR_CodeFiscal, varchar(25)*/(SELECT FA_CodeFiscal FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Pays, varchar(35)*/(SELECT FA_Pays FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_Frais01FR_Denomination*/(SELECT FA_Frais01FR_Denomination FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais01FR_Rem01REM_Valeur*/(SELECT FA_Frais01FR_Rem01REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais01FR_Rem01REM_Type*/(SELECT FA_Frais01FR_Rem01REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais01FR_Rem02REM_Valeur*/(SELECT FA_Frais01FR_Rem02REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_Frais01FR_Rem02REM_Type*/(SELECT FA_Frais01FR_Rem02REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais01FR_Rem03REM_Valeur*/(SELECT FA_Frais01FR_Rem03REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais01FR_Rem03REM_Type*/(SELECT FA_Frais01FR_Rem03REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais02FR_Denomination*/(SELECT FA_Frais02FR_Denomination FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                   ,/*AR_Frais02FR_Rem01REM_Valeur*/(SELECT FA_Frais02FR_Rem01REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') ,/*AR_Frais02FR_Rem01REM_Type*/(SELECT FA_Frais02FR_Rem01REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais02FR_Rem02REM_Valeur*/(SELECT FA_Frais02FR_Rem02REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais02FR_Rem02REM_Type*/(SELECT FA_Frais02FR_Rem02REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_Frais02FR_Rem03REM_Valeur*/(SELECT FA_Frais02FR_Rem03REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') ,/*AR_Frais02FR_Rem03REM_Type*/(SELECT FA_Frais02FR_Rem03REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais03FR_Denomination*/(SELECT FA_Frais03FR_Denomination FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais03FR_Rem01REM_Valeur*/(SELECT FA_Frais03FR_Rem01REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                   ,/*AR_Frais03FR_Rem01REM_Type*/(SELECT FA_Frais03FR_Rem01REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais03FR_Rem02REM_Valeur*/(SELECT FA_Frais03FR_Rem02REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais03FR_Rem02REM_Type*/(SELECT FA_Frais03FR_Rem02REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Frais03FR_Rem03REM_Valeur*/(SELECT FA_Frais03FR_Rem03REM_Valeur FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_Frais03FR_Rem03REM_Type*/(SELECT FA_Frais03FR_Rem03REM_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_Condition*/".$this->AR_Condition.",/*AR_PUNet*/".$this->AR_PUNet.",/*AR_Contremarque*/(SELECT FA_Contremarque FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."') 
                    ,/*AR_FactPoids*/(SELECT FA_FactPoids FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_FactForfait*/(SELECT FA_FactForfait FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_DateCreation*/CAST(GETDATE() AS DATE),/*AR_SaisieVar*/ ".$this->AR_SaisieVar." 
                    ,/*AR_Transfere*/0,/*AR_Publie*/(SELECT FA_Publie FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*AR_DateModif*/CAST(GETDATE() AS DATE),/*AR_Photo*/'' 
                    ,/*AR_PrixAchNouv*/0,/*AR_CoefNouv*/0,/*AR_PrixVenNouv*/0,/*AR_DateApplication*/'1900-01-01' 
                    ,/*AR_CoutStd*/0,/*AR_QteComp*/".$this->AR_QteComp.",/*AR_QteOperatoire*/".$this->AR_QteOperatoire.",/*CO_No*/0
                    ,/*cbCO_No*/NULL,/*AR_Prevision*/0,/*CL_No1*/".$this->CL_No1.",/*cbCL_No1*/(SELECT CASE WHEN ".$this->CL_No1."=0 THEN NULL ELSE ".$this->CL_No1." END),/*CL_No2*/".$this->CL_No2.",/*cbCL_No2*/(SELECT CASE WHEN ".$this->CL_No2."=0 THEN NULL ELSE ".$this->CL_No2." END),/*CL_No3*/".$this->CL_No3.",/*cbCL_No3*/(SELECT CASE WHEN ".$this->CL_No3."=0 THEN NULL ELSE ".$this->CL_No3." END) 
                   ,/*CL_No4*/".$this->CL_No4.",/*cbCL_No4*/(SELECT CASE WHEN ".$this->CL_No4."=0 THEN NULL ELSE ".$this->CL_No4." END),/*AR_Type*/(SELECT FA_Type FROM F_Famille WHERE FA_CodeFamille='".$this->FA_CodeFamille."'),/*RP_CodeDefaut*/NULL,/*cbProt*/0,/*cbCreateur, char(4)*/'".$this->userName."' 
                    ,/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0,".$this->Prix_Min.",".$this->Prix_Max.") ";
        $this->db->query($query);
    }

    public function majQteGros(){
        parent::maj("Qte_Gros" , $this->Qte_Gros);
    }

    public function insertFArtClient($ncat){
        $query= "INSERT INTO [dbo].[F_ARTCLIENT]
                            ([AR_Ref],[AC_Categorie],[AC_PrixVen],[AC_Coef]
                            ,[AC_PrixTTC],[AC_Arrondi],[AC_QteMont],[EG_Champ]
                            ,[AC_PrixDev],[AC_Devise],[CT_Num],[AC_Remise]
                            ,[AC_Calcul],[AC_TypeRem],[AC_RefClient],[AC_CoefNouv]
                            ,[AC_PrixVenNouv],[AC_PrixDevNouv],[AC_RemiseNouv],[AC_DateApplication]
                            ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
                      VALUES
                            (/*AR_Ref, varchar(19),*/'".$this->AR_Ref."',/*AC_Categorie*/$ncat,/*AC_PrixVen*/0,/*AC_Coef*/0
                            ,/*AC_PrixTTC*/".$this->AR_PrixTTC.",/*AC_Arrondi*/0,/*AC_QteMont*/0,/*EG_Champ*/0
                            ,/*AC_PrixDev*/0,/*AC_Devise*/0,/*CT_Num*/NULL,/*AC_Remise*/0
                            ,/*AC_Calcul*/0,/*AC_TypeRem*/0,/*AC_RefClient*/'',/*AC_CoefNouv*/0
                            ,/*AC_PrixVenNouv*/0,/*AC_PrixDevNouv*/0,/*AC_RemiseNouv*/0,/*AC_DateApplication*/'1900-01-01'
                            ,/*cbProt*/0,/*cbCreateur, char(4),*/'".$this->userName."',/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)
                 ";
        $this->db->query($query);
    }

    public function insertFArtModele(){
        $query ="INSERT INTO [dbo].[F_ARTMODELE]
                    ([AR_Ref],[MO_No],[AM_Domaine],[cbProt]
                    ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
              VALUES
                    (/*AR_Ref*/'".$this->AR_Ref."',/*MO_No*/(SELECT MAX(MO_No) FROM F_MODELE),/*AM_Domaine*/0,/*cbProt*/0
                    ,/*cbCreateur*/'".$this->userName."',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)";
        $this->db->query($query);
    }

    public function updateF_ArtStockBorne($AR_Ref,$DE_No,$QteMin,$QteMax){
        $query ="   IF EXISTS (SELECT 1 FROM F_ARTSTOCK WHERE AR_Ref='$AR_Ref' AND DE_No=$DE_No)
                    BEGIN
                        UPDATE F_ARTSTOCK SET AS_QteMini=$QteMin,AS_QteMaxi=$QteMax,cbCreateur='{$this->cbCreateur}' WHERE AR_Ref='$AR_Ref' AND DE_No=$DE_No;
                    END
                    ELSE 
                        INSERT INTO [dbo].[F_ARTSTOCK]
                           ([AR_Ref],[DE_No],[AS_QteMini],[AS_QteMaxi]
                           ,[AS_MontSto],[AS_QteSto],[AS_QteRes],[AS_QteCom]
                           ,[AS_Principal],[AS_QteResCM],[AS_QteComCM],[AS_QtePrepa]
                           ,[DP_NoPrincipal],[cbDP_NoPrincipal],[DP_NoControle],[cbDP_NoControle]
                           ,[AS_QteAControler],[cbProt],[cbCreateur],[cbModification]
                           ,[cbReplication],[cbFlag])
                     VALUES
                     (/*AR_Ref*/'$AR_Ref',/*DE_No*/$DE_No
                         ,/*AS_QteMini*/$QteMin,/*AS_QteMaxi*/$QteMax
                         ,/*AS_MontSto*/0,/*AS_QteSto*/0
                         ,/*AS_QteRes*/0,/*AS_QteCom*/0
                         ,/*AS_Principal*/0,/*AS_QteResCM*/0
                         ,/*AS_QteComCM*/0,/*AS_QtePrepa*/0
                         ,/*DP_NoPrincipal*/0,/*cbDP_NoPrincipal*/NULL
                         ,/*DP_NoControle*/0,/*cbDP_NoControle*/NULL
                         ,/*AS_QteAControler*/0,/*cbProt*/0
                         ,/*cbCreateur*/'{$this->cbCreateur}',/*cbModification*/GETDATE()
                         ,/*cbReplication*/0,/*cbFlag*/0)
                    ;";
        $this->db->query($query);
    }

    public function queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$prot_no){
        $valAchat = "";
        if($flagPxRevient!=2 && $flagPxAchat==0)
            $valAchat = ",AR_PrixAch,AR_PrixVen";
        if($flagPxAchat !=0 && $flagPxRevient!=2)
            $valAchat = ",AR_PrixVen";
        if($flagPxAchat ==0 && $flagPxRevient==2)
            $valAchat = ",AR_PrixAch";
        $query="
                
                BEGIN
                SET NOCOUNT ON;
                DECLARE @Sommeil AS INT,
                            @Stock AS INT,
                            @Prix AS INT,
                            @prot_admin AS INT;
    
                    SET @Sommeil = $ar_sommeil
                    SET @Stock = $stockFlag
                    SET @Prix = $prixFlag
                    
                    SELECT * 
                    FROM(select           AR_Sommeil
                                          ,A.AR_Ref
                                          ,AR_Design
                                          ,FA_CodeFamille
                                          ,ROUND(ISNULL(AS_QteSto,0),2) AS_QteSto
                                          ,ROUND(ISNULL(AS_QteStoCumul,0),0) AS_QteStoCumul
                                          ,ROUND(ISNULL(AS_MontSto,0),2) AS_MontSto
                                          ,Prix_Min
                                          ,Prix_Max
                                          ,PROT_User
                                          $valAchat
             FROM F_ARTICLE A 
             LEFT JOIN F_PROTECTIONCIAL P ON A.cbCreateur = CAST(P.PROT_No AS VARCHAR(5))
             LEFT JOIN (SELECT		AR_Ref
                                    ,SUM(ISNULL(AS_MontSto,0)) AS_MontSto
                                    ,SUM(ISNULL(AS_QteSto,0)) AS_QteSto
                                    ,0 AS AS_QteStoCumul
                        FROM		F_ARTSTOCK S 
                        GROUP BY    AR_Ref) S on S.AR_Ref=A.AR_Ref
             WHERE (-1 = @Sommeil OR AR_Sommeil=@Sommeil) 
             AND      (-1 = @Stock OR (@Stock=1 AND AS_QteSto<>0) OR (@Stock=0 AND (AS_QteSto IS NULL OR AS_QteSto = 0)) ) 
             AND      (-1 = @Prix OR (@Prix=1 AND (Prix_Min<>0 AND Prix_Max<>0)) OR (@Prix=0 AND (Prix_Min=0 OR Prix_Min IS NULL OR Prix_Max IS NULL OR Prix_Max=0))) 
                      ) A  
               ";
        return $query;
    }

    public function getPxMinMaxCatCompta($catCompta){
        $query ="   SELECT AC_Coef,AC_PrixVen
                FROM F_ARTCLIENT
                WHERE AR_Ref='".$this->AR_Ref."'
                AND AC_Categorie=$catCompta";
        $result = $this->db->query($query);
        return json_encode($result->fetchAll(PDO::FETCH_OBJ));
    }

    public function listeArticlePagination(){
        if (!empty($_POST) ) {
            /* Useful $_POST Variables coming from the plugin */
            $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
            $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
            $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
            $orderType = $_POST['order'][0]['dir']; // ASC or DESC
            $start  = $_POST["start"];//Paging first record indicator.
            $length = $_POST['length'];//Number of records that the table can display in the current draw
            $flagPxAchat = $_GET["flagPxAchat"];
            $flagPxRevient = $_GET["flagPxRevient"];
            $prot_no = $_GET["PROT_No"];
            /* END of POST variables */
            $ar_sommeil = -1;
            $stockFlag = -1;
            $prixFlag = -1;
            if(isset($_GET['AR_Sommeil']))
                $ar_sommeil = $_GET['AR_Sommeil'];
            if(isset($_GET['stockFlag']))
                $stockFlag= $_GET['stockFlag'];

            if(isset($_GET['prixFlag']))
                $prixFlag = $_GET['prixFlag'];

            $query = $this->queryListeArticle($flagPxAchat,$flagPxRevient,$ar_sommeil,$prixFlag,$stockFlag,$prot_no);
            $result = $this->db->query($query."END;");
            $recordsTotal = count($result->fetchAll(PDO::FETCH_OBJ));

            /* SEARCH CASE : Filtered data */
            if(!empty($_POST['search']['value'])){
                /* WHERE Clause for searching */
                for($i=0 ; $i<count($_POST['columns']);$i++){
                    $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
                    $where[]=" (AR_Design like '%".$_POST['search']['value']."%' OR AR_Ref like '%".$_POST['search']['value']."%') ";
                }

                $where = " WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
                /* End WHERE */

                $sql = sprintf("$query %s", $where);//Search query without limit clause (No pagination)
                $result = $this->db->query($sql." END; ");

                $recordsFiltered = count($result->fetchAll(PDO::FETCH_OBJ));//Count of search result

                /* SQL Query for search with limit and orderBy clauses*/
                $sql = sprintf("$query %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$where,$orderBy,$orderType ,$start , $length);
                //$sql = sprintf("$query %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY %d , %d ", $where ,$orderBy, $orderType ,$start,$length  );
//            $sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $result = $this->db->query($sql." END;");
                $data = $result->fetchAll(PDO::FETCH_OBJ);
            }
            /* END SEARCH */
            else {
                $sql = sprintf("$query ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$orderBy,$orderType ,$start , $length);
                //$sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $result = $this->db->query($sql." END;");
                $data = $result->fetchAll(PDO::FETCH_OBJ);
                $recordsFiltered = $recordsTotal;
            }

            /* Response to client before JSON encoding */
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            );

            echo json_encode($response);

        } else {
            echo "NO POST Query from DataTable";
        }
    }

    public function getArtFournisseur(){
        $query = "SELECT	AF_RefFourniss
                            ,A.CT_Num
                            ,CT_Intitule
                            ,AF_PrixAch
                            ,AF_TypeRem
                            ,AF_Remise
                            ,CASE WHEN AF_TypeRem=0 THEN cast(cast(AF_Remise as numeric(9,2)) as varchar(10)) 
                                    WHEN AF_TypeRem=1 THEN cast(cast(AF_Remise as numeric(9,2)) as varchar(10))+'%' 
                                        ELSE cast(cast(AF_Remise as numeric(9,2)) as varchar(10))+'U' END DL_Remise
                            ,CONCAT(CAST(AF_Conversion AS INT),CONCAT('/',CAST(AF_ConvDiv AS INT))) AF_Conv
                            ,A.cbMarq
                            FROM F_ARTFOURNISS A 
                            LEFT JOIN F_COMPTET B ON A.CT_Num = B.CT_Num
                            WHERE AR_Ref='".$this->AR_Ref."'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteArtFournisseur ($cbMarq){
        $query="DELETE FROM F_ARTFOURNISS WHERE cbMarq = $cbMarq";
        $this->db->query($query);
    }

    public function getArtFournisseurSelect ($cbMarq){
        $query="SELECT  *,
                        CASE WHEN AF_DateApplication='1900-01-01' THEN 0 ELSE AF_DateApplication END DateApplication 
                FROM F_ARTFOURNISS 
                WHERE cbMarq = $cbMarq";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }
    public function getArtFournisseurByTiers ($ct_num){
        return $this->getApiJson("/getArtFournisseurByTiers&ctNum={$this->formatString($ct_num)}");
    }

    public function getPrixClient($ar_ref, $catcompta, $cattarif) {
        return $this->getApiJson("/getPrixClient&arRef=$ar_ref&catCompta=$catcompta&catTarif=$cattarif");
    }


    public function insertArtFournisseur(   $CT_Num,$AF_RefFourniss,$AF_PrixAch,$AF_Unite,
                                            $AF_Conversion,$AF_DelaiAppro,$AF_Garantie,$AF_Colisage,$AF_QteMini,$AF_QteMont,$EG_Champ,
                                            $AF_Principal,$AF_PrixDev,$AF_Devise,$AF_Remise,$AF_ConvDiv,$AF_TypeRem,$AF_CodeBarre,
                                            $AF_PrixAchNouv,$AF_PrixDevNouv,$AF_RemiseNouv,$AF_DateApplication){
        $query = "
                    BEGIN
                    SET NOCOUNT ON;
                    IF EXISTS (SELECT 1 FROM F_ARTFOURNISS WHERE CT_Num = '$CT_Num' AND AR_Ref ='".$this->AR_Ref."') 
                        SELECT 1 Error,'Le fournisseur existe deja !' Msg
                    ELSE
                    BEGIN
                    INSERT INTO [dbo].[F_ARTFOURNISS]
                   ([AR_Ref],[CT_Num],[AF_RefFourniss],[AF_PrixAch]
                   ,[AF_Unite],[AF_Conversion],[AF_DelaiAppro],[AF_Garantie]
                   ,[AF_Colisage],[AF_QteMini],[AF_QteMont],[EG_Champ]
                   ,[AF_Principal],[AF_PrixDev],[AF_Devise],[AF_Remise]
                   ,[AF_ConvDiv],[AF_TypeRem],[AF_CodeBarre],[AF_PrixAchNouv]
                   ,[AF_PrixDevNouv],[AF_RemiseNouv],[AF_DateApplication],[cbProt]
                   ,[cbCreateur],[cbModification],[cbReplication],[cbFlag])
             VALUES
                   (/*AR_Ref*/'".$this->AR_Ref."',/*CT_Num*/'$CT_Num',/*AF_RefFourniss*/'$AF_RefFourniss',/*AF_PrixAch*/$AF_PrixAch
                   ,/*AF_Unite*/$AF_Unite,/*AF_Conversion*/$AF_Conversion,/*AF_DelaiAppro*/$AF_DelaiAppro,/*AF_Garantie*/$AF_Garantie
                   ,/*AF_Colisage*/$AF_Colisage,/*AF_QteMini*/$AF_QteMini,/*AF_QteMont*/$AF_QteMont,/*EG_Champ*/$EG_Champ
                   ,/*AF_Principal*/$AF_Principal,/*AF_PrixDev*/$AF_PrixDev,/*AF_Devise*/$AF_Devise,/*AF_Remise*/$AF_Remise
                   ,/*AF_ConvDiv*/$AF_ConvDiv,/*AF_TypeRem*/$AF_TypeRem,/*AF_CodeBarre*/'$AF_CodeBarre',/*AF_PrixAchNouv*/$AF_PrixAchNouv
                   ,/*AF_PrixDevNouv*/$AF_PrixDevNouv,/*AF_RemiseNouv*/$AF_RemiseNouv,/*AF_DateApplication*/'$AF_DateApplication',/*cbProt*/0
                   ,/*cbCreateur, char(4),*/'',/*cbModification*/GETDATE(),/*cbReplication, int,*/0,/*cbFlag*/0);
                       SELECT 0 Error,@@IDENTITY  Msg
                   END;
                    END;
                   ";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getShortList() {
        return $this->getApiJson("/getShortList");
    }

    public function  getStockDepot($AR_Ref,$DE_No) {
        $query = "
                      SELECT ISNULL(AS_QteMini,0) AS_QteMini,ISNULL(AS_QteMaxi,0) AS_QteMaxi,ISNULL(AS_QteSto,0) AS_QteSto
                      FROM F_ARTSTOCK
                      WHERE AR_Ref='$AR_Ref' AND DE_No=$DE_No;
                    ";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function ArticleDoublons(){
        $query="SELECT AR_Design
                FROM (
                SELECT AR_Design,COUNT(AR_Ref) Nb
                FROM F_ARTICLE
                GROUP BY AR_Design)A
                WHERE Nb>1";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function stockMinDepasse($de_no){
        return $this->getApiJson("/stockMinDepasse&deNo=$de_no&arRef={$this->AR_Ref}");
    }

    public function getArticleByIntitule($intitule){
        $query="SELECT AR_Ref
                FROM F_ARTICLE
                WHERE AR_Design='$intitule'";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function isStock($de_no){
        $this->lien = "fartstock";
        return $this->getApiJson("/isStockJSON&arRef={$this->AR_Ref}&deNo=$de_no");
    }

    public function insertF_ArtStock($de_no, $montStock, $qte)
    {
        $query= "INSERT INTO [dbo].[F_ARTSTOCK]
           ([AR_Ref],[DE_No],[AS_QteMini],[AS_QteMaxi]
           ,[AS_MontSto],[AS_QteSto],[AS_QteRes],[AS_QteCom]
           ,[AS_Principal],[AS_QteResCM],[AS_QteComCM],[AS_QtePrepa]
           ,[DP_NoPrincipal],[cbDP_NoPrincipal],[DP_NoControle],[cbDP_NoControle]
           ,[AS_QteAControler],[cbProt],[cbCreateur],[cbModification]
           ,[cbReplication],[cbFlag])
     VALUES
           (/*AR_Ref*/'{$this->AR_Ref}',/*DE_No*/$de_no
           ,/*AS_QteMini*/0,/*AS_QteMaxi*/0
           ,/*AS_MontSto*/ROUND($montStock,2),/*AS_QteSto*/$qte
           ,/*AS_QteRes*/0,/*AS_QteCom*/0
           ,/*AS_Principal*/0,/*AS_QteResCM*/0
           ,/*AS_QteComCM*/0,/*AS_QtePrepa*/0
           ,/*DP_NoPrincipal*/0,/*cbDP_NoPrincipal*/NULL
           ,/*DP_NoControle*/0,/*cbDP_NoControle*/NULL
           ,/*AS_QteAControler*/0,/*cbProt*/0
           ,/*cbCreateur*/'AND',/*cbModification*/GETDATE()
           ,/*cbReplication*/0,/*cbFlag*/0)";
        $this->db->query($query);
    }

    public function updateArtStockReel($de_no, $qte)
    {
        $query = "UPDATE F_ARTSTOCK SET AS_QteCom=AS_QteCom+ $qte ,cbModification=GETDATE() WHERE DE_No=$de_no AND AR_Ref='{$this->AR_Ref}'";
        $this->db->requete($query);
    }


    public function updateArtStock($de_no, $qte, $montant)
    {
        $this->lien = "fartstock";
        $this->getApiExecute("/updateArtStock&arRef={$this->AR_Ref}&deNo=$de_no&montant=$montant&qte=$qte");
    }

    public function setASQteMaxiArtStock($de_no){
        $this->lien = "fartstock";
        $this->getApiExecute("/setASQteMaxiArtStock&arRef={$this->AR_Ref}&deNo=$de_no");
    }


    public function __toString() {
        return "";
    }

    public function majRefArticle($newRef){
        $query="BEGIN 
                    SET NOCOUNT ON;
                        DECLARE @ref_ancien AS VARCHAR(30)
                        DECLARE @ref_nouveau AS VARCHAR(30)
                        SET @ref_ancien='{$this->AR_Ref}'
                        SET @ref_nouveau='$newRef'
                        
                        UPDATE [F_DOCLIGNE] SET AR_Ref=@ref_nouveau WHERE AR_Ref= @ref_ancien
                        UPDATE [F_LIGNEARCHIVE] SET AR_Ref=@ref_nouveau WHERE AR_Ref= @ref_ancien
                        UPDATE F_ARTSTOCK SET	AS_QteSto= F_ARTSTOCK.AS_QteSto+A.AS_QteSto
                                                ,AS_MontSto=F_ARTSTOCK.AS_MontSto+A.AS_MontSto
                                                ,AS_QteRes=F_ARTSTOCK.AS_QteRes+A.AS_QteRes
                                                ,AS_QteCom=F_ARTSTOCK.AS_QteCom+A.AS_QteCom
                        FROM (	SELECT AR_Ref,DE_No,AS_QteSto,AS_MontSto,AS_QteRes,AS_QteCom
                                FROM F_ARTSTOCK
                                WHERE AR_Ref=@ref_ancien)A
                        WHERE	A.DE_No = F_ARTSTOCK.DE_No 
                                AND F_ARTSTOCK.AR_Ref=@ref_nouveau
                        
                        UPDATE [F_ARTSTOCK] SET AS_QteSto = 0
                                                ,AS_QteRes = 0
                                                ,AS_QteCom = 0
                                                ,AS_QteResCM = 0
                                                ,AS_QteComCM = 0
                                                ,AS_QtePrepa = 0
                                                ,AS_QteAControler = 0
                                                ,AS_MontSto = 0
                        WHERE AR_Ref= @ref_ancien
                      
                        DELETE FROM [F_ARTSTOCK] WHERE AR_Ref= @ref_ancien
                      
                        UPDATE F_ARTICLE SET AR_Sommeil = 1 WHERE AR_Ref = @ref_ancien;      
                    END;";
        $this->db->query($query);

    }

    public function getAllArticleDispoByArRef($de_no,$codeFamille=0,$intitule = "")
    {
        $value =str_replace(" ","%",$intitule);
        $this->list = $this->getApiJson("/getAllArticleDispoByArRef&deNo=$de_no&codeFamille=$codeFamille&valeur=$value");
        return $this->list;
    }

    public function all($sommeil=-1,$intitule="",$top=0,$arPublie=-1){
        $valeurSaisie =str_replace(" ","%",$intitule);
        $value = "";
        if($top!=0)
            $value = "TOP $top";
        $query = "SELECT  $value AR_Type
                          ,AR_Sommeil
                          ,AR_Ref
                          ,AR_Design
                          ,AR_Ref as id
                          ,CONCAT(CONCAT(AR_Ref,' - '),AR_Design) as text
                          ,CONCAT(CONCAT(AR_Ref,' - '),AR_Design) as value
                        ,AR_PrixAch
                        ,AR_PrixVen
                  FROM F_ARTICLE
                  WHERE -1=$arPublie OR AR_Publie=$arPublie
                  AND -1=$sommeil OR AR_Sommeil=$sommeil
                  AND CONCAT(CONCAT(AR_Ref,' - '),AR_Design) LIKE '%{$valeurSaisie}%'";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }

    public function allSearch($arPublie,$sommeil,$intitule){
        $valeurSaisie =str_replace(" ","%",$intitule);
        return $this->getApiJson("/allSearch&arPublie{$arPublie}&sommeil={$sommeil}&valeurSaisie={$this->formatString($valeurSaisie)}");
    }
}