<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 15:37
 */

class Objet {
    public $db;
    public $table;
    public $id;
    public $idLib;
    public $userName;
    public $objetCollection;
    /**  Variable pour les données surchargées.  */
    public $data;
    public $list = Array();
    public $url;
    public $settings;
    public $class;
    public $racineApi='http://localhost:8083/rest/';
    public $lien;

    function getFromApi($url){
        header('Access-Control-Allow-Origin: *');
        $this->settings = parse_ini_file("config/app.config", 1);
        $this->url = $this->settings["SERVICE_API"];
        $this->url =$this->url.$url;
        $response = file_get_contents($this->url);
        return $response;
    }

    public function getApiJson($url){
        ini_set("allow_url_fopen", 1);
        $url = $this->racineApi.$this->lien.$url;
        $response = file_get_contents($url);
        $objhigher=json_decode($response); //converts to an object
        return $objhigher;
    }

    public function getApiJsonOption($url){
        $options = array(
            'http' => array(
                'protocol_version' => '1.0',
                'method' => 'GET'
            )
        );
        $context = stream_context_create($options);
        ini_set("allow_url_fopen", 1);
        $url = $this->racineApi.$this->lien.$url;
        $response = file_get_contents($url/*,false,$context*/);
        return $response;
    }

    public function getApiExecute($url){
        ini_set("allow_url_fopen", 1);
        $url = $this->racineApi.$this->lien.$url;
        file_get_contents($url);
    }

    public function getApiString($url){
        ini_set("allow_url_fopen", 1);
        $url = $this->racineApi.$this->lien.$url;
        $response = file_get_contents($url);
        return $response; //converts to an object
    }

    function __construct() {
    }

    public function afficheSelect($rows,$value,$code,$intitule)
    {

    }

    function formatAmount($valeur){
        return str_replace(" ","",$valeur);
    }

    function formatString($valeur){
        return urlencode($valeur);
    }

    public function setuserName($login,$mobile){
        $this->userName="";
        if($mobile==""){
            if(!isset($_SESSION))
                session_start();
            $this->userName = $_SESSION["id"];
        }else
        if($login!="")
            $this->userName = $login;
    }

    public function all(){
        return $this->getApiJson("/all");
    }


    public function maj($name,$value){
        $this->getApiJson("/maj&name=$name&value=".htmlspecialchars_decode($value)."&cbMarq={$this->cbMarq}&cbCreateur={$this->userName}");
    }

    public function majCbMarq($name,$value,$cbMarq){
        $this->getApiExecute("/maj/$name/{$this->formatString($value)}/$cbMarq");
    }

    public function majcbModification(){
    }

    public function majNull($name){
    }

    public function getcbCreateurName(){
    }

    public function delete(){
        $this->getApiJson("/delete&cbMarq=".$this->cbMarq);
    }

    public function formatDate($val){
        if($val==NULL)
            return null;
        else {
            $date = DateTime::createFromFormat('Y-m-d', $val);
            return $date->format('Y-m-d');
        }
    }
    public function formatDateSage($val){
        $date = DateTime::createFromFormat('Y-m-d', $val);
        return $date->format('dmy');
    }
}
?>