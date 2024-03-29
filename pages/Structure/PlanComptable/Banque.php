<?php
    $objet = new ObjetCollector();   
    $depot=$_SESSION["DE_No"];  
    $protected = 0;
    $val=0;
    $action=0;
    $module=0;
    if(isset($_GET["action"])) $action = $_GET["action"];
    if(isset($_GET["module"])) $module = $_GET["module"];

    if(isset($_GET["type"])) $val=$_GET["type"];
    $result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));     
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows!=null){
        if($rows[0]->PROT_ARTICLE==1 || $rows[0]->PROT_ARTICLE==3) $protected = $rows[0]->PROT_ARTICLE;
    }
?>
<script src="js/jquery.dynatable.js" type="text/javascript"></script>
<script src="js/Structure/Comptabilite/script_listeBanque.js"></script>
</head>

<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
<div id="milieu">    
    <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
<div class="corps">        
        <input type="hidden" id="mdp" value="<?php echo $_SESSION["mdp"]; ?>"/>
        <input type="hidden" id="login" value="<?php echo $_SESSION["login"]; ?>"/>
   
     <div class="col-md-12">

<fieldset class="entete">
<legend class="entete">Liste des banques</legend>
<div class="form-group">
<form action="indexMVC.php?module=9&action=9" method="GET">
    <table style="margin-bottom: 20px;width:100%">
    <thead>
        <tr>
            <!--<td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_ref" placeholder="Rechercher" /></td>
            <td><input type="text" class="form-control" name="rechercher"  style="width : 200px" value="" id="rechercher_article_design" placeholder="Rechercher" /></td>-->
            <?php if($protected!=1){ ?><td style="float:right"><a href="indexMVC.php?module=9&action=10"><button type="button" id="nouveau" class="btn btn-primary">Nouveau</button></a></td> <?php } ?>
        </tr>
        </form>
</table>
<div class="err" id="add_err"></div>
<table id="table" class="table">
    <thead style="background-color: #dbdbed;color:black">
            <th>Intitulé</th>
            <th>Code postal</th>
            <th>Ville</th>
    </thead>
    <tbody id="liste_Banque">
        <?php
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->getBanque());     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $classe="";
        $i=0;
        if($rows==null){
            echo "<tr><td>Aucun élément trouvé ! </td><td></td><td></td></tr>";
        }else{
            foreach ($rows as $row){
            $i++;
            if($i%2==0) $classe = "info";
                    else $classe="";
            echo "<tr class='article $classe' id='compte_".$row->BQ_No."'>"
                    . "<td><a href='indexMVC.php?module=9&action=10&BQ_No=".$row->BQ_No."'>".$row->BQ_Intitule."</a></td>"
                    . "<td>".$row->BQ_CodePostal."</td>"
                    . "<td>".$row->BQ_Ville."</td>";
                    echo "</tr>";
            }
        }
      ?>
</tbody>
</table>
 </div>

   
</div>
 
</div>
