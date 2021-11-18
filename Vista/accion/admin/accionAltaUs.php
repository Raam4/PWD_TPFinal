<?php 
include_once "../../../configuracion.php";
$data = data_submitted();
$respuesta = false;
if (isset($data['usnombre'])){
        $abmUs = new AbmUsuario();
        $data['uspass']=(md5($data['uspass']));
        $respuesta = $abmUs->alta($data);
        if (!$respuesta){
            $mensaje = " La accion  ALTA No pudo concretarse";
            
        }
}
$retorno['respuesta'] = $respuesta;
if (isset($mensaje)){
    
    $retorno['errorMsg']=$mensaje;
   
}
 echo json_encode($retorno);
?>
