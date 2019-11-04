<script src="js/script_listeFacture.js?d=<?php echo time(); ?>"></script>
<script src="js/jquery.dynatable.js?d=<?php echo time(); ?>" type="text/javascript"></script>

<h1 class="text-uppercase text-center" style="background-color: #4e73df;color: rgb(246,247,249);padding-top: 5px;padding-bottom: 5px;"><?= $protection->listeFactureNom($type) ?></h1>
<form id="valideLigne" action="listeFacture-<?= $type ?>" method="POST">
    <div class="row">
    <div class="col-md-6 col-xl-3 mb-4"><label>&nbsp;Début :&nbsp;</label>
        <div id="datetimepicker1" class="input-group date">
            <input type="text" id="datedebut" name="datedebut" class="form-control" inputmode="numeric" maxlength="6" value="<?= $datedeb ?>">
                <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4"><label>&nbsp;Fin :&nbsp;</label>
        <div id="datetimepicker1" class="input-group date">
            <input type="text" id="datefin" name="datefin" class="form-control" inputmode="numeric" maxlength="6" value="<?= $datefin ?>">
            <span class="input-group-addon">&nbsp;<span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4"><label>Dépot :</label>
        <input type="hidden" value="<?= sizeof($_POST) ?>" name="post" id="post"/>
        <input type="hidden" value="<?= $protection->lienMenuNouveau($type) ?>" name="lienMenuNouveau" id="lienMenuNouveau"/>
        <input type="hidden" value="<?= $type ?>" name="typeDoc" id="typeDoc"/>

        <div class="field">
                <select class="form-control" id="depot" name="depot">
                        <?= $listeDepot ?>
                </select>
            </div>
    </div>
    <div <?= $afficheListeTiers ?> class="col-md-6 col-xl-3 mb-4"><label><?= $libTiers ?></label>
            <div class="field">
                <input type="hidden" id="CT_Num" value ="<?= $client ?>" name="client">
                <input type="text"  id="client" value ="<?= $libClient ?>" name="libClient" class="form-control">
            </div>
    </div>
</div>
<div class="row">
    <div <?= $afficheTypeFacture ?> class="col-md-6 col-xl-3 mb-4"><label>Type facture</label>
            <div class="field">
                <select class="form-control" id="type" name="type">
                    <?= $listeTypeFacture ?>
                </select>
            </div>
    </div>

    <div class="col-md-6 col-xl-3 mb-4"></div>
    <div class="col-md-6 col-xl-3 mb-4"></div>
    <div class="col-md-6 col-xl-3 text-right mb-4"><button class="btn btn-primary" id="valider" type="button">Valider</button></div>
</div>
</form>
</div>


