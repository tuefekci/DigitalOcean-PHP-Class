PHP wrapper for the Digital Ocean API
=====================================

This is a PHP wrapper class of the [Digital Ocean](https://www.digitalocean.com/) API. All methods are supported.

Documentation for the [Digital Ocean API](https://www.digitalocean.com/api) can be found here.

[Automatically generated phpDoc](http://remmelt.github.com/DigitalOcean-PHP-Class) live here.

Example Usage
---------------------
```PHP
require_once('DigitalOcean.class.php');
$ocean = new \DigitalOceanApi\DigitalOcean('aasBfHZphJSs4UXa855ok','FCjbS7imjTDUyBthEpg6bkq0MDT8hQk3czChU6ghd');
$droplets = get_object_vars($ocean->getDroplets());
$i=0;
$x=0;
foreach ($droplets as $drops) {
	//print_r($drops);
	//echo $drops[0]->name;
	//echo $drops->status;
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