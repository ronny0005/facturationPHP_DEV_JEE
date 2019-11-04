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
class PlanComptable {
    public function doAction($action) {
            switch($action) {
                    case 1 : 
                        $this->Plan_comptable(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 2 : 
                        $this->Creation_Plan_comptable(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 3 : 
                        $this->Plan_analytique(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 4 : 
                        $this->Creation_Plan_analytique(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 5 : 
                        $this->Taxe(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 6 : 
                        $this->Creation_Taxe(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 7 : 
                        $this->Journaux(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 8 : 
                        $this->Creation_Journaux(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 9 : 
                        $this->Banque(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 10 : 
                        $this->Creation_Banque(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 11 : 
                        $this->ModeReglement(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 12 : 
                        $this->Creation_ModeReglement(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 13 : 
                        $this->Liste_journauxExercice(); //rechercher un étudiant par domaine d'activité 
                        break;
                    case 14 : 
                        $this->Saisie_journauxExercice(); //rechercher un étudiant par domaine d'activité 
                        break;
                case 15 :
                    $this->Controle_de_caisse(); //rechercher un étudiant par domaine d'activité
                    break;
                case 16 :
                    $this->mise_a_jour_comptable(); //rechercher un étudiant par domaine d'activité
                    break;
                    default : 
                            $this->Plan_comptable(); // On décide ce que l'on veut faire		
            }
    }

    public function Plan_comptable() {
        include("pages/Structure/PlanComptable/PlanComptable.php");
    }
    public function Creation_Plan_comptable() {
        include("pages/Structure/PlanComptable/CreationPlanComptable.php");
    }
    
    public function Plan_analytique() {
        include("pages/Structure/PlanComptable/PlanAnalytique.php");
    }
    public function Creation_Plan_analytique() {
        include("pages/Structure/PlanComptable/CreationPlanAnalytique.php");
    }
    public function Taxe() {
        include("pages/Structure/PlanComptable/Taxe.php");
    }
    public function Creation_Taxe() {
        include("pages/Structure/PlanComptable/CreationTaxe.php");
    }
    public function Journaux() {
        include("pages/Structure/PlanComptable/Journaux.php");
    }
    public function Creation_Journaux() {
        include("pages/Structure/PlanComptable/CreationJournaux.php");
    }
    public function Banque() {
        include("pages/Structure/PlanComptable/Banque.php");
    }
    public function Creation_Banque() {
        include("pages/Structure/PlanComptable/CreationBanque.php");
    }
    public function ModeReglement() {
        include("pages/Structure/PlanComptable/ModeReglement.php");
    }
    public function Creation_ModeReglement() {
        include("pages/Structure/PlanComptable/CreationModeReglement.php");
    }
    public function Liste_journauxExercice() {
        include("pages/Structure/PlanComptable/Liste_journauxExercice.php");
    }
    public function Saisie_journauxExercice() {
        include("pages/Structure/PlanComptable/SaisieJournalExercice.php");
    }
    public function Controle_de_caisse() {
        include("pages/Structure/PlanComptable/Controle_de_caisse.php");
    }
    public function mise_a_jour_comptable() {
        include("pages/Structure/PlanComptable/Mise_a_jour_comptable.php");
    }
}
?>
