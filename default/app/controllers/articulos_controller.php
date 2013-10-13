<?php
/*Cargar los modelos necesarios*/
Load::models('articulos', 'estados');
class ArticulosController extends AppController
{
    //Inicio metodo index
    public function index(){
        Router::toAction("create");
    }
    //fin metodo index
    
    //inicio metodo create
    public function create()
    {
        $estados = new articulos();
	$this->query= $estados->obtener_articulos('%');
        if(Input::hasPost('articulos')){
		$articulos = new Articulos();
		if($articulos->create(Input::post('articulos'))){
			Flash::success('Articulo Registrado Correctamente');
			Input::delete();
			return Router::toAction('create');
		}else{
				Flash::error('No se pudo guardar el articulo');
		}
	}

    }
    //fin metodo create
    
    //inicio metodo update
    public function update($id) 
    {
    	View::select('create');
	$articulos = new Articulos();
	if(Input::hasPost('articulos')){
		if($articulos->update(Input::post('articulos'))){
                    Flash::success('La informacion se actualizo');
                    return Router::toAction('lists');
	        }else{
                    Flash::error('No se puede modificar el articulo');
	        }
	}else{		
	     $this->articulo = $articulos->find($id);
   	}

    }
    //fin metodo update
    
    //inicio metodo delete
    public function delete($id) //Para eliminar registros
    {
	view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
	$articulos= new Articulos();
	if ($articulos->delete($id))
            Flash::success('Articulo borrado');
	else
            Flash::error('No se puede eliminar, verifique los datos');
            return Router::toAction('create');//redireciona a donde yo quiero que vaya...
    }
    //fin metodo delete
    
    //inicio metodo lists
    public function lists($page=1)
    {
	$articulos= new Articulos();
	$this->listapersona=$articulos->paginacion($page);
    }
    //fin metodo listar
        public function autocomplete() {
        View::template(NULL);
        View::select(NULL);
        //if (Input::isAjax()) { //solo devolvemos los estados si se accede desde ajax 
            $busqueda = Input::post('busqueda');
            $estados = Load::model('estados')->obtener_estados($busqueda);
            die(json_encode($estados)); // solo devolvemos los datos, sin template ni vista
            //json_encode nos devolverá el array en formato json ["aragua","carabobo","..."]
        //}
    }
    public function listar()
    {
        View::template(NULL);
        View::select(NULL);
        $articulos= new Articulos();
        echo $articulos->obtener_lista();
        //echo "algo";
    }
}