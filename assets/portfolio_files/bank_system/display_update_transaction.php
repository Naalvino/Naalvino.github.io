<?php
include "dbconfig.php";

#checks for cookies
if (isset($_COOKIE["login_successful"])){
    $valueofthecookie=$_COOKIE[login_successful];  
    #logout function 
    echo ("<a href='logout.php'>User logout</a>");
    echo ("<br>"."You can only update the <b>Note</b> column.");
    
    $con=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    
    $query="SELECT mid, code, amount, type, sid, mydatetime, note FROM $dbname.Money where cid=$valueofthecookie";
    $result=mysqli_query($con,$query);
    
    if ($result) {
        if(mysqli_num_rows($result)>0){
            echo "<form action='update_transaction.php' method='post'>";
            echo "<TABLE border=1>";
            echo "<TR><TH>ID<TH>Code<TH>Amount<TH>Operation<TH>Source<TH>Date Time<TH>Note<TH>Delete";
            while($row=mysqli_fetch_array($result)){
                $id=$row['mid'];
                $code=$row['code'];
                $type=$row['type'];
                $amount=$row['amount'];
                $datetime=$row['mydatetime'];
                $note=$row['note'];
                $source=$row['sid'];
                echo "<TR><TD>$id<TD>$code<TD>";
                 if ($amount<0){
            echo "<font color='red'>$amount</font>";
            }
            if ($amount>0){
            echo "<font color='blue'>$amount</font>";
               }
            if($amount==0){
            echo "$amount";
            }
                echo "<TD>";
                if($type=='D'){
                  echo("Deposit");
                }
                if($type=='W'){
                  echo("Withdraw");
                }
                echo "<TD>";
                  switch($source){
                    case "1": 
                      echo "ATM";
                      break;
                    case "2": 
                      echo "Online";
                      break;
                    case "3": 
                      echo "Branch";
                      break;
                    case "4": 
                      echo "Wired";
                      break;  
                    default:
                      echo "no source indicated";    
                }  
                echo "<TD>$datetime<TD>";
                
                echo ("<input type='text' value='$note' style='background-color:yellow' name='noted_id[$i]'>");
                


               echo "<TD><input type='checkbox' name='deletedd[$i]' value='Y'>";
               echo "<input type='hidden' name='deletedd[$i]' value='N'>";
               
               echo "<input type='hidden' name='codes_id[$i]' value='$code'>";
               


              }






            echo "</TABLE>";
        }
    }

#adding amounts for total
$con3=mysqli_connect($server,$login,$password,$dbname)
or die("<br>Cannot connect to DB");
$query3="SELECT sum(amount) sum FROM Money WHERE cid=$valueofthecookie";
$result3=mysqli_query($con3,$query3);
$rows_amount2=$result3->num_rows;
if($rows_amount2 == 1){	
    while($row2=$result3->fetch_assoc()){
        echo("Total balance: ".$row2['sum']);
    }
}

#add transaction button
#make it so it passes code
echo "<br><input type='submit' value='Update Transaction'>";
echo "</form>";






















}

    #if cookies are missing
else{
    echo "Please login first!";
    echo "<br><a href='proj2.html'>Return to Home Page</a>";
}

?>