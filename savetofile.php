<?php
if (isset($_FILES['myFile'])) {
//    include("resize-class.php");
//    var_dump($_FILES['myFile']);
//    $resizeObj = new resize($_FILES['myFile']);
//    $resizeObj -> resizeImage(200, 200, 'crop');
//    $resizeObj -> saveImage($_FILES['myFile'], 1000);
//    echo "temporaire ".$_FILES['myFile']['tmp_name'];
    $fichier = $_FILES['myFile']['tmp_name'];
    $command = 'C:\\"Program Files (x86)"\\ZBar\\bin\\zbarimg -q "'.$fichier.'"';

    exec($command, $result);
    if(sizeof($result)>0) {
        $data = array('codeBarre' => $result[0]);
        echo $result[0];
    }
    else{
        $data = array('codeBarre' => "");
        echo "";
    }
}
?>