<?php
class Querys{
    public static function create($param, $table){
        $resp = false;
        $tupla = Model::factory($table)->create();
        $tupla->set($param);
        if($tupla->save()){
            $resp = $tupla->id();
        }
        return $resp;
    }
    
    public static function read($param, $table){
        $arreglo = array();
        if($param){
            $res = Model::factory($table)->where($param)->find_result_set();
        }else{
            $res = Model::factory($table)->find_result_set();
        }
        if($res){
            foreach($res as $tupla){
                array_push($arreglo, $tupla->as_array());
            }
        }
        return $arreglo;
    }

    public static function update($param, $table, $id){
        $resp = '';
        $tupla = Model::factory($table)->find_one($param[$id]);
        if(!is_null($tupla)) {
            $tupla->set($param);
            if($tupla->save()){
                $resp = $tupla->id();
            }
        }    
        return $resp;
    }
    
    public static function delete($param, $table, $id){
        $resp = false;
        $tupla = Model::factory($table)->find_one($param[$id]);
        if (!is_null($tupla)) {
            if ($tupla->delete()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    public static function deleteClaveComp($param, $table){
        $resp = false;
        $tupla = Model::factory($table)->where($param)->find_one();
        if (!is_null($tupla)) {
            if ($tupla->delete()){
                $resp = true;
            }
        }
        return $resp;
    }
}
?>