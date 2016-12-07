<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	$host="mysql2772int.cp.blacknight.com";
	$uname="u1429550_sweng";
	$pwd="sw3ngproject?";
	$db="db1429550_swengproject";
	
	define(OBJECT_NOT_FOUND, "0")
	define(SUCCESS_RESPONSE, "1")
	define(OBJECT_FOUND, "2")
	define(LIST_PROJECTS, "3")
	define(LIST_PERSON, "4")
	define(DUPLICATE, "5")
	
	$con = mysqli_connect($host,$uname,$pwd,$db) or die("connection failed");
	//
	// foreach ($_POST as $key => $value) {
	//
	// 	 echo "Key = " . $key . " ";
	//
	// 	 echo "Value = " . $value;
	//  }


	$type = $_POST["TYPE"];

	switch($type){
		case 1: add_project($con);
		break;
		case 2: add_individuals($con);
		break;
		case 3: search_object();
		break;
		case 4: assign_object();
		break;
		case 5: 
		break;
		case 6: date_objects_list();
		break;
		case 7: other_objects_list();
		break;
		case 8: find_object();
		break;
	}

	function add_project($con){
		$projectName = $_POST["NAME"];
		$endDate = $_POST["END_DATE"];
		$num = $_POST["INDIVIDUALS_NUM"];
		$indvs = array();
		for($i=0;$i<$num;$i++){
			$indvs[$i] = $_POST["INDIVIDUALS" . $i];
		}

		// ADD the new project into the database
		$sql = "INSERT INTO Project (Name, EndDate) VALUES ('$projectName', '$endDate') ";
		$ret = mysqli_query($con,$sql)  or die(mysqli_error($con));

	  //Attach individuals to each projects
		for($i=0;$i<$num;$i++){
			$sql = "INSERT INTO ProjectGroup (ProjectName,MemberName) VALUES ('$projectName','$indvs[$i]')";
			$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		}
		echo SUCCESS_RESPONSE;
		mysqli_close($con);

	}
	
	function add_individuals($con){

		$name = $_POST["NAME"];
		$num = $_POST["TEAM_NUM"];
		$projects = array();
		for($i=0;$i<$num;$i++){
			$projects[$i] = $_POST["TEAM".$i];
		}
		$sql = "INSERT INTO Person (Name) VALUES ('$name')";
		$ret = mysqli_query($con,$sql) or die(mysqli_error($con));

		for($i=0;$i<$num;$i++){
			$sql = "INSERT INTO ProjectGroup (ProjectName,MemberName) VALUES ('$projects[$i]','$name')";
			$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		}
		echo SUCCESS_RESPONSE;
		mysqli_close($con);
	}
	
	function search_object($con){
		$barcode = $_POST['BARCODE_INFO']
		$sql = "SELECT * FROM Object WHERE Barcode = ('$barcode')";
		$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		
		if (mysqli_num_rows($ret) == 0) {
			echo OBJECT_NOT_FOUND;
		} else {
			$rows = mysqli_fetch_all($ret);
			foreach($rows as $row) { 
				echo $row["ObjectID"] . "#" . $row["Barcode"] . "#" . $row["PersonID"] . "#" . $row["Project"] . "#" . $row["Broken"] . "#";
			}
		}
		mysqli_close($con);
	}
		
	function assign_object(){
		$name = $_POST['NAME']; //not used
		$date = $_POST['DATE'];//not used
		$group = $_POST['GROUP'];
		$barcode = $_POST['BARCODE'];
		$individual $_POST['INDIVIDUAL'];
		$broken = $_POST['DAMAGED'];
		
		$sql = "INSERT into Object (Barcode, PersonID, Project, Broken) VALUES ('$barcode', '$indivdual', '$group', '$broken')";
		$ret = mysqli_query($con,$sql)  or die(mysqli_error($con));
		echo SUCCESS_RESPONSE;
		mysqli_close($con)
	}
	
	function reclaimed_objects_list(){
		$sql = "SELECT * FROM Object o LEFT OUTER JOIN Project p ON o.Project = p.Name WHERE p.EndDate < NOW() OR o.Project IS NULL";
		$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		if (mysqli_num_rows($ret) == 0) {
			echo OBJECT_NOT_FOUND;
		} else {
			echo OBJECT_FOUND;
			$rows = mysqli_fetch_all($ret);
			foreach($rows as $row) { 
				echo $row["ObjectID"] . "#" . $row["Barcode"] . "#" . $row["PersonID"] . "#" . $row["Project"] . "#" . $row["Broken"] . "#";
			}
		}
		mysqli_close($con);
	}
	
	function broken_objects_list(){
		$sql = "SELECT * FROM Object o WHERE o.Broken = 1";
		$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		if (mysqli_num_rows($ret) == 0) {
			echo OBJECT_NOT_FOUND;
		} else {
			echo OBJECT_FOUND;
			$rows = mysqli_fetch_all($ret);
			foreach($rows as $row) { 
				echo $row["ObjectID"] . "#" . $row["Barcode"] . "#" . $row["PersonID"] . "#" . $row["Project"] . "#" . $row["Broken"] . "#";
			}
		}
		mysqli_close($con);
	}
	
	function attached_objects_list() {
		$sql = "SELECT * FROM Object o LEFT OUTER JOIN Project p ON o.Project = p.Name WHERE p.EndDate > NOW() AND o.Project IS NOT NULL";
		$ret = mysqli_query($con,$sql) or die(mysqli_error($con));
		if (mysqli_num_rows($ret) == 0) {
			echo OBJECT_NOT_FOUND;
		} else {
			echo OBJECT_FOUND;
			$rows = mysqli_fetch_all($ret);
			foreach($rows as $row) { 
				echo $row["ObjectID"] . "#" . $row["Barcode"] . "#" . $row["PersonID"] . "#" . $row["Project"] . "#" . $row["Broken"] . "#";
			}
		}
		mysqli_close($con);
	}
?>