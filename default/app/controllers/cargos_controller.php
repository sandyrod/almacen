<?php
/*Cargar los modelos necesarios*/
Load::models('cargos');
class cargosController extends AppController
{
    //Inicio metodo index
    public function index(){
        Router::toAction("create");
    }
    //fin metodo index
    
    //inicio metodo create
    public function create()
    {
        if(Input::hasPost('cargos')){
		$cargos = new cargos();
		if($cargos->create(Input::post('cargos'))){
			Flash::success('Cargo Registrado Correctamente');
			Input::delete();
			return Router::toAction('create');
		}else{
				Flash::error('No se pudo guardar el cargo');
		}
	}

    }
    //fin metodo create
    
    //inicio metodo update
    public function update($id) 
    {
    	View::select('create');
	$cargos = new cargos();
	if(Input::hasPost('cargos')){
		if($cargos->update(Input::post('cargos'))){
                    Flash::success('La informacion se actualizo');
                    return Router::toAction('lists');
	        }else{
                    Flash::error('No se puede modificar los datos del cargo');
	        }
	}else{		
	     $this->cargos = $cargos->find($id);
   	}

    }
    //fin metodo update
    
    //inicio metodo delete
    public function delete($id) //Para eliminar registros
    {
	view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
	$cargos= new cargos();
	if ($cargos->delete($id))
            Flash::success('Cargo borrado');
	else
            Flash::error('No se puede eliminar, verifique los datos');
            return Router::toAction('create');//redireciona a donde yo quiero que vaya...
    }
    //fin metodo delete
    
    //inicio metodo lists
    public function lists($page=1)
    {
	$cargos= new cargos();
	$this->listapersona=$cargos->paginacion($page);
    }
    //fin metodo listar
}