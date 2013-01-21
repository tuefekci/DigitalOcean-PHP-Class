<?php
namespace DigitalOceanAPI;

/**
 * DigitalOcean PHP Class
 *
 * Author: Giacomo Tüfekci <giacomo.tuefekci@googlemail.com>
 * Additions: Remmelt Pit <remmelt@gmail.com>
 *
 * Copyright (c): 2012 Is.It.Media, all rights reserved
 * Version: 1.0.0 - 2012-10-26
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
 *
 * You may contact the author of DigitalOcean PHP Class by e-mail at:
 * giacomo.tuefekci@googlemail.com
 *
 * The latest version of DigitalOcean PHP Class can be obtained from:
 * https://github.com/tuefekci/DigitalOcean-PHP-Class
 */
class DigitalOcean {

	/**
	 * The API base url
	 */
	const API_URL = 'https://api.digitalocean.com';

	/**
	 * The Client ID as provided by Digital Ocean
	 * @var string
	 */
	private $clientId; // API - CLIENT ID

	/**
	 * The API key as provided by Digital Ocean
	 * @var string
	 */
	private $apiKey; // API - KEY

	/**
	 * External connection class to facilitate testing
	 * @var ApiConnector
	 */
	private $apiConnector;

	########################
	# Base Functions
	########################	

	/**
	 * Setter for the API connector class
	 * @param ApiConnector $apiConnector
	 */
	public function setApiConnector($apiConnector) {
		$this->apiConnector = $apiConnector;
	}

	/**
	 * Constructor
	 * @param String $clientId
	 * @param String $apiKey
	 */
	public function __construct($clientId, $apiKey) {
		$this->clientId = $clientId;
		$this->apiKey = $apiKey;
	}

	/**
	 * Send command to API
	 * @param $action
	 * @return mixed
	 */
	private function connectTo($action) {
		$uri = DigitalOcean::API_URL . '/' . $action;
		$uri .= strpos($uri, '?') !== false ? '&' : '?';
		$uri .= 'client_id=' . $this->clientId . '&api_key=' . $this->apiKey;

		return json_decode($this->apiConnector->connectToApi($uri));
	}

	########################
	# Droplets
	########################

	/**
	 * Show All Active Droplets
	 * This method returns all active droplets that are currently running in your account. All available API information is presented for each droplet.
	 * @return mixed
	 */
	public function getDroplets() {
		return $this->connectTo('droplets/');
	}

	/**
	 * Show Droplet
	 * This method returns full information for a specific droplet ID that is passed in the URL.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function showDroplet($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/');
	}

	/**
	 * New Droplet
	 * This method returns full information for a specific droplet ID that is passed in the URL.
	 * @param string $name
	 * @param int $sizeId
	 * @param int $imageId
	 * @param int $regionId
	 * @return mixed
	 */
	public function newDroplet($name, $sizeId, $imageId, $regionId) {
		return $this->connectTo('droplets/new?name=' . $name . '&size_id=' . $sizeId . '&image_id=' . $imageId . '&region_id=' . $regionId);
	}

	/**
	 * Reboot Droplet
	 * This method allows you to reboot a droplet. This is the preferred method to use if a server is not responding.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function reboot($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/reboot/');
	}

	/**
	 * Power Cycle Droplet
	 * This method allows you to power cycle a droplet. This will turn off the droplet and then turn it back on.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function powerCycle($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/power_cycle/');
	}

	/**
	 * Shut Down Droplet
	 * This method allows you to shutdown a running droplet. The droplet will remain in your account.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function shutDown($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/shut_down/');
	}

	/**
	 * Power Off
	 * This method allows you to power off a running droplet. The droplet will remain in your account.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function powerOff($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/power_off/');
	}

	/**
	 * Power On
	 * This method allows you to power on a powered off droplet.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function powerOn($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/power_on/');
	}

	/**
	 * Reset Root Password
	 * This method will reset the root password for a droplet. Please be aware that this will reboot the droplet to allow resetting the password.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function resetRootPassword($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/reset_root_password/');
	}

	/**
	 * Resize Droplet
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $dropletId
	 * @param int $sizeId
	 * @return mixed
	 */
	public function resizeDroplet($dropletId, $sizeId) {
		return $this->connectTo('droplets/' . $dropletId . '/resize/?size_id=' . $sizeId);
	}

	/**
	 * Take a Snapshot
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $dropletId
	 * @param string $name
	 * @return mixed
	 */
	public function takeASnapshot($dropletId, $name) {
		return $this->connectTo('droplets/' . $dropletId . '/snapshot/?name=' . $name);
	}

	/**
	 * Restore Droplet
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $dropletId
	 * @param int $imageId
	 * @return mixed
	 */
	public function restore($dropletId, $imageId) {
		return $this->connectTo('droplets/' . $dropletId . '/restore/?image_id=' . $imageId);
	}

