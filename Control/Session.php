<?php
class Session{

    /**
     * Constructor de la clase que inicia la sesión
     */
    public function __construct(){
        session_start();
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados
     */
    public function iniciar($usNombre,$psw){  
        $ini=false;
        if($this->validar($usNombre,$psw)){
            $ini=true;
        }   
        return $ini;
    }

    /**
     *  Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar($usNombre,$psw){
        $valido=false;
        $abmUs=new AbmUsuario();
        $list = $abmUs->buscar(["usnombre" => $usNombre, "uspass" => $psw]);
        if($list){
            if($list[0]['usdeshabilitado']==NULL || $list[0]['usdeshabilitado']=="0000-00-00 00:00:00"){
                $_SESSION["idusuario"] = $list[0]['idusuario'];
                $roles = $abmUs->roles(["idusuario"=>$list[0]['idusuario']]);
                $_SESSION["rolactivo"] = $roles[0]['idrol'];
                $_SESSION["carrito"] = array();
                $valido=true;
            }            
        }
        return $valido;
    }

    /**
     * Devuelve true o false si la sesión está activa o no.
     */
    public function activa(){
        $activa=false;
        if(isset($_SESSION["idusuario"])){
            $activa=true;
        }
        return $activa;
    }

    /**
     * Devuelve el usuario logueado como un arreglo
     */
    public function getUsuario(){
        $usuario=null;
        $abmUs=new AbmUsuario();
        $list=$abmUs->buscar(["idusuario"=>$_SESSION["idusuario"]]); 
        if($list){
            $usuario = $list[0];
        }
        return $usuario;
    }

    /**
     * Devuelve los roles del usuario logueado como arreglo de arreglos
     */
    public function getRoles(){
        $uss = $this->getUsuario();
        $abmUs = new AbmUsuario();
        $roles = $abmUs->roles(["idusuario"=>$uss['idusuario']]);
        return $roles;
    }

    /**
     * Devuelve el rol activo del usuario logueado como arreglo
     */
    public function getRolActivo(){
        $abmRol = new AbmRol();
        $rol = $abmRol->buscar(["idrol"=>$_SESSION['rolactivo']]);
        return $rol[0];
    }

    public function setRolActivo($idrol){
        $ret = false;
        $roles = $this->getRoles();
        $i = 0;
        while($i<count($roles) && !$ret){
            if($roles[$i]['idrol'] == $idrol){
                $_SESSION['rolactivo'] = $idrol;
                $ret = true;
            }
            $i++;
        }
    }

    public function getCarrito(){
        return $_SESSION["carrito"];
    }

    /**
     * Recibe un arreglo asociativo con claves idproducto y cantidad
     */
    public function sumarAlCarrito($param){
        $abmprod = new AbmProducto();
        $var = false;
        $i = 0;
        $stock = 0;
        while($i < count($_SESSION['carrito']) && !$var){
            if($_SESSION['carrito'][$i]['idproducto'] == $param['idproducto']){
                $prod = $abmprod->buscar(['idproducto' => $param['idproducto']]);
                $prod[0]['procantstock'] -= $param['cantidad'];
                $stock = $prod[0]['procantstock'];
                $abmprod->modificacion($prod[0]);
                $_SESSION['carrito'][$i]['cantidad'] += $param['cantidad'];
                $var = true;
            }else{
                $i++;
            }
        }
        if(!$var){
            $prod = $abmprod->buscar(['idproducto' => $param['idproducto']]);
            $prod[0]['procantstock'] -= $param['cantidad'];
            $stock = $prod[0]['procantstock'];
            $abmprod->modificacion($prod[0]);
            array_push($_SESSION['carrito'], $param);
        }
        return $stock;
    }

    /**
     * Recibe un arreglo asociativo con claves idproducto y cantidad
     */
    public function restarAlCarrito($param){
        $abmprod = new AbmProducto();
        $var = false;
        $i = 0;
        while($i < count($_SESSION['carrito']) && !$var){
            if($_SESSION['carrito'][$i]['idproducto'] == $param['idproducto']){
                $prod = $abmprod->buscar(['idproducto' => $param['idproducto']]);
                $prod[0]['procantstock'] += $param['cantidad'];
                $abmprod->modificacion($prod[0]);
                $_SESSION['carrito'][$i]['cantidad'] -= $param['cantidad'];
                if($_SESSION['carrito'][$i]['cantidad'] == 0){
                    unset($_SESSION['carrito'][$i]);
                }
                $var = true;
            }else{
                $i++;
            }
        }
        return $var;
    }

    public function vaciarCarrito(){
        $abmprod = new AbmProducto();
        foreach($_SESSION['carrito'] as $item){
            $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
            $prod[0]['procantstock'] += $item['cantidad'];
            $abmprod->modificacion($prod[0]);
        }
        return $_SESSION['carrito'] = array();
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar(){
        if($_SESSION['carrito']){
            $this->vaciarCarrito();
        }
        return session_destroy();
    }
}
