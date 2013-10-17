<?php

load::models('requisicion');
class DespachosController extends AppController
{
    public function create() 
    {
    
    }

	public function consulta()
	{
		$num= new Requisicion();
		if (Input::hasPost('nro_req'))
		{
			if ($num->find(Input::post('nro_req')))
			{
				if ($num->estatus='true')
					Router::redirect("requisiciones/create");
				else
					echo "<script>alert ('Requisición no habilitada...')</script>";
			}
		}
	}
}
