<?php
namespace OCA\stationeryapp\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\stationeryapp\Service\NotFoundException;


class ActionControllerTest extends TestCase {

	protected $controller;
	protected $service;
	protected $userId = 'john';
	protected $request;

	public function setUp(): void {
		$this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
		$this->service = $this->getMockBuilder('OCA\stationeryapp\Service\ActionService')
			->disableOriginalConstructor()
			->getMock();
		$this->controller = new ActionController(
			'stationeryapp', $this->request, $this->service, $this->userId
		);
	}

	public function testUpdate(): void {
		$note = 'just check if this value is returned correctly';
		$this->service->expects($this->once())
			->method('update')
			->with($this->equalTo(3),
					$this->equalTo('name'),
					$this->equalTo(1),
					$this->equalTo('material'),
					$this->equalTo('date'))
			->will($this->returnValue($action));

		$result = $this->controller->update(3, 'name', 1, 'material', 'date');

		$this->assertEquals($action, $result->getData());
	}


	public function testUpdateNotFound(): void {
		// test the correct status code if no note is found
		$this->service->expects($this->once())
			->method('update')
			->will($this->throwException(new NotFoundException()));

		$result = $this->controller->update(3, 'name', 1, 'material', 'date');

		$this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
	}

}