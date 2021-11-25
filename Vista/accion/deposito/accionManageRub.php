<?php
include_once("../../../configuracion.php");
$data = data_submitted();
$abmprod = new AbmRubro();
if(isset($stat)){
    $abmprod->manage(['idrubro' => $data]);
}else{
    $abmrub = new AbmRubro();
    if(isset($data['idrubro'])){
        $rubro = $abmrub->buscar(['idrubro' => $data['idrubro']]);
        $rubro[0]['runombre'] = $data['runombre'];
        $id = $abmrub->modificacion($rubro[0]);
    }else{
        $id = $abmrub->alta(['runombre' => $data['runombre']]);
    }
    echo json_encode($id);
}
?>