

    <script src="js/script_creationArticle.js?d=<?php echo time(); ?>"></script>

    <form action="indexMVC.php?module=3&action=1" method="GET" id="formArticle">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link fontApplication" id="home-tab" data-toggle="tab" href="#FichePrincipale" role="tab" aria-controls="FichePrincipale" aria-selected="true">Fiche principale</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fontApplication" id="profile-tab" data-toggle="tab" href="#Complement" role="tab" aria-controls="Complement" aria-selected="false">Complément</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fontApplication" id="contact-tab" data-toggle="tab" href="#Descriptif" role="tab" aria-controls="Descriptif" aria-selected="false">Descriptif</a>
            </li>
        </ul>
        <div class="tab-content card p-3" id="myTabContent">
            <div class="tab-pane active" id="FichePrincipale" role="tabpanel" style="padding-top: 20px" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-4">
                        <label>Famille : </label>
                        <select name="famille" class="form-control" id="famille">
                            <?php
                            $familleClass = new FamilleClass(0);
                            $liste = $familleClass->getShortList();
                            if($liste!=null)
                                foreach($liste as $row){
                                    if($row->FA_Type==0) {
                                        echo "<option value='{$row->FA_CodeFamille}'";
                                        if ($row->FA_CodeFamille == $famille) echo " selected";
                                        echo ">{$row->FA_Intitule}</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label>Référence </label>
                        <input maxlength="19" style="text-transform: uppercase" onkeyup="this.value=this.value.replace(' ','')" type="text" value="<?= $ref; ?>" name="reference" class="form-control only_alpha_num" id="reference" placeholder="Référence" <?php if(isset($_GET["AR_Ref"])) echo "readonly"; ?>/>
                        <input type="hidden" value="<?= (isset($_GET["AR_Ref"])) ? $article->cbMarq : 0 ; ?>" name="cbMarqArticle" class="form-control" id="cbMarqArticle"  />
                    </div>
                    <div class="col-sm-6">
                        <label>Désignation </label>
                        <input maxlength="69" type="text" value="<?= $design; ?>"  name="designation" class="form-control" id="designation" placeholder="Désignation"/>
                    </div>
                </div>
                <div class="row">
                        <div class="col-sm-2">
                            <label>Prix de vente affiché</label>
                            <select id="AR_PrixTTC" name="AR_PrixTTC" class="form-control">
                                <option value="0" <?= ($CT_PrixTTC==0) ? "selected" : ""; ?> >PV HT</option>
                                <option value="1" <?= ($CT_PrixTTC==1) ? "selected" : ""; ?> >PV TTC</option>
                            </select>
                            <input type="text" value="<?= $pxVtHT; ?>" name="pxHT" class="form-control" id="pxHT" placeholder="Prix de vente" <?php if(!$flagInfoLibreArticle  || (!$flagProtected)) echo "readonly"; ?>/>
                        </div>
                    <?php if($flagPxAchat==0){?>
                        <div class="col-sm-2">
                            <label>Prix d'achat </label>
                            <input type="text" value="<?= $pxAch; ?>" name="pxAchat" class="form-control" id="pxAchat" placeholder="Prix d'achat" <?php if(!$flagInfoLibreArticle) echo "readonly"; ?>/>
                        </div>
                    <?php }?>

                        <div class="col-sm-2">
                            <label>Prix gros </label>
                            <input type="text" value="<?= $pxMin; ?>" name="pxMin" class="form-control" id="pxMin" placeholder="Prix gros" <?php if(!$flagInfoLibreArticle || (!$flagProtected)) echo " readonly"; ?>/>
                        </div>
                        <div class="col-sm-2">
                            <label>Prix détails</label>
                            <input type="text" value="<?= $pxMax; ?>" name="pxMax" class="form-control" id="pxMax" placeholder="Prix détails" <?php if(!$flagInfoLibreArticle==2  || (!$flagProtected)) echo "readonly"; ?>/>
                        </div>
                    <div class="col-sm-2">
                        <label>Conditionnement</label>
                        <select id="conditionnement" name="conditionnement" class="form-control" <?php if(!$flagProtected) echo "readonly"; ?>>
                            <?php
                            $pconditionnement = new P_ConditionnementClass(0);
                            $pconditionnement->afficheSelect($pconditionnement->all(),$ar_cond);
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Qté min gros</label>
                        <input type="texte" name="qteGros" id="qteGros" class="form-control" value="<?= $qte_gros; ?>" <?php if(!$flagInfoLibreArticle  || (!$flagProtected)) echo "readonly"; ?>/>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist" style="padding-top: 20px">
                    <li class="nav-item">
                        <a class="nav-link fontApplication" id="depotT-tab" data-toggle="tab" href="#depotT" role="tab" aria-controls="depotT" aria-selected="true">Depot</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fontApplication" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Catégories tarifaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fontApplication" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Fournisseurs</a>
                    </li>
                </ul>
                <div style="padding-bottom: 50px" class="tab-content" id="myTabContent">
                    <div class="tab-pane active" id="depotT" role="tabpanel" style="padding-top: 20px" aria-labelledby="depotT-tab">

                        <table id="table" class="table" style="width:500px;float:left;margin-left:100px">
                            <tr style="background-color: #dbdbed;">
                                <td>Intitulé</td>
                                <td>Stock réel</td>
                                <?php if($flagPxAchat==0) echo "<td>CMUP</td>"; ?>
                            </tr>
                            <tbody>
                            <?php
                            $articleClass = new ArticleClass($ref);
                            $rows = $articleClass->getArticleAndDepot();
                            if($rows==null){
                                echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                            }else{
                                foreach ($rows as $row){
                                    echo "<tr class='article' id='article_".$row->AR_Ref."'>"
                                        . "<td>".$row->DE_Intitule."</td>"
                                        . "<td>".round($row->AS_QteSto,2)."</td>";
                                    if($flagPxAchat==0) echo "<td>".round($row->AS_MontSto,2)."</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <div style="float : left;width:200px;margin-left:200px">
                            <div class="form-group" >
                                <div class="col-lg-20">
                                    <label id="labelCode">Depot</label>
                                    <select name="depot_stock" id="depot_stock" class="form-control">
                                        <?php
                                        if($admin==0) {
                                            $depot = new DepotUserClass(0);
                                            $rows = $depot->getDepotUser($_SESSION["id"]);
                                        }
                                        else{
                                            $depot = new DepotClass(0);
                                            $rows = $depot->alldepotShortDetail();
                                        }
                                        foreach ($rows as $row) {
                                            echo "<option value='{$row->DE_No}'>{$row->DE_Intitule}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-20">
                                <label id="labelCode">Stock min :</label>
                                <input class="form-control" type="text" id="stock_min" name="stock_min"/>
                                </select>
                            </div>
                            <div class="col-lg-20">
                                <label id="labelCode">Stock max :</label>
                                <input class="form-control" type="text" id="stock_max" name="stock_max"/>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="home" role="tabpanel" style="padding-top: 20px" aria-labelledby="home-tab">
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Catégorie</th>
                                        <th>Coefficient</th>
                                        <th>Prix de vente</th>
                                        <th>Remise</th>
                                    </tr>
                                </thead>
                                <?php
                                $pconditionnement = new P_ConditionnementClass(0);
                                $rows = $pconditionnement->getPrixConditionnement($ref);
                                $i=0;
                                if($rows==null){
                                }else{
                                    foreach($rows as $row){
                                        $i++;
                                        echo"<tr id='detailCond_{$row->CT_Intitule}'>
                                                <td id='intitule_cond' >{$row->CT_Intitule}</td>
                                                <td>".ROUND($row->AC_Coef,2)."</td>
                                                <td><span id='prix_cond'>".ROUND($row->AC_PrixVen,2)."</span>
                                                <span id='Cat_PrixTTC'> ". valTTC($row->AC_PrixTTC)."</span></td>
                                                <td><input type='hidden' value='$i' id='value_cond'/></td>
                                                <td id='AC_PrixTTC' style='visibility:hidden'>{$row->AC_PrixTTC}</td>
                                                <td id='AC_PrixTTCExist' style='visibility:hidden'>{$row->AC_PrixTTCExist}</td>
                                            </tr>";
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" style="padding-top: 20px" aria-labelledby="profile-tab">
                        <input type="button" class="btn btn-primary" id="nouveauFournisseur" id="nouveauFournisseur" value="nouveau"/>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fournisseur</th>
                                    <th>Ref. Fournisseur</th>
                                    <th>Prix d'achat</th>
                                    <th>Remise</th>
                                    <th>Conversion</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        if(isset($_GET["AR_Ref"])){
                                            $listArtFourniss=$article->getArtFournisseur();
                                            if($listArtFourniss!=null){
                                                foreach($listArtFourniss as $row){
                                                    echo "<tr id='listeFournisseur'>
                                                            <td id='CT_Num'>{$row->CT_Num}</td>
                                                            <td id='CT_Intitule'>{$row->CT_Intitule}</td>
                                                            <td>{$objet->formatChiffre(($row->AF_PrixAch))}</td>
                                                            <td>{$row->DL_Remise}</td>
                                                            <td>{$row->AF_Conv}</td>
                                                            <td id='cbMarq' style='display: none;'>{$row->cbMarq}</td>
                                                            <td id='modifFournisseur'><i class='fa fa-pencil fa-fw'></i></td>
                                                            <td id='supprFournisseur'><i class='fa fa-trash fa-fw'></i></td>
                                                            </tr>";
                                                }
                                            }
                                        }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="Complement" role="tabpanel" style="padding-top: 20px" aria-labelledby="profile-tab">
                <?php
                $taxe1 =" - ";$taxe2 =" - ";$taxe3 =" - ";$cgnum=" - ";$cgnuma=" - ";
                $libtaxe1 ="";$libtaxe2 ="";$libtaxe3 ="";$libcgnum="";$libcgnuma="";
                $taux1 =0;$taux2 =0;$taux3 =0;
                $articleClass = new ArticleClass($ref);
                $rows = $articleClass->getCatComptaByArRef($articleClass->AR_Ref,1,0);
                if($rows!=null){
                    if($rows[0]->Taxe1!="")
                        $taxe1 =$rows[0]->Taxe1;

                    if($rows[0]->Taxe2!="")
                        $taxe2 =$rows[0]->Taxe2;

                    if($rows[0]->Taxe3!="")
                        $taxe3 =$rows[0]->Taxe3;

                    if($rows[0]->CG_Num!="")
                        $cgnum=$rows[0]->CG_Num;
                    if($rows[0]->CG_NumA!="")
                        $cgnuma=$rows[0]->CG_NumA;
                    $libtaxe1 =$rows[0]->TA_Intitule1;$libtaxe2 =$rows[0]->TA_Intitule2;$libtaxe3 =$rows[0]->TA_Intitule3;
                    $libcgnum=$rows[0]->CG_Intitule;$libcgnuma=$rows[0]->CG_IntituleA;
                    $taux1 =$rows[0]->TA_Taux1;$taux2 =$rows[0]->TA_Taux2;$taux3 =$rows[0]->TA_Taux3;
                }
                ?>
                    <table id="table_compteg" class="table" style="">
                        <thead>
                            <tr style="background-color: #dbdbed;">
                                <th>
                                    <select name="p_catcompta" id="p_catcompta" class="form-control">
                                        <?php
                                        $pcatCompta = new P_CatComptaClass(0);
                                        $rows = $pcatCompta->getCatComptaVente();
                                        foreach ($rows as $row) {
                                            echo "<option value='{$row->idcompta}V'>{$row->marks}</option>";
                                        }
                                        $rows = $pcatCompta->getCatComptaAchat();
                                        foreach ($rows as $row) {
                                            echo "<option value='{$row->idcompta}A'>{$row->marks}</option>";
                                        }
                                        ?>
                                    </select>
                                </th>
                                <th>Compte/Code</th>
                                <th>Intitulé</th>
                                <th>Taux</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id='libCompte'>Compte général</td>
                                <td id="codeCompte" style='text-decoration: underline;color:blue'><?= $cgnum; ?></td>
                                <td id="intituleCompte"><?= $libcgnum; ?></td>
                                <td id="valCompte"></td>
                            </tr>
                            <tr>
                                <td id='libCompte'>Section analytique</td>
                                <td id="codeCompte" style='text-decoration: underline;color:blue'><?= $cgnuma; ?></td>
                                <td id="intituleCompte"><?= $libcgnuma; ?></td>
                                <td id="valCompte"></td>
                            </tr>
                            <tr>
                                <td id='libCompte'>Code taxe 1</td>
                                <td id="codeCompte" style='text-decoration: underline;color:blue'><?= $taxe1; ?></td>
                                <td id="intituleCompte"><?= $libtaxe1; ?></td>
                                <td id="valCompte"><?= $objet->formatChiffre($taux1); ?></td>
                            </tr>
                            <tr>
                                <td id='libCompte'>Code taxe 2</td>
                                <td id="codeCompte" style='text-decoration: underline;color:blue'><?= $taxe2; ?></td>
                                <td id="intituleCompte"><?= $libtaxe2; ?></td>
                                <td id="valCompte"><?= $objet->formatChiffre($taux2); ?></td>
                            </tr>
                            <tr>
                                <td id='libCompte'>Code taxe 3</td>
                                <td id="codeCompte" style='text-decoration: underline;color:blue'><?= $taxe3; ?></td>
                                <td id="intituleCompte"><?= $libtaxe3; ?></td>
                                <td id="valCompte"><?= $objet->formatChiffre($taux3); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <div id="comptegSelect" class="row mb-3">
                    <div class="col-12">
                        <label>Code</label>
                        <input type="hidden" id="comptegCode" />
                        <input type="hidden" id="typeCatCompta" />
                        <input type="text" class="form-control" id="compteGSelectInput" name="compteGSelectInput" />
                    </div>
                </div>
                <div id="taxeSelect" class="row mb-3">
                    <div class="col-12">
                        <label>Code</label>
                        <input type="hidden" id="taxeCode" />
                        <input type="text" class="form-control" id="taxeSelectInput" name="taxeSelectInput" />
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Descriptif" role="tabpanel" style="padding-top: 20px" aria-labelledby="contact-tab">
                <fieldset style="margin-left: 30px" class="entete">
                    <legend class="entete">Catalogue</legend>
                    <div class="row mb-3">
                        <div class="col-6 col-lg-3">
                            <label>Niveau 1 : </label>
                            <select id="catalniv1" name="catalniv1" class="form-control">
                                <option value="0"></option>
                                <?php
                                $fcatalogue = new F_CatalogueClass($cl_no1);
                                echo "<option value='{$fcatalogue->CL_No}'";
                                if($fcatalogue->CL_No==$cl_no1) echo " selected";
                                echo">{$fcatalogue->CL_Intitule}</option>";
                                ?>
                            </select>
                        </div>
                        <div class="col-6 col-lg-3">
                            <label>Niveau 2 : </label>
                            <select id="catalniv2" name="catalniv2" class="form-control" <?php if(!$flagProtected) echo "disabled"; else ""; ?>>
                                <option value="0"></option>
                                <?php
                                $rows = $fcatalogue->getCatalogueByCL(1,$cl_no1);
                                if($rows==null){
                                }else{
                                    if($cl_no2==0) echo '<option value="0"></option>';
                                    foreach ($rows as $row){
                                        if($cl_no2==0){
                                            echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                        }else{
                                            if($row->CL_No==$cl_no2)
                                                echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    <div class="col-6 col-lg-3">
                        <label>Niveau 3 : </label>
                        <select id="catalniv3" name="catalniv3" class="form-control" <?php if(!$flagProtected) echo "disabled"; else ""; ?>>
                            <option value="0"></option>
                            <?php
                            $rows = $fcatalogue->getCatalogueByCL(2,$cl_no2);
                            if($rows==null){
                            }else{
                                if($cl_no3==0) echo '<option value="0"></option>';
                                foreach ($rows as $row){
                                    if($cl_no3==0){
                                        echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                    }else{
                                        if($row->CL_No==$cl_no3)
                                            echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label>Niveau 4 : </label>
                        <select id="catalniv4" name="catalniv4" class="form-control" <?php if(!$flagProtected) echo "disabled"; else ""; ?>>
                            <option value="0"></option>
                            <?php
                            $rows = $fcatalogue->getCatalogueChildren(3,$cl_no3);
                            if($rows==null){
                            }else{
                                if($cl_no4==0) echo '<option value="0"></option>';
                                foreach ($rows as $row){
                                    if($cl_no4==0){
                                        echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                    }else{
                                        if($row->CL_No==$cl_no4)
                                            echo "<option value='{$row->CL_No}'>{$row->CL_Intitule}</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                </fieldset>
                <div id="panel_cond">
                    <div style="" class="form-group">
                        <div class="row">
                            <div class="col-lg-4">
                            <label style="">Prix vente/Prix max : </label>
                            <select id="COND_PrixTTC" name="COND_PrixTTC" class="form-control" style="">
                                <option value="0" <?php if($CT_PrixTTC==0) echo "selected"; ?> >PV HT</option>
                                <option value="1" <?php if($CT_PrixTTC==1) echo "selected"; ?> >PV TTC</option>
                            </select>
                            <input type="text" value="" style="" name="pxCond" class="form-control" id="pxCond" />
                            </div>
                            <div class="col-lg-4">
                                <label>Coef/Prix Min</label>
                                <input type="text" class="form-control" name="AC_Coef" id="AC_Coef" value="" placeholder="Coefficient" />
                            </div>
                        </div>
                        <input type="hidden" value="" name="valCond" class="form-control" id="valCond" />
                    </div>
                    <table id="table" class="table">
                        <tr style="background-color: #dbdbed;"><td>Intitulé</td><td>Quantité</td><td>Prix</td><td></td></tr>
                        <tbody id="TbDetail_cond">
                        <?php
                        $articleClass = new ArticleClass($ref);
                        $rows = $articleClass->detailConditionnement(1);
                        $i=0;
                        if($rows==null){
                            echo "<tr><td>Aucun élément trouvé ! </td></tr>";
                        }else{
                            foreach ($rows as $row){
                                echo "<tr>
                                        <td>{$row->EC_Enumere}</td>
                                        <td>".round($row->EC_Quantite,2)."</td>
                                        <td>".round($row->TC_Prix,2)."</td>
                                      </tr>";
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                    <table id="table" class="table" >
                        <tr><td>Titre :</td><td><input style="width:150px" class="form-control"  type="text" id="titre_cond"/>
                                <input type="hidden" id="Atitre_cond"/>
                                <input type="hidden" id="val_cond"/></td></tr>
                        <tr><td>Quantité :</td><td><input style="width:150px" type="text" class="form-control" id="qte_cond"/></td></tr>
                        <tr><td>Prix :</td><td><input style="width:150px" type="text" class="form-control" id="prixV_cond"/></td></tr>
                    </table>
                </div>
            </div>
        </div>

    <body style="font-family: tahoma;font-size: 13px;">
        <input type="hidden" value="3" name="module"/>
        <input type="hidden" value="1" name="action"/>
<div style="clear:both"></div>

<div id="panelFournisseur" style="display: none;">
<form action="indexMVC.php?module=3&action=1" method="GET" id="formFournisseur">
    <div class="form-group">
        <div class="row hide">
            <div class="col-sm-6">
                <label>Date d'application</label>
                <input type="text" id="AF_DateApplication" name="AF_DateApplication" class="form-control" />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Référence</label>
                <input type="text" id="AF_RefFourniss" name="AF_RefFourniss" class="form-control" onkeyup="this.value=this.value.replace(' ','')" style="text-transform: uppercase" />
            </div>
            <div class="col-sm-6">
            <label>N° Fournisseur</label>
            <select id="fournisseurNum" name="fournisseurNum" class="form-control">
                <?php
                    $tiersClass = new ComptetClass(0);
                    echo $tiersClass->optionTiers(1,0);
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>Code barres</label>
            <input type="text" id="AF_CodeBarre" name="AF_CodeBarre" class="form-control" />
        </div>
        <div class="col-sm-6">
            <label>Devise</label>
            <select id="AF_Devise" name="AF_Devise" class="form-control" >
                <option value='0' selected>Aucune</option>
                <?php
                    $pDeviseClass = new P_DeviseClass(0);
                    echo $pDeviseClass->afficheSelect($pDeviseClass->all(),0);
                ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label>Prix d'achat</label>
            <input type="text" id="AF_PrixAch" name="AF_PrixAch" class="form-control" />
        </div>
        <div class="col-sm-6">
            <label>PA Devise</label>
            <input type="text" id="fournisseurPADevise" name="fournisseurPADevise" class="form-control only_num" readonly/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6" style="padding-top: 25px">
            <select style="float:left; width: 35%" class="form-control" id="AF_TypeRem" name="AF_TypeRem">
                <option value="0">Remise</option>
                <option value="1">Hors Remise</option>
            </select>
            <input style="float:left; width: 65%" type="text" id="AF_Remise" name="AF_Remise" class="form-control" />
        </div>
        <div class="col-sm-6">
            <label>Collisage</label>
            <input type="text" id="AF_Colisage" name="AF_Colisage" class="form-control" value="1" />
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <label>Unité d'achat</label>
            <select id="AF_Unite" name="AF_Unite" class="form-control">
                <?php
                    $puniteClass = new P_UniteClass(0);
                    echo $pDeviseClass->afficheSelect($puniteClass->all(),$cbIndice);
                ?>
            </select>
            <div style="float:left;width:25%">
                <input type="text" id="AF_ConvDiv" name="AF_ConvDiv" class="form-control only_num" value="1" />
            </div>
            <div style="float:left;width:25%;padding-top: 10px">Unité(s) d'achat</div>
            <div style="float:left;width:25%">
                <input type="text" id="AF_Conversion" name="AF_Conversion" class="form-control only_num" value="1" />
            </div>
            <div style="float:left;width:25%;padding-top: 10px">Unité(s) de vente</div>
        </div>
        <div class="col-sm-6">
            <label>QEC</label>
            <input type="text" id="AF_QteMini" name="AF_QteMini" class="form-control only_num" value="1" />
            <label>Garantie</label>
            <input type="text" id="AF_Garantie" name="AF_Garantie" class="form-control only_num" value="0" />
            <label>Délai appro</label>
            <input type="text" id="AF_DelaiAppo" name="AF_DelaiAppo" class="form-control only_num" value="0" />
        </div>
    </div>
    <div clas="row">
        <label>Fournisseur principal</label>
        <input type="checkbox" class="form-check" name="AF_Principal" id="AF_Principal" checked disabled/>
    </div>

</form>
</div>

            <input style="float: left;clear: both;<?php if(isset($ficheArticle)) echo "display:none"; ?>" type="button" id="ajouter" name="<?php if(isset($_GET["AR_Ref"])) echo "modifier"; else echo "ajouter"; ?>" class="bgcolorApplication btn btn-primary" value="Valider" <?php if(!$flagProtected) echo "disabled"; ?>/>
        </form>


