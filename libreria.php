
<?php
include_once 'Email.php';
function usuariosFichero($fich){
    $fp=fopen($fich,"r");
    $nombres=[];
    $bool=false;
    while (!feof($fp)) {
        $array=explode(",",fgets($fp));
        foreach ($array as $value) {
            if ($value==$array[0]||$value==$array[1]) {
                $bool=true;
            }
            
        }
    }
    if (!$bool) {
        $nombres[]=$array[0];
        $nombres[]=$array[1];
    }
    return $nombres;
}
function anadirEmail($email){
    $fp=fopen("files/emails.txt","a+");
    fwrite($fp,$email->getEmisor().",");
    fwrite($fp,$email->getReceptor().",");
    fwrite($fp,$email->getFecha().",");
    fwrite($fp,$email->getAsunto().PHP_EOL);
}
function actualizarFichero(){
    $fp=fopen("files/emails.txt","w+");
    foreach ($_SESSION['emails'] as  $value) {
        fwrite($fp,unserialize($value)->getEmisor().",");
        fwrite($fp,unserialize($value)->getReceptor().",");
        fwrite($fp,unserialize($value)->getFecha().",");
        fwrite($fp,unserialize($value)->getAsunto().PHP_EOL);
    }
}
?>