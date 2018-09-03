<?php

function getPackageId(){
	$url = add_query_arg( NULL, NULL );
	$url = explode('/', $url);
	$pHash = $url[1];
	$pHash = explode('-', $url[1]);
	
	$package = getPackage(md5($pHash[0]));
	print_r($package);exit();
	$package_id = $package->package_id;
	return $package_id;
}

// remove options
@include 'functions/remove.php';

// add package pages
@include 'functions/packages.php';

// enqueue files
@include 'functions/enqueue.php';

// API functions
@include 'functions/api.php';


?>