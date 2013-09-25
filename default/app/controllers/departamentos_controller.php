<?php
/*Cargar los modelos necesarios*/
Load::models('departamentos');
class DepartamentosController extends AppController
{
    //Inicio metodo index
    public function index(){
        Router::toAction("create");
    }
    //fin metodo index
    
    //inicio metodo create
    public function create()
    {
        if(Input::hasPost('departamentos')){
		$departamentos = new Departamentos();
		if($departamentos->create(Input::post('departamentos'))){
			Flash::success('Empleado Registrado Correctamente');
			Input::delete();
			return Router::toAction('create');
		}else{
				Flash::error('No se pudo guardar el empleado');
		}
	}

    }
    //fin metodo create
    
    //inicio metodo update
    public function update($id) 
    {
    	View::select('create');
	$departamentos = new Departamentos();
	if(Input::hasPost('departamentos')){
		if($articulos->update(Input::post('departamentos'))){
                    Flash::success('La informacion se actualizo');
                    return Router::toAction('lists');
	        }else{
                    Flash::error('No se puede modificar los datos del empleado');
	        }
	}else{		
	     $this->departamentos = $departamentos->find($id);
   	}

    }
    //fin metodo update
    
    //inicio metodo delete
    public function delete($id) //Para eliminar registros
    {
	view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
	$departamentos= new Departamentos();
	if ($departamentos->delete($id))
            Flash::success('Empleado borrado');
	else
            Flash::error('No se puede eliminar, verifique los datos');
            return Router::toAction('create');//redireciona a donde yo quiero que vaya...
    }
    //fin metodo delete
    
    //inicio metodo lists
    public function lists($page=1)
    {
	$departamentos= new Departamentos();
	$this->listapersona=$departamentos->paginacion($page);
    }
    //fin metodo listar
}