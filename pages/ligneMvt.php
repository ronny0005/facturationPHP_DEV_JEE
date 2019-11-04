<?php
$do_domaine = $docEntete->DO_Domaine;
$do_type = $docEntete->DO_Type;
?>

<fieldset class="entete">
<legend class="entete">Ligne</legend>
<div class="err" id="add_err"></div>
<form action="indexMVC.php?action=5&module=4" method="GET" name="form-ligne" id="form-ligne">
    <input type="hidden" value="4" name="module"/>
    <input type="hidden" value="5" name="action"/>
    <input type="hidden" value="<?php echo $do_imprim; ?>" name="do_imprim" id="do_imprim"/>
<div class="row">
    <input class="form-control" id="entete" name="entete" name="entete" type="hidden" value="<?php echo $entete; ?>"/>
     <div class="col-sm-2">
         <input type="hidden" class="form-control" id="AR_Ref" name="AR_Ref" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
         <input type="text" class="form-control" id="reference" name="reference" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>

    </div>
    <div class="col-md-3">
        <input class="form-control" id="designation" name="designation" placeholder="Désignation" disabled/>
     </div>

    <div class="col-md-2">
        <input type="text" class="form-control" name="quantite" id="quantite"  value="" placeholder="Qté" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
    </div>
    <div class="col-md-2" style="<?php if($flagPxRevient!=0) echo "display:none" ?>">
        <input type="text" class="form-control" id="prix"  value="" name="prix" placeholder="P.U" <?php if(!isset($_GET["cbMarq"]) || $isVisu) echo "disabled" ?>/>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control" id="quantite_stock"  value="" placeholder="Quantité en stock" disabled />
    </div>
	 <div class="col-md-1">
            <input type="hidden" name="ADL_Qte" id="ADL_Qte" value="0"/>
            <input type="hidden" name="APrix" id="APrix" value="0"/>
            <input type="hidden" name="cb_Marq" id="cb_Marq" value="0"/>
            <input type="hidden" name="idSec" id="idSec" value="0"/>
            <input type="hidden" name="acte" id="acte" value="ajout_ligne"/>

     </div>
</div>
 </form>
<div class="form-group">
 <table id="tableLigne" class="table">
    <thead>
      <tr>
        <th>Référence</th>
        <th>Désignation</th>
          <th style="<?php
          if($flagPxRevient!=0)
              echo "display:none";?>
                  ">Prix Unitaire</th>
        <th>Quantité</th>
          <?php if($flagPxRevient==0) echo "<th>Montant</th>"; ?>
<?php
if(!$isVisu && $type!="Transfert_confirmation")
    echo "<th></th>";
if(!$isVisu && $type=="Transfert" && $type=="Transfert_confirmation")
echo "<th></th>";
      if($protection->PROT_CBCREATEUR!=2)
        echo "<th>Createur</th>";
?>
      </tr>
    </thead>
    <tbody id="article_body">
      <?php

      if($type=="Transfert")
          $rows=$docEntete->getLigneTransfert();
      else if($type=="Transfert_confirmation")
          $rows=$docEntete->getLigneTransfert();
      else if($type=="Transfert_valid_confirmation")
          $rows=$docEntete->getLignetConfirmation();
        else
            $rows=$docEntete->getLigneFactureTransfert();
        $i=0;
        $id_sec=0;
        $classe="";
        if($rows==null){
        }else{
            foreach ($rows as $row){
                $docligne = new DocLigneClass($row->cbMarq);
                $i++;
            $prix = $row->DL_PrixUnitaire;
            $remise = $row->DL_Remise;
            $qte=$row->DL_Qte;
            $type_remise = 0;
            $rem=0;
            if(strlen($remise)!=0){
                if(strpos($remise, "%")){
                    $remise=str_replace("%","",$remise);
                $rem = $prix * $remise / 100;
                }
                if(strpos($remise, "U")){
                    $remise=str_replace("U","",$remise);
                    $rem = $remise;
                }
            }else $remise=0;
            if($i%2==0)
                $classe = "info";
            else $classe = "";
                $a=round(($prix- $rem)*$qte,0);
                $b=round(($a * $row->DL_Taxe1)/100,0);
                $c=round(($a * $row->DL_Taxe2)/100,0);
                $d=($row->DL_Taxe3 * $qte);
                $totalht=$totalht+$a;
                $totalqte=$totalqte+$qte;
                $tva = $tva +$b;
                $precompte=$precompte+$c;
                $marge=$marge+$d;
                $totalttc=$totalttc+round(($a+$b+$c)+$d,0);

                echo "<tr class='facture $classe' id='article_".$row->cbMarq."'";
                    echo "><td id='AR_Ref' style='color:blue;text-decoration: underline'>".$row->AR_Ref."</td>"
                    . "<td id='DL_Design' style='align:left'>".$row->DL_Design."</td>";
                    ?>
                <td id='DL_PrixUnitaire'
                    style="<?php
                    if($flagPxRevient!=0)
                        echo "display:none";?>">
                    <?= $objet->formatChiffre(round($row->DL_PrixUnitaire, 2)); ?></td>

                <?php
                    echo "<td id='DL_Qte'>".$objet->formatChiffre(round($row->DL_Qte*100)/100)."</td>";
                if($flagPxRevient==0) echo    "<td id='DL_MontantHT'>".$objet->formatChiffre($row->DL_MontantHT)."</td>";
                    echo "<td style='display:none' id='cbMarq'>".$row->cbMarq."</td>"
                    . "<td style='display:none' id='id_sec'>".$row->idSec."</td>";
                if(!$isVisu && $type!="Transfert" && $type!="Transfert_confirmation")
                        echo "<td id='modif_".$row->cbMarq."'><i class='fa fa-pencil fa-fw'></i></td>";
                if(!$isVisu && $type!="Transfert_valid_confirmation")
                    echo "<td id='suppr_".$row->cbMarq."'><i class='fa fa-trash-o'></i></td>";
                if($protection->PROT_CBCREATEUR!=2)
                    echo "<td>{$docligne->getcbCreateurName()}</td>";
                echo"</tr>";
            }

        }
      ?>
    </tbody>
  </table>
 </div>

 </fieldset>
