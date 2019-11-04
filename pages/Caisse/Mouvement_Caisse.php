<a href="Mouvement_Caisse.php"></a>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>"></script>
<script src="js/script_caisse.js?d=<?php echo time(); ?>"></script>
<script type="text/javascript" src="js/jquery.js?d=<?php echo time(); ?>"></script>

</head>
</head>
<body>    
<?php
include("module/Menu/BarreMenu.php");
require 'Send/class.phpmailer.php';
    $CA_Num="-1";
    $datedeb= date("Y-m-d");
    $datefin= date("Y-m-d");

    $ca_no=-1;
    $type=-1;
    $result=$objet->db->requete($objet->getParametre($_SESSION["id"]));
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    if($rows==null){
    }else{
        if($profil_caisse==1)
            $ca_no=$rows[0]->CA_No;
    }

    $datapost = 0;
        if(isset($_POST["dateReglementEntete_deb"])) {
            $datedeb = $_POST["dateReglementEntete_deb"];
            $datapost=1;
        }
        if(isset($_POST["dateReglementEntete_fin"]))
            $datefin = $_POST["dateReglementEntete_fin"];

        if(isset($_POST["caisseComplete"]))
            $ca_no = $_POST["caisseComplete"];

        if(isset($_POST["type_mvt_ent"]))
            $type = $_POST["type_mvt_ent"];
        if(isset($_POST["libelle"])){
            $montant = str_replace(" ","",$_POST["montant"]);
            $login = $_SESSION["id"];
            $CA_Num="";
            if(isset($_POST["CA_Num"]))
                $CA_Num=$_POST["CA_Num"];
            $libelle = str_replace("'", "''", $_POST['libelle']);
            $rg_typereg = $_POST['rg_typereg'];
            $user ="";
            if(isset($_POST["user"]))
                $user = $_POST["user"];
            if($rg_typereg==6) $libelle=$libelle;
            $caisse = new CaisseClass($_POST["CA_No"]);
            $co_nocaissier = $caisse->CO_NoCaissier;
            $ca_intitule = $caisse->CA_Intitule;
            $jo_num = $caisse->JO_Num;

            $collabClass = new CollaborateurClass($co_nocaissier);
            if($collabClass==null){
            }
            else{
                $collaborateur_caissier = $collabClass ->CO_Nom;
            }
            $cg_num = $_POST['cg_num'];
            $banque =0;
            if($rg_typereg==2) $cg_num="NULL";
            if($rg_typereg==6) {
                // Pour les vrst bancaire mettre a jour le compteur du RGPIECE
                $banque=1;
            }
            if($rg_typereg!=16) {
                $rg_typeregVal = $rg_typereg;
                if($rg_typereg==6)
                    $rg_typeregVal = 4;
                $result = $objet->db->requete($objet->addCReglement('NULL', $_POST['date'], $montant, $jo_num, $cg_num, $_POST['CA_No'], $co_nocaissier, $_POST['date'], $libelle, 0, 2, 1, $rg_typeregVal, 1, $banque, $login));
                if($rg_typereg==6)
                    $result = $objet->db->requete($objet->addCReglement('NULL', $_POST['date'], $montant, $_POST["journalRec"], $cg_num, $_POST['CA_No'], $co_nocaissier, $_POST['date'], $libelle, 0, 2, 1, 5, 1, 1, $login));
            }
            else {
                $result = $objet->db->requete($objet->addCReglement('NULL', $_POST['date'], $montant , $jo_num, $cg_num, $_POST['CA_No'], $co_nocaissier, $_POST['date'], $libelle, 0, 2, 1, 4, 1, $banque, $login));
                $caisseDest = new CaisseClass($_POST['CA_No_Dest']);
                $result = $objet->db->requete($objet->addCReglement('NULL', $_POST['date'], $montant , $caisseDest->JO_Num , $cg_num, $caisseDest->CA_No, $caisseDest->CO_NoCaissier, $_POST['date'], $libelle, 0, 2, 1, 5, 1, $banque, $login));
            }
            $result=$objet->db->requete($objet->getLastReglement());
            $rows = $result->fetchAll(PDO::FETCH_OBJ);

            if($objet->db->flagDataOr==1) {
                $creglement = new ReglementClass(0);
                $creglement->setuserName("",$mobile);
                $creglement->insertZ_REGLEMENT_ANALYTIQUE($rows[0]->RG_No, $CA_Num);
            }
            if($rg_typereg == 4){
                $message='SORTIE D\' UN MONTANT DE '.$objet->formatChiffre($montant ).' POUR '.$libelle.' DANS LA CAISSE '.$ca_intitule.'  SAISI PAR '.$user.' LE '.date("d/m/Y", strtotime($_POST['date']));
                $result=$objet->db->requete($objet->getCollaborateurEnvoiMail("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows!=null){
                    foreach($rows as $row){
                        $email=$row->CO_EMail;
                        $collab_intitule = $row->CO_Nom;
                        if(($email!="" || $email!=null)){
                            $objet->envoiMail($message,"Mouvement de sortie",$email);
                        }
                    }
                }
                $result=$objet->db->requete($objet->getCollaborateurEnvoiSMS("Mouvement de sortie"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows!=null) {
                    foreach($rows as $row) {
                        $telephone=$row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message = 'SORTIE DE ' . $objet->formatChiffre($montant ) . ' POUR ' . $libelle . ' LE ' . date("d/m/Y", strtotime($_POST['date'])) . ' DANS ' . $ca_intitule;
                            $contactD = new ContatDClass(1);
                            $contactD->sendSms($telephone, $message);
                        }
                    }
                }
            }

            if($rg_typereg == 6){
                $message='VERSEMENT BANCAIRE D\' UN MONTANT DE '.$montant .' DANS LA CAISSE '.$ca_intitule.'  SAISI PAR '.$user.' LE '.$_POST['date'];
                $result=$objet->db->requete($objet->getCollaborateurEnvoiMail("Versement bancaire"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows!=null) {
                    foreach ($rows as $row) {
                        $email = $row->CO_EMail;
                        $collab_intitule = $row->CO_Nom;
                        $telephone = $row->CO_Telephone;
                        if (($email != "" || $email != null)) {
                            $objet->envoiMail($message, "Versement bancaire", $email);
                        }
                    }
                }

                $result=$objet->db->requete($objet->getCollaborateurEnvoiSMS("Versement bancaire"));
                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                if($rows!=null) {
                    foreach($rows as $row) {
                        $telephone=$row->CO_Telephone;
                        if (($telephone != "" || $telephone != null)) {
                            $message='SORTIE DE '.$montant .' POUR '.$libelle.' LE '.$_POST['date'].' DANS '.$ca_intitule;
                            $contactD = new ContatDClass(1);
                            $contactD->sendSms($telephone,$message);
                        }
                    }
                }
            }

            if($rg_typereg!=2)$objet->incrementeCOLREGLEMENT();
        }


?>
    <div id="milieu">    
        <div class="container">
    
<div class="container clearfix">
    <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
        <?php echo $texteMenu; ?>
    </h4>

    <input type="hidden" class="form-control" id="flagAffichageValCaisse" value="<?php echo $flagAffichageValCaisse;/*$flagModifSupprComptoir;*/ ?>" />
    <input type="hidden" class="form-control" id="flagCtrlTtCaisse" value="<?php echo $flagCtrlTtCaisse/*$flagModifSupprComptoir;*/ ?>" />

</div>
                <fieldset class="entete">
                    <legend class="entete">Entete</legend>
                    <form class="form-horizontal" action="indexMVC.php?module=6&action=1" method="POST">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Caisse</label>
                                    <input type="hidden" id="action" name="action" value="1"/>
                                    <input type="hidden" id="module" name="module" value="6"/>
                                    <input type="hidden" id="postData" name="postData" value="<?= $datapost; ?>"/>
                                    <select class="form-control" name="caisseComplete" id="caisseComplete">
                                        <option value="-1">Sélectionner une caisse</option>
                                        <?php
                                            $isPrincipal = 0;

                                            if($admin==0){
                                                $isPrincipal = 1;
                                                $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                                            }else{
                                                $result=$objet->db->requete($objet->caisse());
                                            }
                                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                            $depot="";
                                            if($rows==null){
                                            }else{
                                                foreach($rows as $row) {
                                                    if ($isPrincipal == 0) {
                                                        echo "<option value=" . $row->CA_No . "";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">" . $row->CA_Intitule . "</option>";
                                                    } else {
                                                        if ($row->IsPrincipal == 1) {
                                                            echo "<option value=" . $row->CA_No . "";
                                                            if ($row->CA_No == $ca_no) echo " selected";
                                                            echo ">" . $row->CA_Intitule . "</option>";
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <label>Type</label>
                                    <select class="form-control" name="type_mvt_ent" id="type_mvt_ent">
                                        <option value="-1">Sélectionner un type</option>
                                        <?php
                                        if($profil_caisse==1 || $admin==1){
                                        ?>
                                            <option value="4" <?php if($type=="4") echo " selected"; ?>>Mouvement de sortie</option>
                                            <option value="5" <?php if($type=="5") echo " selected"; ?>>Mouvement d'entrée</option>
                                            <option value="2" <?php if($type=="2") echo " selected"; ?>>Fond de caisse</option>
                                            <option value="16" <?php if($type=="16") echo " selected"; ?>>Transfert de caisse</option>
                                        <?php
                                        }
                                        ?>
                                        <option value='6'<?php if($type=="6") echo " selected"; ?>>Verst bancaire</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label>Début</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?= $datedeb; ?>"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Fin</label>
                                    <input  type="text"  class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?= $datefin; ?>"/>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-primary" id="recherche" name="recherche">Rechercher</button>
                                </div>
                                <div class="col-lg-2">
                                    <button type="button" class="btn btn-primary" id="imprimer">Imprimer</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </fieldset>

                <fieldset class="entete">
                    <legend class="entete">Ligne</legend>
                    <?php 
                    if(1==1){
                    ?>
                        <form class="form-horizontal" action="indexMVC.php?module=6&action=1" method="POST" name="form_ligne" id="form_ligne">
                        <div class="form-group">

                            <div class="form-group">
                                <input type="hidden" id="action" name="action" value="1"/>
                                <input type="hidden" id="module" name="module" value="6"/>
                                <input type="hidden" id="caisseComplete_ligne" name="caisseComplete" value=""/>
                                <input type="hidden" id="type_mvt_ent_ligne" name="type_mvt_ent" value=""/>
                                <input type="hidden" id="dateReglementEntete_deb_ligne" name="dateReglementEntete_deb" value=""/>
                                <input type="hidden" id="dateReglementEntete_fin_ligne" name="dateReglementEntete_fin" value=""/>
                                <input type="hidden" id="cg_num_ligne" name="cg_num" value=""/>
                              <?php //if($flagDateMvtCaisse!=2){ ?>
                                <div class="col-md-2">
                                    <input type="text"  class="form-control" id="dateReglement" name="date" placeholder="Date" <?php if($flagDateMvtCaisse==2) echo "readonly"; ?>/>
                                </div>
                                <?php //} ?>
                                <div class="col-md-2">
                                    <select class="form-control" name="CA_No" id="caisseLigne" placeholder="caisse">
                                        <option value="-1">Sélectionner une caisse</option>
                                        <?php


                                        $isPrincipal = 0;
                                        if($admin==0){
                                            $isPrincipal = 1;
                                            $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                                        }else{
                                            $result=$objet->db->requete($objet->caisse());
                                        }
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                if ($isPrincipal == 0) {
                                                    echo "<option value=" . $row->CA_No . "";
                                                    if ($row->CA_No == $ca_no) echo " selected";
                                                    echo ">" . $row->CA_Intitule . "</option>";
                                                } else {
                                                    if ($row->IsPrincipal == 1) {
                                                        echo "<option value=" . $row->CA_No . "";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">" . $row->CA_Intitule . "</option>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" maxlength="27" class="form-control" id="libelleRec" name="libelle" placeholder="Libelle" />
                                </div>
                            </div>
                            <div class="form-group"> 
                                
                                <div class="col-md-2">
                                    <select class="form-control" name="cg_num" id="banque" placeholder="Compte générale">
                                        <option value="0">Sélectionner un compte</option>
                                        <?php 
                                        $result=$objet->db->requete($objet->getCompteg());     
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row){
                                                echo "<option value=".$row->CG_Num."";
                                                echo ">".$row->CG_Num." - ".$row->CG_Intitule."</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="rg_typereg" id="type_mvt_lig">
                                        <?php 
                                        if(1==1){
                                           ?>
                                        <option value='4'>Mouvement de sortie</option>
                                            <option value="5">Mouvement d'entrée</option>
                                            <option value="2">Fond de caisse</option>
                                        <?php }
                                        if($admin==1) echo "<option value='16'>Transfert caisse</option>";
                                        ?>
                                        <option value='6'>Verst bancaire</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" id="montantRec" name="montant" placeholder="Montant" />
                                </div>
                                <div class="col-md-2" id="divJournalDest">
                                    <select class="form-control" id="journalRec" name="journalRec">
                                        <option value=""></option>
                                        <?php
                                            $journalRec = new JournalClass(0);
                                            $rows = $journalRec->getJournauxType(2);
                                            foreach ($rows as $row){
                                                ?>
                                                <option value="<?= $row->JO_Num ?>"><?= $row->JO_Intitule ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <?php if($objet->db->flagDataOr==1){ ?>
                                    <div class="form-group col-lg-3">
                                        <label>Affaire : </label>
                                        <select class="form-control" id="affaire" name="affaire">
                                            <?php
                                            $result=$objet->db->requete($objet->getAffaire(0));
                                            $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                            if($rows==null){
                                            }else{
                                                foreach($rows as $row) {
                                                    echo "<option value='" . $row->CA_Num . "'";
                                                    if ($row->CA_Num == $CA_Num) echo " selected ";
                                                    echo ">" . $row->CA_Intitule . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>
                                <div class='col-md-2' id="divCaisseDest">
                                    <label>Caisse dest. :</label>
                                    <select style="float:left" class="form-control" name="CA_No_Dest" id="CA_No_Dest" placeholder="caisse">

                                        <option value="-1">Sélectionner une caisse</option>
                                        <?php
                                        $isPrincipal = 0;
                                        if($admin==0){
                                            $isPrincipal = 1;
                                            $result=$objet->db->requete($objet->getCaisseDepot($_SESSION["id"]));
                                        }else{
                                            $result=$objet->db->requete($objet->caisse());
                                        }
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        $depot="";
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                if ($isPrincipal == 0) {
                                                    echo "<option value=" . $row->CA_No . "";
                                                    if ($row->CA_No == $ca_no) echo " selected";
                                                    echo ">" . $row->CA_Intitule . "</option>";
                                                } else {
                                                    if ($row->IsPrincipal == 1) {
                                                        echo "<option value=" . $row->CA_No . "";
                                                        if ($row->CA_No == $ca_no) echo " selected";
                                                        echo ">" . $row->CA_Intitule . "</option>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                <button type="button" class="btn btn-primary" id = "validerRec" name= "validerRec">Valider</button>
                            </div>
                            </div>
                            </div>
                            <?php
                    echo "</form>";
                    }
    ?>
                        <table class="table" id="tableRecouvrement">
                            <thead>
                                <tr>
                                    <th>Numéro</th>
                                    <th>N° Piece</th>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Montant</th>
                                    <th>Caisse</th>
                                    <th>Caissier</th>
                                    <th>Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    function typeCaisse($val){
                                        if($val==16) return "Transfert caisse";
                                        if($val==5) return "Entrée";
                                        if($val==4) return "Sortie";
                                        if($val==2) return "Fond de caisse";
                                        if($val==6) return "Vrst bancaire";
                                    }
                                    $reglement = new ReglementClass(0);
                                    $rows = $reglement->listeReglementCaisse($datedeb,$datefin,$ca_no,$type);
                                    $i=0;
                                    $classe="";
                                    $sommeMnt = 0;
                                    if($rows==null){
                                        echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé ! </td></tr>";
                                    }else{
                                        foreach ($rows as $row){
                                            $rg_banque = $row->RG_Banque;
                                            $rg_type = $row->RG_Type;
                                            $rg_typereg = $row->RG_TypeReg;
                                            if($rg_typereg==4){
                                                if($rg_banque==1 && $rg_type==4)
                                                    $rg_typereg = 3;
                                            }
                                        $i++;
                                        $fichier="";
                                        if($row->Lien_Fichier!=null)
                                            $fichier="<a target='_blank' class='fa fa-download' href='upload/files/".$row->Lien_Fichier."'></a>";
                                        $montant = round($row->RG_Montant);
                                        if($row->RG_TypeReg==3 || $row->RG_TypeReg==4)
                                            $montant =$montant*-1; 
                                        if($i%2==0) $classe = "info";
                                                else $classe="";
                                        echo "<tr class='reglement $classe' id='reglement_".$row->RG_No."'>
                                                <td style='color:blue;text-decoration:underline' id='RG_No'>".$row->RG_No."</a></td>
                                                <td id='RG_Piece'>".$row->RG_Piece."</td>
                                                <td id='RG_Date'>".$row->RG_Date."</td>
                                                <td id='RG_Libelle'>".$row->RG_Libelle."</td>
                                                <td id='RG_Montant'>$montant</td>
                                                <td id='CA_Intitule'>".$row->CA_Intitule."</td>
                                                <td id='CO_Nom'><span id='RG_No' style='visibility:hidden'>".$row->RG_No."</span>".$row->CO_Nom."</td>
                                                <td id='RG_TypeReg'>".typeCaisse($rg_typereg)."</td>";
                                                if($objet->db->flagDataOr==1)
                                                    echo "<td style='display:none' id='Affaire'>" . $row->CA_Num. "</td>";
                                                if($flagAffichageValCaisse==0) echo "<td id='RG_Modif'><i class='fa fa-pencil fa-fw'></i></td>";
                                                if($flagCtrlTtCaisse==0) echo "<td id='RG_Suppr'><i class='fa fa-trash-o'></i></td>";
                                            if($rg_banque==1 && $rg_type==4)
                                                    echo "<td>$fichier</td><td><input type='checkbox'  id='check_vrst' checked disabled/></td>";
                                                else 
                                                    if($rg_typereg==3)
                                                    echo "<td>$fichier</td><td><input type='checkbox' id='check_vrst' disabled/></td>";
                                                else "<td></td>";
                                                echo "</tr>";
                                        $sommeMnt = $sommeMnt + $montant;
                                        }
                                        echo "<tr class='reglement' style='background-color:grey;color:white'><td id='rgltTotal'><b>Total</b></td><td></td><td></td><td></td><td><b>$sommeMnt</b></td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    }

                                ?>
                            </tbody>
                        </table>
                        </div>
                        
                            
                        <div id="blocModal">
                            <div class='col-md-6'>
                            Libellé :<input type='text' class='form-control' id='libelleRecModif' placeholder='Libellé' />
                            </div>
                            <div class='col-md-6'>
                                Montant :<input type='text' class='form-control' id='montantRecModif' placeholder='Montant' />
                            </div>
                            <?php if($objet->db->flagDataOr==1){ ?>
                                <div class="form-group col-lg-3">
                                    <label>Affaire : </label>
                                    <select class="form-control" id="AffaireRecModif" name="AffaireRecModif">
                                        <?php
                                        $result=$objet->db->requete($objet->getAffaire(0));
                                        $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                        if($rows==null){
                                        }else{
                                            foreach($rows as $row) {
                                                echo "<option value='" . $row->CA_Num . "'";
                                                if ($row->CA_Num == $CA_Num) echo " selected ";
                                                echo ">" . $row->CA_Intitule . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } ?>
                        </div>
                        </div>
                </fieldset>
            </div>
        </div>
        <div id="valide_vrst" title="VALIDATION VRST BANCAIRE DAF">
            <div class="form-group">
                <div class="col-lg-3">
                    <label>Bordereau</label>
                    <input class="form-control" name="bordereau" id="bordereau"/>
                </div>
                <div class="col-lg-3">
                    <label>Banque</label>
                    <input class="form-control" maxlength="8" name="libelle_banque" id="libelle_banque"/>
                </div>
                <div class="col-lg-3">
                    <label>Date</label>
                    <input class="form-control" maxlength="8" name="libelle_date" id="libelle_date"/>
                </div>
                <div id="fichier" class="col-md-3">
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <div id="files" class="files"></div>
                </div>
            </div>
        </div>
</body>
</html>
