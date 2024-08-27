<?php
include "waf_lib.php";

//Connecting to db called test and will use the table called train
$con = mysqli_connect("localhost","root","goodyear",'test');

//check connection
if (mysqli_connect_errno()){
	echo "Failed to connect" . mysqli_connect_error();
	exit();
}

// Get name and return associated email 
$name = $_GET["name"];
$namee = "Jonathan";

//perform the query
$result = mysqli_query($con, "SELECT * FROM person WHERE name = '$name'");

$b_train = $_GET["train"];
$b_benign = $_GET["benign"];
// if $b_train{
//train("simplepage.php","paramname",50,1);
//train("hofstra.edu","name",40,0);
//
// }
//check("simplepage.php","paramname",$name);
//check("hofstra.edu","name","name");

while($row = mysqli_fetch_assoc($result)){
	echo "email : " . $row["email"] ;
}
mysqli_close($con);

?>
