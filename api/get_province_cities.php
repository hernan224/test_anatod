<?php
    require_once '../classes/class.localidades.php';
    $localidad_ctr = new Localidades();

    if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
        $response = $localidad_ctr->getProvinceCities($_GET['pid'], 'nombre');
    } else {
        $response = [
            'success' => false,
            'error' => 'ID de provincia inválido'
        ];
    }

    echo json_encode($response);
?>