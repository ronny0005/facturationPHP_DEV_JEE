<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class CaisseClass Extends Objet{
    //put your code here
    public $db,$CA_No,$CA_Intitule,$DE_No,$CO_No,$CO_NoCaissier,$CT_Num,$JO_Num,$CA_Souche,$cbCreateur;
    public $table = 'F_CAISSE';
    public $lien ="fcaisse";
    function __construct($id)
    {
        $this->data = $this->getApiJson("/$id");
        if($id!=0)
        if (sizeof($this->data) > 0) {
            $this->CA_No = $this->data[0]->CA_No;
            $this->CA_Intitule = stripslashes($this->data[0]->CA_Intitule);
            $this->DE_No = $this->data[0]->DE_No;
            $this->CO_No = $this->data[0]->CO_No;
            $this->CO_NoCaissier = $this->data[0]->CO_NoCaissier;
            $this->CT_Num = stripslashes($this->data[0]->CT_Num);
            $this->JO_Num = stripslashes($this->data[0]->JO_Num);
            $this->CA_Souche = $this->data[0]->CA_Souche;
            $this->cbCreateur = $this->data[0]->cbCreateur;

        }
    }

    public function insertDepotCaisse($DE_No){
        $query = "INSERT INTO Z_DEPOTCAISSE VALUES ($DE_No,{$this->CA_No})";
        $this->db->query($query);
    }

    public function allCaisse(){
        return $this->getApiJson("/all");
    }


    public function getCaisseDepot($prot_no){
        return $this->getApiJson("/getCaisseDepot/$prot_no");
   }

    public function maj_caisse(){
        parent::maj('CA_Intitule', $this->CA_Intitule);
        parent::maj('DE_No', $this->DE_No);
        parent::maj('CO_No', $this->CO_No);
        parent::maj('CO_NoCaissier', $this->CO_NoCaissier);
        parent::maj('CT_Num', $this->CT_Num);
        parent::maj('JO_Num', $this->JO_Num);
        parent::maj('CA_Souche', $this->CA_Souche);
        parent::maj('cbCreateur', $this->userName);
        parent::majcbModification();

    }

    public function insertCaisse(){
        $query = "
                  BEGIN 
                  SET NOCOUNT ON;
                  INSERT INTO [dbo].[F_CAISSE]
                ([CA_No],[CA_Intitule],[DE_No],[CO_No]
                ,[cbCO_No],[CO_NoCaissier],[cbCO_NoCaissier],[CT_Num]
                ,[JO_Num],[CA_IdentifCaissier],[CA_DateCreation],[N_Comptoir]
                ,[N_Clavier],[CA_LignesAfficheur],[CA_ColonnesAfficheur],[CA_ImpTicket]
                ,[CA_SaisieVendeur],[CA_Souche],[cbProt],[cbCreateur]
                ,[cbModification],[cbReplication],[cbFlag])
          VALUES
                (/*CA_No*/ISNULL((SELECT MAX(CA_No) FROM F_CAISSE)+1,0),/*CA_Intitule*/'{$this->CA_Intitule}',/*DE_No*/1
                ,/*CO_No*/0,/*cbCO_No*/NULL,/*CO_NoCaissier*/{$this->CO_NoCaissier}
                ,/*cbCO_NoCaissier*/(SELECT CASE WHEN {$this->CO_NoCaissier}=0 THEN NULL ELSE {$this->CO_NoCaissier} END)
                ,/*CT_Num*/(SELECT TOP 1 CT_Num
                            FROM F_COMPTET
                            WHERE CT_Num LIKE '%DIVERS%'
                            AND CT_Type=0),/*JO_Num*/'{$this->JO_Num}',/*CA_IdentifCaissier*/0
                ,/*CA_DateCreation*/CAST(GETDATE() AS DATE),/*N_Comptoir*/1,/*N_Clavier*/1
                ,/*CA_LignesAfficheur*/0,/*CA_ColonnesAfficheur*/0,/*CA_ImpTicket*/0
                ,/*CA_SaisieVendeur*/0,/*CA_Souche*/0,/*cbProt*/0
                ,/*cbCreateur*/'AND',/*cbModification*/CAST(GETDATE() AS DATE),/*cbReplication*/0,/*cbFlag*/0)
                SELECT *
                FROM F_CAISSE WHERE cbMarq =@@IDENTITY; 
                END
                ";
        $result=$this->db->query($query);
        $row = $result->fetchAll(PDO::FETCH_OBJ);
        $this->majcbModification();
        return $row[0];
    }

    public function supprDepotCaisse()
    {
        $query = "DELETE FROM Z_DEPOTCAISSE WHERE CA_No={$this->CA_No}";
        $this->db->query($query);
    }

    public function listeCaisseShort(){
        $query = "SELECT JO_Num,CA_Intitule,CA_No,CO_NoCaissier,CA_Souche,CT_Num,cbModification 
                  FROM F_CAISSE";
        $result= $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

public function getCaissierByCaisse($ca_no)
{
    $query = "SELECT CO.CO_No,CO_Nom
                FROM " . $this->db->baseCompta . ".dbo.F_COLLABORATEUR CO
                LEFT JOIN F_CAISSECAISSIER CA ON CO.CO_No = CA.CO_No
                WHERE CO_Caissier=1 AND (0 = $ca_no OR CA_No = $ca_no)
                GROUP BY CO.CO_No,CO_Nom";
    $result= $this->db->query($query);
    return $result->fetchAll(PDO::FETCH_OBJ);
}
    public function __toString() {
        return "";
    }

}