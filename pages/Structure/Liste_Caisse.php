<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];

    $protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
    $flagProtected = $protection->protectedType("caisse");
    $flagSuppr = $protection->SupprType("caisse");
    $flagNouveau = $protection->NouveauType("caisse");
?>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/script_listeCaisse.js?d=<?php echo time(); ?>"></script>
</head>
<body>
    <?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
        <section style="background-color: rgb(19,72,34);margin: 0px;padding: 5px;">
            <h1 class="text-center" style="color: rgb(255,255,255);">LISTE CAISSE</h1>
        </section>

        <div class="corps">
        <input type="hidden" id="mdp" value="<?= $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?= $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete">
    <legend class="entete">Liste dépôt</legend>
<div class="form-group">
<form action="listeCaisse" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
        <?php if($flagNouveau){ ?>
            <td style="float:right"><a href=ficheCaisse"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table table-striped">
        <thead>
            <th>Intitulé</th>
            <?= ($flagSuppr) ? "<th></th>" : "" ?>
        </thead>
    <tbody id="liste_depot">
        <?php
        
        $objet = new ObjetCollector();
        $caisseClass = new CaisseClass(0);
            foreach ($caisseClass->all() as $row){
                echo "<tr class='article' id='article_{$row->CA_No}'>
                        <td><a href='ficheCaisse-{$row->CA_No}'>{$row->CA_Intitule}</a></td>";
                        if($flagSuppr) echo "<td><a href='Traitement\Depot.php?acte=suppr&CA_No={$row->CA_No}' onclick=\"if(window.confirm('Voulez-vous vraiment supprimer ".$row->CA_Intitule." ?')){return true;}else{return false;}\"><i class='fa fa-trash-o'></i></a></td>";
                        echo "</tr>";
            }
      ?>
</tbody>
</table>
 </div>   
</div>
 
</div>
