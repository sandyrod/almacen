<?php
class departamentos extends ActiveRecord{

         public function paginacion($page, $per_page=25)
        {
	
                return $this->paginate("page: $page", "per_page: $per_page");
        }
}