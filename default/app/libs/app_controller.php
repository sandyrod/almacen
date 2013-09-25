<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
Load::models('bitacora');
class AppController extends Controller
{
    public $site = 'http://localhost/almacen/default/';

    final protected function initialize()
    {
                
                View::template('krisley');
                $bitaco = new bitacora();
                $bitaco->clase=$this->controller_name;
                $bitaco->metodo=$this->action_name;
                $bitaco->usuario= Session::get('usuario');
                $bitaco->save();
    }

    final protected function finalize()
    {
        
    }

}
