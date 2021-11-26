<?php
class AbmCompraEstado extends AbmSuper{
    
    public function __construct(){
        $this->clase = new CompraEstado();
        $this->id = 'idcompraestado';
    }

    public function finPedido($param, $iduser){
        $abmcompra = new AbmCompra();
        $abmprod = new AbmProducto();
        $abmcompraitem = new AbmCompraItem();
        $compra = ['cofecha' => date('Y-m-d H:i:s'), 'idusuario' => $iduser];
        $idcompra = $abmcompra->alta($compra);
        foreach($param['arreglo'] as $item){
            $prod = $abmprod->buscar(['idproducto' => $item['idproducto']]);
            $compraitem = [
                'idproducto' => $item['idproducto'],
                'idcompra' => $idcompra,
                'cicantidad' => $item['cantidad'],
                'citotal' => $prod[0]['proprecio'] * $item['cantidad']
            ];
            $prod[0]['procantstock'] -= $item['cantidad'];
            $abmprod->modificacion($prod[0]);
            $abmcompraitem->alta($compraitem);
        }
        return $idcompra;
    }

    public function cancelaPedido($param){
        $ret = false;
        $abmcompraitem = new AbmCompraItem();
        $abmproducto = new AbmProducto();
        $compraestado = $this->buscar($param);
        $compraestado[0]['idcompraestadotipo'] = 4;
        $compraestado[0]['cefechafin'] = date('Y-m-d H:i:s');
        if($this->modificacion($compraestado[0])){
            $compraitem = $abmcompraitem->buscar(['idcompra' => $compraestado[0]['idcompra']]);
            foreach($compraitem as $item){
                $prod = $abmproducto->buscar(['idproducto' => $item['idproducto']]);
                $prod[0]['procantstock'] += $item['cicantidad'];
                $abmproducto->modificacion($prod[0]);
            }
            $ret = true;
        }
        return $ret;
    }

    public function aceptaPedido($param){
        $compraestado = $this->buscar(['idcompraestado' => $param]);
        $compraestado[0]['idcompraestadotipo'] = 2;
        return $this->modificacion($compraestado[0]);
    }

    public function enviaPedido($param){
        $compraestado = $this->buscar(['idcompraestado' => $param]);
        $compraestado[0]['idcompraestadotipo'] = 3;
        $compraestado[0]['cefechafin'] = date('Y-m-d H:i:s');
        return $this->modificacion($compraestado[0]);
    }
}
?>