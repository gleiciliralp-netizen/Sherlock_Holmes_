<?php
require_once __DIR__ . '/holmes/HOLMES.php'; 

if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $holmes = new HOLMES();
    $sucesso = $holmes->delete($id);

    // CORRIGIDO: Redireciona de volta para a sua página principal real (createSH.php)
    if($sucesso) {
        header("Location: createSH.php?msg=deleted");
    } else {
        header("Location: createSH.php?msg=error"); 
    }
    exit; 
} else {
    // CORRIGIDO: Redireciona de volta para createSH.php
    header("Location: createSH.php");
    exit;
}