<?php

namespace Ubiquity\scaffolding\creators;

use Ubiquity\scaffolding\ScaffoldController;
use Ubiquity\controllers\rest\RestServer;
use Ubiquity\utils\base\UFileSystem;
use Ubiquity\cache\CacheManager;

/**
 * Creates a Rest controller.
 * Ubiquity\scaffolding\creators$RestControllerCreator
 * This class is part of Ubiquity
 *
 * @author jcheron <myaddressmail@gmail.com>
 * @version 1.0.3
 * @category ubiquity.dev
 *
 */
class RestControllerCreator extends BaseControllerCreator {
	private $resource;
	private $baseClass;
	public function __construct($restControllerName, $baseClass,$resource='', $routePath = '') {
		$this->controllerName = $restControllerName;
		if($routePath!=null){
			$this->routePath = '/'.\ltrim($routePath,'/');
		}
		$this->resource=$resource;
		$this->baseClass="\\".$baseClass;
		$this->controllerNS = RestServer::getRestNamespace ();
		$this->templateName = call_user_func($baseClass.'::_getTemplateFile');
	}

	public function create(ScaffoldController $scaffoldController, $reInit = null) {
		$this->scaffoldController = $scaffoldController;
		$controllerName = $this->controllerName;
		$controllerNS = $this->controllerNS;
		$messages = [ ];

		$restControllersDir = \ROOT . \DS . str_replace ( "\\", \DS, $controllerNS );
		UFileSystem::safeMkdir ( $restControllersDir );

		$filename = $restControllersDir . \DS . $controllerName . ".php";
		if (! \file_exists ( $filename )) {
			$templateDir = $scaffoldController->getTemplateDir ();
			$namespace = '';
			if ($controllerNS != null){
				$namespace = "namespace " . $controllerNS . ";";
			}
			$routePath = $this->controllerName;
			$routeAnnot='';
			if ($this->routePath != null) {
				$routePath=$this->routePath;
				$routeAnnot=$this->getRouteAnnotation($this->routePath);
			}
			$variables = [ '%route%' => $routeAnnot,'%controllerName%' => $controllerName,'%namespace%' => $namespace,'%routePath%' => $routePath ,'%baseClass%'=>$this->baseClass];
			$this->addVariablesForReplacement ( $variables );
			$variables ['%uses%'] = $this->getUsesStr();
			UFileSystem::openReplaceWriteFromTemplateFile ( $templateDir . $this->templateName, $filename, $variables );
			$messages [] = $scaffoldController->showSimpleMessage ( "The <b>" . $controllerName . "</b> Rest controller has been created in <b>" . UFileSystem::cleanPathname ( $filename ) . "</b>.", "success", "Rest creation", "checkmark circle", 30000, "msgGlobal" );
			if (isset ( $reInit )) {
				$this->scaffoldController->initRestCache ( false );
			}
		} else {
			$messages [] = $scaffoldController->showSimpleMessage ( "The file <b>" . $filename . "</b> already exists.<br>Can not create the <b>" . $controllerName . "</b> Rest controller!", "warning", "Rest error", "warning circle", 30000, "msgGlobal" );
		}
		$this->scaffoldController->_refreshRest ( true );
		echo implode ( "\n", $messages );
	}

	protected function addVariablesForReplacement(&$variables) {
		$values=[];
		if($this->resource!=null){
			$values['resource']=$this->resource;
		}
		$variables ['%restAnnot%'] = CacheManager::getAnnotationsEngineInstance()->getAnnotation($this,'rest',$values)->asAnnotation();
	}

	protected function addViews(&$messages, &$classContent) {
	}
}

