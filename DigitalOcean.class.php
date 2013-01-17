<?php

/*************************************************
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
 *************************************************/

class DigitalOcean {

	const API_URL = 'https://api.digitalocean.com'; // THE API BASE URL

	/**
	 * @var string
	 */
	private $clientId; // API - CLIENT ID

	/**
	 * @var string
	 */
	private $apiKey; // API - KEY

	/**
	 * @var ApiConnector
	 */
	private $apiConnector;

	public function setApiConnector($apiConnector) {
		$this->apiConnector = $apiConnector;
	}

	########################
	# Base Functions
	########################	

	private function connectTo($action) {
		$uri = DigitalOcean::API_URL . '/' . $action;
		$uri .= strpos($uri, '?') !== true ? '?' : '&';
		$uri .= 'client_id=' . $this->clientId . '&api_key=' . $this->apiKey;

		return json_decode($this->apiConnector->connectToApi($uri));
	}

	public function __construct($clientId, $apiKey) {
		$this->clientId = $clientId;
		$this->apiKey = $apiKey;
	}

	########################
	# Droplets
	########################

	# Show All Active Droplets
	# This method returns all active droplets that are currently running in your account. All available API information is presented for each droplet.
	public function getDroplets() {
		return $this->connectTo('droplets');
	}

	# Show Droplet
	# This method returns full information for a specific droplet ID that is passed in the URL.
	public function showDroplet($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id);
	}

	# New Droplet
	# This method returns full information for a specific droplet ID that is passed in the URL.
	public function newDroplet($name, $size_id, $image_id, $region_id) {
		return $this->connectTo('droplets/new?name=' . $name . '&size_id=' . $size_id . '&image_id=' . $image_id . '&region_id=' . $region_id);
	}

	# Reboot Droplet
	# This method allows you to reboot a droplet. This is the preferred method to use if a server is not responding.
	public function reboot($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/reboot/');
	}

	# Power Cycle Droplet
	# This method allows you to power cycle a droplet. This will turn off the droplet and then turn it back on.
	public function powerCycle($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_cycle/');
	}

	# Shut Down Droplet
	# This method allows you to shutdown a running droplet. The droplet will remain in your account.
	public function shutDown($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/shut_down/');
	}

	# Power Off
	# This method allows you to power off a running droplet. The droplet will remain in your account.
	public function powerOff($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_off/');
	}

	# Power On
	# This method allows you to power on a powered off droplet.
	public function powerOn($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_on/');
	}

	# Reset Root Password
	# This method will reset the root password for a droplet. Please be aware that this will reboot the droplet to allow resetting the password.
	public function resetRootPassword($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/reset_root_password/');
	}

	# Resize Droplet
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function resizeDroplet($droplet_id, $size_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/resize/?size_id=' . $size_id);
	}

	# Take a Snapshot
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function takeASnapshot($droplet_id, $name) {
		return $this->connectTo('droplets/' . $droplet_id . '/snapshot/?name=' . $name);
	}

	# Restore Droplet
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function restore($droplet_id, $image_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/restore/?image_id=' . $image_id);
	}

	# Rebuild Droplet
	# This method allows you to reinstall a droplet with a default image. This is useful if you want to start again but retain the same IP address for your droplet.
	public function rebuild($droplet_id, $image_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/rebuild/?image_id=' . $image_id);
	}

	# Enable Automatic Backups
	# This method enables automatic backups which run in the background daily to backup your droplet's data.
	public function enableBackups($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/enable_backups');
	}

	# Disable Automatic Backups
	# This method disables automatic backups from running to backup your droplet's data.
	public function disableBackups($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/disable_backups');
	}

	# Destroy Droplet
	# This method destroys one of your droplets - this is irreversible.
	public function destroy($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/destroy');
	}

	########################
	# Regions
	########################

	# All Regions
	# This method will return all the available regions within the Digital Ocean cloud.
	public function getRegions() {
		$data = $this->connectTo('regions');

		$return = array();
		foreach ($data->regions as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	########################
	# Images
	########################	

	# All Images
	# This method returns all the available images that can be accessed by your client ID. You will have access to all public images by default, and any snapshots or backups that you have created in your own account.
	public function getImages() {
		$data = $this->connectTo('images');

		$return = array();
		foreach ($data->images as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	# Show Image
	# This method displays the attributes of an image.
	public function showImage($image_id) {
		return $this->connectTo('images/' . $image_id);
	}

	# Destroy Image
	# This method allows you to destroy an image. There is no way to restore a deleted image so be careful and ensure your data is properly backed up.
	public function destroyImage($image_id) {
		return $this->connectTo('images/' . $image_id . '/destroy');
	}

	########################
	# SSH Keys
	########################	

	# All SSH Keys
	# This method lists all the available public SSH keys in your account that can be added to a droplet.
	public function getSSHKeys() {
		return $this->connectTo('ssh_keys');
	}

	# Show SSH Key
	# This method shows a specific public SSH key in your account that can be added to a droplet.
	public function showSSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id);
	}

	# Add SSH Key
	# This method allows you to add a new public SSH key to your account.
	public function addSSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/add');
	}

	# Edit SSH Key
	# This method allows you to modify an existing public SSH key in your account.
	public function editSSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/edit');
	}

	# Destroy SSH Key
	# This method will delete the SSH key from your account.
	public function destroySSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/destroy');
	}

	########################
	# Sizes
	########################	

	# Sizes
	# Sizes indicate the amount of memory and processors that will be allocated to your droplet on creation.
	public function getSizes() {
		$data = $this->connectTo('sizes');

		$return = array();
		foreach ($data->sizes as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

}

class ApiConnector {
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
			throw new RuntimeException('Error: DigitalOcean class cannot connect to api!');
		}
	}
}
