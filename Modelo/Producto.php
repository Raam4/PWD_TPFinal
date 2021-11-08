<?php
/**
 * @property int $idproducto
 * @property int $pronombre
 * @property string $prodetalle
 * @property int $procantstock
 * @property double $proprecio
 */
class Producto extends ModOrm{
    public static $_table = 'Producto';
    public static $_id_column = 'idproducto';

    public function compraitems(){
        return $this->belongs_to('CompraItem', 'idproducto', 'idproducto');
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