<?php

class articulos extends ActiveRecord{
public $debug = false;
         public function paginacion($page, $per_page=25)
        {
	
                return $this->paginate("page: $page", "per_page: $per_page");
        }

        public function obtener_articulos($estado)
        {
        if ($estado != '') {
            $estado = stripcslashes($estado);
            $res = $this->find('columns: descripcion', "descripcion like '%{$estado}%'");
            if ($res) {
                foreach ($res as $estado) {
                    $estados[] = '"' . $estado->descripcion . '"';
                }
                return $estados;
            }
        }
        return array('no hubo coincidencias');
    }

    
        public function obtener_lista()
        {
        
            $J=0;
            $res = $this->find_all_by_sql('select id, descripcion, cant from articulos');
             $tirajson = '[ ';
            foreach ($res as $marca) {
                $tirajson = $tirajson . '{ "id":"' . $marca->id . '" , "descripcion": "' . $marca->descripcion . '", "cant": "' . $marca->cant . '"}, ';
                $J = $J + 1;
             }
            $tirajson = substr($tirajson, 0, strlen($tirajson) - 2);
            $tirajson = $tirajson . ' ]';       
            return $tirajson;
    }
    
                }