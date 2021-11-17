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
     * Recibe int con el idproducto
     */
    public function agregarAlCarrito($param){
        $var = false;
        if(!in_array($param, $_SESSION['carrito'])){
            array_push($_SESSION['carrito'], $param);
            $var = true;
        }
        return $var;
    }

    /**
     * Recibe un arreglo asociativo con claves idproducto y cantidad
     */
    public function sacarDelCarrito($param){
        $var = false;
        $i = 0;
        while($i<count($_SESSION['carrito']) && !$var){
            if($_SESSION['carrito'][$i] == $param){
                unset($_SESSION['carrito'][$i]);
                $var = true;
            }
            $i++;
        }
        sort($_SESSION['carrito']);
        return $var;
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar(){
        return session_destroy();
    }
}
