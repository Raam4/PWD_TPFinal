<?php 
include_once "../../../configuracion.php";
$abmUs = new AbmUsuario();
$colUsuarios = $abmUs->buscar(array());

$strhtnl="";
          $strhtnl.="<table id='listUs' class='table table-hover' style='width:1200px'>
                    <thead >
                        <tr >
                            <th scope='col' class='col-1'>ID</th>
                            <th scope='col' class='col-2'>Nombre</th>
                            <th scope='col' class='col-2'>Email</th>
                            <th scope='col' class='col-2'>Contraseña</th>
                            <th scope='col' class='col-1'>Estado</th>
                            <th scope='col' class='col-3' >Acción</th>
                        </tr>
                    </thead>
                    <tbody>";

if (count($colUsuarios) > 0) {
    $strhtnl.="<tr>
    <td></td>
    <td contenteditable class='coledit ' ></td>
    <td contenteditable class='coledit' ></td>
    <td contenteditable class='coledit' ></td>
    <td><i class='bi bi-check2'></i></td>
    <td><button id='altaUs' class='btn btn-outline-secondary' >Alta</button></td>
    
    </tr>";
   foreach ($colUsuarios as $us) {
        $strhtnl.="<tr>
        <td>". $us["idusuario"]."</td>
        <td>". $us["usnombre"] ."</td>
        <td>".$us["usmail"] ."</td> 
        <td> </td>";

        if($us["usdeshabilitado"]==null){
            $strhtnl.="<td> <i class='bi bi-check2'></i> </td>";
            
        }else{
            $strhtnl.="<td> <i class='bi bi-x-lg'></i> </td>";
        }
        $strhtnl.="<td>";
        if($us["usdeshabilitado"]==null){
            $strhtnl.=" <button class='editarUs btn btn-outline-secondary' id='editarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' >Editar</button>
            <button class='btn btn-outline-secondary' id='confirm".$us['idusuario']."'  style='display:none' >Confirmar</button>
            <button class='btn btn-outline-secondary' id='cancel".$us['idusuario']."'  style='display:none' onclick='controlButton(".$us['idusuario'].",0)' >Cancelar</button>
            <button class='borrarUs btn btn-outline-secondary' id='borrarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' >Borrar</button> 
            <a class='btn btn-outline-secondary' id='gestion".$us['idusuario']."' href='../accion/gestionRol.php?idusuario=".$us['idusuario']."' >Gestion rol</a>";

        }        
        if($us["usdeshabilitado"]!=null){
            $strhtnl.="<button class='btn btn-outline-secondary' id='habilUs' data-id='".$us['idusuario'] ."' >Habilitar</button> ";
        }       
 
}
$strhtnl.="</td></tr> </tbody>
        </table>";

}
echo $strhtnl;

?>
<style>
    .inputList{
        height: 25px;
        margin: 0px;
        padding: 0px;
        border: 0px;
        outline: none;
    }
    /* td{
        margin: 0px;
        padding: 0px;
    } */
    .dlgMod{
        padding: 10px;
        width: 40%;
        position: fixed;
        background-color: white;
        border: 2px solid royalblue;
        border-radius: 5px;
        top: 200px;
        left: 30%;
    }

</style>

