<?php 
function deleteDir($dirPath) {

    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
       print $file . '<br>';
       if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}


echo "EXCLUI DIRETÓRIOS DE BANCO DE DADOS<br>";
$currentDir = getcwd();
echo $currentDir. '<br>';
if(strpos($currentDir, 'tppa_pedidos') > 0) {
    $dir = "../../../DATABASE_TPPA/DESENVOLVIMENTO";
    echo "EXECUTA:" . $dir;
}

if(strpos($currentDir, 'HOMOLOGA') > 0) {
    $dir = "../../../DATABASE_TPPA/HOMOLOGA";
    echo "EXECUTA:" . $dir;
}

if(strpos($currentDir, 'PRODUCAO') > 0) {
    echo "<br><h1>COMANDO NÃO DEVE SER EXECUTADO EM PRODUÇÃO</h1>";
    die;
}

// exec("rm -r " + $currentDir);

deleteDir($dir);

die("<br>FIM");


?>