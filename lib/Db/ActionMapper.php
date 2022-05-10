<?php
namespace OCA\stationeryapp\Db;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

class ActionMapper extends QBMapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'stationeryapp_action', Action::class);
    }

    public function find(int $id) {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
            ->from($this->getTableName())
            ->where($qb->expr()->eq('id', $qb->createNamedParameter($id)));
        return $this->findEntity($qb);
    }

    public function findAll() {
        $qb = $this->db->getQueryBuilder();

        $qb->select('*')
           ->from($this->getTableName());

        return $this->findEntities($qb);
    }

}