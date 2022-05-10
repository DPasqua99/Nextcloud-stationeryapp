<?php
namespace OCA\stationeryapp\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Action extends Entity implements JsonSerializable {

	protected $name;
	protected $material;
	protected $quantity;
	protected $date;

	public function __construct() {
		$this->addType('id','integer');
	}

	public function jsonSerialize() {
		return [
			'id' => $this->id,
			'name' => $this->name,
			'material' => $this->material,
			'quantity' => $this->quantity,
			'date' => $this->date,
		];
	}
}