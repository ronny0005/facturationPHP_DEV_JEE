<?php
/**
 * Created by PhpStorm.
 * User: T.Ron
 * Date: 27/04/2018
 * Time: 23:58
 */

class P_ConditionnementClass Extends Objet{
    //put your code here
    public $db
        ,$P_Conditionnement
		,$cbIndice
		,$cbMarq;
    public $lien = 'pconditionnement';
    public $table = 'P_Conditionnement';

    function __construct($id,$db=null) {
        parent::__construct($this->table, $id,'cbMarq',$db);
        $this->data = $this->getApiJson("/cbMarq=$id");
        if(sizeof($this->data)>0) {
            $this->P_Conditionnement = $this->data[0]->P_Conditionnement;
            $this->cbIndice = $this->data[0]->cbIndice;
            $this->cbMarq = $this->data[0]->cbMarq ;
        }
    }

    public function getPrixConditionnement($arRef){
        return $this->getApiJson("/getPrixConditionnement&arRef=$arRef");
    }

    public function afficheSelect($rows,$value, $code="cbIndice", $intitule="P_Conditionnement")
    {
        $html="";
        foreach ($rows as $row) {
            $html = $html ."<option value='{$row->cbIndice}'";
            if ($value == $row->cbIndice)
                $html." selected";
            $html = $html.">{$row->P_Conditionnement}</option>";
        }
        echo $html;
        //return parent::afficheSelect($rows, $code, $intitule, $value); // TODO: Change the autogenerated stub
    }


public function __toString() {
        return "";
    }

}