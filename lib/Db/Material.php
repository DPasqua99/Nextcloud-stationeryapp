<?php
namespace OCA\stationeryapp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Material extends Entity implements JsonSerializable {

	protected $name;
	protected $quantity;

	public function __construct() {
		$this->addType('id','integer');
	}

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'quantity' => $this->quantity,
		];
	}
}