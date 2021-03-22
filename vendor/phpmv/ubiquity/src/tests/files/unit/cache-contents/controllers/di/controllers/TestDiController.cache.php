<?php
return array("iService"=>function($controller){return new services\ui\IService();},"inj"=>function ($ctrl){return new \services\ui\IAllService($ctrl);},"allS"=>function ($controller=null){return new \services\ui\IAllService($controller);});
