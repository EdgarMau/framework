<?php

namespace controllers;

use services\ui\IService;
use Ubiquity\controllers\Controller;
use services\ui\IInjected;
use Ubiquity\cache\CacheManager;
use Ubiquity\controllers\Startup;
use Ubiquity\exceptions\RestException;

/**
 * Controller TestDiController
 *
 * @property \services\ui\IAllService allS
 */
class TestDiController extends Controller {
	/**
	 *
	 * @autowired
	 * @var IService
	 */
	private $iService;

	public function initCache() {
		$config = Startup::getConfig ();
		CacheManager::start ( $config );
		try {
			CacheManager::initCache ( $config );
		} catch ( RestException $e ) {
		}
	}

	/**
	 *
	 * @injected
	 * @var IInjected
	 */
	public $inj;

	public function index() {
	}

	public function autowired() {
		$this->iService->do ( "!:autowired:!" );
	}

	public function injected() {
		$this->inj->do ( "!:injected:!" );
	}

	public function allInjected() {
		$this->allS->do ( "!:*injected:!" );
	}

	public function setIService($iService) {
		$this->iService = $iService;
	}
}
