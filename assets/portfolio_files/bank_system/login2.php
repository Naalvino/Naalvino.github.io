<?php
include "dbconfig.php";
$con=mysqli_connect($server,$login,$password,$dbname)
or die("<br>Cannot connect to DB");

#gets usernames from html form
$htmllogin = strtolower ($_POST["login"]);
$htmlpassword = ($_POST["password"]);

#check if empty them access database
if ((empty($htmllogin) and empty($htmlpassword))==true){
 	die ("Please enter a login and password!");	
}
if (empty($htmllogin)==true){
	die ("Please enter a login!");	
}
if (empty($htmlpassword)==true){
	die ("Please enter a password!");	
}

else 
#check if the username is in the database
$query="SELECT * FROM Customers where login='$htmllogin'";
$result=mysqli_query($con,$query);
if(mysqli_num_rows($result) == 1){	
	#if in here, login is right
	while($row=$result->fetch_assoc()){
		if($row['password'] == $htmlpassword){

			##############Correct login is in here#################
			#password is right
			#logout function 
			echo ("<a href='logout.php'>User logout</a>"."<br>");
			
			#all top information above table from project1			
			$UserID=$row['id'];
			#cookie set
			setcookie(login_successful,$UserID,time()+3600);
			$ip=$_SERVER['REMOTE_ADDR'];
			echo ("Your IP: $ip"."<br>");
			echo("Welcome Customer: ".$row['name']. "<br>");
			#checks age
			$age = floor((time() - strtotime($row['DOB'])) / 31556926);
			echo ("age: $age <br>");
			echo("Address: ".$row['street'].", ".$row['city'].", ".$row['zipcode']. "<br>");
			echo("<hr>");
			echo("The transactions from customer ".$row['name']." are: Savings account");
			$nameofthecustomer=$row['name'];
					#Money table to display  
					$con2=mysqli_connect($server,$login,$password,$dbname)
					or die("<br>Cannot connect to DB");
					$query2="SELECT * FROM Money where cid=$UserID";
					$result2=mysqli_query($con2,$query2);
					if ($result2) {
						if(mysqli_num_rows($result2)>0){
							echo "<TABLE border=1>";
							echo "<TR><TH>ID<TH>Code<TH>Operation<TH>Amount<TH>Date Time<TH>Note";
							while($row=mysqli_fetch_array($result2)){
								if($row['cid']==$UserID){
									$mid=$row['mid'];
									$code=$row['code'];
									$type=$row['type'];
									$amount=$row['amount'];
									$datetime=$row['mydatetime'];
									$note=$row['note'];
									echo "<TR><TD>$mid<TD>$code<TD>";
									if($type=='D'){
										echo("Deposit");
									}
									if($type=='W'){
										echo("Withdraw");
									}
									echo "<TD>";
									if ($amount<0){
										echo "<font color='red'>$amount</font>";
									}
									if ($amount>0){
										echo "<font color='blue'>$amount</font>";
									}
									if($amount==0){
										echo "$amount";
									}
									echo "<TD>$datetime<TD>$note";
								}
							}	
							echo "</TABLE>";
						}
					}
					else
						echo "<br>No records in the database.";
						mysqli_free_result($result2);

					#adding amounts for total
					$con3=mysqli_connect($server,$login,$password,$dbname)
					or die("<br>Cannot connect to DB");
					$query3="SELECT sum(amount) sum FROM Money WHERE cid=$UserID";
					$result3=mysqli_query($con3,$query3);
					$rows_amount2=$result3->num_rows;
					if($rows_amount2 == 1){	
						while($row2=$result3->fetch_assoc()){
							echo("Total balance: ".$row2['sum']);
						}
					}
					
					#buttons at the bottom
					echo "<TABLE border='0'>";
					#add transaction button
					echo "<TR><TD><form action='add_transaction.php' method='POST'>"."<input type='hidden' name='nameofcustomer' value='$nameofthecustomer'>"."<input type='submit' value='Add transaction'>"."</form>";
					#Display and update transactions link	
					echo "<TD><TD><TD><TD><TD><a href='display_update_transaction.php'>Display and update transaction</a>";
					echo "</TABLE>";
					#search form and button
					echo "<form action='search.php'>";
					echo "Keyword: "."<input type='text' name='keyword'>"." "."<input type='submit' value='Search transaction'>";
				  	echo "</form>"; 
					
					

					
					#####################End of correct login###########################
		}
		else
			#login right, password wrong
			die("Login $htmllogin exists, but password does not match");
	}
}
else	
	#if here, login is incorrect
	die("Login $htmllogin doesn't exist in the database"); 
?>