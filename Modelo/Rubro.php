<?php
/**
 * @property int $idrubro
 * @property string $rudescripcion
 * @property int $idpadre
 */
class Rubro extends ModOrm{
    
    public static $_table = 'Rubro';
    public static $_id_column = 'idrubro';

    public function productos(){
        return $this->has_many('Producto', 'idrubro', 'idrubro');
    }

    public function subrubros(){
        return $this->has_many(self::$_table, 'idpadre', 'idrubro');
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