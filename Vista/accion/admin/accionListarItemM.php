<?php 
include_once "../../../configuracion.php";
$abmMenu = new AbmMenu();
$colItemMenu = $abmMenu->buscar(null);

$strhtnl="";
          $strhtnl.="<table id='listIt' class='table table-striped text-center'>
                    <thead>
                        <tr >
                            <th scope='col' class='col-1' style='width: 3%'>ID</th>
                            <th scope='col' class='col-2' style='width: 20%'>Nombre</th>
                            <th scope='col' class='col-2' style='width: 47%'>Descripción</th>
                            <th scope='col' class='col-2' style='width: 5%'>ID Padre</th>
                            <th scope='col' class='col-1' style='width: 15%'>Estado</th>
                            <th scope='col' class='col-3' style='width: 10%'>Acción</th>
                        </tr>
                    </thead>
                    <tbody>";

if (count($colItemMenu) > 0) {
    $strhtnl.="<tr>
    <td ></td>
    <td contenteditable class='coledit'></td>
    <td contenteditable class='coledit'></td>
    <td contenteditable class='coledit'></td>
    <td><i class='fa fa-check'></i></td>
    <td><button id='altaIt' class='btn btn-info'><i class='fa fa-plus'></i> </button></td>
    
    </tr>";
   foreach ($colItemMenu as $itm) {
        $strhtnl.="<tr>
        <td>". $itm["idmenu"]."</td>
        <td>". $itm["menombre"] ."</td>
        <td>".$itm["medescripcion"] ."</td>
        <td>".$itm["idpadre"] ."</td> ";
        if($itm["medeshabilitado"]==null || $itm["medeshabilitado"]=='0000-00-00 00:00:00'){
            $strhtnl.="<td><i class='fa fa-check'></i> </td>";
            
        }else{
            $strhtnl.="<td><i class='fa fa-times'></i></td>";
        }
        $strhtnl.="<td>";
        if($itm["medeshabilitado"]==null || $itm["medeshabilitado"]=='0000-00-00 00:00:00'){

            $strhtnl.=" <button class='editarItm btn btn-warning' id='editarIt".$itm['idmenu']."' data-id='".$itm['idmenu'] ."' ><i class='fa fa-pen'></i> </button>
            <button class='btn btn-success' id='confirmIt".$itm['idmenu']."'  style='display:none' ><i class='fa fa-check'></i> </button>
            <button class='btn btn-danger mx-2' id='cancelIt".$itm['idmenu']."'  style='display:none' onclick='controlButton(".$itm['idmenu'].",0)' ><i class='fa fa-times'></i> </button>";

            if(!is_null($itm["idpadre"])){
                $strhtnl .= "<button class='borrarItm btn btn-danger' id='borrarIt".$itm['idmenu']."' data-id='".$itm['idmenu'] ."' onclick='manage(".$itm['idmenu'].")'><i class='fa fa-arrow-down'></i></button>";
            }
        }        
        if($itm["medeshabilitado"]!=null && $itm["medeshabilitado"]!='0000-00-00 00:00:00'){
            $strhtnl.="<button class='btn btn-success' id='habilIt' data-id='".$itm['idmenu'] ."' onclick='manage(".$itm['idmenu'].")'><i class='fa fa-arrow-up'></i> </button> ";
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