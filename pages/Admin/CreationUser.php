<?php
    $id = 0;
    $username = "";
    $description = "";
    $password = "";
    $email="";
    $depot_no="";
    $caisse_no="";
    $objet = new ObjetCollector(); 
    if(isset($_GET["id"])){
        $objet = new ObjetCollector();   
        $result=$objet->db->requete($objet->UsersByid($_GET["id"]));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $classe="";
        if($rows==null){
        }else{
            $id = $rows[0]->PROT_No;
            $username = $rows[0]->PROT_User;
            $description = $rows[0]->PROT_Description;
            $depot_no=$rows[0]->DE_No;
            $caisse_no=$rows[0]->CA_No;
            $password = $objet->decrypteMdp($rows[0]->PROT_Pwd);
            $groupeid = $rows[0]->PROT_Right;
            $profiluser= $rows[0]->PROT_UserProfil;
            $email= $rows[0]->PROT_EMail;
            //ancien profil
            $resultdefautprofil=$objet->db->requete($objet->getProfilByid($profiluser));
            $rowsdefautprofil = $resultdefautprofil->fetchAll(PDO::FETCH_OBJ);
            if($rowsdefautprofil==null){
            }else{
                 $designationprofil=$rowsdefautprofil[0]->PROT_User;
            }
        }
    }
    
//    if(isset($_GET["ajouter"]) ||isset($_GET["modifier"]) ){
//        $username = $_GET["username"];
//        $password = $_GET["password"];
//        $email = $_GET["email"];
//        $groupeid = $_GET["groupeid"];
//        //$profiluser = $_GET["profiluser"];
//        $description= $_GET["description"];
//    }
?>
<script src="js/script_creationUser.js?d=<?php echo time(); ?>"></script>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
?>
</head>
<div id="milieu">    
    <div class="container">
            
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>
</div>
    <div class="err" id="add_err"></div>
    <form id="formUser" class="formUser" action="indexMVC.php?module=8&action=4" method="GET">
        <input name="action" value="4" type="hidden"/>
        <input name="module" value="8" type="hidden"/>
		<input name="id" id="id" value="<?php echo "$id"; ?>" type="hidden"/>
        <div><h1>Fiche Utilisateur</h1></div>
        <div class="form-group col-lg-3" >
            <label> Nom : </label>
            <input value="<?php echo $username; ?>" name="username" type="text" class="form-control" id="username" placeholder="Nom et prenom"/>
        </div>
        <div class="form-group col-lg-3" >
            <label> Description : </label>
            <input value="<?php echo $description; ?>" name="description" type="text" class="form-control" id="description" placeholder="Description"/>
        </div>
        <div style="clear:both"></div>
        <div class="form-group col-lg-3" >
            <label> Mot de passe : </label>
            <input value="<?php echo $objet->decrypteMdp($password); ?>" type="text" class="form-control" name="password" id="password" placeholder="Mot de passe" />
        </div>
        <div class="form-group col-lg-3" >
            <label> Email : </label>
            <input value="<?php echo $email; ?>" type="text" class="form-control" name="email" id="email" placeholder="email" />
        </div>
        <div style="clear:both"></div>
        <div class="form-group col-lg-3" >
            <label> Groupe : </label>
            <select name="groupeid" class="form-control"  id="groupeid">
                <?php
                if(isset($groupeid)){
                    if($groupeid==1){echo "<option value='1' selected >Administrateurs</option>";
                    }else echo "<option value='2' selected >Utilisateurs</option>";
                }
                ?>
               <option value="1">Administrateurs</option>
               <option value="2">Utilisateurs</option>
            </select>
        </div>
        <div class="form-group col-lg-3" >
            <label> Profil Utilisateur : </label>
            <select name="profiluser" class="form-control"  id="profiluser">
                <?php
                if(isset($designationprofil)){
                        echo "<option value='".$profiluser."' "; echo "selected >".$designationprofil."</option>";
                }else echo "<option value='0' selected >PAS DE PROFIL</option>";
                ?>
                <option value="0">PAS DE PROFIL</option>
                <?php
                $result=$objet->db->requete($objet->getAllProfils());   
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->PROT_No."";
                        echo ">".$row->PROT_User."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div style="clear:both"></div>
        <div class="form-group col-lg-3" >
            <label> Forcer Changement Mot de passe : </label>
            <select name="changepass" class="form-control"  id="changepass">
               <option value="0">NON</option>
               <option value="1">OUI</option>
            </select>
        </div>
        <div style="clear:both"></div>
        <div class="form-group col-lg-3" >
            <label>Liste des dépôts</label>
            <select class="form-control" id="depot" name="depot[]" multiple>

                <?php
                $result=$objet->db->requete($objet->getDepotUserByUser($id));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        echo "<option value=".$row->DE_No."";
                        if($row->Valide_Depot==1) echo " selected";
                        echo ">".$row->DE_No." - ".$row->DE_Intitule."</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group col-lg-3" >
            <label>Liste des dépôts principaux</label>
            <select class="form-control" id="depotprincipal" name="depotprincipal[]" multiple>
                <?php
                $result=$objet->db->requete($objet->getDepotUserByUser($id));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows==null){
                }else{
                    foreach($rows as $row){
                        if($row->Valide_Depot==1) {
                            echo "<option value=" . $row->DE_No . "";
                            if ($row->IsPrincipal== 1) echo " selected";
                            echo ">" . $row->DE_No . " - " . $row->DE_Intitule . "</option>";
                        }
                    }
                }
                ?>
            </select>
        </div>
        
        <div style="clear:both"></div>
        <div class="form-group col-lg-3" >
            <input type="button" id="ajouterUser" name="ajouterUser" class="btn btn-primary" <?php if(isset($_GET["id"])) echo 'value="Modifier"'; else echo 'value="Ajouter"'; ?> />
        </div>
    </form>
        <?php
        
        ?>