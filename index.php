<?php

	//create db connection
	$servername = "localhost";
	$username = "dbuser";
	$password = "dbpass";

	try {
	  $conn = new PDO("mysql:host=$servername;dbname=valid", $username, $password);
	  // set the PDO error mode to exception
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  echo "Connected successfully";
	} catch(PDOException $e) {
	  echo "Connection failed: " . $e->getMessage();
	} 
	//end create db connection
	
	echo "Hello world";




	$userFirstName = mysql_real_escape_string($_POST['userFirstName']);
	$userMiddleName = mysql_real_escape_string($_POST['userMiddleName']);
	$userLastName = mysql_real_escape_string($_POST['userLastName']);
	$userName = ucwords(strtolower($userLastName)).", ".ucwords(strtolower($userFirstName)).", ".ucwords(strtolower($userMiddleName));
	$userDob = mysql_real_escape_string($_POST['userDob']);		
	$userAddressZip = mysql_real_escape_string($_POST['userAddressZip']);

		//convert userDob to string for search
		$dateVar=date_create($userDob); //create the date
			$thisDate = $dateVar->format('m-d-Y'); //format the date
			$krr = explode('-',$thisDate); //create array from characters of the date
			$thisDate = implode("/",$krr); //recombine characters inserting "/
			$userDobEcho = $thisDate;//pass $result to $userDobEcho
		


	if ($userFirstName==NULL)
		echo "* Please enter your first name.<br />";
	if ($userMiddleName==NULL)
		echo "* Please enter your middle name.<br />";
	if ($userLastName==NULL)
		echo "* Please enter your last name.<br />";
	if ($userDob==NULL)
		echo "* Please enter your date of birth.<br />";
	if ($userAddressZip==NULL)
		echo "* Please enter the zip code from your ID.<br />";
		

	else
		{
			$conditions = "FROM valid.20200521 WHERE name = '$userName' AND zip = '$userAddressZip' AND dateofbirth = '$userDob' ";

			$validName = mysql_query("SELECT name $conditions");
			$validName_num_rows = mysql_num_rows($validName);

			$validDob = mysql_query("SELECT dateofbirth $conditions");
			$validDob_num_rows = mysql_num_rows($validDob);
			
			$validAddressZip = mysql_query("SELECT zip $conditions");
			$validAddressZip_num_rows = mysql_num_rows($validAddressZip);


			// if number of 'validated' rows are > 0, affirmative messege 
			if ($validName_num_rows>0 AND 
				$validDob_num_rows>0 AND 
				$validAddressZip_num_rows>0{

				$validName = mysql_result($validName, 0);
				$validDob = mysql_result($validDob, 0);
				$validAddressZip = mysql_result($validAddressZip, 0);

				echo "<p>Yes. Our records show that $userFirstName $userMiddleName $userLastName, born $userDobEcho with a Guam zip code of $validAddressZip, is registered to vote.</p>";
			};

			// if number of validated rows are == 0, negative message

			if ($validName_num_rows==0){
				echo "<p>No. The information you entered does not match our records. $userFirstName $userMiddleName $userLastName, born $userDobEcho and receiving mail in zip-code $userAddressZip is not currently registered to vote.</p><p style='color:red; font-size:0.6em;'>Please check that your responses are true and correct. If you would like to register; OR if you believe that our records are inaccurate and you would like to update your record, please contact our office for assistance.</p>";
			}	;
		};
?>