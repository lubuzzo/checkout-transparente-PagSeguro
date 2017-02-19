<?php

	include 'env.php';

	sleep(5);
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $urlPagseguro . "transactions/". $_POST['id'] . "?email=". $emailPagseguro . "&token=" . $tokenPagseguro);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml; charset=ISO-8859-1'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	$dataXML = simplexml_load_string($data);

	header('Content-Type: application/json; charset=UTF-8');
	$data = (json_encode($dataXML));

	echo (json_decode($data)->status);
	curl_close($ch);