<?php
namespace OCA\stationeryapp\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\stationeryapp\Db\Action;
use OCA\stationeryapp\Db\ActionMapper;


class NoteService {

    private $mapper;

    public function __construct(ActionMapper $mapper){
        $this->mapper = $mapper;
    }

    public function findAll(string $userId) {
        return $this->mapper->findAll($userId);
    }

    private function handleException ($e) {
        if ($e instanceof DoesNotExistException ||
            $e instanceof MultipleObjectsReturnedException) {
            throw new NotFoundException($e->getMessage());
        } else {
            throw $e;
        }
    }

    public function find(int $id) {
        try {
            return $this->mapper->find($id);

        // in order to be able to plug in different storage backends like files
        // for instance it is a good idea to turn storage related exceptions
        // into service related exceptions so controllers and service users
        // have to deal with only one type of exception
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function create(string $name, int $quantity, string $material) {
        $action = new Action();
        $action->setName($name);
        $action->setQuantity($quantity);
        $action->setMaterial($material);
        $dateTime = new DateTime("now", new DateTimeZone('America/Los_Angeles'));
		$action->setDate($dateTime);
        return $this->mapper->insert($action);
    }

    public function update(int $id, string $name, int $quantity, string $material, string $date) {
        try {
            $action = $this->mapper->find($id);
            $action->setName($name);
            $action->setQuantity($quantity);
            $action->setMaterial($material);
            $action->setDate($date);
            return $this->mapper->update($action);
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

    public function delete(int $id) {
        try {
            $action = $this->mapper->find($id);
            $this->mapper->delete($action);
            return $action;
        } catch(Exception $e) {
            $this->handleException($e);
        }
    }

}