<?php

function getPackages() {
    $packages = file_get_contents("https://sync2api.com/consumer/callApi/?cKey=15c85f2ff4e9c983de00b567b3d407b1b748ba61&scKey=62e6ccf9f5c3a0d1f7cecf80524084ad8d4a27d6&module=audiolock&method=Packages&outputType=json"); 
    return json_decode($packages);
}

function getPackage($id) {
	$ip = $_SERVER['REMOTE_ADDR'];
    $package = file_get_contents("https://sync2api.com/consumer/callApi/?cKey=15c85f2ff4e9c983de00b567b3d407b1b748ba61&scKey=62e6ccf9f5c3a0d1f7cecf80524084ad8d4a27d6&module=audiolock&method=Package&package=".$id."&outputType=json&ip=".$ip); 
    return json_decode($package);
}

function getTrack($id) {
    $track = file_get_contents("https://sync2api.com/consumer/callApi/?cKey=15c85f2ff4e9c983de00b567b3d407b1b748ba61&scKey=62e6ccf9f5c3a0d1f7cecf80524084ad8d4a27d6&module=audiolock&method=Track&track_id=".$id."&outputType=json"); 
    return json_decode($track);
}

function getPackagePreview($id) {
	$package = file_get_contents("https://sync2api.com/consumer/callApi/?cKey=15c85f2ff4e9c983de00b567b3d407b1b748ba61&scKey=62e6ccf9f5c3a0d1f7cecf80524084ad8d4a27d6&module=audiolock&method=PackagePreview&package=".$id."&outputType=json");
	return json_decode($package);
}

?>