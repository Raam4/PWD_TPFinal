<?php
/**
 * @property int $idrol
 * @property string $rodescripcion
 */
class Rol extends ModOrm{
    public static $_table = 'Rol';
    public static $_id_column = 'idrol';

    public function usuarios(){
        return $this->has_many_through('Usuario', 'UsuarioRol', 'idrol', 'idusuario');
    }

    public function menus(){
        return $this->has_many_through('Menu', 'MenuRol', 'idrol', 'idmenu');
    }

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
        return Querys::delete($param, self::$_table, self::$_id_column);
    }
    
    public function listar($param){
        return Querys::read($param, self::$_table);
    }
}
?>