<div class="container-fluid" style="margin-bottom: 30px;">
    <div><button <?= $afficheBoutonNouveau ?> class="btn btn-primary" id="nouveau" type="button">Nouveau</button>

        <div class="table-responsive" style="margin-top: 30px;clear:both">
            <table id="tableListeFacture" class="table table-striped">

            <!--<div style="clear:both" class="table-responsive">
            <table id="table" class="table table-striped" cellspacing="0" width="100%"> -->
                <thead class="">
                <tr>
                    <th>Numéro Pièce</th>
                    <th>Reference</th>
                    <th>Date</th>
                    <th <?= ($protection->afficheClientListe($type)) ?>>Client</th>
                    <th <?= ($protection->afficheDepotListe($type)) ?>>Dépot</th>
                    <th <?= ($protection->afficheFournisseurListe($type)) ?>>Fournisseur</th>
                    <th <?= ($protection->afficheFournisseurListe($type)) ?>>Dépot</th>
                    <th <?= ($protection->afficheDepotDestListe($type)) ?>>Dépot source</th>
                    <th <?= ($protection->afficheDepotDestListe($type))?>>Dépot dest.</th>
                    <th>Total TTC</th>
                    <th <?= ($protection->afficheStatutListe ($type)) ?>>Montant r&eacute;gl&eacute;</th>
                    <th <?= ($protection->afficheStatutListe ($type)) ?>>Statut</th>
                    <th <?= ($protectedSuppression) ? "" : "style='display:none'" ?> ></th>
                    <th <?= ($protection->afficheTransformListe($type))  ?>></th>
                    <th></th>
                    <th <?= ($protection->PROT_CBCREATEUR!=2) ? "" : "style='display:none'" ?>>Créateur</th>
                </tr>
                </thead>


                <tbody>
                <?php
                $docEntete = new DocEnteteClass(0);
                $listFacture = $docEntete->listeFactureSelect($depot,$objet->getDate($datedeb),$objet->getDate($datefin),$client,$type);

                if(sizeof($listFacture)>0){
                    foreach ($listFacture as $row){
                    $message="";
                    $avance="";
                    if($protection->afficheStatutListe ($type)==""){
                        $avance = round($row->avance);
                        if($avance==null) $avance = 0;
                        $message =$row->statut;
                    }
                    $date = new DateTime($row->DO_Date);
                    ?>
                    <tr data-toggle="tooltip" data-placement="top" title="<?= $row->PROT_User ?>"
                        class='facture' id='article_<?= $row->DO_Piece ?>'>
                        <td id='entete'><a href='<?= lienfinal($row->DO_Piece,$type,$row->cbMarq,$row->DO_Domaine,$row->DO_Type,$protected) ?>'><?= $row->DO_Piece ?></a></td>
                        <td><?= $row->DO_Ref ?></td>
                        <span style='display:none' id='cbMarq'><?= $row->cbMarq ?></span>
                        <span style='display:none' id='cbCreateur'><?= $row->PROT_User ?></span>
                        <td><?= $date->format('d-m-Y') ?></td>
                        <td <?= ($protection->afficheClientListe($type)) ?>><?= $row->CT_Intitule ?></td>
                        <td <?= ($protection->afficheDepotListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheFournisseurListe($type)) ?>><?= $row->CT_Intitule ?></td>
                        <td <?= ($protection->afficheFournisseurListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheDepotDestListe($type)) ?>><?= $row->DE_Intitule ?></td>
                        <td <?= ($protection->afficheDepotDestListe($type)) ?>><?= $row->DE_Intitule_dest ?></td>
                        <td><?= $objet->formatChiffre(round($row->ttc)) ?></td>
                        <td <?= ($protection->afficheStatutListe ($type)) ?>><?= $objet->formatChiffre($avance) ?></td>
                        <td <?= ($protection->afficheStatutListe ($type)) ?>><?= $message ?></td>
                        <td <?= ($protectedSuppression) ? "" : "style='display:none'" ?> >
                            <a href="Traitement\Facturation.php?type=$type&acte=suppr_facture&cbMarq=<?=$row->cbMarq ?>" onclick="if(window.confirm('Voulez-vous vraiment supprimer la facture <?= $row->DO_Piece ?> ?')){return true;}else{return false;}">
                                <i class='fa fa-trash-o'></i></a></td>
                        </td>
                        <td <?= $protection->afficheTransformListe($type) ?>><input type="button" class="btn btn-primary" value="Convertir en facture" id="transform"/></td>
                        <td><i class='fa fa-print' <?= ($row->DO_Imprim) ? "" : "style='display:none'" ?>></i></td>
                        <td <?= ($protection->PROT_CBCREATEUR!=2) ? "" : "style='display:none'" ?>><?= $row->PROT_User ?></td>
                    </tr>
                        <?php
                    }
                }
                    ?>

                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
    <div style="text-align: center" id="menu_transform">
        <div class="form-group col-lg-4">
            <label>Type<br/></label>
            <select id="type_trans" name="type_trans" class="form-control">
                <option value="6">Facture</option>
                <?php
                if($type=="Devis")
                    echo "<option value='3'>Bon de livraison</option>";
                ?>
            </select>
        </div>
        <div class="form-group col-lg-4">
            <label>Choisisser une nouvelle date</label>
            <input class="form-control" type="text" id="date_transform"/>
        </div>
        <div class="form-group col-lg-4">
            <label>Choisisser une nouvelle référence</label>
            <input class="form-control" type="text" id="reference"/>
        </div>
    </div>