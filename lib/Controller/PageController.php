<?php

declare(strict_types=1);

namespace OCA\stationeryapp\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\Util;

class PageController extends Controller {
	protected $appName;

	public function __construct($appName, IRequest $request) {
		parent::__construct($appName, $request);
		$this->appName = $appName;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index() {
		Util::addScript($this->appName, 'stationeryapp-main');

		$response = new TemplateResponse('stationeryapp','main');
		return $response;
	}
}