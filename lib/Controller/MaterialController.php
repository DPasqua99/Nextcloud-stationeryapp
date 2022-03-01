<?php
namespace OCA\stationeryapp\Controller;

use Exception;

use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\NotesTutorial\Db\Material;
use OCA\NotesTutorial\Db\MaterialMapper;

class MaterialController extends Controller {

	public function __construct(string $AppName, IRequest $request, MaterialMapper $mapper, $UserId){
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
	*/
	public function create(string $name, int $quantity) {
		$material = new Material();
		$material->setName($name);
		$material->setQuantity($quantity);
		return new DataResponse($this->mapper->insert($note));
	}

	/**
	 * @NoAdminRequired
	*
	* @param int $id
	* @param string $name
	* @param int $quantity
	*/
	public function update(int $id, string $name, int $quantity) {
		try {
			$material = $this->mapper->find($id);
		} catch(Exception $e) {
			return new DataResponse([], Http::STATUS_NOT_FOUND);
		}
		$action->setName($name);
		$action->setQuantity($quantity);
		return new DataResponse($this->mapper->update($material));
	}

	/**
	* @NoAdminRequired
	*
	* @param int $id
	*/
	public function destroy(int $id) {
		try {
			$material = $this->mapper->find($id);
		} catch(Exception $e) {
			return new DataResponse([], Http::STATUS_NOT_FOUND);
		}
		$this->mapper->delete($material);
		return new DataResponse($material);
	}
}