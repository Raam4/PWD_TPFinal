<?php
/**
 * @property int $idmenu
 * @property string $menombre
 * @property string $medescripcion
 * @property int $idpadre
 * @property date $medeshabilitado
 */
class Menu extends ModOrm{
    
    public static $_table = 'Menu';
    public static $_id_column = 'idmenu';

    public function roles(){
        return $this->has_many_through('Rol', 'MenuRol', 'idmenu', 'idrol');
    }

    public function submenus(){
        return $this->has_many(self::$_table, 'idpadre', 'idmenu');
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