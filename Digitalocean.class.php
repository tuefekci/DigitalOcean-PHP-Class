<?php

/*************************************************

DigitalOcean PHP Class
Author: Giacomo Tüfekci <giacomo.tuefekci@googlemail.com>
Copyright (c): 2012 Is.It.Media, all rights reserved
Version: 1.0.0 - 2012-10-26

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

You may contact the author of DigitalOcean PHP Class by e-mail at:
giacomo.tuefekci@googlemail.com

The latest version of DigitalOcean PHP Class can be obtained from:
https://github.com/tuefekci/DigitalOcean-PHP-Class

*************************************************/

class Digitalocean {

	var $client_id = ""; // API - CLIENT ID
	var $api_key = ""; // API - KEY
	var $api_url = "https://api.digitalocean.com"; // THE API BASE URL
	
	var $base_size; // THE BASIC SIZE
	var $base_image; // THE BASIC IMAGE
	var $base_region; // THE BASIC REGION
	
	########################
	# Base Functions
	########################	
	
	private function connectTo($action) {
		
		if(function_exists('file_get_contents')) {
			
			$content = file_get_contents($this->api_url."/".$action);
			
		} elseif (function_exists('fopen')) {
			
			$fp = fopen($this->api_url."/".$action,"r");
		
			$content = "";
		
			if ($fp) {
				while(!feof($fp)) {
					
					$content .= fgets($fp);
			
				}
				fclose($fp);
			}				
			
		} else {
			die("Error: DigitalOcean class can't connect to api!");	
		}
		
		return json_decode($content);
	}

	########################
	# Droplets
	########################

	# Show All Active Droplets
	# This method returns all active droplets that are currently running in your account. All available API information is presented for each droplet.
	public function getDroplets() {
		$data = $this->connectTo("droplets/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Show Droplet
	# This method returns full information for a specific droplet ID that is passed in the URL.
	public function showDroplet($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# New Droplet
	# This method returns full information for a specific droplet ID that is passed in the URL.
	public function newDroplet($name,$size_id,$image_id,$region_id) {
		$data = $this->connectTo("droplets/new?name=".$name."&size_id=".$size_id."&image_id=".$image_id."&region_id=".$region_id."&client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}				
	
	# Reboot Droplet
	# This method allows you to reboot a droplet. This is the preferred method to use if a server is not responding.
	public function reboot($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/reboot/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	

	# Power Cycle Droplet
	# This method allows you to power cycle a droplet. This will turn off the droplet and then turn it back on.
	public function powerCycle($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/power_cycle/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}		
	
	# Shut Down Droplet
	# This method allows you to shutdown a running droplet. The droplet will remain in your account.
	public function shutDown($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/shut_down/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Power Off
	# This method allows you to poweroff a running droplet. The droplet will remain in your account.
	public function powerOff($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/power_off/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Power On
	# This method allows you to poweron a powered off droplet.
	public function powerOn($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/power_on/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Reset Root Password
	# This method will reset the root password for a droplet. Please be aware that this will reboot the droplet to allow resetting the password.
	public function resetRootPassword($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/reset_root_password/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Resize Droplet
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function resizeDroplet($droplet_id,$size_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/resize/?size_id=".$size_id."&client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Take a Snapshot
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function takeASnapshot($droplet_id,$name) {
		$data = $this->connectTo("droplets/".$droplet_id."/snapshot/?name=".$name."&client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Restore Droplet
	# This method allows you to resize a specific droplet to a different size. This will affect the number of processors and memory allocated to the droplet.
	public function restore($droplet_id,$image_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/restore/?image_id=".$image_id."&client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}										
	
	# Rebuild Droplet
	# This method allows you to reinstall a droplet with a default image. This is useful if you want to start again but retain the same IP address for your droplet.
	public function rebuild($droplet_id,$image_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/rebuild/?image_id=".$image_id."&client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	

	# Enable Automatic Backups
	# This method enables automatic backups which run in the background daily to backup your droplet's data.
	public function enableBackups($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/enable_backups/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Disable Automatic Backups
	# This method disables automatic backups from running to backup your droplet's data.
	public function disableBackups($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/disable_backups/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Destroy Droplet
	# This method destroys one of your droplets - this is irreversible.
	public function destroy($droplet_id) {
		$data = $this->connectTo("droplets/".$droplet_id."/destroy/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}				
	
	########################
	# Regions
	########################

	# All Regions
	# This method will return all the available regions within the Digital Ocean cloud.
	public function getRegions() {
		$data = $this->connectTo("regions/?client_id=".$this->client_id."&api_key=".$this->api_key);
		
		foreach ($data->regions as $key => $value) {
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
		$data = $this->connectTo("images/?client_id=".$this->client_id."&api_key=".$this->api_key);
		
		foreach ($data->images as $key => $value) {
			$return[$value->id] = $value;
		}
		
		return $return;
	}	
	
	# Show Image
	# This method displays the attributes of an image.
	public function showImage($image_id) {
		$data = $this->connectTo("images/".$image_id."/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Destroy Image
	# This method allows you to destroy an image. There is no way to restore a deleted image so be careful and ensure your data is properly backed up.
	public function destroyImage($image_id) {
		$data = $this->connectTo("images/".$image_id."/destroy/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	########################
	# SSH Keys
	########################	
	
	# All SSH Keys
	# This method lists all the available public SSH keys in your account that can be added to a droplet.
	public function getSSHKeys() {
		$data = $this->connectTo("ssh_keys/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}	
	
	# Show SSH Key
	# This method shows a specific public SSH key in your account that can be added to a droplet.
	public function showSSHKey($ssh_key_id) {
		$data = $this->connectTo("ssh_keys/".$ssh_key_id."/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}		

	# Add SSH Key
	# This method allows you to add a new public SSH key to your account.
	public function addSSHKey($ssh_key_id) {
		$data = $this->connectTo("ssh_keys/".$ssh_key_id."/add/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Edit SSH Key
	# This method allows you to modify an existing public SSH key in your account.
	public function editSSHKey($ssh_key_id) {
		$data = $this->connectTo("ssh_keys/".$ssh_key_id."/edit/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}
	
	# Destroy SSH Key
	# This method will delete the SSH key from your account.
	public function destroySSHKey($ssh_key_id) {
		$data = $this->connectTo("ssh_keys/".$ssh_key_id."/destroy/?client_id=".$this->client_id."&api_key=".$this->api_key);
		return $data;
	}			
	
	########################
	# Sizes
	########################	
	
	# Sizes
	# Sizes indicate the amount of memory and processors that will be allocated to your droplet on creation.
	public function getSizes() {
		$data = $this->connectTo("sizes/?client_id=".$this->client_id."&api_key=".$this->api_key);
		foreach ($data->sizes as $key => $value) {
			$return[$value->id] = $value;
		}
		
		return $return;
	}	

}