	/**
	 * Rebuild Droplet
	 * This method allows you to reinstall a droplet with a default image. This is useful if you want to start again but retain the same IP address for your droplet.
	 * @param int $dropletId
	 * @param int $imageId
	 * @return mixed
	 */
	public function rebuild($dropletId, $imageId) {
		return $this->connectTo('droplets/' . $dropletId . '/rebuild/?image_id=' . $imageId);
	}

	/**
	 * Enable Automatic Backups
	 * This method enables automatic backups which run in the background daily to backup your droplet's data.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function enableBackups($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/enable_backups/');
	}

	/**
	 * Disable Automatic Backups
	 * This method disables automatic backups from running to backup your droplet's data.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function disableBackups($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/disable_backups/');
	}

	/**
	 * Destroy Droplet
	 * This method destroys one of your droplets - this is irreversible.
	 * @param int $dropletId
	 * @return mixed
	 */
	public function destroy($dropletId) {
		return $this->connectTo('droplets/' . $dropletId . '/destroy/');
	}

	########################
	# Regions
	########################

	/**
	 * All Regions
	 * This method will return all the available regions within the Digital Ocean cloud.
	 * @return mixed
	 */
	public function getRegions() {
		$data = $this->connectTo('regions/');

		$return = array();
		foreach ($data->regions as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	########################
	# Images
	########################	

	/**
	 * All Images
	 * This method returns all the available images that can be accessed by your client ID. You will have access to all public images by default, and any snapshots or backups that you have created in your own account.
	 * @return mixed
	 */
	public function getImages() {
		$data = $this->connectTo('images/');

		$return = array();
		foreach ($data->images as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	/**
	 * Show Image
	 * This method displays the attributes of an image.
	 * @param int $imageId
	 * @return mixed
	 */
	public function showImage($imageId) {
		return $this->connectTo('images/' . $imageId . '/');
	}

	/**
	 * Destroy Image
	 * This method allows you to destroy an image. There is no way to restore a deleted image so be careful and ensure your data is properly backed up.
	 * @param int $imageId
	 * @return mixed
	 */
	public function destroyImage($imageId) {
		return $this->connectTo('images/' . $imageId . '/destroy/');
	}

	########################
	# SSH Keys
	########################	

	/**
	 * All SSH Keys
	 * This method lists all the available public SSH keys in your account that can be added to a droplet.
	 * @return mixed
	 */
	public function getSSHKeys() {
		return $this->connectTo('ssh_keys/');
	}

	/**
	 * Show SSH Key
	 * This method shows a specific public SSH key in your account that can be added to a droplet.
	 * @param int $sshKeyId
	 * @return mixed
	 */
	public function showSSHKey($sshKeyId) {
		return $this->connectTo('ssh_keys/' . $sshKeyId . '/');
	}

	/**
	 * Add SSH Key
	 * This method allows you to add a new public SSH key to your account.
	 * @param int $sshKeyId
	 * @return mixed
	 */
	public function addSSHKey($sshKeyId) {
		return $this->connectTo('ssh_keys/' . $sshKeyId . '/add/');
	}

	/**
	 * Edit SSH Key
	 * This method allows you to modify an existing public SSH key in your account.
	 * @param int $sshKeyId
	 * @return mixed
	 */
	public function editSSHKey($sshKeyId) {
		return $this->connectTo('ssh_keys/' . $sshKeyId . '/edit/');
	}

	/**
	 * Destroy SSH Key
	 * This method will delete the SSH key from your account.
	 * @param int $sshKeyId
	 * @return mixed
	 */
	public function destroySSHKey($sshKeyId) {
		return $this->connectTo('ssh_keys/' . $sshKeyId . '/destroy/');
	}

	########################
	# Sizes
	########################	

	/**
	 * Sizes
	 * Sizes indicate the amount of memory and processors that will be allocated to your droplet on creation.
	 * @return mixed
	 */
	public function getSizes() {
		$data = $this->connectTo('sizes/');

		$return = array();
		foreach ($data->sizes as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

}

/**
 * Helper class to connect to the API
 */
class ApiConnector {
	/**
	 * Send command to the API
	 * @param $uri
	 * @return mixed
	 * @throws \RuntimeException if no connection methods were found
	 */
	function connectToApi($uri) {
		if (function_exists('file_get_contents')) {
			$content = file_get_contents($uri);
			return $content;
		} elseif (function_exists('fopen')) {
			$fp = fopen($uri, 'r');
			$content = '';

			if ($fp) {
				while (!feof($fp)) {
					$content .= fgets($fp);
				}
				fclose($fp);
				return $content;
			}
			return $content;
		} else {
			throw new \RuntimeException('Error: DigitalOcean class cannot connect to api!');
		}
	}
}
