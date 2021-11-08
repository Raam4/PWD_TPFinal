<?php
/**
 * @property int $idusuario
 * @property string $usnombre
 * @property string $uspass
 * @property string $usmail
 * @property string $usdeshabilitado
 */
class Usuario extends ModOrm{
    public static $_table = 'Usuario';
    public static $_id_column = 'idusuario';

    public function roles(){
        return $this->has_many_through('Rol', 'UsuarioRol', 'idusuario', 'idrol');
    }

    public function compras(){
        return $this->has_many('Compra', 'idusuario', 'idusuario');
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