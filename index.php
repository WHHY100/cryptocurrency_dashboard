<?php

	require_once "database.inc";
	require_once "functions.inc.php";

	/* -------------------------------------------------------*/
    /* GET CRYPTOCURRENCY DATA */
	/* -------------------------------------------------------*/
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
	
	/* -------------------------------------------------------*/
    /* GET CURRENCY DATA */
	/* -------------------------------------------------------*/
	const CURRENCIES = ['USD', 'CHF', 'EUR', 'GBP', 'CAD'];
	
	$currdt = date('Y-m-d H:i:s');
	
	$sqlCommand = [];
	
	# create sql string
	for($i = 0; $i < count(CURRENCIES); $i++){
		$sqlCommand[$i] = createBatchDatabase(CURRENCIES[$i], $currdt);
	}
	
	# save data to db
	$resultDB = saveDataCurrencyDB($mysqliConnect, $sqlCommand, "tab_currency_price");
	
	
	/* -------------------------------------------------------*/
    /* CREATE CSV FILE */
	/* -------------------------------------------------------*/
	# write new CSV if prev step insert new data to db
	if ($resultSaveDB == True && $resultDB == True){
		createCSV("cryptocurrency.csv", $mysqliConnect, "tab_cryptocurrency_price");
		createCSV("currency.csv", $mysqliConnect, "tab_currency_price");
		echo "New data saved in database!";
	}
	else{
		echo "Data for today has already been saved!";
	}
	
	#close conn with db
	closeConnDb($mysqliConnect);