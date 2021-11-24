<?php
/**
 * @property int $idusuario
 * @property int $idrol
 */

//Verificar bien el funcionamiento de claves compuestas

class UsuarioRol extends ModOrm{
    
    public static $_table = 'usuariorol';
    public static $_id_column = array('idusuario', 'idrol');
    
    public function retornaObj($param){
        return Model::factory(self::$_table)->find_one($param);
    }
    
    public function insertar($param){
        return Querys::create($param, self::$_table);
    }
    
    public function modificar($param){
        return Querys::update($param, self::$_table, self::$_id_column);
    }
    
    public function eliminar($param){
        return Querys::deleteClaveComp($param, self::$_table);
    }
    
    public function listar($param){
        return Querys::read($param, self::$_table);
    }
}
?>