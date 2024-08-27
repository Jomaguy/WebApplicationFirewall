<?php
//It inserts the parameters of the given web app into a data base
function train($page_name,$param_name,$param_value,$b_benign){

	//Create new connection
	$con = new mysqli("localhost","root","goodyear",'test');
	//If connection fails
	if ($con->connect_error){
		die("Connection failed: " . $con->connect_error);
	}		
	
	$sql = "INSERT INTO train(pageName,paramName,paramValue,benign)
		VALUES('$page_name','$param_name','$param_value','$b_benign')";

	if ($con->query($sql) === TRUE){
		echo "New record inserted";
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
	
	mysqli_close($con);
}

function check($page_name,$param_name,$param_value){

	
	//Create new connection
	$con = new mysqli("localhost","root","goodyear",'test');

	if ($con->connect_error){

		die("Connection failed " . $con->connect_error);
	}		

	//Based on $page_name, $param_name and $param_value return whether benign or malicious
	$result = mysqli_query($con, "SELECT * FROM train WHERE pageName = '$page_name' AND paramName = '$param_name'
		AND paramValue = '$param_value'");
	
	while($row = mysqli_fetch_assoc($result)){
		if ($row["benign"] == 1)	
		{
			echo " Benign ";
		}
		if ($row["benign"] == 0)
		{
			echo " Malicious ";
		}

	}
}
?>
