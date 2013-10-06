<?php
/*Cargar los modelos necesarios*/
Load::models('unidades');
class UnidadesController extends AppController
{
    //Inicio metodo index
    public function index(){
        Router::toAction("create");
    }
    //fin metodo index
    
    //inicio metodo create
    public function create()
    {
        if(Input::hasPost('unidades')){
		$unidades = new Unidades();
		if($unidades->create(Input::post('unidades'))){
			Flash::success('Unidad Registrado Correctamente');
			Input::delete();
			return Router::toAction('create');
		}else{
				Flash::error('No se pudo guardar el unidad');
		}
	}

    }
    //fin metodo create
    
    //inicio metodo update
    public function update($id) 
    {
    	View::select('create');
	$unidades = new Unidades();
	if(Input::hasPost('unidades')){
		if($unidades->update(Input::post('unidades'))){
                    Flash::success('La informacion se actualizo');
                    return Router::toAction('lists');
	        }else{
                    Flash::error('No se puede modificar los datos del unidad');
	        }
	}else{		
	     $this->unidades = $unidades->find($id);
   	}

    }
    //fin metodo update
    
    //inicio metodo delete
    public function delete($id) //Para eliminar registros
    {
	view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
	$unidades= new Unidades();
	if ($unidades->delete($id))
            Flash::success('Unidad borrado');
	else
            Flash::error('No se puede eliminar, verifique los datos');
            return Router::toAction('create');//redireciona a donde yo quiero que vaya...
    }
    //fin metodo delete
    
    //inicio metodo lists
    public function lists($page=1)
    {
	$unidades= new Unidades();
	$this->listapersona=$unidades->paginacion($page);
    }
    //fin metodo listar
}