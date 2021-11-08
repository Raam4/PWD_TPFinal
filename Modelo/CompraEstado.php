<?php
/**
 * @property int $idcompraestado
 * @property int $idcompra
 * @property int $idcompraestadotipo
 * @property date $cefechaini
 * @property date $cefechafin
 */
class CompraEstado extends ModOrm{

    public static $_table = 'compraestado';
    public static $_id_column = 'idcompraestado';
    
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