<?php 
include_once "../../../configuracion.php";
$abmUs = new AbmUsuario();
$colUsuarios = $abmUs->buscar(array());

$strhtnl="";
          $strhtnl.="<table id='listUs' class='table table-striped text-center'>
                    <thead >
                        <tr >
                            <th scope='col' class='col-1' style='width: 3%'>ID</th>
                            <th scope='col' class='col-2' style='width: 20%'>Nombre</th>
                            <th scope='col' class='col-2' style='width: 27%'>Email</th>
                            <th scope='col' class='col-2' style='width: 20%'>Teléfono</th>
                            <th scope='col' class='col-2' style='width: 20%'>Contraseña</th>
                            <th scope='col' class='col-1' style='width: 5%'>Estado</th>
                            <th scope='col' class='col-3' style='width: 25%'>Acción</th>
                        </tr>
                    </thead>
                    <tbody>";

if (count($colUsuarios) > 0) {
    $strhtnl.="<tr>
    <td></td>
    <td contenteditable class='coledit ' ></td>
    <td contenteditable class='coledit' ></td>
    <td contenteditable class='coledit' ></td>
    <td contenteditable class='coledit' style='-webkit-text-security: disc;' ></td>
    <td><i class='fa fa-check'></i></td>
    <td><button id='altaUs' class='btn btn-info' title='Alta Usuario' ><i class='fa fa-plus'></i> </button></td>
    
    </tr>";
   foreach ($colUsuarios as $us) {
        $strhtnl.="<tr>
        <td>". $us["idusuario"]."</td>
        <td class='contmod' >". $us["usnombre"] ."</td>
        <td class='contmod' >".$us["usmail"] ."</td>
        <td class='contmod' >".$us["ustelefono"] ."</td>  
        <td> </td>";
        

        if($us["usdeshabilitado"]==null){
            $strhtnl.="<td> <i class='fa fa-check'></i> </td>";
            
        }else{
            $strhtnl.="<td> <i class='fa fa-times'></i> </td>";
        }
        $strhtnl.="<td>";
        if($us["usdeshabilitado"]==null){
            $strhtnl.=" <button class='editarUs btn btn-warning' id='editarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' title='Editar' ><i class='fa fa-pen'></i> </button>
            <button class='btn btn-success' id='confirm".$us['idusuario']."'  style='display:none' title='Confirmar' ><i class='fa fa-check'></i></button>
            <button class='btn btn-danger mx-2' id='cancel".$us['idusuario']."'  style='display:none' onclick='controlButton(".$us['idusuario'].",0)' title='Cancelar'><i class='fa fa-times'></i></button>
            <button class='borrarUs btn btn-danger' id='borrarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' title='Borrar Usuario'><i class='fa fa-arrow-down'> </i></button>
            <button class='btn btn-info' id='gestion".$us['idusuario']."' title='Roles' onclick='roles(".$us['idusuario'].")'><i class='fa fa-user'></i></button>
            "; 
        }        
        if($us["usdeshabilitado"]!=null){
            $strhtnl.="<button class='btn btn-success' id='habilUs' data-id='".$us['idusuario'] ."' title='Habilitar' ><i class='fa fa-arrow-up'></i> </button> ";
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

