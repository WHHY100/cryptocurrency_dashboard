<?php

	# download data from path
	function downloaData($path){
		$content = file_get_contents($path);
		
		return $content;
	}
	
	# decode json to array
	function decodeJsonToArray($jsonDecode, $value){
		$finArray = [];
		
		for($i=0; $i<=4; $i++){
			$finArray[$i] = $jsonDecode['coins'][$i][$value];
		}
		
		return $finArray;
	}
	
	# connect to database
	function connectDB($host, $user, $password, $dbname){
		$mysqliConnect = mysqli_connect($host, $user , $password);
		mysqli_select_db($mysqliConnect, $dbname);
		mysqli_set_charset($mysqliConnect, "utf8");
		mysqli_query($mysqliConnect, 'SET collation_connection = utf8_general_ci');
		
		return $mysqliConnect;
	}
	
	# save data to db
	function saveDataDB($tabCoinName, $tabCoinPrice, $mysqliConnect){
		
		$maxDateInDb = mysqli_query($mysqliConnect, "SELECT MAX(DATE(create_date)) FROM tab_cryptocurrency_price");
		
		$maxDate = mysqli_fetch_row($maxDateInDb);

		if ($maxDate[0] == date("Y-m-d")){
			return False;
		}
		
		try{
			for($i=0; $i<count($tabCoinName); $i++){
				
				$currdt = date('Y-m-d H:i:s');
				
				$sql = "INSERT INTO tab_cryptocurrency_price(create_date, price, currency_name, cryptocurrency_name) VALUES
						('" . strval($currdt) . "', " . filter_var($tabCoinPrice[$i], FILTER_SANITIZE_STRING) . ", 'PLN', '" . filter_var(strtoupper($tabCoinName[$i]), FILTER_SANITIZE_STRING) . "');";
				mysqli_query($mysqliConnect, $sql);
				mysqli_commit($mysqliConnect);
			}
		}
		catch (Exception $e) {
			return False;
		}
		
		return True;
	}
	
	# create csv file from db table
	function createCSV($nameFile, $mysqliConnect, $nameTab): void{
		$reader = mysqli_query($mysqliConnect, "SELECT * FROM " . $nameTab);

		$file = fopen($nameFile, "w");

		while ($result = mysqli_fetch_row($reader)){
			for($i=0; $i<count($result); $i++){
				fwrite($file, $result[$i] . ";");
			}
			fwrite($file, "\n");
		}

		fclose($file);
	}
	
	# close conn to db
	function closeConnDb($mysqliConnect): void{
		mysqli_close($mysqliConnect);
	}
	
	# currency - insert sql string
	function createBatchDatabase($currency, $date){

		$link = "https://api.nbp.pl/api/exchangerates/rates/c/" . $currency . "/" . $date . "/?format=json";
		$link = "https://api.nbp.pl/api/exchangerates/rates/a/" . $currency . "/?format=json";

		$jsonUndecode = downloaData($link);
		$jsonDecode = json_decode($jsonUndecode, true);
			
		$code = $jsonDecode["code"];
		$price = round($jsonDecode["rates"][0]["mid"], 2);

		$sql = "INSERT INTO tab_currency_price(create_date, price, currency_base, currency_name) VALUES
				('" . strval($date) . "', " . filter_var($price, FILTER_SANITIZE_STRING) . ", 'PLN', '" . filter_var($currency, FILTER_SANITIZE_STRING) . "');";

		return $sql;
	}
	
	# insert currency into db
	function saveDataCurrencyDB($mysqliConnect, $sql, $nameTab){
	
		$maxDateInDb = mysqli_query($mysqliConnect, "SELECT MAX(DATE(create_date)) FROM " . $nameTab);

		$maxDate = mysqli_fetch_row($maxDateInDb);

		if ($maxDate[0] == date("Y-m-d")){
			return False;
		}
			
		try{
			for($i=0; $i<count($sql); $i++){
					mysqli_query($mysqliConnect, $sql[$i]);
					mysqli_commit($mysqliConnect);
				}
		}
		catch (Exception $e) {
			return False;
		}
		
		return True;
	}
	