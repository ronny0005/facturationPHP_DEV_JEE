<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 * @author Test
 */
class Facturation {

    public function doAction($action) {
        $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
        if($protection->Prot_No !=null){
            switch($action) {
                    case 1 :
                        if($protection->protectionListeFacture($_GET["type"]))
                            $this->Facture_Vente();
                        else
                            header('Location: indexMVC_.Newphp?accueil'); //rechercher un étudiant par domaine d'activité
                        break;
                    case 3 :
                        if($protection->protectionListeFacture($_GET["type"]))
                            $this->Facturation_Vente();
                        else
                            header('Location: indexMVC_.Newphp?accueil'); //rechercher un étudiant par domaine d'activité
                        break;
/*                case 13 :
                    if($protection->PROT_Right==1 || ($protection->PROT_DOCUMENT_VENTE_FACTURE!=2))
                        $this->Facturation_Ticket();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;
                case 14 :
                    if($protection->PROT_Right==1 || ($protection->PROT_VENTE_COMPTOIR!=2))
                        $this->Ticket();
                    else
                        header('Location: indexMVC.php?module=1&action=1'); //rechercher un étudiant par domaine d'activité
                    break;*/
                    default : 
                            $this->Facture_Vente(); // On décide ce que l'on veut faire		
            }
        } else 
            header('Location: index.php');
    }


    public function Facture_Vente() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/listeFactureController.php");
        include("pages/ListeFacture.php");
    }
    public function Facturation_Vente() {
        include("module/Menu/SetParamGlobal.php");
        include("controller/FactureController.php");
        include("pages/Vente/FactureVente.php");
    }
/*    public function Ticket() {
        include("pages/Vente/FactureVente.php");
    }
    public function Facturation_Ticket() {
        include("module/Menu/BarreMenu.php");
        include("pages/ListeFacture_old.php");
    }*/
}
?>