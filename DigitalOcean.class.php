<?php
namespace DigitalOceanAPI;

/**
 * DigitalOcean PHP Class
 *
 * Author: Giacomo Tüfekci <giacomo.tuefekci@googlemail.com>
 * Additions: Remmelt Pit <remmelt@gmail.com>
 * Additions: Sean Fleming <smenus@me.com>
 *
 * Copyright (c): 2012 Is.It.Media, all rights reserved
 * Version: 1.0.0 - 2012-10-26
 * Version: 1.1.0 - 2013-01-16
 * Version: 1.2.0 - 2013-07-02
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
	private $client_id; // API - CLIENT ID

	/**
	 * The API key as provided by Digital Ocean
	 * @var string
	 */
	private $api_key; // API - KEY

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
	 * @param String $client_id
	 * @param String $api_key
	 */
	public function __construct($client_id, $api_key) {
		$this->client_id = $client_id;
		$this->api_key = $api_key;
	}

	/**
	 * Send command to API
	 * @param $action
	 * @return mixed
	 */
	private function connectTo($action) {
		$uri = DigitalOcean::API_URL . '/' . $action;
		$uri .= strpos($uri, '?') !== false ? '&' : '?';
		$uri .= 'client_id=' . $this->client_id . '&api_key=' . $this->api_key;

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
	 * New Droplet
	 * This method returns full information for a specific droplet ID that is passed in the URL.
	 * @param string $name
	 * @param int $size_id
	 * @param int $image_id
	 * @param int $region_id
	 * @return mixed
	 */
	public function newDroplet($name, $size_id, $image_id, $region_id, $ssh_key_ids = NULL) {
		return $this->connectTo('droplets/new?name=' . $name . '&size_id=' . $size_id . '&image_id=' . $image_id . '&region_id=' . $region_id . 
			(is_null($ssh_key_ids) ? '' : '&ssh_key_ids=' . $ssh_key_ids));
	}

	/**
	 * Show Droplet
	 * This method returns full information for a specific droplet ID that is passed in the URL.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function showDroplet($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/');
	}

	/**
	 * Reboot Droplet
	 * This method allows you to reboot a droplet. This is the preferred method to use if a server is not responding.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function reboot($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/reboot/');
	}

	/**
	 * Power Cycle Droplet
	 * This method allows you to power cycle a droplet. This will turn off the droplet and then turn it back on.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function powerCycle($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_cycle/');
	}

	/**
	 * Shut Down Droplet
	 * This method allows you to shutdown a running droplet. The droplet will remain in your account.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function shutDown($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/shut_down/');
	}

	/**
	 * Power Off
	 * This method allows you to power off a running droplet. The droplet will remain in your account.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function powerOff($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_off/');
	}

	/**
	 * Power On
	 * This method allows you to power on a powered off droplet.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function powerOn($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/power_on/');
	}

	/**
	 * Reset Root Password
	 * This method will reset the root password for a droplet. Please be aware that this will reboot the droplet to allow resetting the password.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function resetRootPassword($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/password_reset/');
	}

	/**
	 * Resize Droplet
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $droplet_id
	 * @param int $size_id
	 * @return mixed
	 */
	public function resizeDroplet($droplet_id, $size_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/resize/?size_id=' . $size_id);
	}

	/**
	 * Take a Snapshot
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $droplet_id
	 * @param string $name
	 * @return mixed
	 */
	public function takeASnapshot($droplet_id, $name = NULL) {
		return $this->connectTo('droplets/' . $droplet_id . '/snapshot/' . (is_null($name) ? '' : '?name=' . $name));
	}

	/**
	 * Restore Droplet
	 * This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	 * @param int $droplet_id
	 * @param int $image_id
	 * @return mixed
	 */
	public function restore($droplet_id, $image_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/restore/?image_id=' . $image_id);
	}

	/**
	 * Rebuild Droplet
	 * This method allows you to reinstall a droplet with a default image. This is useful if you want to start again but retain the same IP address for your droplet.
	 * @param int $droplet_id
	 * @param int $image_id
	 * @return mixed
	 */
	public function rebuild($droplet_id, $image_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/rebuild/?image_id=' . $image_id);
	}

	/**
	 * Enable Automatic Backups
	 * This method enables automatic backups which run in the background daily to backup your droplet's data.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function enableBackups($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/enable_backups/');
	}

	/**
	 * Disable Automatic Backups
	 * This method disables automatic backups from running to backup your droplet's data.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function disableBackups($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/disable_backups/');
	}

	/**
	 * Rename Droplet
	 * This method renames the droplet to the specified name.
	 * @param int $droplet_id
	 * @param string $name
	 * @return mixed
	 */
	public function rename($droplet_id, $name) {
		return $this->connectTo('droplets/' . $droplet_id . '/rename/?name=' . $name);
	}

	/**
	 * Destroy Droplet
	 * This method destroys one of your droplets - this is irreversible.
	 * @param int $droplet_id
	 * @return mixed
	 */
	public function destroy($droplet_id) {
		return $this->connectTo('droplets/' . $droplet_id . '/destroy/');
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
	 * @param string $filter
	 * @return mixed
	 */
	public function getImages($filter = 'my_images') {
		$data = $this->connectTo('images/?filter=' . $filter);

		$return = array();
		foreach ($data->images as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	/**
	 * Show Image
	 * This method displays the attributes of an image.
	 * @param int $image_id
	 * @return mixed
	 */
	public function showImage($image_id) {
		return $this->connectTo('images/' . $image_id . '/');
	}

	/**
	 * Destroy Image
	 * This method allows you to destroy an image. There is no way to restore a deleted image so be careful and ensure your data is properly backed up.
	 * @param int $image_id
	 * @return mixed
	 */
	public function destroyImage($image_id) {
		return $this->connectTo('images/' . $image_id . '/destroy/');
	}

	/**
	 * Transfer Image
	 * This method allows you to transfer an image to a specified region.
	 * @param int $image_id
	 * @param int $region_id
	 * @return mixed
	 */
	public function transferImage($image_id, $region_id) {
		return $this->connectTo('images/' . $image_id . '/transfer/?region_id=' . $region_id);
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
		$data = $this->connectTo('ssh_keys/');

		$return = array();
		foreach ($data->ssh_keys as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	/**
	 * Add SSH Key
	 * This method allows you to add a new public SSH key to your account.
	 * @param int $ssh_key_id
	 * @return mixed
	 */
	public function addSSHKey($ssh_key_id, $name, $ssh_key_pub) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/new/?name=' . $name . '&ssh_key_pub=' . $ssh_key_pub);
	}

	/**
	 * Show SSH Key
	 * This method shows a specific public SSH key in your account that can be added to a droplet.
	 * @param int $ssh_key_id
	 * @return mixed
	 */
	public function showSSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/');
	}

	/**
	 * Edit SSH Key
	 * This method allows you to modify an existing public SSH key in your account.
	 * @param int $ssh_key_id
	 * @return mixed
	 */
	public function editSSHKey($ssh_key_id, $ssh_key_pub) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/edit/?ssh_key_pub=' . $ssh_key_pub);
	}

	/**
	 * Destroy SSH Key
	 * This method will delete the SSH key from your account.
	 * @param int $ssh_key_id
	 * @return mixed
	 */
	public function destroySSHKey($ssh_key_id) {
		return $this->connectTo('ssh_keys/' . $ssh_key_id . '/destroy/');
	}

	########################
	# Sizes
	########################	

	/**
	 * All Sizes
	 * This method returns all the available sizes that can be used to create a droplet.
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

	########################
	# Domains
	########################	

	/**
	 * All Domains
	 * This method returns all of your current domains.
	 * @return mixed
	 */
	public function getDomains() {
		$data = $this->connectTo('domains/');

		$return = array();
		foreach ($data->domains as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	/**
	 * New Domain
	 * This method creates a new domain name with an A record for the specified [ip_address].
	 * @param string $name
	 * @param string $ip_address
	 * @return mixed
	 */
	public function newDomain($name, $ip_address) {
		return $this->connectTo('domains/new/?name=' . $name . '&ip_address=' . $ip_address);
	}

	/**
	 * Show Domain
	 * This method returns the specified domain.
	 * @param string $domain_id
	 * @return mixed
	 */
	public function showDomain($domain_id) {
		return $this->connectTo('domains/' . $domain_id . '/');
	}

	/**
	 * Destroy Domain
	 * This method deletes the specified domain.
	 * @param string $domain_id
	 * @return mixed
	 */
	public function destroyDomain($domain_id) {
		return $this->connectTo('domains/' . $domain_id . '/destroy/');
	}

	/**
	 * All Domain Records
	 * This method returns all of your current domain records.
	 * @param string $domain_id
	 * @return mixed
	 */
	public function getDomainRecords($domain_id) {
		$data = $this->connectTo('domains/' . $domain_id . '/records/');

		$return = array();
		foreach ($data->records as $value) {
			$return[$value->id] = $value;
		}
		return $return;
	}

	/**
	 * New Domain Record
	 * This method creates a new domain record for the specified domain.
	 * @param string $domain_id
	 * @param string $record_type
	 * @param string $data
	 * @param string $name
	 * @param int $priority
	 * @param int $port
	 * @param int $weight
	 * @return mixed
	 */
	public function newDomainRecord($domain_id, $record_type, $data, $name = NULL, $priority = NULL, $port = NULL, $weight = NULL) {
		return $this->connectTo('domains/' . $domain_id . '/records/new/?record_type=' . $record_type . '&data=' . $data . 
			(is_null($name) ? '' : '&name=' . $name) . 
			(is_null($priority) ? '' : '&priority=' . $priority) . 
			(is_null($port) ? '' : '&port=' . $port) . 
			(is_null($weight) ? '' : '&weight=' . $weight));
	}

	/**
	 * Show Domain Record
	 * This method returns the specified domain record.
	 * @param string $domain_id
	 * @param int $record_id
	 * @return mixed
	 */
	public function showDomainRecord($domain_id, $record_id) {
		return $this->connectTo('domains/' . $domain_id . '/records/' . $record_id . '/');
	}

	/**
	 * Edit Domain Record
	 * This method edits an existing domain record.
	 * @param string $domain_id
	 * @param int $record_id
	 * @param string $record_type
	 * @param string $data
	 * @param string $name
	 * @param int $priority
	 * @param int $port
	 * @param int $weight
	 * @return mixed
	 */
	public function editDomainRecord($domain_id, $record_id, $record_type, $data, $name = NULL, $priority = NULL, $port = NULL, $weight = NULL) {
		return $this->connectTo('domains/' . $domain_id . '/records/' . $record_id . '/edit/?record_type=' . $record_type . '&data=' . $data . 
			(is_null($name) ? '' : '&name=' . $name) . 
			(is_null($priority) ? '' : '&priority=' . $priority) . 
			(is_null($port) ? '' : '&port=' . $port) . 
			(is_null($weight) ? '' : '&weight=' . $weight));
	}

	/**
	 * Destroy Domain Record
	 * This method deletes the specified domain record.
	 * @param string $domain_id
	 * @param int $record_id
	 * @return mixed
	 */
	public function destroyDomainRecord($domain_id, $record_id) {
		return $this->connectTo('domains/' . $domain_id . '/records/' . $record_id . '/destroy/');
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
	 * @throws \RuntimeException if no connection methods were found or allow_url_include is disabled.
	 */
	function connectToApi($uri) {
		if (!ini_get('allow_url_fopen')) {
			throw new \RuntimeException('Error: allow_url_include disabled!');
		}
		
		if (function_exists('file_get_contents')) {
			$content = file_get_contents($uri);
			return $content;
		} 
		
		if (function_exists('fopen')) {
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
		} 
		
		throw new \RuntimeException('Error: DigitalOcean class cannot connect to api!');
	}
}
