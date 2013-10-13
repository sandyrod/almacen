<?php
class Estados extends ActiveRecord {
 
    public function obtener_estados($estado) {
        if ($estado != '') {
            $estado = stripcslashes($estado);
            $res = $this->find('columns: estado', "estado like '%{$estado}%'");
            if ($res) {
                foreach ($res as $estado) {
                    $estados[] = '"' . $estado->estado . '"';
                }
                return $estados;
            }
        }
        return array('no hubo coincidencias');
    }
 
}