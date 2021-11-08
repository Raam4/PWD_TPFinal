<?php
/**
 * @property int $idcompraestadotipo
 * @property string $cetdescripcion
 * @property string $cetdetalle
 */
class CompraEstadoTipo extends ModOrm{
    public static $_table = 'compraestadotipo';
    public static $_id_column = 'idcompraestadotipo';

    public function compraestado(){
        return $this->belongs_to('CompraEstado', 'idcompraestadotipo', 'idcompraestadotipo');
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