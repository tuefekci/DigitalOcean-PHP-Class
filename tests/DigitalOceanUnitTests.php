<?php
/*************************************************
 * DigitalOcean Unit Test Class
 *
 * Author: Remmelt Pit <remmelt@gmail.com>
 *
 * Copyright (c): 2013 Remmelt Pit, all rights reserved
 * Version: 1.1.0 - 2013-01-16
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *************************************************/
require_once('../DigitalOcean.class.php');

class DigitalOceanUnitTests extends PHPUnit_Framework_TestCase {
	const CLIENT_ID = "test-client-id";
	const API_KEY = "test-api-key";

	/**
	 * @var DigitalOcean
	 */
	private $digitalOcean;

	/**
	 * @var PHPUnit_Framework_MockObject_MockObject
	 */
	private $apiConnector;

	protected function setUp() {
		$this->digitalOcean = new DigitalOcean(DigitalOceanUnitTests::CLIENT_ID, DigitalOceanUnitTests::API_KEY);
		$this->apiConnector = $this->getMock('ApiConnector', array('connectToApi'));
		$this->digitalOcean->setApiConnector($this->apiConnector);
	}

	public function testGetDroplets() {
		$expectedParameter = 'https://api.digitalocean.com/droplets/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->getDroplets();
	}

	/**
	 * @param string $expectedParameter
	 * @param string $returnValue
	 * @return void
	 */
	private function initMock($expectedParameter, $returnValue = null) {
		$this->apiConnector->expects($this->once())->method('connectToApi')->with($expectedParameter)->will($this->returnValue($returnValue));
	}

	public function testShowDroplet() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showDroplet($dropletId);
	}

	public function testNewDroplet() {
		$name = "dropletName";
		$sizeId = 3;
		$imageId = 2;
		$regionId = 1;
		$expectedParameter = 'https://api.digitalocean.com/droplets/new?name=dropletName&size_id=3&image_id=2&region_id=1&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->newDroplet($name, $sizeId, $imageId, $regionId);
	}

	public function testReboot() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/reboot/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->reboot($dropletId);
	}

	public function testPowerCycle() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/power_cycle/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->powerCycle($dropletId);
	}

	public function testShutDown() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/shut_down/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->shutDown($dropletId);
	}

	public function testPowerOff() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/power_off/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->powerOff($dropletId);
	}

	public function testPowerOn() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/power_on/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->powerOn($dropletId);
	}

	public function testResetRootPassword() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/reset_root_password/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->resetRootPassword($dropletId);
	}

	public function testResizeDroplet() {
		$dropletId = 1234;
		$sizeId = 1;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/resize/?size_id=1&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->resizeDroplet($dropletId, $sizeId);
	}

	public function testTakeASnapshot() {
		$dropletId = 1234;
		$name = "snapshotName";
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/snapshot/?name=snapshotName&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->takeASnapshot($dropletId, $name);
	}

	public function testRestore() {
		$dropletId = 1234;
		$imageId = 1;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/restore/?image_id=1&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->restore($dropletId, $imageId);
	}

	public function testRebuild() {
		$dropletId = 1234;
		$imageId = 1;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/rebuild/?image_id=1&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->rebuild($dropletId, $imageId);
	}

	public function testEnableBackups() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/enable_backups/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->enableBackups($dropletId);
	}

	public function testDisableBackups() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/disable_backups/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->disableBackups($dropletId);
	}

	public function testDestroy() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/destroy/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->destroy($dropletId);
	}

	public function testGetRegions() {
		$expectedParameter = 'https://api.digitalocean.com/regions/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status":"OK","regions":[{"id":1,"name":"New York 1"},{"id":2,"name":"Amsterdam 1"}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getRegions();
	}

	public function testGetImages() {
		$expectedParameter = 'https://api.digitalocean.com/images/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status":"OK","images":[{"id":429,"name":"Real Backup 10242011","distribution":"Ubuntu"},{"id":430,"name":"test233","distribution":"Ubuntu"},{"id":431,"name":"test888","distribution":"Ubuntu"},{"id":442,"name":"tesah22","distribution":"Ubuntu"},{"id":443,"name":"testah33","distribution":"Ubuntu"},{"id":444,"name":"testah44","distribution":"Ubuntu"},{"id":447,"name":"ahtest55","distribution":"Ubuntu"},{"id":448,"name":"ahtest66","distribution":"Ubuntu"},{"id":449,"name":"ahtest77","distribution":"Ubuntu"},{"id":458,"name":"Rails3-1Ruby1-9-2","distribution":"Ubuntu"},{"id":466,"name":"NYTD Backup 1-18-2012","distribution":"Ubuntu"},{"id":478,"name":"NLP Final","distribution":"Ubuntu"},{"id":540,"name":"API - Final","distribution":"Ubuntu"},{"id":577,"name":"test1-1","distribution":"Ubuntu"},{"id":578,"name":"alec snapshot1","distribution":"Ubuntu"}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getImages();
	}

	public function testShowImage() {
		$imageId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/images/1234/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showImage($imageId);
	}

	public function testDestroyImage() {
		$imageId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/images/1234/destroy/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->destroyImage($imageId);
	}

	public function testGetSSHKeys() {
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->getSSHKeys();
	}

	public function testShowSSHKey() {
		$sshKeyId = 321;
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showSSHKey($sshKeyId);
	}

	public function testAddSSHKey() {
		$sshKeyId = 321;
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/add/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->addSSHKey($sshKeyId);
	}

	public function testEditSSHKey() {
		$sshKeyId = 321;
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/edit/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->editSSHKey($sshKeyId);
	}

	public function testDestroySSHKey() {
		$sshKeyId = 321;
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/destroy/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->destroySSHKey($sshKeyId);
	}

	public function testGetSizes() {
		$expectedParameter = 'https://api.digitalocean.com/sizes/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status":"OK","sizes":[{"id":33,"name":"512MB"},{"id":34,"name":"1GB"},{"id":35,"name":"2GB"},{"id":36,"name":"4GB"},{"id":37,"name":"8GB"},{"id":38,"name":"16GB"}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getSizes();
	}

}
