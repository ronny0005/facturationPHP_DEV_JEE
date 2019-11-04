<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CollaborateurClass Extends Objet{
    //put your code here
    public $db,$CO_No,$CO_Nom,$CO_Prenom,$CO_Fonction,$CO_Adresse
    ,$CO_Complement,$CO_CodePostal,$CO_Ville,$CO_CodeRegion
    ,$CO_Pays,$CO_Service,$CO_Vendeur,$CO_Caissier
    ,$CO_DateCreation,$CO_Acheteur,$CO_Telephone,$CO_Telecopie
    ,$CO_EMail,$CO_Receptionnaire,$PROT_No,$CO_TelPortable,$CO_ChargeRecouvr,$cbCreateur;
    public $table = '.dbo.F_COLLABORATEUR';
    public $lien ="fcollaborateur";

    function __construct($id)
    {
        $this->class="fcollaborateur";
        $this->data = $this->getApiJson("/$id");
        if (sizeof($this->data)>0) {

            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_Nom = stripslashes($this->data[0]->CO_Nom);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_Fonction = stripslashes($this->data[0]->CO_Fonction);
            $this->CO_Adresse = stripslashes($this->data[0]->CO_Adresse);
            $this->CO_Complement = stripslashes($this->data[0]->CO_Complement);
            $this->CO_Ville = stripslashes($this->data[0]->CO_Ville);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_EMail = stripslashes($this->data[0]->CO_EMail);
            $this->CO_Prenom = stripslashes($this->data[0]->CO_Prenom);
            $this->CO_CodePostal = $this->data[0]->CO_CodePostal;
            $this->CO_CodeRegion = $this->data[0]->CO_CodeRegion;
            $this->CO_Pays = $this->data[0]->CO_Pays;
            $this->CO_Service = stripslashes($this->data[0]->CO_Service);
            $this->CO_Vendeur = stripslashes($this->data[0]->CO_Vendeur);
            $this->CO_Caissier = $this->data[0]->CO_Caissier;
            $this->CO_DateCreation = $this->data[0]->CO_DateCreation;
            $this->CO_Acheteur = $this->data[0]->CO_Acheteur;
            $this->CO_Telephone = $this->data[0]->CO_Telephone;
            $this->CO_Receptionnaire = $this->data[0]->CO_Receptionnaire;
            $this->PROT_No = $this->data[0]->PROT_No;
            $this->CO_TelPortable = $this->data[0]->CO_TelPortable;
            $this->CO_ChargeRecouvr = $this->data[0]->CO_ChargeRecouvr;
            $this->cbCreateur = $this->data[0]->cbCreateur;
        }
    }

    public function maj_collaborateur(){
        parent::maj(CO_No, $this->CO_No);
        parent::maj(CO_Nom, $this->CO_Nom);
        parent::maj(CO_Prenom, $this->CO_Prenom);
        parent::maj(CO_Fonction, $this->CO_Fonction);
        parent::maj(CO_Adresse, $this->CO_Adresse);
        parent::maj(CO_Complement, $this->CO_Complement);
        parent::maj(CO_Ville, $this->CO_Ville);
        parent::maj(CO_Prenom, $this->CO_Prenom);
        parent::maj(CO_EMail, $this->CO_EMail);
        parent::maj(CO_CodePostal, $this->CO_CodePostal);
        parent::maj(CO_CodeRegion, $this->CO_CodeRegion);
        parent::maj(CO_Service, $this->CO_Service);
        parent::maj(CO_Vendeur, $this->CO_Vendeur);
        parent::maj(CO_Caissier, $this->CO_Caissier);
        parent::maj(CO_DateCreation, $this->CO_DateCreation);
        parent::maj(CO_Acheteur, $this->CO_Acheteur);
        parent::maj(CO_Telephone, $this->CO_Telephone);
        parent::maj(CO_Receptionnaire, $this->CO_Receptionnaire);
        parent::maj(PROT_No, $this->PROT_No);
        parent::maj(CO_TelPortable, $this->CO_TelPortable);
        parent::maj(CO_ChargeRecouvr, $this->CO_ChargeRecouvr);
        parent::maj("cbCreateur", $this->userName);
    }


    public function allCaissier(){
        return $this->getApiJson("/allCaissier"); //converts to an object
    }

    public function allAcheteur(){
        return $this->getApiJson("/allCaissier"); //converts to an object
    }

    public function allVendeur(){
        return $this->getApiJson("/allVendeur"); //converts to an object
    }

    public function __toString() {
        return "";
    }

    public function insertCollaborateur($nom, $prenom, $adresse, $complement, $codepostal, $fonction, $ville, $region, $pays, $service, $vendeur, $caissier, $acheteur, $telephone, $telecopie, $email, $controleur, $recouvrement)
    {
        $requete = "INSERT INTO [dbo].[F_COLLABORATEUR]
           ([CO_No],[CO_Nom],[CO_Prenom],[CO_Fonction],[CO_Adresse]
           ,[CO_Complement],[CO_CodePostal],[CO_Ville],[CO_CodeRegion]
           ,[CO_Pays],[CO_Service],[CO_Vendeur],[CO_Caissier]
           ,[CO_DateCreation],[CO_Acheteur],[CO_Telephone],[CO_Telecopie]
           ,[CO_EMail],[CO_Receptionnaire],[PROT_No],[cbPROT_No]
           ,[CO_TelPortable],[CO_ChargeRecouvr],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*CO_No*/ISNULL((SELECT MAX(CO_No)CO_No FROM F_COLLABORATEUR),0)+1,/*CO_Nom*/'$nom',/*CO_Prenom*/'$prenom'
           ,/*CO_Fonction*/'$fonction',/*CO_Adresse*/'$adresse'
           ,/*CO_Complement*/'$complement',/*CO_CodePostal*/'$codepostal'
           ,/*CO_Ville*/'$ville',/*CO_CodeRegion*/'$region'
           ,/*CO_Pays*/'$pays',/*CO_Service*/'$service'
           ,/*CO_Vendeur*/$vendeur,/*CO_Caissier*/$caissier
           ,/*CO_DateCreation*/GETDATE(),/*CO_Acheteur*/$acheteur
           ,/*CO_Telephone*/'$telephone',/*CO_Telecopie*/'$telecopie'
           ,/*CO_EMail*/'$email',/*CO_Receptionnaire*/$controleur
           ,/*PROT_No*/0,/*cbPROT_No*/NULL
           ,/*CO_TelPortable*/'',/*CO_ChargeRecouvr*/$recouvrement
           ,/*cbProt*/0,/*cbCreateur*/'AND'
           ,/*cbModification*/GETDATE(),/*cbReplication*/0,/*cbFlag*/0)
";
        $this->db->query($requete);
    }


    public function modifCollaborateur($nom, $prenom, $adresse, $complement, $codepostal, $fonction, $ville, $region, $pays, $service, $vendeur, $caissier, $acheteur, $telephone, $telecopie, $email, $controleur, $recouvrement, $co_no)
    {
        $requete = "UPDATE [dbo].[F_COLLABORATEUR]
                SET [CO_Nom] = '$nom',[CO_Prenom] = '$prenom',[CO_Fonction] = '$fonction',[CO_Adresse] = '$adresse'
                   ,[CO_Complement] = '$complement',[CO_CodePostal] = '$codepostal',[CO_Ville] = '$ville',[CO_CodeRegion] = '$region'
                   ,[CO_Pays] = '$pays',[CO_Service] = '$service',[CO_Vendeur] = $vendeur,[CO_Caissier] = $caissier
                   ,[CO_Acheteur] = $acheteur,[CO_Telephone] = '$telephone'
                   ,[CO_Telecopie] = '$telecopie',[CO_EMail] = '$email',[CO_Receptionnaire] = $controleur
                   ,[CO_ChargeRecouvr] = $recouvrement
                   ,[cbModification] = GETDATE()
             WHERE [CO_No] = $co_no
             ";
        $this->db->query($requete);
    }


}