<?php
include_once "../../../configuracion.php";
$data = data_submitted();

if (isset($data['idmenu'])){
    $abmM = new AbmMenu();
    $data['medeshabilitado']=date('Y-m-d H:i:s');
    $respuesta = $abmM->modificacion($data);
    // $respuesta = $objC->baja($data);
    if (!$respuesta){
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

//  $retorno['respuesta']=$data;
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
    echo json_encode($retorno);
?>