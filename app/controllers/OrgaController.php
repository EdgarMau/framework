<?php
namespace controllers;
 use models\Organization;

 /**
  * Controller OrgaController
  */
class OrgaController extends ControllerBase{
    #[Route('orga')]
	public function index(){
		$orgas=DAO::getAll(Organization::class,"",['groupes.users']);
		var_dump($orgas);
		$this->loadView("OrgaController/index.html",['orgas'=>$orgas]);
	}
}
