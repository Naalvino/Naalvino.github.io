<?php
echo "<HTML>";
include "dbconfig.php";

$con=mysqli_connect($server,$login,$password,$dbname)
or die("<br>Cannot connect to DB");

$query="SELECT id,login,password,name,gender,dob,street,city,state,zipcode FROM Customers";

$result=mysqli_query($con,$query);


if ($result) {
	if(mysqli_num_rows($result)>0){
		echo "The following customers are in the bank system:";
		echo "<TABLE border=1>";
		echo "<TR><TH>ID<TH>Login<TH>Password<TH>Name<TH>Gender<TH>DOB<TH>Street<TH>City<TH>State<TH>Zipcode";

	while($row=mysqli_fetch_array($result)){
		$id=$row['id'];
		$login=$row['login'];
		$password=$row['password'];
		$name=$row['name'];
		$gender=$row['gender'];
		$DOB=$row['dob'];
		$street=$row['street'];
		$city=$row['city'];
		$state=$row['state'];
		$zipcode=$row['zipcode'];
		echo "<TR><TD>$id<TD>$login<TD>$password<TD>$name<TD>$gender<TD>$DOB<TD>$street<TD>$city<TD>$state<TD>$zipcode";
		}
		echo "</TABLE>";
	}
	else{
		echo "<br>No records in the database.";
		mysqli_free_result($result);
	}
}
else{
	echo "<br>Something wrong with SQL query";
}

 mysqli_close($con);
?>
