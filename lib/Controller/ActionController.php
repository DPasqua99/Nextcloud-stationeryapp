<?php
namespace OCA\stationeryapp\Controller;

use Exception;

use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\stationeryapp\Db\Action;
use OCA\stationeryapp\Db\ActionMapper;

class ActionController extends Controller {

	public function __construct(string $AppName, IRequest $request, ActionMapper $mapper,$UserId){
		parent::__construct($AppName, $request);
		$this->mapper = $mapper;
		$this->userId = $UserId;
	}

	/**
	 * @NoAdminRequired
	*/
	public function index() {
		return new DataResponse($this->mapper->findAll());
	}

	/**
	* @NoAdminRequired
	*
	* @param int $id
	*/
	public function show(int $id) {
		try {
			return new DataResponse($this->mapper->find($id));
		} catch(Exception $e) {
			return new DataResponse([], Http::STATUS_NOT_FOUND);
		}
	}

	/**
	* @NoAdminRequired
	*
	* @param string $name
	* @param string $quantity
	* @param int $quantity
	* @param string $date
	*/
	public function create(string $name, int $quantity, string $material) {
		$action = new Action();
		$action->setName($name);
		$action->setQuantity($quantity);
		$action->setMaterial($material);
		$dateTime = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
		$action->setDate($dateTime);
		return new DataResponse($this->mapper->insert($action));
	}

	/**
	 * @NoAdminRequired
	*
	* @param int $id
	* @param string $title
	* @param string $content
	*/
	public function update(int $id, string $name, int $quantity, string $material, string $date) {
		try {
			$action = $this->mapper->find($id);
		} catch(Exception $e) {
			return new DataResponse([], Http::STATUS_NOT_FOUND);
		}
		$action->setName($name);
		$action->setQuantity($quantity);
		$action->setMaterial($material);
		$action->setDate($date);
		return new DataResponse($this->mapper->update($action));
	}

	/**
	* @NoAdminRequired
	*
	* @param int $id
	*/
	public function destroy(int $id) {
		try {
			$action = $this->mapper->find($id);
		} catch(Exception $e) {
			return new DataResponse([], Http::STATUS_NOT_FOUND);
		}
		$this->mapper->delete($action);
		return new DataResponse($action);
	}
}