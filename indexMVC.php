<!DOCTYPE html>
<?php
    session_start();
    include("Modele/DB.php");
    include("Modele/Objet.php");
    include("Modele/ObjetCollector.php");
    include("Modele/CaisseClass.php");
    include("Modele/CollaborateurClass.php");
    include("Modele/JournalClass.php");
    include("Modele/DepotClass.php");
    include("Modele/DepotCaisseClass.php");
    include("Modele/DepotUserClass.php");
    include("Modele/DocEnteteClass.php");
    include("Modele/CatComptaClass.php");
    include("Modele/EtatClass.php");
    include("modele/ReglementClass.php");
    include("modele/LiaisonEnvoiMailUser.php");
    include("Modele/LiaisonEnvoiSMSUser.php");
    include("Modele/ContatDClass.php");
    include("Modele/DocLigneClass.php");
    include("Modele/ComptetClass.php");
    include("Modele/CatTarifClass.php");
    include("Modele/ProtectionClass.php");
    include("Modele/TaxeClass.php");
    include("Modele/FamilleClass.php");
    include("Modele/ArticleClass.php");
    include("Modele/F_TarifClass.php");
    include("module/Menu.php");
    include("module/Facturation.php");
    include("module/MenuAchat.php");
    include("module/Creation.php");
    include("module/Mouvement.php");
    include("module/Caisse.php");
    include("module/Etat.php");
    include("module/Admin.php");
include("module/PlanComptable.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css" media="screen" />
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery-ui.theme.css" rel="stylesheet">
    <link href="css/fieldset.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

    <script src="js/jquery.js"></script>
    <script src="js/notify.js"></script>
    <script src="js/jquery_ui.js"></script>
    <script src="js/bootstrap-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/bootstrap-clockpicker.js"></script>
    <script src="js/scriptCombobox.js"></script>
    <script src="js/jqModal.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/jquery.fileupload.js"></script>
    <script src="js/scriptFonctionUtile.js?d=<?php echo time(); ?>"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
    <link rel="stylesheet" href="css/select2.min.css">
    <link rel="stylesheet" href="css/select2-bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <?php
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
            $module = new Menu(); // Par defaut on fait l'action 1 du module 1
            $action = 1;
            if(isset($_GET['module'])){
                    switch($_GET['module']){
                            case 1 : //Rien a faire, dÃ©jÃ  fait plus haut//$module = new Module1();
                            break;
                            case 2 : 
                                $module = new Facturation();
                            break;
                            case 3 : 
                                $module = new Creation();
                            break;
                            case 4 : 
                                $module = new Mouvement();
                             break;
                            case 5 : 
                                $module = new Etat();
                            break;
                            case 6 : 
                                $module = new Caisse();
                            break;
                            case 7 : 
                                $module = new MenuAchat();
                            break;
                            case 8 : 
                                $module = new Admin();
                            break;
                            case 9 : 
                                $module = new PlanComptable();
                            break;
                    }
            }
            // On rÃ©cupï¿½&#168;re l'action faite..
            if(isset($_GET['action'])) 
                    $action = (int)$_GET['action'];
            // On demande au module concernÃ© de gÃ©rer l'action associÃ©e.
            $module->doAction($action);
            
            //redirection à la page d'accueil a la deconnexion
            if(isset($_GET['action']) && ($_GET['action'] == 'logout'))
            {
                $_SESSION = array();
                unset($_SESSION['login']);
                unset($_SESSION['mdp']);
                unset($_SESSION["DE_No"]);
                unset($_SESSION["CT_Num"]);
                unset($_SESSION["DO_Souche"]);
                unset($_SESSION["Affaire"]);
                unset($_SESSION["Vehicule"]);
                unset($_SESSION["CO_No"]);
                unset($_SESSION["id"]);
                session_destroy();
                ob_get_clean();
                header("location:index.php");
            }
            ?>
</div></div>
</body>
</html>