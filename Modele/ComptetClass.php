<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class ComptetClass Extends Objet{
    //put your code here
    public $db,$CT_Num,$CT_Intitule,$CT_Type,$CG_NumPrinc,$CT_Qualite,$CT_Classement
    ,$CT_Contact,$CT_Adresse,$CT_Complement,$CT_CodePostal,$CT_Ville,$CT_CodeRegion
    ,$CT_Pays,$CT_Raccourci,$BT_Num,$N_Devise,$CT_Ape,$CT_Identifiant,$CT_Siret,$CT_Statistique01
    ,$CT_Statistique02,$CT_Statistique03,$CT_Statistique04,$CT_Statistique05,$CT_Statistique06,$CT_Statistique07
    ,$CT_Statistique08,$CT_Statistique09,$CT_Statistique10,$CT_Commentaire,$CT_Encours,$CT_Assurance,$CT_NumPayeur
    ,$N_Risque,$CO_No,$N_CatTarif,$CT_Taux01,$CT_Taux02,$CT_Taux03,$CT_Taux04,$N_CatCompta,$N_Period
    ,$CT_Facture,$CT_BLFact,$CT_Langue,$CT_Edi1,$CT_Edi2,$CT_Edi3,$N_Expedition,$N_Condition,$CT_DateCreate
    ,$CT_Saut,$CT_Lettrage,$CT_ValidEch,$CT_Sommeil,$DE_No,$CT_ControlEnc,$CT_NotRappel,$N_Analytique,$CA_Num
    ,$CT_Telephone,$CT_Telecopie,$CT_EMail,$CT_Site,$CT_Coface,$CT_Surveillance,$CT_SvDateCreate,$CT_SvFormeJuri,$CT_SvEffectif
    ,$CT_SvCA,$CT_SvResultat,$CT_SvIncident,$CT_SvDateIncid,$CT_SvPrivil,$CT_SvRegul,$CT_SvCotation,$CT_SvDateMaj,$CT_SvObjetMaj,$CT_SvDateBilan
    ,$CT_SvNbMoisBilan,$N_AnalytiqueIFRS,$CA_NumIFRS,$CT_PrioriteLivr,$CT_LivrPartielle
    ,$MR_No,$CT_NotPenal,$EB_No,$CT_NumCentrale,$CT_DateFermeDebut,$CT_DateFermeFin,$CT_FactureElec,$CT_TypeNIF,$CT_RepresentInt
    ,$CT_RepresentNIF,$cbMarq,$cbCreateur,$cbModification

    ,$LibCatTarif,$LibCatCompta;

    public $table = 'dbo.F_COMPTET';
    public $lien = 'fcomptet';

    function __construct($id,$mode="all",$type="ctNum")
    {
        if($type=="ctNum")
            $this->data = $this->getApiJson("/ctNum=$id");
        else
            $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0){
            $this->CT_Num = $this->data[0]->CT_Num;
            $this->CT_Intitule = $this->data[0]->CT_Intitule;
            $this->CT_Type = $this->data[0]->CT_Type;
            $this->CG_NumPrinc = $this->data[0]->CG_NumPrinc;
            if($mode=="all") {
                $this->CT_Qualite = $this->data[0]->CT_Qualite;
                $this->CT_Classement = $this->data[0]->CT_Classement;
                $this->CT_Contact = $this->data[0]->CT_Contact;
                $this->CT_Adresse = $this->data[0]->CT_Adresse;
                $this->CT_Complement = $this->data[0]->CT_Complement;
                $this->CT_CodePostal = $this->data[0]->CT_CodePostal;
                $this->CT_Ville = $this->data[0]->CT_Ville;
                $this->CT_CodeRegion = $this->data[0]->CT_CodeRegion;
                $this->CT_Pays = $this->data[0]->CT_Pays;
                $this->CT_Raccourci = $this->data[0]->CT_Raccourci;
                $this->BT_Num = $this->data[0]->BT_Num;
                $this->N_Devise = $this->data[0]->N_Devise;
                $this->CT_Ape = $this->data[0]->CT_Ape;
                $this->CT_Identifiant = $this->data[0]->CT_Identifiant;
                $this->CT_Siret = $this->data[0]->CT_Siret;
                $this->CT_Statistique01 = $this->data[0]->CT_Statistique01;
                $this->CT_Statistique02 = $this->data[0]->CT_Statistique02;
                $this->CT_Statistique03 = $this->data[0]->CT_Statistique03;
                $this->CT_Statistique04 = $this->data[0]->CT_Statistique04;
                $this->CT_Statistique05 = $this->data[0]->CT_Statistique05;
                $this->CT_Statistique06 = $this->data[0]->CT_Statistique06;
                $this->CT_Statistique07 = $this->data[0]->CT_Statistique07;
                $this->CT_Statistique08 = $this->data[0]->CT_Statistique08;
                $this->CT_Statistique09 = $this->data[0]->CT_Statistique09;
                $this->CT_Statistique10 = $this->data[0]->CT_Statistique10;
                $this->CT_Commentaire = $this->data[0]->CT_Commentaire;
                $this->CT_Encours = $this->data[0]->CT_Encours;
                $this->CT_Assurance = $this->data[0]->CT_Assurance;
                $this->CT_NumPayeur = $this->data[0]->CT_NumPayeur;
                $this->N_Risque = $this->data[0]->N_Risque;
                $this->CO_No = $this->data[0]->CO_No;
                $this->N_CatTarif = $this->data[0]->N_CatTarif;
                $this->CT_Taux01 = $this->data[0]->CT_Taux01;
                $this->CT_Taux02 = $this->data[0]->CT_Taux02;
                $this->CT_Taux03 = $this->data[0]->CT_Taux03;
                $this->CT_Taux04 = $this->data[0]->CT_Taux04;
                $this->N_CatCompta = $this->data[0]->N_CatCompta;
                $this->N_Period = $this->data[0]->N_Period;
                $this->CT_Facture = $this->data[0]->CT_Facture;
                $this->CT_BLFact = $this->data[0]->CT_BLFact;
                $this->CT_Langue = $this->data[0]->CT_Langue;
                $this->CT_Edi1 = $this->data[0]->CT_Edi1;
                $this->CT_Edi2 = $this->data[0]->CT_Edi2;
                $this->CT_Edi3 = $this->data[0]->CT_Edi3;
                $this->N_Expedition = $this->data[0]->N_Expedition;
                $this->N_Condition = $this->data[0]->N_Condition;
                $this->CT_DateCreate = $this->data[0]->CT_DateCreate;
                $this->CT_Saut = $this->data[0]->CT_Saut;
                $this->CT_Lettrage = $this->data[0]->CT_Lettrage;
                $this->CT_ValidEch = $this->data[0]->CT_ValidEch;
                $this->CT_Sommeil = $this->data[0]->CT_Sommeil;
                $this->DE_No = $this->data[0]->DE_No;
                $this->CT_ControlEnc = $this->data[0]->CT_ControlEnc;
                $this->CT_NotRappel = $this->data[0]->CT_NotRappel;
                $this->N_Analytique = $this->data[0]->N_Analytique;
                $this->CA_Num = $this->data[0]->CA_Num;
                $this->CT_Telephone = $this->data[0]->CT_Telephone;
                $this->CT_Telecopie = $this->data[0]->CT_Telecopie;
                $this->CT_EMail = $this->data[0]->CT_EMail;
                $this->CT_Site = $this->data[0]->CT_Site;
                $this->CT_Coface = $this->data[0]->CT_Coface;
                $this->CT_Surveillance = $this->data[0]->CT_Surveillance;
                $this->CT_SvDateCreate = $this->data[0]->CT_SvDateCreate;
                $this->CT_SvFormeJuri = $this->data[0]->CT_SvFormeJuri;
                $this->CT_SvEffectif = $this->data[0]->CT_SvEffectif;
                $this->CT_SvCA = $this->data[0]->CT_SvCA;
                $this->CT_SvResultat = $this->data[0]->CT_SvResultat;
                $this->CT_SvIncident = $this->data[0]->CT_SvIncident;
                $this->CT_SvDateIncid = $this->data[0]->CT_SvDateIncid;
                $this->CT_SvPrivil = $this->data[0]->CT_SvPrivil;
                $this->CT_SvRegul = $this->data[0]->CT_SvRegul;
                $this->CT_SvCotation = $this->data[0]->CT_SvCotation;
                $this->CT_SvDateMaj = $this->data[0]->CT_SvDateMaj;
                $this->CT_SvObjetMaj = $this->data[0]->CT_SvObjetMaj;
                $this->CT_SvDateBilan = $this->data[0]->CT_SvDateBilan;
                $this->CT_SvNbMoisBilan = $this->data[0]->CT_SvNbMoisBilan;
                $this->N_AnalytiqueIFRS = $this->data[0]->N_AnalytiqueIFRS;
                $this->CA_NumIFRS = $this->data[0]->CA_NumIFRS;
                $this->CT_PrioriteLivr = $this->data[0]->CT_PrioriteLivr;
                $this->CT_LivrPartielle = $this->data[0]->CT_LivrPartielle;
                $this->MR_No = $this->data[0]->MR_No;
                $this->CT_NotPenal = $this->data[0]->CT_NotPenal;
                $this->EB_No = $this->data[0]->EB_No;
                $this->CT_NumCentrale = $this->data[0]->CT_NumCentrale;
                $this->CT_DateFermeDebut = $this->data[0]->CT_DateFermeDebut;
                $this->CT_DateFermeFin = $this->data[0]->CT_DateFermeFin;
                $this->CT_FactureElec = $this->data[0]->CT_FactureElec;
                $this->CT_TypeNIF = $this->data[0]->CT_TypeNIF;
                $this->CT_RepresentInt = $this->data[0]->CT_RepresentInt;
                $this->CT_RepresentNIF = $this->data[0]->CT_RepresentNIF;
                $this->cbMarq = $this->data[0]->cbMarq;
                $this->cbCreateur = $this->data[0]->cbCreateur;
                $this->cbModification = $this->data[0]->cbModification;
            }
        }
    }

    public function maj_client(){

        parent::maj("CT_Intitule" , $this->formatString($this->CT_Intitule));
        parent::maj("CG_NumPrinc" , $this->formatString($this->CG_NumPrinc));
        parent::maj("CT_Contact" , $this->formatString($this->CT_Contact));
        parent::maj("CT_Adresse" , $this->formatString($this->CT_Adresse));
        parent::maj("CT_Complement" , $this->formatString($this->CT_Complement));
        parent::maj("CT_CodePostal" , $this->formatString($this->CT_CodePostal));
        parent::maj("CT_Ville" , $this->formatString($this->CT_Ville));
        parent::maj("CT_CodeRegion" , $this->formatString($this->CT_CodeRegion));
        parent::maj("CT_Pays" , $this->formatString($this->CT_Pays));
        parent::maj("CT_Ape" , $this->formatString($this->CT_Ape));
        parent::maj("CT_Identifiant" , $this->formatString($this->CT_Identifiant));
        parent::maj("CT_Siret" , $this->formatString($this->CT_Siret));
        parent::maj("CO_No" , $this->CO_No);
        parent::maj("N_CatTarif" , $this->N_CatTarif);
        parent::maj("N_CatCompta" , $this->N_CatCompta);
        parent::maj("N_Expedition" , $this->N_Expedition);
        parent::maj("N_Condition" , $this->N_Condition);
        parent::maj("DE_No" , $this->DE_No);
        parent::maj("CA_Num" , $this->formatString($this->CA_Num));
        parent::maj("CT_Telephone" , $this->formatString($this->CT_Telephone));
        parent::maj("CT_Telecopie" , $this->formatString($this->CT_Telecopie));
        parent::maj("CT_EMail" , $this->formatString($this->CT_EMail));
        parent::maj("MR_No" , $this->MR_No);
/*
        parent::maj("CT_Encours" , $this->CT_Encours);
        parent::maj("CT_ControlEnc" , $this->CT_ControlEnc);
        parent::maj("N_AnalytiqueIFRS" , $this->N_AnalytiqueIFRS);
        parent::maj("CA_NumIFRS" , $this->CA_NumIFRS);
        parent::maj("N_Devise" , $this->N_Devise);
        parent::maj("N_Analytique" , $this->N_Analytique);
        parent::maj("CT_Sommeil" , $this->CT_Sommeil);
*/    }

    public function modifClientUpdateCANum(){
        $this->getApiExecute("/modifClientUpdateCANum&ctNum={$this->formatString($this->CT_Num)}&caNum={$this->formatString($this->CA_Num)}");
    }

    public function majMrNo(){
        $this->getApiExecute("/majMRNo&ctNum={$this->formatString($this->CT_Num)}&mrNo={$this->MR_No}");
    }

    public function allClients($sommeil=-1) {
        return $this->getApiJson("/allClientShort&sommeil=$sommeil");
    }

    public function allClientsSelect() {
        return $this->getApiJson("/allClientsSelect");
    }

    public function allFournisseur($sommeil = -1) {
        return $this->getApiJson("/allFournisseurShort&sommeil=$sommeil");
    }

    public function rafraichir_listeClient($typeFacture){
        return $this->getApiJson("/rafraichir_listeClient&typeFacture=$typeFacture");
    }

    public function getTiersByIntitule($intitule){
        return $this->getApiJson("/tiersByCTIntitule&ctIntitule={$this->formatString($intitule)}");
    }

    public function getDepotClient($deNo,$ctType) {
        return $this->getApiJson("/getDepotClient&deNo=$deNo&ctType=$ctType");
    }

    public function createClientMin(){
		
        $this->getApiJson("/createClientMin&ctNum={$this->formatString($this->CT_Num)}&ctIntitule={$this->formatString($this->CT_Intitule)}&ctType={$this->CT_Type}&cgNumPrinc={$this->formatString($this->CG_NumPrinc)}&ctAdresse={$this->formatString($this->CT_Adresse)}&ctCodePostal={$this->formatString($this->CT_CodePostal)}&ctVille={$this->formatString($this->CT_Ville)}&ctCodeRegion={$this->formatString($this->CT_CodeRegion)}&ctIdentifiant={$this->formatString($this->CT_Identifiant)}&ctSiret={$this->formatString($this->CT_Siret)}&coNo={$this->CO_No}&nCatTarif={$this->N_CatTarif}&nCatCompta={$this->N_CatCompta}&deNo={$this->DE_No}&caNum={$this->formatString($this->CA_Num)}&ctTelephone={$this->formatString($this->CT_Telephone)}&mrNo={$this->MR_No}&cbCreateur={$this->formatString($this->cbCreateur)}");
    }

    public function allFournisseurSelect() {
        return $this->getApiJson("/allFournisseurSelect");
    }

    public function getCodeAuto($type) {
		$rows = $this->getApiJson("/allFournisseurSelect&type=$type");
        if(sizeof($rows)>0)
            return $rows[0]->T_Racine;
        else
            return "";
    }

    public function getFLivraisonByCTNum($ct_num) {
        return $this->getApiJson("/getFLivraisonByCTNum&ctNum=$ct_num");
    }

    public function tiersByCTIntitule($val) {
		
        $rows= $this->getApiJson("/tiersByCTIntitule&ctIntitule=$val");
        if(sizeof($rows)>0)
            return $rows[0]->cbMarq;
        else
            return null;
    }

    public function getTiersByNumIntituleSearch($intitule,$type,$ctSommeil=-1){
        return $this->getApiJson("/getTiersByNumIntituleSearch&intitule=$intitule&type=$type&ctSommeil=$ctSommeil");
    }

    public function optionTiers($type,$value)
    {
        $liste = [];
        if ($type == 0)
            $liste = $this->allClients();
        else
            $liste = $this->allFournisseur();
        $html="";
        foreach ($liste as $row) {
            $html = $html ."<option value='{$row->CT_Num}'";
            if ($value == $row->CT_Num)
                $html." selected";
            $html = $html.">{$row->CT_Intitule}</option>";
        }
        return $html;
    }


    public function queryListeClient($type,$sommeil,$searchString,$orderBy,$orderType ,$start , $length){
        $url = "/queryListeClient&ctType=$type&ctSommeil=$sommeil&searchString=$searchString&orderBy=$orderBy&orderType=$orderType&start=$start&length=$length";
        return $this->getApiJson($url);
    }
    public function listeClientPagination(){
        if (!empty($_POST) ) {
            /* Useful $_POST Variables coming from the plugin */
            $draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
            $orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
            $orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
            $orderType = $_POST['order'][0]['dir']; // ASC or DESC
            $start  = $_POST["start"];//Paging first record indicator.
            $length = $_POST['length'];//Number of records that the table can display in the current draw
            /* END of POST variables */
            $recordsTotal = sizeof($this->queryListeClient($_GET['CT_Type'],$_GET['CT_Sommeil'],$this->formatString(""),"","","",""));
            /* SEARCH CASE : Filtered data */
            if(!empty($_POST['search']['value'])){

                /* WHERE Clause for searching */
                for($i=0 ; $i<count($_POST['columns']);$i++){
                    $column = $_POST['columns'][$i]['data'];//we get the name of each column using its index from POST request
                    $where[]=" (CT_Num like '%".$_POST['search']['value']."%' OR CT_Intitule like '%".$_POST['search']['value']."%') ";
                }
//                $where = " WHERE ".implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....
                $where = " WHERE (CT_Num like '%".$_POST['search']['value']."%' OR CT_Intitule like '%".$_POST['search']['value']."%') ";//.implode(" OR " , $where);// id like '%searchValue%' or name like '%searchValue%' ....

                /* End WHERE */

                $sql = sprintf(" %s", $where);//Search query without limit clause (No pagination)
                $recordsFiltered = count($this->queryListeClient($_GET['CT_Type'],$_GET['CT_Sommeil'],$this->formatString($_POST['search']['value']),$orderBy,$orderType ,$start , $length));//Count of search result

                /* SQL Query for search with limit and orderBy clauses*/
                $sql = sprintf("%s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$where,$orderBy,$orderType ,$start , $length);
                //$sql = sprintf("$query %s ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY %d , %d ", $where ,$orderBy, $orderType ,$start,$length  );
//            $sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $data = $this->queryListeClient($_GET['CT_Type'],$_GET['CT_Sommeil'],$this->formatString($_POST['search']['value']),$orderBy,$orderType ,$start , $length);
            }
            /* END SEARCH */
            else {
                $sql = sprintf("ORDER BY %s %s OFFSET %d ROWS FETCH NEXT %d ROWS ONLY",$orderBy,$orderType ,$start , $length);
                //$sql = $query." $where ORDER BY $orderBy $orderType OFFSET $start ROWS FETCH NEXT $length ROWS ONLY ";
                $data = $this->queryListeClient($_GET['CT_Type'],$_GET['CT_Sommeil'],$this->formatString($_POST['search']['value']),$orderBy,$orderType ,$start , $length);
                $recordsFiltered = $recordsTotal;
            }

            /* Response to client before JSON encoding */
            $response = array(
                "draw" => intval($draw),
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            );

            echo json_encode($response);

        } else {
            echo "NO POST Query from DataTable";
        }

    }

    public function TiersDoublons(){
        return $this->getApiJson("/TiersDoublons");
    }

    public function getTiersByNumIntitule($term,$typeFac,$all){
        $value =str_replace(" ","%",$term);
        $value= $this->getApiJson("/getTiersByNumIntitule&typeFacture=$typeFac&term=$value&all=$all");

        foreach ($value as $val){
            $rows[] = array("label" => $val->CT_Intitule
            ,"value" => $val->CT_Num,"CO_No" => $val->CO_No,"N_CatCompta" => $val->N_CatCompta,'N_CatTarif' => $val->N_CatTarif);
        }
        return $rows;
    }

    public function remplacementTiers($CT_NumAncien,$CT_NumNouveau){
        $this->getApiJson("/remplacementTiers&ctNumNouveau=$CT_NumNouveau&ctNumAncien=$CT_NumAncien");
    }

    public function __toString() {
        return "";
    }
}
