<?php

if(isset($_POST['userId'])){
	$pattern = MEDIA_FOLDER . $_POST['userId'] . '/' . 'profile.*';
	$tmp = glob($pattern);
	if(count($tmp) > 0){
		$ext = pathinfo($tmp[0], PATHINFO_EXTENSION);
		header('Content-Type:image/' . $ext);
		readfile($tmp[0]);
	}
}