<?php
namespace controllers;

use models\Group;
use models\Organization;
use models\User;
use services\dao\OrgaRepository;
use services\ui\UIGroups;
use Ubiquity\attributes\items\di\Autowired;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
 * Controller MainController
 */
class MainController extends ControllerBase{
    use WithAuthTrait;

    private $ui;
    private $uiService;

    #[Route('_default', name:'home')]
    public function index(){
        $this->jquery->getHref('a[data-target]', parameters:['historize'=>false,
            'hashLoader'=>'internal','listenerOn'=>'body']);
        $this->jquery->renderView("MainController/index.html");
        //$this->loadView("MainController/index.html");
    }

    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }

    #[Route(path: "test/Ajax",name: "main.testAjax")]
    public function testAjax(){
        $user=DAO::getById(User::class,[1],false);
        //var_dump($user);
        $this->loadDefaultView(['user'=>$user]);
    }

    #[Route('user/details', name:'user.details')]
    public function userDetails($id){
        $user=DAO::getById(User::class,[$id],true);
        echo "Organisation :".$user->getOrganization();
    }
    #[Get('new/user', name: 'new.user')]
    public function newUser(){
        $this->ui->newUser('frm-user');
        $this->jquery->renderView('main/vForm.html');
    }
    #[Autowired]
    private OrgaRepository $repo;

    public function setRepo(OrgaRepository $repo): void {
        $this->repo = $repo;
    }
    public function initialize() {
        $this->ui=new UIGroups($this);
        parent::initialize();
    }
    #[Route('groups/list',name: 'groups.list')]
    public function listGroups(){
    $idOrga=USession::get('idOrga');
    $groups=DAO::getAll(Group::class,'idOrganization= ?',false,[$idOrga]);
    $this->uiService->listGroups($groups);
    $this->jquery->renderDefaultView();
}
    #[Get('newOrga',name: 'newOrga')]
    public function orgaForm() {
    $this->uiService->orgaForm(new Organization());
    $this->jquery->renderDefaultView();
}

    #[Post('addOrga', name:'addOrga')]
    public function addOrga() {
    var_dump($_POST);
    }
}