<?php
class Maker{
    public static function perfil($param){
        $strhtml = '';
        $strroles = '';
        if($param){
            if($param['roles']){
                foreach($param['roles'] as $rol){
                    if($param['rolactivo'] == $rol){
                        $strroles .='
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>'.$rol['rodescripcion'].'</p>
                                </a>
                            </li>
                        ';
                    }else{
                        $strroles .='
                            <li class="nav-item">
                                <a class="nav-link" href="../public/Index.php?newrol='.$rol['idrol'].'">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>'.$rol['rodescripcion'].'</p>
                                </a>
                            </li>
                        ';
                    }
                }
            }else{
                $strroles .= '<li><a class="nav-link" href="#">Sin asignar</a></li>';
            }
            $strhtml = '
                <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="far fa-user nav-icon"></i>
                            <p>'.$param['user']['usnombre']. '
                            <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../public/misDatos.php" class="nav-link">
                                <i class="far fa-pencil nav-icon"></i>
                                <p>Mis datos</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Roles
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                '.$strroles.'
                            </ul>
                        </li>
                    </ul>
                </li>
            ';
        }else{
            $strhtml = '
                <li class="nav-item">
                    <a href="../public/login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt nav-icon"></i>
                        <p>Iniciar Sesión</p>
                    </a>
                </li>
            ';
        }
        return $strhtml .= '<hr style="color: whitesmoke;">';
    }

    public static function menu($rol){
        $strhtml = '';
        $abmrol = new AbmRol();
        $abmmenu = new AbmMenu();
        $menus = $abmrol->menus($rol);
        $idmenu = $menus[0]['idmenu'];
        $strhtml = '<li class="nav-header"><b>'.ucfirst($menus[0]['menombre']).'</b></li>';
        foreach($abmmenu->submenus(['idmenu' => $idmenu]) as $submenu){
            if($submenu['medeshabilitado'] == "0000-00-00 00:00:00" || is_null($submenu['medeshabilitado'])){
                $dosub = $abmmenu->submenus(['idmenu' => $submenu['idmenu']]);
                if($dosub){
                    $strhtml .= '
                        <li class="nav-item">
                            <a href="../'.$menus[0]['menombre'].'/'.$submenu['menombre'].'.php" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>
                                    '.ucfirst($submenu['menombre']).'
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                    ';
                    foreach($dosub as $subsubmenu){
                        if($submenu['medeshabilitado'] == "0000-00-00 00:00:00" || is_null($submenu['medeshabilitado'])){
                            $strhtml .= '
                                <li class="nav-item">
                                    <a href="../'.$submenu['menombre'].'/'.$subsubmenu['menombre'].'.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>'.ucfirst($subsubmenu['menombre']).'</p>
                                    </a>
                                </li>
                            ';
                        }
                    }
                    $strhtml .= '</ul></li>';
                }else{
                    $strhtml .= '
                    <li class="nav-item">
                        <a href="../'.$menus[0]['menombre'].'/'.$submenu['menombre'].'.php" class="nav-link">
                            <i class="fas fa-circle nav-icon"></i>
                            <p id="'.$submenu['menombre'].'">'.ucfirst($submenu['menombre']).'</p>
                        </a>
                    </li>
                    ';
                }
            }
        }
        return $strhtml;
    } 
}
?>