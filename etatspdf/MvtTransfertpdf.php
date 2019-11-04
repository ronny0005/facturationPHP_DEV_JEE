<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
$daydate=date('d-m-Y H:i:s');
require_once("../Modele/DB.php");
require_once("../Modele/ObjetCollector.php");
session_start();
ob_start();
if($_GET["type"]=="Transfert"){
    $do_domaine = 2;
    $do_type = 23;
}   
if($_GET["type"]=="Transfert_detail"){
    $do_domaine = 4;
    $do_type = 40;
}   
if($_GET["type"]=="Entree"){
    $do_domaine = 2;
    $do_type = 20;
}    
if($_GET["type"]=="Sortie"){
    $do_domaine = 2;
    $do_type = 21;
}    
$type=$_GET["type"];

$objet = new ObjetCollector();
$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$prixRevient = 0;
$result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null){
    $admin=$rows[0]->PROT_Right;
    $vente=$rows[0]->PROT_DOCUMENT_VENTE;
    $prixRevient=$rows[0]->PROT_PX_REVIENT;
    $rglt=$rows[0]->PROT_DOCUMENT_REGLEMENT;
    if($rows[0]->ProfilName=="VENDEUR")
        $profil_caisse=1;
    if($rows[0]->ProfilName=="COMMERCIAUX" || $rows[0]->ProfilName=="GESTIONNAIRE" || $rows[0]->ProfilName=="VENDEUR")
        $profil_commercial=1;
    if($rows[0]->ProfilName=="RAF" ||$rows[0]->ProfilName=="GESTIONNAIRE" ||$rows[0]->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($rows[0]->ProfilName=="RAF")
        $profil_daf=1;
    if($rows[0]->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($rows[0]->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
}


?>
    <style>
        table {
            font-size: 12px;
        }
    </style>
<div style="width:730px;">

<?php
$cat_tarif=0;
$cat_compta=0;
$libcat_tarif="";
$libcat_compta="";
$entete="";
$affaire="";
$souche="";
$co_no=0;
$depot_no=0;
$collaborateur=0;
$modif=0;
$client = 0;
$totalht=0;
$totalqte=0;
$tva=0;
$precompte=0;
$marge=0;
$totalttc=0;
$reference="";
$dateEntete=date("Y-m-d");

//    if(isset($_GET["atk"]) && is_numeric($_GET["atk"])){
//        $uid= $_GET["atk"];
//    }
    // Création de l'entete de document
    if(isset($_GET["entete"])){
        $entete = $_GET["entete"];
        $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,$do_type));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        if($rows==null){
        }else{
            $reference=$rows[0]->DO_Ref;
            $depot=$rows[0]->DE_No;
            $dotiers=$rows[0]->DO_Tiers;
            $date=$rows[0]->DO_Date;
            $cono=$rows[0]->CO_No;
        }
        if($type=="Transfert_detail"){
           $result=$objet->db->requete($objet->getDoPiece($entete,$do_domaine,41));     
            $rows = $result->fetchAll(PDO::FETCH_OBJ);
            if($rows==null){
            }else{
                $dotiers=$rows[0]->DE_No;
            } 
        }
    }
    //intitule depot source
    $resultdepotsource=$objet->db->requete($objet->getDepotByDE_No($depot));
    $rowsdepotsource = $resultdepotsource->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    if($rowsdepotsource==null){
        //echo "<tr><td>Aucun depot trouvé !</td></tr>";
    }else{
        foreach ($rowsdepotsource as $rowdepotsource){
            $i++;
            $depotnomsource=$rowdepotsource->DE_Intitule;
        }
    }
    
    //intitule depot destination
    $resultdepotdestination=$objet->db->requete($objet->getDepotByDE_No($dotiers));     
    $rowsdepotdestination = $resultdepotdestination->fetchAll(PDO::FETCH_OBJ);
    $i=0;
    if($rowsdepotdestination==null){
        //echo "<tr><td>Aucun depot trouvé !</td></tr>";
    }else{
        foreach ($rowsdepotdestination as $rowdepotdestination){
            $i++;
            $depotnomdestination=$rowdepotdestination->DE_Intitule;
        }
    }
    
    
    //infos collaborateur
     $resultcollabotareur=$objet->db->requete($objet->getCollaborateurByCOno($cono)); 
    while ($colla = $resultcollabotareur->fetch()) {
        $nom=$colla['CO_Nom'];
        $prenom=$colla['CO_Prenom'];
    }
//    $resultconnecte=$objet->db->requete($objet->getProfilByid($uid)); 
//    while ($uconnecte = $resultconnecte->fetch()) {
//        $nomuser=$uconnecte['PROT_User'];
//    }
    
//date du doc entete
$nomuser=$_SESSION['login'];
    $resultdate=$objet->db->requete($objet->getDateEnJMA($date)); 
   while ($re = $resultdate->fetch()) {$dateenJMA=$re[0];
   }

    //infos client
  $resultctnum=$objet->db->requete($objet->getCtnumBydopiece($entete)); 
  $rowsctnum = $resultctnum->fetchAll(PDO::FETCH_OBJ);
  if($rowsctnum==null){
  }else{
      $dotiers2=$rowsctnum[0]->DO_Tiers;
  }

$profil_caisse=0;
$profil_special=0;
$profil_commercial=0;
$profil_daf=0;
$profil_superviseur=0;
$profil_gestionnaire=0;
$result=$objet->db->requete($objet->connexionProctection($_SESSION["login"], $_SESSION["mdp"]));
$rows = $result->fetchAll(PDO::FETCH_OBJ);
if($rows!=null){
    $admin=$rows[0]->PROT_Right;
    $vente=$rows[0]->PROT_DOCUMENT_VENTE;
    $rglt=$rows[0]->PROT_DOCUMENT_REGLEMENT;
    if($rows[0]->ProfilName=="VENDEUR")
        $profil_caisse=1;
    if($rows[0]->ProfilName=="COMMERCIAUX" || $rows[0]->ProfilName=="GESTIONNAIRE" || $rows[0]->ProfilName=="VENDEUR")
        $profil_commercial=1;
    if($rows[0]->ProfilName=="RAF" ||$rows[0]->ProfilName=="GESTIONNAIRE" ||$rows[0]->ProfilName=="SUPERVISEUR" )
        $profil_special =1;
    if($rows[0]->ProfilName=="RAF")
        $profil_daf=1;
    if($rows[0]->ProfilName=="SUPERVISEUR")
        $profil_superviseur=1;
    if($rows[0]->ProfilName=="GESTIONNAIRE")
        $profil_gestionnaire=1;
}

?>
<div style="float:left;width:710px;height:52px;">
	<table border="0" height="52" width="690">
		<tr>
			<td style='width:400px'>   
				<table border="1" height="52" width="400">
				
				   <tr>
					<th style='width:200px'>N° de Mouvement</th>
					<th style='width:200px'>Date du Document</th>
				   </tr>
				   <tr>
					<td style='width:200px; height:20px'><?php echo $entete; ?></td>
					<td style='width:200px; height:20px'><?php echo $dateenJMA; ?></td>
				   </tr>
				   
				   <tr>
					<th style='width:200px'>Référence</th>
					<th style='width:200px'>Saisie par:</th>
				   </tr>
                                   
				   <tr>
					<td style='width:200px; height:20px'><?php echo $reference; ?></td>
                                        <td style='width:200px; height:20px'><?php if(isset($nomuser)){echo $nomuser;} ?> </td>
				   </tr>
				
				</table>
			</td>
	   
			<td style='width:5px'></td>
                        
                        <td style='width:275px'>   
				<table border="1" height="52" width="275">
				
				   <tr>
					<th style='width:275px'>Dépot origine</th>
				   </tr>
				   <tr>
					<td style='width:275px; height:20px'><?php echo $depotnomsource; ?></td>
				   </tr>
				   
				   <tr>
					<th style='width:275px'>Dépot destination</th>
				   </tr>
                                   
				   <tr>
					<td style='width:275px; height:20px'><?php echo $depotnomdestination; ?></td>
				   </tr>
				
				</table>
			</td>
		  
		</tr>
	</table>
 

</div>
    <div style="clear:both;"></div>
<br/><br/>	
<?php
if($type=="Transfert_detail"){
?>
<h4 style="text-align:center">MOUVEMENT DE TRANSFERT DETAIL</h4>  

<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <th style='width:70px'>Référence</th>
    <th style='width:175px'>Désignation</th>
    <th style='width:50px'>Unité</th>
    <th style='width:75px'>Prix Unitaire</th>
    <th style='width:100px'>Quantité</th>
    <th style='width:50px'>Remise</th>
    <th style='width:75px'>Montant HT</th>
    <th style='width:75px'>Montant TTC</th>
</tr>	
<?php
   $result=$objet->db->requete($objet->getLigneTransfert_detail($entete));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $id_sec=0;
        if($rows==null){
        }else{
            foreach ($rows as $row){
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
            
                echo "<tr><td style='width:50px' align='center'>".$row->AR_Ref."</td>"
                    . "<td style='width:175px'>".$row->DL_Design."</td>"
                    . "<td style='width:100px' align='center'>".$row->P_Conditionnement."</td>";
                if($prixRevient==0)
                    echo "<td style='width:75px' align='center'>".round($row->DL_PrixUnitaire,2)."</td>";
                else echo "<td></td>";
                    echo "<td style='width:100px' align='center'>".round($row->DL_Qte)."</td>";
                if($prixRevient==0)
                    echo "<td style='width:100px' align='center'>".$row->DL_Remise."</td>"
                    . "<td style='width:100px' align='center'>".round($row->DL_MontantHT)."</td>"
                    . "<td style='width:100px' align='center'>".round($row->DL_MontantTTC)."</td>";
                    else
                        echo "<td></td><td></td><td></td>";
                    echo"</tr>";
                echo "<tr><td style='width:50px' align='center'>".$row->AR_Ref_Dest."</td>"
                    . "<td style='width:175px'>".$row->DL_Design_Dest."</td>"
                    . "<td style='width:100px' align='center'>".$row->P_Conditionnement_Dest."</td>";
                if($prixRevient==0)
                    echo "<td style='width:75px' align='center'>".round($row->DL_PrixUnitaire_dest,2)."</td>";
                else echo "<td></td>";
                echo "<td style='width:100px' align='center'>".round($row->DL_Qte_dest)."</td>";
                if($prixRevient==0)
                    echo "<td style='width:100px' align='center'>".$row->DL_Remise_dest."</td>"
                    . "<td style='width:100px' align='center'>".round($row->DL_MontantHT_dest)."</td>"
                    . "<td style='width:100px' align='center'>".round($row->DL_MontantTTC_dest)."</td>";
                else echo "<td></td><td></td><td></td>";
                    echo "</tr>";
            }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                    <td style='width:50px; border:0'><b>TOTAL</b></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'>".$totalqte."</td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:100px; border:0'><b>";
                    if($prixRevient==0) echo $totalht;
                    echo "</b></td><td style='width:100px; border:0'><b>";
                    if($prixRevient==0) echo $totalttc;
                    echo "</b></td></tr>";

        }
?>		
</table>
<?php 
}
if($type =="Transfert"){
?>
      <h4 style="text-align:center">MOUVEMENT DE TRANSFERT</h4>  

      
<table style="width:730px;border:1;border-radius:12" align="center">
<tr>
    <th style='width:70px'>Référence</th>
    <th style='width:175px'>Désignation</th>
    <th style='width:75px'>Prix Unitaire</th>
    <th style='width:100px'>Quantité</th>
    <th style='width:100px'>Remise</th>
    <th style='width:100px'>Montant HT</th>
    <th style='width:100px'>Montant TTC</th>
</tr>	
<?php
   $result=$objet->db->requete($objet->getLigneTransfert($entete));     
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $i=0;
        $id_sec=0;
        if($rows==null){
        }else{
            foreach ($rows as $row){
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
                echo "<tr><td style='width:50px' align='center'>".$row->AR_Ref."</td>"
                    . "<td style='width:175px'>".$row->DL_Design."</td>";
                if($prixRevient==0)
                    echo "<td style='width:75px' align='center'>".round($row->DL_PrixUnitaire,2)."</td>";
                else
                    echo "<td></td>";
                echo "<td style='width:100px' align='center'>".round($row->DL_Qte)."</td>";
                if($prixRevient==0)
                    echo "<td style='width:100px' align='center'>".$row->DL_Remise."</td>"
                        . "<td style='width:100px' align='center'>".round(($prix- $rem)*$qte)."</td>"
                        . "<td style='width:100px' align='center'>".round($row->DL_MontantTTC)."</td>";
                else
                    echo "<td></td><td></td><td></td>";
                echo "</tr>";
            }
                echo "<tr style='background-color: #46464be6;color: white;font-weight: bold;'>
                    <td style='width:50px; border:0'><b>TOTAL</b></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:50px; border:0'>".$totalqte."</td>
                    <td style='width:50px; border:0'></td>
                    <td style='width:100px; border:0'><b>";
            if($prixRevient==0) echo $totalht;
            echo "</b></td>
                    <td style='width:100px; border:0'><b>";
            if($prixRevient==0) echo $totalttc;
            echo "</b></td>
                    </tr>";

        }
?>		
</table>
      <?php
}
      ?>
      
      <br/><br/><br/>	
<br/><br/><br/><br/>

</div>
<?php 
$content = ob_get_clean(); 
require_once("../vendor/autoload.php");

$type="P"; 
if($_GET["format"]=="A5"){
  $type="L"; 
}
try
    {
        $html2pdf = new HTML2PDF($type, $_GET["format"], 'fr');
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        ob_end_clean();
        $html2pdf->Output($type.'Mouvement_Transfert.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>