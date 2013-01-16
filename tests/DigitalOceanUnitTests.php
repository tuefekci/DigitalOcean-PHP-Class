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

	var $digitalOcean;

	public function testGetDroplets() {
		$this->digitalOcean = $this->getMock('ApiConnector', array('connectTo'), array(DigitalOceanUnitTests::CLIENT_ID, DigitalOceanUnitTests::API_KEY));
		$this->digitalOcean->expects($this->any())->method('connectTo')->will($this->returnValue('done'));
		//new DigitalOcean(DigitalOceanUnitTests::CLIENT_ID, DigitalOceanUnitTests::API_KEY);
//		$this->getMock()

		var_dump($this->digitalOcean->());

	}
}
