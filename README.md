PHP wrapper for the Digital Ocean API
=====================================

This is a PHP wrapper class of the [Digital Ocean](https://www.digitalocean.com/) API. All methods are supported.

Documentation for the [Digital Ocean API](https://www.digitalocean.com/api) can be found here.

[Automatically generated phpDoc](http://remmelt.github.com/DigitalOcean-PHP-Class) live here.

Example Usage
---------------------
```PHP
require_once('DigitalOcean.class.php');
$ocean = new \DigitalOceanApi\DigitalOcean('client_id_here','api_key_here');
$droplets = get_object_vars($ocean->getDroplets());
$i=0;
$x=0;
foreach ($droplets as $drops) {
	if (!is_array($drops)) {
		echo $i . '. Status: ' . $drops . '<br />';
	} else {
		echo $i . '. Name: ' . $drops[$x]->name . '<br />';
		echo $i . '. IP: ' . $drops[$x]->ip_address . '<br />';
		$x++;
	}
	$i++;
}
```