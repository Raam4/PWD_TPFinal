<?php
/**
 * @property int $idcompra
 * @property date $cofecha
 * @property int $idusuario
 */
class Compra extends ModOrm{
    public static $_table = 'Compra';
    public static $_id_column = 'idcompra';

    public function compraestado(){
        return $this->has_one('CompraEstado', 'idcompra', 'idcompra');
    }

    public function compraitems(){
        return $this->has_many('CompraItem', 'idcompra', 'idcompra');
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