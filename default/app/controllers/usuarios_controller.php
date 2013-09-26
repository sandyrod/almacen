<?php
/*Cargar los modelos necesarios*/
Load::models('usuario');
class UsuariosController extends AppController{
/*Inicio el metodo index*/
        public function index(){
            //Redirecciono hacia el metodo login
                return Router::toAction('login'); 
        }
/*Fin el metodo index*/
        
       
        /*Inicio del metodo login
         * Este metodo autentifica a los usuarios y crea una variable de sesion
         */
        public function login(){
            //verifico si se han enviado los datos
            echo "sinhaspost";
        if (Input::hasPost("login","clave")){
            echo "haspost";
            
            if (Session::get('intento')>23){
                Flash::error('Supero el maximo de intentos, intente mas tarde');
            }else{
            //encriptamos la clave utilizando md5
            $pwd = md5(Input::post("clave"));
            //extraemos el login
            $usuario=Input::post("login");
            echo $pwd;
            //Router::redirect("articulos/create");
            /*Utlizamos la clase auth ya que la misma a sido probada por distintas organizaciones
             *y es resistente a distintas tecnicas de hacking
             *Instanciamos la clase auth y le pasamos los parametros
             * model: indica que autentificara contra un modelo
             * class: indica cual sera el modelo que utilizaremos en este caso usuario
             * login y clave
             * nota: la clave en la base de datos tambien debe estar en md5 
             */
             $auth = new Auth("model", "class: usuario", "nomb_usuario: $usuario", "contrasenna: $pwd");
             //ejecuto la autentificacion y valido el resultado
            if ($auth->authenticate()) {
                //si es verdadero creo una variable sesion y almaceno alli el usuario
                Session::set('usuario',$usuario);           
                //opcionalemte podria traer los demas datos del usuario si asi lo requiero
		$user = new usuario();
		//$user->find_first("nomb_usuario= '" .$usuario ."'");
		foreach($user->find("nomb_usuario= '" .$usuario ."'") as $producto){
			Session::set('id',$producto->id);
                        //$_SESSION['usuario'] = $producto->nombre;
		}
	        //$user->id);
                //redirecciono a la pantalla inicial que desee
                Flash::success("Bienvenidos a SICA");
                Router::redirect("articulos/create");
            } else {
                /*Si el metodo autenticar devolvio falso quiere decir que el usuario no es valido
                 * por lo tanto envio uni mensaje inforando y me mantengo en la misma pantalla
                 */
                Flash::error("Usuario o Clave no valida");
                Session::set('intento',Session::get('intento')+1);
            }
        }
        
            }
        }
        /*Fin del metodo login*/
        
        /*Inicio del metodo create
         * Este metodo permite crear nuevos usuarios 
         */
        public function create(){
            if (Session::get('usuario')!='root'){
                Flash::warning("Solo el administrador puede crear nuevos usuarios");
                Router::toAction('login');
            }
            //Valido que el campo login este lleno
                if(Input::hasPost('nomb_usuario')){
                    //valido que la clave no tenga errores 
                        if((Input::post('contrasenna'))==(Input::post('contrasenna2'))){
                            //creo una instancia de nuestro modelo usuario
                                $usuario1 = new Usuario();
                                $usuario1->nomb_usuario = Input::post('nomb_usuario');
                                $usuario1->contrasenna = md5(Input::post('contrasenna'));
				$usuario1->nombre = Input::post('nombre');
                                $usuario1->apellido = Input::post('apellido');
                                $usuario1->cedula = Input::post('cedula');
                                $usuario1->correo = Input::post('correo');
                                $usuario1->tipo = '0';
                                /*
                                 * Grabo los campos en mi modelo
                                 */
                                if($usuario1->save()){
                                    //si guardo correctamente muestro un mensaje
                                        Flash::success('Usuario registrado correctamente');
					Router::toAction('lists');
                                }else{
                                    //si no se pudo grabar encio este mensaje
                                        Flash::error('Algo salio mal, verifique los datos');
                                }
                        }else{
                            //si existe un error en la clave envio este mensaje
                                Flash::error('Las claves no coinciden, verifique los datos e intente nuevamente');
                        }
                }
        }
        /*Fin del metodo create*/
        /*Inicia el metodo del
         * Este metodo sirve para eliminar usuarios
         */
        public function del($id){
        			view::select('null');//porque no va a renderizar ninguna vista, que solo ejecute la opción
			$usuario= new Usuario();
			if ($usuario->delete($id))
				Flash::success('Usuario Eliminado Correctamente');
			else
				Flash::error('No se puede eliminar');
			return Router::toAction('lists');//redireciona a donde yo quiero que vaya...
        }
        /*Fin del metodo del*/
        
        /*Incio del metodo list*/
        public function lists($page = 1){
        	$usuario= new Usuario();
		$this->listausuarios=$usuario->paginacion($page);
        }
        /*Fin del metodo listar*/
        
        /*Inicio del metodo salir
         * Este metodo destruye la sesion y redirecciona al metodo login
         */
	public function salir(){
            //evito que muestre otra vista
		View::select(NULL);
                //elimino la variable de sesion usuario
		Session::delete('usuario');
                Session::delete('intento');
                //redirecciono a login para que no tenga acceso hasta que validemos sus datos
                Router::redirect("usuarios/login");
	}
        //Fin del metodo salir
        public function update($id) 
        {
            View::select('create');
           		$usuario= new Usuario();
			if(Input::hasPost('nomb_usuario'))
			{
                                $usuario->nomb_usuario = Input::post('nomb_usuario');
                                $usuario->contrasenna = md5(Input::post('contrasenna'));
				$usuario->nombre = Input::post('nombre');
                                $usuario->apellido = Input::post('apellido');
                                $usuario->cedula = Input::post('cedula');
                                $usuario->correo = Input::post('correo');
                                $usuario->id = $id;
                                $usuario->tipo = '0';
				if($usuario->update()){
					Flash::success("Actualizado correctamente");
                                    Router::toAction('lists');
                                }else{
					Flash::error("Error");
                                }
			}else{
				//$this->usuarios = $usuario->find($id);
                            //$usuario= new Usuario();
                                foreach($usuario->find("id= '" .$id ."'") as $producto){    
                                    $this->nombre = $producto->nombre;
                                    $this->apellido = $producto->apellido;
                                    $this->correo = $producto->correo;
                                    $this->cedula = $producto->cedula;
                                    $this->contrasenna = $producto->contrasenna;
                                    $this->nomb_usuario = $producto->nomb_usuario;
                                    $this->id=$producto->id;
                                }
			}
		
        }
}
//Fin de la clase usuarios
?>
