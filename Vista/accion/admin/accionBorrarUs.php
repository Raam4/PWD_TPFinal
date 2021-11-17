<?php
include_once "../../../configuracion.php";
$data = data_submitted();

if (isset($data['idusuario'])){
    $objC = new AbmUsuario();
    $data['usdeshabilitado']=date('Y-m-d H:i:s');
    $respuesta = $objC->modificacion($data);
    // $respuesta = $objC->baja($data);
    if (!$respuesta){
        $mensaje = " La accion  ELIMINACION No pudo concretarse";
    }
}

// $retorno['respuesta']=$data;
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    $retorno['errorMsg']=$mensaje;
}
    echo json_encode($retorno);
?>