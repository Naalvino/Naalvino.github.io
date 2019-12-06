<?php
include "dbconfig.php";

#checks for cookies
if (isset($_COOKIE["login_successful"])){
    $valueofthecookie=$_COOKIE[login_successful];  
    #logout function 
    echo ("<a href='logout.php'>User logout</a>");
    echo ("<br>"."<h2>Add Transaction</h2>");

    #gets name from login2.php program
    $username=$_POST['nameofcustomer'];
    echo ("<b>$username</b>");
    ###get users balance
    $connect=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    $statement="SELECT sum(amount) sum FROM Money WHERE cid=$valueofthecookie";
    $answer=mysqli_query($connect, $statement);
    while($rowz=mysqli_fetch_array($answer)){
    $totalbalance=$rowz['sum'];
    }
    echo (" current balance is <b>$totalbalance</b>."."<br>");


    echo ("<form action='insert_transaction.php' method='post' required='required'>");
    echo ("Transaction code: "."<input type='text' name='transaction_code_inserted' required='required'>"."<br>");
    echo ("<input type='radio' name='banking' id='deposit' value='D'>Deposit ");
    echo ("<input type='radio' name='banking' id='withdraw' value='W'>Withdraw"."<br>");
    echo ("Amount: <input type='text' name='amountenteredbyuser' required='required'><input type='hidden' name='totalbalance' value=$totalbalance>"."<br>");
    
    #for drop down selection
    $secondconnection=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    $selectstatement="SELECT id, name FROM Sources";
    $answerz=mysqli_query($secondconnection, $selectstatement);
    echo ("Select a Source: ");
    echo ("<select name='source'>"."<option value=''></option>");
    while($rowing=mysqli_fetch_array($answerz)){
    $sourceid=$rowing['id'];
    $sourcename=$rowing['name'];
    echo ("<option value=$sourceid>$sourcename</option>");
    }
    echo ("</select>"."<br>");
    echo ("Note: <input type='text' name='notesenteredbyuser' required='required'><input type='hidden' name='totalbalance' value=$totalbalance>"."<br>");
    echo ("<input type='submit' value='Submit'>");
    echo("</form>");

    ##########end of program if cookies are present#########################
}

#if cookies are missing
else{
    echo "Please login first!";
    echo "<br><a href='proj2.html'>Return to Home Page</a>";
}
?>