<?php
namespace controllers;
use models\Basket;
use models\Order;
use models\Product;
use models\Section;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\controllers\auth\AuthController;
use Ubiquity\controllers\auth\WithAuthTrait;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

/**
 * Controller MainController
 **/
class MainController extends ControllerBase{

    use WithAuthTrait;

    #[Route ('_default', name:'home')]
    public function index(){
        $this->loadDefaultView();
    }

    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }

    #[Route ('store', name:'store')]
    public function store(){
        $store = DAO::getAll(Product::class, false, false);
        $listCat = DAO::getAll(Section::class,'', ['products']);
        $listPromo = DAO::getAll(Product::class, 'promotion< ?', false, [0]);
        $this->loadDefaultView(['store'=>$store,'listSection'=>$listCat, 'listProm'=>$listPromo ]);
    }
    #[Route ('order',name:'order')]
    public function order(){
        $order = DAO::getAll(Order::class, 'idUser = ?', false,[USession::get("idUser")]);
        $this->loadDefaultView(['order'=>$order]);
    }

    #[Route ('Basket', name:'basket')]
    public function basket(){
        $basket=DAO::getAll(Basket::class, 'idUser = ?',false,[USession::get("idUser")]);
    }
}