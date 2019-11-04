<script src="js/scriptRecouvrement.js?d=<?php echo time(); ?>"></script>
<script src="js/scriptCombobox.js?d=<?php echo time(); ?>" type="text/javascript"></script>
</head>
<body>
<?php
include("module/Menu/BarreMenu.php");
$objet = new ObjetCollector();

$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$client="";
$caisse = 0;
$type=0;
$treglement=0;
$caissier = 0;
$datedeb="";
$datesaisie="";
$datefin="";
$typeRegl = "Client";
if(isset($_GET["typeRegl"]))
    $typeRegl = $_GET["typeRegl"];
$result=$objet->db->requete($objet->getParametre($_SESSION["id"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows==null){
}else{
    if($profil_caisse==1)$caisse=$rows[0]->CA_No;
    $souche=$rows[0]->CA_Souche;
    $co_no=$rows[0]->CO_No;
    $depot_no=$rows[0]->DE_No;
    $caissier = $rows[0]->CO_NoCaissier;
}
if(isset($_GET["client"])) $client=$_GET["client"];
if(isset($_GET["type"])) $type=$_GET["type"];
if(isset($_GET["caisse"])) $caisse=$_GET["caisse"];
if(isset($_GET["mode_reglement"])) $treglement=$_GET["mode_reglement"];
if(isset($_GET["dateReglementEntete_deb"])) $datedeb=$_GET["dateReglementEntete_deb"];
if(isset($_GET["dateReglementEntete_fin"])) $datefin=$_GET["dateReglementEntete_fin"];
$objet = new ObjetCollector();
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
if ($typeRegl == "Client") {
    $flagProtected = $protection->protectedType("ReglementClient");
    $flagSuppr = $protection->SupprType("ReglementClient");
    $flagNouveau = $protection->NouveauType("ReglementClient");
}
else {
    $flagProtected = $protection->protectedType("ReglementFournisseur");
    $flagSuppr = $protection->SupprType("ReglementFournisseur");
    $flagNouveau = $protection->NouveauType("ReglementFournisseur");
}
?>

<div id="protectionPage" style="visibility: hidden;"><?php echo $flagProtected;?></div>
<div id="protectionSupprPage" style="visibility: hidden;"><?php echo $flagSuppr;?></div>
<div id="milieu">
    <div class="container">

        <div class="container clearfix">
            <h4 id="logo" style="text-align: center;background-color: #eee;padding: 10px;text-transform: uppercase">
                <?php echo $texteMenu; ?>
            </h4>
        </div>
        <?php
        $lienForm="indexMVC.php?action=2&module=1";
        $actionForm="2";
        if($typeRegl=="Fournisseur"){
            $lienForm="indexMVC.php?action=4&module=1";
            $actionForm = "4";
        }
        if($typeRegl=="Collaborateur"){
            $lienForm="indexMVC.php?action=5&module=1";
            $actionForm = "5";
        }
        ?>
        <input type="hidden" value="" name="ValRGPiece" id="Val_RG_Piece" />
        <input type="hidden" value="<?php echo $_SESSION["CO_No"]; ?>" name="CO_NoSession" id="CO_NoSession" />

        <form action="<?php echo $lienForm; ?>" method="GET">
            <legend>Entête</legend>
            <input type="hidden" value="1" name="module"/>
            <input type="hidden" value="<?php echo $actionForm; ?>" name="action"/>
            <input type="hidden" value="<?php echo $caissier; ?>" name="caissier" id="caissier" />
            <input type="hidden" value="<?php echo $typeRegl; ?>" name="typeRegl" id="typeRegl" />

            <div class="form-group col-lg-2" >
                <label><?php echo $typeRegl; ?></label>
                <select class="form-control" name="client" id="client">
                    <option value=""></option>
                    <?php
                    if($typeRegl=="Client")
                        $result=$objet->db->requete($objet->allClients());
                    if($typeRegl=="Fournisseur")
                        $result=$objet->db->requete($objet->allFournisseur());
                    if($typeRegl=="Collaborateur")
                        $result=$objet->db->requete($objet->getAllCollaborateursVendeur());
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    $depot="";
                    if($rows==null){
                    }else{
                        foreach($rows as $row){
                            $ct_num = "";
                            if($typeRegl=="Collaborateur")
                                $ct_num = $row->CO_No;
                            else
                                $ct_num = $row->CT_Num;
                            if($typeRegl=="Collaborateur")
                                $ct_intitule = $row->CO_Nom;
                            else
                                $ct_intitule = $row->CT_Intitule;

                            echo "<option value=".$ct_num."";
                            if($ct_num==$client) echo " selected";
                            echo ">".$ct_intitule."</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <label>Début</label>
                <input  type="text"  class="form-control" id="dateReglementEntete_deb" name="dateReglementEntete_deb" placeholder="Date" value="<?php echo $datedeb; ?>"/>
            </div>
            <div class="form-group col-lg-2" >
                <label>Fin</label>
                <input  type="text" class="form-control" id="dateReglementEntete_fin" name="dateReglementEntete_fin" placeholder="Date" value="<?php echo $datefin; ?>"/>
            </div>

            <!-- Text input-->
            <div class="form-group col-lg-2" >
                <label>Type Règlement</label>
                <select style="width:165px" type="checkbox" id="mode_reglement" name="mode_reglement" class="form-control">

                    <?php
                    $result = $objet->db->requete( $objet->listeTypeReglement());
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    //if($flagRisqueClient!=0)
                    echo "<option value='0'";
                    if($treglement==0) echo " selected ";
                    echo ">TOUT REGLEMENTS</option>";
                    if($rows !=null){
                        foreach ($rows as $row){
                            echo "<option value='".$row->R_Code."' ";
                            if ($row->R_Code == $treglement) echo "selected";
                            echo ">" . $row->R_Intitule . "</option>";

                        }
                    }
                    ?>
                    <!--           <option value="07">REMBOURSEMENT CLIENT</option> -->
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <label>Journal</label>
                <select class="form-control" name="journal" id="journal">
                    <?php
                    $result=$objet->db->requete($objet->getJournaux(1));
                    $rows = $result->fetchAll(PDO::FETCH_OBJ);
                    if($rows==null){
                    }else{
                        foreach($rows as $row)
                            echo "<option value='" . $row->JO_Num . "'>" . $row->JO_Intitule . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-2" >
                <?php
                $isPrincipal = 0;
                $caisseClass = new CaisseClass(0);
                if($admin==0){
                    $isPrincipal = 1;
                    $rows = $caisseClass->getCaisseDepot($_SESSION["id"]);
                }else{
                    $rows = $caisseClass->listeCaisseShort();

                }
                ?>
                <label>Caisse</label>
                <select class="form-control" name="caisse" id="caisse" <?php if(/*$profil_caisse==1 || */sizeof($rows)==1) echo "disabled"; ?>>
                    <?php if($admin==1) echo "<option value='0'>TOUTES LES CAISSES</option>";

                    if($rows!=null){
                        foreach($rows as $row) {
                            if ($isPrincipal == 0) {
                                echo "<option value=" . $row->CA_No . "";
                                if ($row->CA_No == $caisse) echo " selected";
                                echo ">" . $row->CA_Intitule . "</option>";
                            } else {
                                if ($row->IsPrincipal == 1) {
                                    echo "<option value=" . $row->CA_No . "";
                                    if ($row->CA_No == $caisse) echo " selected";
                                    echo ">" . $row->CA_Intitule . "</option>";
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-lg-2" >
                <label>Type réglement</label>
                <select class="form-control" name="type" id="type">
                    <option value="-1" <?php if ($type==-1) echo "selected"; ?> >Tout les règlements</option>
                    <option value="1"  <?php if ($type==1) echo "selected"; ?> >Règlements imputés</option>
                    <option value="0"  <?php if ($type==0) echo "selected"; ?> >Règlements non imputés</option>
                </select>
            </div>

            <div class="form-group col-lg-1" >
                <input type="button" id="imprimer" class="btn btn-primary" value="Imprimer"/>
            </div>
            <div class="form-group col-lg-2" >
                <input type="submit" class="btn btn-primary" value="Rechercher"/>
            </div>
        </form>
        <div style="clear: both">
        </div>
        <fieldset class="entete">
            <form id="formValider" action="Traitement/Recouvrement.php" method="GET" class="form-horizontal">
                <input type="hidden" value="1" name="module"/>
                <input type="hidden" value="2" name="action"/>
                <input type="hidden" value="addReglement" name="acte"/>
                <input type="hidden" value="" name="client" id="client_ligne" />
                <input type="hidden" value="" name="dateReglementEntete_deb" id="dateReglementEntete_deb_ligne" />
                <input type="hidden" value="" name="dateReglementEntete_fin" id="dateReglementEntete_fin_ligne" />
                <input type="hidden" value="" name="mode_reglement" id="mode_reglement_ligne" />
                <input type="hidden" value="" name="journal" id="journal_ligne" />
                <input type="hidden" value="" name="caisse" id="caisse_ligne" />
                <input type="hidden" value="" name="caissier" id="caissier_ligne" />
                <input type="hidden" value="" name="JO_Num" id="journal_ligne" />
                <input type="hidden" value="" name="boncaisse" id="boncaisse_ligne" />
                <input type="hidden" value="" name="RG_NoLier" id="rgnolier_ligne" />
                <input type="hidden" value="" name="typeRegl" id="typeRegl_ligne" />
                <input type="hidden" value="" name="type" id="type_ligne" />
                <input type="hidden" id="flagDelai" value="<?php echo $protection->getDelai(); ?>"/>
                <input type="hidden" value="0" name="RG_Type" id="RG_Type"/>
                <input type="hidden" value="0" name="impute" id="impute"/>
                <legend class="entete">Ligne</legend>
                <?php if($flagProtected) { ?>
                    <div class="form-group">
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="dateRec" name="dateRec" value="<?php echo $datesaisie;?>"placeholder="Date" <?php if($flagDateRglt!=0) echo "readonly"; ?>/>
                        </div>
                        <div class="col-md-5">
                            <input type="text" maxlength="25" class="form-control" id="libelleRec" name="libelleRec" placeholder="Libelle"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="montantRec" name="montantRec" placeholder="Montant"/>
                        </div>
                        <div class="col-md-2">
                            <select type="checkbox" id="mode_reglementRec" name="mode_reglementRec" class="form-control">
                                <?php
                                $result = $objet->db->requete( $objet->listeTypeReglement());
                                $rows = $result->fetchAll(PDO::FETCH_OBJ);
                                if($rows !=null) {
                                    foreach ($rows as $row) {

                                        if ($row->R_Code == "01") {
                                            echo "<option value='" . $row->R_Code . "'>" . $row->R_Intitule . "</option>";
                                        } else {
                                            if ($flagRisqueClient == 0) {
                                                echo "<option value='" . $row->R_Code . "'>" . $row->R_Intitule . "</option>";
                                            }
                                        }
                                    }
                                }
                                //echo "<option value='07'>REMBOURSEMENT CLIENT</option>";
                                if($typeRegl=="Collaborateur")
                                    echo"<option value='10'>RETOUR BON DE CAISSE</option>";

                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <input name="client" id="client_valide" type="hidden" value="2" name="action"/>
                            <input type="button" class="btn btn-primary" name="acte" id = "validerRec" value="Valider"/>
                        </div>
                    </div>
                <?php } ?>
            </form>
            <div class="form-group">
                <div id="blocListeReglement" style="float:left;width:540px;clear: both;height: 300px;overflow: scroll;">
                    <table class="table" id="tableRecouvrement" style="width:500px">
                        <thead>
                        <tr>
                            <?php if($flagProtected) echo "<th></th>" ?>
                            <?php if($flagSuppr) echo "<th></th>" ?>
                            <th>N° Piece</th>
                            <th>Date</th>
                            <th>Libelle</th>
                            <th>Montant</th>
                            <th>Montant imputé</th>
                            <th>Reste à imputer</th>
                            <th>Caisse</th>
                            <th>Caissier</th>
                            <?php if($protection->PROT_Right==1) echo "<th>Créateur</th>"; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $collab= 0;
                        if($typeRegl=="Collaborateur") $collab=1;
                        $datedebval = "";
                        if($datedeb!="") $datedebval = $objet->getDate($datedeb);
                        $datefinval = "";
                        if($datefin!="") $datefinval = $objet->getDate($datefin);
                        $typeSelectRegl = 0;
                        if($typeRegl!="Client") $typeSelectRegl = 1;
                        $reglementClass = new ReglementClass(0);
                        if($profil_daf==1){
                            $rows = $reglementClass->getReglementByClient($client,0,$type,$treglement,$datedebval,$datefinval,$caissier,$collab,$typeSelectRegl);
                        }
                        else {
                            $rows = $reglementClass->getReglementByClient($client, $caisse, $type, $treglement, $datedebval, $datefinval, $caissier, $collab, $typeSelectRegl);
                        }
                        $i=0;
                        $classe="";
                        $someRC=0;
                        $someRG=0;
                        if($rows==null){
                            echo "<tr id='reglement_' class='reglement'><td>Aucun élément trouvé ! </td></tr>";
                        }else{
                            foreach ($rows as $row){
                                $someRC=$someRC+$row->RC_Montant;
                                $someRG=$someRG+$row->RG_Montant;
                                $i++;
                                if($i%2==0) $classe = "info";
                                else $classe="";
                                echo "<tr class='reglement $classe' id='reglement_".$row->RG_No."'>";
                                if($flagProtected)  echo "<td id='modifRG_Piece'><i class='fa fa-pencil fa-fw'></i></td>";
                                if($flagSuppr)  echo "<td id='supprRG_Piece'><i class='fa fa-trash-o'></i></td>";
                                echo "<td id='RG_Piece' style='color:blue;text-decoration: underline;'>{$row->RG_Piece}</td>
                                        <td id='RG_Date'>{$row->RG_Date}</td>
                                        <td id='RG_Libelle'>{$row->RG_Libelle}</td>
                                        <td id='RG_Montant'>{$objet->formatChiffre(round($row->RG_Montant))}</td>
                                        <td id='RC_Montant'>{$objet->formatChiffre(round($row->RC_Montant))}</td>
                                        <td id='RA_Montant'>{$objet->formatChiffre(round($row->RG_Montant-$row->RC_Montant))}</td>
                                        <td id='CA_NoTable'>{$row->CA_Intitule}</td>
                                        <td>{$row->CO_Nom}<span style='display:none' id='N_Reglement'>{$row->N_Reglement}</span></td>";
                                if($protection->PROT_Right==1)
                                    echo "<td>{$row->PROT_User}</td>";

                                echo"   <td style='display:none' id='RG_No'>{$row->RG_No}</td>
                                        <td style='display:none' id='RG_Impute'>{$row->RG_Impute}</td>
                                        <td style='display:none' id='CO_NoCaissier'>{$row->CO_NoCaissier}</td>
                                        <td style='display:none' id='JO_Num'>{$row->JO_Num}</td>
                                        <td style='display:none' id='DO_Modif'>{$row->DO_Modif}</td>
                                        </tr>";
                            }
                            $diffSomme=$someRG-$someRC;
                            echo "<tr class='reglement' style='background-color:grey;color:white;font-weight:bold'>
                                        <td>Total</td><td></td><td></td><td></td><td></td>
                                        <td>{$objet->formatChiffre($someRG)}</td>
                                        <td>{$objet->formatChiffre($someRC)}</td>
                                        <td>{$objet->formatChiffre($diffSomme)}</td><td></td><td></td>";
                            if($protection->PROT_Right==1)
                                echo "<td></td>";
                            echo"</tr>";
                        }

                        ?>
                        </tbody>
                    </table>
                </div>
                <form style="float:left;width:500px" id="form_facture" name="form_facture" >
                    <div  id="blocFacture">
                        <div style="clear: both;height: 300px;overflow: scroll;">
                            <table class="table" id="tableFacture">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                    <th>Reste à payer</th>
                                </tr>
                                </thead>
                                <tbody id="Listefacture">
                                </tbody>
                            </table>
                        </div>
                        <div style="float :right" id="total_reste">Total reste à payer : <b>0</b></div>
                    </div>

                    <div  id="blocFactureRGNO" style="display: none;">
                        <div style="clear: both;height: 300px;overflow: scroll;">
                            <table class="table" id="tableFactureRGNO">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="ListefactureRGNO">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="blocFacture_dialog" style="display: none;">
                        <div style="float:right;clear: both;font-size: 13px;font-weight: bold" id="montant_reglement"></div>
                        <div style="clear: both;height: 300px;overflow: scroll;">
                            <table class="table"  id="tableFacture_dialog">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Date</th>
                                    <th>Libelle</th>
                                    <th>Référence</th>
                                    <th>Avance</th>
                                    <th>TTC</th>
                                    <th>Montant réglé </th>
                                </tr>
                                </thead>
                                <tbody id="Listefacture_dialog">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>



            <div title="Choississez un collaborateur" id="choose_caissier" style="display: none;">
                <div form-group col-lg-2>
                    <label>Journal :</label>
                    <select class="form-control" name="journal_choix" id="journal_choix">
                        <?php
                        $journalClass = new JournalClass(0);
                        $rows = $journalClass->getJournaux(1);
                        if($rows!=null){
                            foreach($rows as $row)
                                echo "<option value='" . $row->JO_Num . "'>" . $row->JO_Intitule . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div form-group col-lg-2>
                    <label>Collaborateur :</label>
                    <select class="form-control" name="caissier_choix" id="caissier_choix">
                        <?php
                        $caisseClass = new CaisseClass(0);
                        $rows = $caisseClass ->getCaissierByCaisse($caisse);
                        $depot="";
                        if($rows!=null){
                            foreach($rows as $row){
                                echo "<option value=".$row->CO_No."";
                                echo ">".$row->CO_Nom."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="blocTransfert" title="CONVERSION DU TRANSFERT" style="display: none;">
                <label for="inputdateofbirth" class="col-md-1 control-label">Caisse </label>
                <div class="col-md-3">
                    <select class="form-control" name="caisseTransfert" id="caisseTransfert" <?php if($profil_caisse==1) echo "disabled"; ?>>
                        <?php
                        $caisseClass = new CaisseClass(0);
                        $rows = $caisseClass->listeCaisseShort();
                        if($rows!=null){
                            foreach($rows as $row){
                                echo "<option value=".$row->CA_No."";
                                if($row->CA_No==$caisse) echo " selected";
                                echo ">".$row->CA_Intitule."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
        </fieldset>
    </div>
</div>
<div id="blocDateRemiseBon" style="display: none;">
    <input  type='text'  class='form-control' id='dateRemiseBon' name='dateRemiseBon' placeholder='Date' />
</div>
<div id="blocRemboursementRglt" style="display: none;">
    <div class="col-lg-8">
        <label>Date remboursement</label>
        <input  type='text'  class='form-control' id='dateRemboursement' name='dateRemboursement' placeholder='Date' />
    </div>
    <div class="col-lg-8">
        <label>Montant remboursement</label>
        <input  type='text'  class='form-control only_float' id='mttRemboursement' name='mttRemboursement' placeholder='Montant' />
    </div>
</div>