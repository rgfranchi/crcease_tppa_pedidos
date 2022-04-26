<?php 

function changeDir($dirPath) {
    
    if (! is_dir($dirPath)) {
        echo "ERROR<br>";
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    var_dump($files);
    foreach ($files as $file) {
        print $file . '<br>';
        if (is_dir($file)) {
            changeDir($file);
        } else {
            chmod($file, 0777);
        }
    }
    chmod($dirPath, 0777);
}



echo "ALTERAR PERMISSÃO DOS DIRETÓRIOS DE BANCO DE DADOS PARA 0777<br>";

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


// exec("chmod -R 0777 " + $dir);

changeDir($dir);

die("<br>FIM");

?>