<?php
namespace OCA\stationeryapp\Tests\Unit\Service;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\stationeryapp\Db\Action;

class ActionServiceTest extends PHPUnit_Framework_TestCase {

    private $service;
    private $mapper;
    private $userId = 'john';

    public function setUp() {
        $this->mapper = $this->getMockBuilder('OCA\stationeryapp\Db\NoteMapper')
            ->disableOriginalConstructor()
            ->getMock();
        $this->service = new ActionService($this->mapper);
    }

    public function testUpdate() {
        // the existing note
        $action = Action::fromRow([
            'id' => 3,
            'name' => 'yo',
            'quantity' => 1,
            'material' => 'material',
            'date' => 'date'
        ]);
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->returnValue($action));

        // the note when updated
        $updatedAction = Action::fromRow(['id' => 3]);
        $updatedAction->setName('name');
        $updatedAction->setQuantity(2);
        $updatedAction->setMaterial('Matite');
        $updatedAction->setDate('22/10/2022');
        $this->mapper->expects($this->once())
            ->method('update')
            ->with($this->equalTo($updatedAction))
            ->will($this->returnValue($updatedAction));

        $result = $this->service->update(3, 'name', 2, 'Matite', '22/10/2022');

        $this->assertEquals($updatedAction, $result);
    }


    /**
     * @expectedException OCA\stationeryapp\Service\NotFoundException
     */
    public function testUpdateNotFound() {
        // test the correct status code if no note is found
        $this->mapper->expects($this->once())
            ->method('find')
            ->with($this->equalTo(3))
            ->will($this->throwException(new DoesNotExistException('')));

        $this->service->update(3, 'name', 2, 'Matite', '22/10/2022');
    }

}