<?php
/*Cargar los modelos necesarios*/
Load::models('empleados');
class EmpleadosController extends AppController
{
    //Inicio metodo index
    public function index(){
        Router::toAction("create");
    }
    //fin metodo index
    
    //inicio metodo create
    public function create()
    {
        if(Input::hasPost('empleados')){
		$empleados = new Empleados();
		if($empleados->create(Input::post('empleados'))){
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
	$empleados = new Empleados();
	if(Input::hasPost('empleados')){
		if($empleados->update(Input::post('empleados'))){
                    Flash::success('La informacion se actualizo');
                    return Router::toAction('lists');
	        }else{
                    Flash::error('No se puede modificar los datos del empleado');
	        }
	}else{		
	     $this->empleados = $empleados->find($id);
   	}

    }
    //fin metodo update
    
    //inicio metodo delete
    public function delete($id) //Para eliminar registros
    {
	view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
	$empleados= new Empleados();
	if ($empleados->delete($id))
            Flash::success('Empleado borrado');
	else
            Flash::error('No se puede eliminar, verifique los datos');
            return Router::toAction('create');//redireciona a donde yo quiero que vaya...
    }
    //fin metodo delete
    
    //inicio metodo lists
    public function lists($page=1)
    {
	$empleados= new Empleados();
	$this->listapersona=$empleados->paginacion($page);
    }
    //fin metodo listar
}