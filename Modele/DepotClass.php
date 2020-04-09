<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class DepotClass Extends Objet{
    //put your code here
    public $db,$DE_No,$DE_Intitule,$DE_Adresse,$DE_Complement,$DE_CodePostal,$DE_Ville,$DE_Contact,$DE_Principal
    ,$DE_CatCompta,$DE_Region,$DE_Pays,$DE_EMail,$DE_Code,$DE_Telephone,$DE_Telecopie,$DE_Replication
    ,$DP_NoDefaut,$cbMarq,$cbModification,$CA_CatTarif,$CA_No,$CA_Num,$CA_SoucheAchat,$CA_SoucheVente,$CA_SoucheStock;
    public $table = 'F_DEPOT';
    public $lien = "fdepot";

    function __construct($id) {
        $this->data = $this->getApiJson("/deNo=$id");

        if(sizeof($this->data) > 0) {
            $this->DE_No = $this->data[0]->DE_No;
            $this->DE_Intitule = stripslashes($this->data[0]->DE_Intitule);
            $this->DE_Complement = $this->data[0]->DE_Complement;
            $this->DE_CodePostal = $this->data[0]->DE_CodePostal;
            $this->DE_Ville = $this->data[0]->DE_Ville;
            $this->DE_Contact = stripslashes($this->data[0]->DE_Contact);
            $this->DE_Principal = stripslashes($this->data[0]->DE_Principal);
            $this->DE_CatCompta = $this->data[0]->DE_CatCompta;
            $this->DE_Region = $this->data[0]->DE_Region;
            $this->DE_Pays = $this->data[0]->DE_Pays;
            $this->DE_EMail = $this->data[0]->DE_EMail;
            $this->DE_Code = $this->data[0]->DE_Code;
            $this->DE_Telephone = $this->data[0]->DE_Telephone;
            $this->DE_Telecopie = $this->data[0]->DE_Telecopie;
            $this->DE_Replication = $this->data[0]->DE_Replication;
            $this->DP_NoDefaut = $this->data[0]->DP_NoDefaut;
            $this->cbMarq = $this->data[0]->cbMarq;
            $this->cbModification = $this->data[0]->cbModification;
            $this->CA_No = $this->data[0]->CA_No;
            $this->CA_Num = $this->data[0]->CA_Num;
            $this->CA_SoucheAchat = $this->data[0]->CA_SoucheAchat;
            $this->CA_SoucheVente = $this->data[0]->CA_SoucheVente;
            $this->CA_SoucheStock = $this->data[0]->CA_SoucheStock;
            $this->setCatTarif();
        }
    }


    public function setCatTarif(){
        $this->CA_CatTarif = $this->getApiString("/setCatTarif&deNo={$this->DE_No}");
    }

    public function maj_depot(){
        parent::maj('DE_Complement', $this->DE_Complement);
        parent::maj('DE_CodePostal', $this->DE_CodePostal);
        parent::maj('DE_Ville', $this->formatString($this->DE_Ville));
        parent::maj('DE_Contact', $this->formatString($this->DE_Contact));
        parent::maj('DE_Principal', $this->DE_Principal);
        parent::maj('DE_CatCompta', $this->DE_CatCompta);
        parent::maj('DE_Region', $this->formatString($this->DE_Region));
        parent::maj('DE_Pays', $this->formatString($this->DE_Pays));
        parent::maj('DE_EMail', $this->formatString($this->DE_EMail));
        parent::maj('DE_Code', $this->DE_Code);
        parent::maj('DE_Telephone', $this->formatString($this->DE_Telephone));
        parent::maj('DE_Telecopie', $this->formatString($this->DE_Telecopie));
        parent::maj('DE_Replication', $this->DE_Replication);
        parent::maj('DP_NoDefaut', $this->DP_NoDefaut);
        parent::maj('cbModification', $this->formatString(substr($this->cbModification,0,10)));
        $this->majCatTarif();
    }

    public function __toString() {
        return "";
    }

    public function majCatTarif(){
        $this->getApiExecute("/majCatTarif&deNo={$this->DE_No}&catTarif={$this->CA_CatTarif}");
    }

    public function insertFDepot()
    {
        $query = "
BEGIN 
SET NOCOUNT ON;
            INSERT INTO [dbo].[F_DEPOT]
           ([DE_No],[DE_Intitule],[DE_Adresse],[DE_Complement],[DE_CodePostal],[DE_Ville]
           ,[DE_Contact],[DE_Principal],[DE_CatCompta],[DE_Region],[DE_Pays],[DE_EMail]
           ,[DE_Code],[DE_Telephone],[DE_Telecopie],[DE_Replication],[DP_NoDefaut],[cbDP_NoDefaut]
           ,[cbProt],[cbCreateur],[cbModification],[cbReplication],[cbFlag])
     VALUES
           (/*DE_No*/(SELECT ISNULL((select MAX(DE_No)+1 from f_depot),1)),/*DE_Intitule*/'{$this->DE_Intitule}',/*DE_Adresse*/'{$this->DE_Adresse}'
           ,/*DE_Complement*/'{$this->DE_Complement}',/*DE_CodePostal*/'{$this->DE_CodePostal}',/*DE_Ville*/'{$this->DE_Ville}'
           ,/*DE_Contact*/'{$this->DE_Contact}',/*DE_Principal*/0,/*DE_CatCompta*/1
           ,/*DE_Region*/'{$this->DE_Region}',/*DE_Pays*/'{$this->DE_Pays}',/*DE_EMail*/'{$this->DE_EMail}'
           ,/*DE_Code*/NULL,/*DE_Telephone*/'{$this->DE_Telephone}',/*DE_Telecopie*/'{$this->DE_Telecopie}'
           ,/*DE_Replication*/0,/*DP_NoDefaut*/NULL,/*cbDP_NoDefaut*/NULL
           ,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE)
           ,/*cbReplication*/0,/*cbFlag*/0)
           SELECT *
           FROM F_DEPOT 
           WHERE cbMarq = @@IDENTITY;
           END ";
        $result = $this->db->query($query);
        $rows = $result->fetchAll(PDO::FETCH_OBJ);
        $this->DE_No = $rows[0]->DE_No;
        $this->cbMarq = $rows[0]->cbMarq;
        $this->majCatTarif();
    }

    public function insertFDepotTempl()
    {
        $query = "
            BEGIN 
             SET NOCOUNT ON;
            INSERT INTO [dbo].[F_DEPOTEMPL]
           ([DE_No],[DP_No],[DP_Code],[DP_Intitule]
           ,[DP_Zone],[DP_Type],[cbProt],[cbCreateur]
           ,[cbModification],[cbReplication],[cbFlag])
            VALUES
           (/*DE_No*/{$this->DE_No},/*DP_No*/(SELECT ISNULL((SELECT MAX(DP_No)+1 FROM F_DEPOTEMPL),1)),/*DP_Code*/'DEFAUT',/*DP_Intitule*/'Défaut',/*DP_Zone*/0
           ,/*DP_Type*/0,/*cbProt*/0,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0);
           
            DECLARE @cbmarq As INT 
            SET @cbmarq = @@IDENTITY
    
            UPDATE F_DEPOT SET  DP_NoDefaut = (SELECT ISNULL((select DP_No FROM F_DEPOTEMPL WHERE cbMarq=@cbmarq),1))
                                ,cbDP_NoDefaut = (SELECT ISNULL((select DP_No FROM F_DEPOTEMPL WHERE cbMarq=@cbmarq),1))
                                ,cbModification = GETDATE()
             WHERE DE_No = {$this->DE_No}
             END";
            $this->db->query($query);
    }


    public function insertDepotClient($codeClient)
    {
        $this->getApiExecute("/insertDepotClient&deNo={$this->DE_No}&value=$codeClient");
    }


    public function insertDepotSouche($CA_SoucheVente,$CA_SoucheAchat,$CA_SoucheStock,$CA_Num){
        $this->getApiExecute( "/insertDepotSouche&deNo={$this->DE_No}&caNum=$CA_Num&caSoucheVente=$CA_SoucheVente&caSoucheAchat=$CA_SoucheAchat&caSoucheStock=$CA_SoucheStock");
    }

    public function insertDepotCaisse($CA_No){
        $this->getApiExecute( "/insertDepotCaisse&deNo={$this->DE_No}&caNo=$CA_No");
    }

    public function supprDepotClient(){
        $this->getApiExecute("/supprDepotClient&deNo={$this->DE_No}");
    }

    public function supprReglement($rg_no){
        return "DELETE FROM F_REGLECH WHERE RG_No = $rg_no AND RC_Montant=0;
                    DELETE FROM F_CREGLEMENT WHERE RG_No = $rg_no;
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No = $rg_no;
                    DELETE FROM Z_RGLT_BONDECAISSE WHERE RG_No_RGLT = $rg_no;";
    }

    public function alldepotShortDetail(){
        return $this->getApiJson("/depotShortDetail");
    }


    public function getDepotUser($Prot_No){
        $query = "  SELECT  A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal
                    FROM    F_DEPOT A
                    INNER JOIN Z_DEPOTUSER B ON A.DE_No = B.DE_No
                    WHERE   Prot_No=$Prot_No
                    GROUP BY A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }

    public function getDepotUserSearch($Prot_No,$depotExclude,$searchTerm,$principal=1){
        return $this->getApiJson("/getDepotUserSearch&protNo=$Prot_No&depotExclude=$depotExclude&searchTerm={$this->formatString($searchTerm)}&principal=$principal");
    }

    public function getDepotUserPrincipal($Prot_No){
        $query = "  SELECT  A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal
                    FROM    F_DEPOT A
                    INNER JOIN (SELECT *
                                FROM Z_DEPOTUSER 
                                WHERE IsPrincipal = 1) B ON A.DE_No = B.DE_No
                    WHERE   Prot_No=$Prot_No
                    GROUP BY A.DE_No
                            ,DE_Intitule
                            ,IsPrincipal";
        $result= $this->db->query($query);
        $this->list = Array();
        $this->list = $result->fetchAll(PDO::FETCH_OBJ);
        return $this->list;
    }

    public function delete() {
        $query = "UPDATE F_DEPOT SET DP_NoDefaut = 0,cbDP_NoDefaut = NULL,cbModification=GETDATE() WHERE DE_No={$this->DE_No}; 
            DELETE FROM F_DEPOT WHERE DE_No={$this->DE_No};
            DELETE FROM F_DEPOTEMPL WHERE DE_No={$this->DE_No}";
        $this->db->query($query);
    }


    public function getDepotByIntitule($intitule,$depotExclude=-1){
        $value = $this->getApiJson("/getDepotByIntitule&deNo=$depotExclude&intitule={$this->formatString($intitule)}");
        $rows=array();
        foreach ($value as $val){
            $rows[] = array("id" => $val->DE_No , "text" => $val->DE_Intitule,"DE_Intitule" => $val->DE_Intitule,"DE_No" => $val->DE_No , "value" => $val->DE_Intitule );
        }
        return $rows;
    }
}