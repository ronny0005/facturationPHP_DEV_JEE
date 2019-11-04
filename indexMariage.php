<?php

$dbh = null;
class DB {

    public $host_name = 'localhost:3306';
    public $database = 'mariage';
    public $user_name = 'root';
    public $password = '';

    public $connexion_bdd;
    function __construct()
    {
        $this->connexion_bdd = new PDO("mysql:host=".$this->host_name."; dbname=".$this->database.";", $this->user_name, $this->password);
        $this->connexion_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function requete($requete)
    {
        $prepare = $this->connexion_bdd->prepare($requete);
        $prepare->execute();
        return $prepare;
    }

    public function query($requete)
    {
        $prepare = $this->connexion_bdd->prepare($requete);
        $prepare->execute();
        return $prepare;
    }
}

class ObjetCollector
{
    public $db;


    /**  Variable pour les données surchargées.  */
    public $list = Array();

    function __construct()
    {
        $this->db = new DB();
    }
}

$objet = new ObjetCollector();

function envoiRequete($requete,$objet){
    $result=$objet->db->requete($requete);
    $rows = $result->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($rows);
}
function execRequete($requete,$objet){
    $objet->db->requete($requete);
}
$val=$_GET["page"];

switch ($val) {
    case "recoiMsgSite":
        $sql = "INSERT INTO MsgSite(Nom,Msg,DtMsg) VALUES('".str_replace("'","''",($_GET["nom"]))."','".str_replace("'","''",($_GET["message"]))."',now())";
        $fp = fopen('log_msg.txt', 'a');
        fwrite($fp, $sql.'\n');
        fclose($fp);
        execRequete($sql,$objet);
        break;
    case "recoiRsvp":
        $sql = "INSERT INTO RsvpSite(nomRsvp,emailRsvp,absentRsvp,seulRsvp,dtChrg) 
	VALUES('".str_replace("'","''",($_GET["nomRsvp"]))."','".str_replace("'","''",($_GET["emailRsvp"]))."','".str_replace("'","''",($_GET["absentRsvp"]))."','".str_replace("'","''",($_GET["seulRsvp"]))."',now())";
        execRequete($sql,$objet);
        break;
    case "SendMsgSite":
        envoiRequete("SELECT * FROM MsgSite",$objet);
        break;
}

?>