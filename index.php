<?php

	require_once "database.inc";
	require_once "functions.inc.php";

	$jsonUndecode = downloaData("https://api.coinstats.app/public/v1/coins?skip=0&limit=5&currency=PLN");

	# get json content
	$jsonDecode = json_decode($jsonUndecode, true);

	# get values to array
	$tabCoinName = decodeJsonToArray($jsonDecode, 'id');
	$tabCoinPrice = decodeJsonToArray($jsonDecode, 'price');

	# connect to database
	$mysqliConnect = connectDB(HOST_NAME, USER, PASSWORD, DB_NAME);

	# save data to DB
	$resultSaveDB = saveDataDB($tabCoinName, $tabCoinPrice, $mysqliConnect);

	# write new CSV if prev step insert new data to db
	if ($resultSaveDB == True){
		createCSV("cryptocurrency.csv", $mysqliConnect);
		echo "New data saved in database!";
	}
	else{
		echo "Data for today has already been saved!";
	}

	#close conn with db
	closeConnDb($mysqliConnect);