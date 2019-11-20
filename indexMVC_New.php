<?php
session_start();
if(!isset($_SESSION))
    header('Location: connexion'); //rechercher un étudiant par domaine d'activité

?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
    <link rel="stylesheet" href="assets/css/customIT.css">
    <link rel="stylesheet" href="assets/css/Data-Table-1.css">
    <link rel="stylesheet" href="assets/css/Data-Table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.jqueryui.min.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/input.css">
    <link rel="stylesheet" href="assets/css/select.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">
    <link href="css/jquery-ui.theme.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" rel="stylesheet">

</head>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.jqueryui.min.js"></script>
<script src="assets/js/bs-charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script src="assets/js/theme.js"></script>
<script src="assets/js/My-Date-Picker.js"></script>
<script src="assets/js/customIT.js"></script>
<script src="js/scriptCombobox.js"></script>
<?php
    include("module/includeHeader.php");
    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
?>
<body id="page-top">
<div id="wrapper">
    <?php include ("module/Menu/barreMenuGauche.php"); ?>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id=""><!-- content -->
            <?php include ("module/Menu/barreMenuHaut.php");

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
        </div>

        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Brand 2019</span></div>
            </div>
        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>
</body>

</html>