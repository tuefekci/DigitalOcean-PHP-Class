<?php
namespace DigitalOceanAPI\test;

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

class DigitalOceanUnitTests extends \PHPUnit_Framework_TestCase {
	const CLIENT_ID = "test-client-id";
	const API_KEY = "test-api-key";

	/**
	 * @var \DigitalOceanApi\DigitalOcean
	 */
	private $digitalOcean;

	/**
	 * @var \PHPUnit_Framework_MockObject_MockObject
	 */
	private $apiConnector;

	protected function setUp() {
		$this->digitalOcean = new \DigitalOceanApi\DigitalOcean(DigitalOceanUnitTests::CLIENT_ID, DigitalOceanUnitTests::API_KEY);
		$this->apiConnector = $this->getMock('ApiConnector', array('connectToApi'));
		$this->digitalOcean->setApiConnector($this->apiConnector);
	}

	/**
	 * @param string $expectedParameter
	 * @param string $returnValue
	 * @return void
	 */
	private function initMock($expectedParameter, $returnValue = null) {
		$this->apiConnector->expects($this->once())->method('connectToApi')->with($expectedParameter)->will($this->returnValue($returnValue));
	}

	public function testGetDroplets() {
		$expectedParameter = 'https://api.digitalocean.com/droplets/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->getDroplets();
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

	public function testShowDroplet() {
		$dropletId = 1234;
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showDroplet($dropletId);
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
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/password_reset/?client_id=test-client-id&api_key=test-api-key';
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

	public function testRename() {
		$dropletId = 1234;
		$name = 'name';
		$expectedParameter = 'https://api.digitalocean.com/droplets/1234/rename/?name=name&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->rename($dropletId, $name);
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
		$expectedParameter = 'https://api.digitalocean.com/images/?filter=my_images&client_id=test-client-id&api_key=test-api-key';
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

	public function testTransferImage() {
		$imageId = 1234;
		$regionId = 1;
		$expectedParameter = 'https://api.digitalocean.com/images/1234/transfer/?region_id=1&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->transferImage($imageId, $regionId);
	}

	public function testGetSSHKeys() {
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status":"OK","ssh_keys":[{"id": 10,"name": "office-imac"},{"id": 11,"name": "macbook-air"}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getSSHKeys();
	}

	public function testAddSSHKey() {
		$sshKeyId = 321;
		$name = 'name';
		$ssh_key_pub = 'ssh_key_pub';
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/new/?name=name&ssh_key_pub=ssh_key_pub&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->addSSHKey($sshKeyId, $name, $ssh_key_pub);
	}

	public function testShowSSHKey() {
		$sshKeyId = 321;
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showSSHKey($sshKeyId);
	}

	public function testEditSSHKey() {
		$sshKeyId = 321;
		$ssh_key_pub = 'ssh_key_pub';
		$expectedParameter = 'https://api.digitalocean.com/ssh_keys/321/edit/?ssh_key_pub=ssh_key_pub&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->editSSHKey($sshKeyId, $ssh_key_pub);
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

	public function testGetDomains() {
		$expectedParameter = 'https://api.digitalocean.com/domains/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status":"OK","domains":[{"id": 100,"name":"example.com","ttl":1800,"live_zone_file":"$TTL\\t600\\n@\\t\\tIN\\tSOA\\tNS1.DIGITALOCEAN.COM.\\thostmaster.example.com. (\\n\\t\\t\\t1369261882 ; last update: 2013-05-22 22:31:22 UTC\\n\\t\\t\\t3600 ; refresh\\n\\t\\t\\t900 ; retry\\n\\t\\t\\t1209600 ; expire\\n\\t\\t\\t10800 ; 3 hours ttl\\n\\t\\t\\t)\\n             IN      NS      NS1.DIGITALOCEAN.COM.\\n @\\tIN A\\t8.8.8.8\\n","error":null,"zone_file_with_error":null}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getDomains();
	}

	public function testNewDomain() {
		$name = 'DomainName';
		$ipAddress = '1.2.3.4';
		$expectedParameter = 'https://api.digitalocean.com/domains/new/?name=DomainName&ip_address=1.2.3.4&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->newDomain($name, $ipAddress);
	}

	public function testShowDomain() {
		$domainId = 100;
		$expectedParameter = 'https://api.digitalocean.com/domains/100/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showDomain($domainId);
	}

	public function testDestroyDomain() {
		$domainId = 100;
		$expectedParameter = 'https://api.digitalocean.com/domains/100/destroy/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->destroyDomain($domainId);
	}

	public function testGetDomainRecords() {
		$domainId = 100;
		$expectedParameter = 'https://api.digitalocean.com/domains/100/records/?client_id=test-client-id&api_key=test-api-key';
		$json = '{"status": "OK","records": [{"id": 49,"domain_id": "100","record_type": "A","name": "example.com","data": "8.8.8.8","priority": null,"port": null,"weight": null},{"id": 50,"domain_id": "100","record_type": "CNAME","name": "www","data": "@","priority": null,"port": null,"weight": null}]}';
		$this->initMock($expectedParameter, $json);
		$this->digitalOcean->getDomainRecords($domainId);
	}

	public function testNewDomainRecord() {
		$domainId = 100;
		$recordType = 'A';
		$data = 'test-data';
		$expectedParameter = 'https://api.digitalocean.com/domains/100/records/new/?record_type=A&data=test-data&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->newDomainRecord($domainId, $recordType, $data);
	}

	public function testShowDomainRecord() {
		$domainId = 100;
		$domainRecordId = 123;
		$expectedParameter = 'https://api.digitalocean.com/domains/100/records/123/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->showDomainRecord($domainId, $domainRecordId);
	}

	public function testEditDomainRecord() {
		$domainId = 100;
		$domainRecordId = 123;
		$recordType = 'A';
		$data = 'test-data';
		$expectedParameter = 'https://api.digitalocean.com/domains/100/records/123/edit/?record_type=A&data=test-data&client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->editDomainRecord($domainId, $domainRecordId, $recordType, $data);
	}

	public function testDestroyDomainRecord() {
		$domainId = 100;
		$domainRecordId = 123;
		$expectedParameter = 'https://api.digitalocean.com/domains/100/records/123/destroy/?client_id=test-client-id&api_key=test-api-key';
		$this->initMock($expectedParameter);
		$this->digitalOcean->destroyDomainRecord($domainId, $domainRecordId);
	}
}
