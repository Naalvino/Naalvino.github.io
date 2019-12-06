<?php
include "dbconfig.php";

#checks for cookies
if (isset($_COOKIE["login_successful"])){
    $valueofthecookie=$_COOKIE[login_successful];  
    #logout function 
    echo ("<a href='logout.php'>User logout</a>"."<br>");
    $tc=$_POST['transaction_code_inserted'];
    $dow=$_POST['banking'];
    $valofmon=$_POST['amountenteredbyuser'];
    $se=$_POST['source'];
    $notification=$_POST['notesenteredbyuser'];
    $balanceofbank=$_POST['totalbalance'];

    #negative or 0 amount entered
    if($valofmon<=0){
        echo ("Amount entered is less than 0 or 0, this is not allowed"."<br>");
    }
    #no amount entered
    if (empty($valofmon)&& $valofmon!=0){
        echo ("No amount was entered"."<br>");
    }
    #no source selected
    if ($se==""){
        echo("No source was selected"."<br>");
    }
    
    #withdrawl or deposit not selected
    if (empty($dow)){
        echo ("No transaction type was entered"."<br>");
    }
    #balance is less than the withdraw amount
    if ($dow=="W" && ($balanceofbank<$valofmon)){
      
        echo ("Withdraw amount exeeds the Balance, you will have a negative balance if this is entered"."<br>"."Withdrawl Denied"."<br>");
        
    }

    #connects to database to check is code is duplicate
    $connect=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    $statement="SELECT * FROM Money WHERE cid=$valueofthecookie and code='$tc'";
    $answer=mysqli_query($connect, $statement);
    while($rowz=mysqli_fetch_array($answer)){
        $mid=$rowz['code'];
        }
  
    if ($mid==$tc){
        #if code exists
        echo ("This transaction code already exist. Please enter a unique code."."<br>");
    }
    
    if (($valofmon>0) && ((empty($valofmon)&& $valofmon!=0)==false) &&  ($se!="")  &&   (empty($dow)==false)   && (($dow=="W" && ($balanceofbank<$valofmon))==false)  && ($mid!=$tc) ) {   
        #if code doesn't exists already
        if ($dow=="D"){
            $connections=mysqli_connect($server,$login,$password,$dbname)
            or die("<br>Cannot connect to DB");
            $statements="INSERT into Money values (mid, '$tc', $valueofthecookie, '$dow', '$valofmon', NOW(), '$notification', $se);";
            $inserted=mysqli_query($connections, $statements);
            echo ("You have just deposited $$valofmon into your account! "."<br>");
            echo ("<a href='add_transaction.php'>Back to Banking</a>"."<br>");
        }
        if ($dow=="W") {
            $negativeamt = "-$valofmon";
            $connections=mysqli_connect($server,$login,$password,$dbname)
            or die("<br>Cannot connect to DB");
            $statements="INSERT into Money values (mid, '$tc', $valueofthecookie, '$dow', '$negativeamt', NOW(), '$notification', $se);";
            $inserted=mysqli_query($connections, $statements);
            echo ("You have just withdrew $$negativeamt from your account! "."<br>");
            echo ("<a href='add_transaction.php'>Back to Banking</a>"."<br>");
        }
      
        ####END of insert code#####
    }




    ###### END OF PROGRAM ######
}



#if cookies are missing
else{
    echo "Please login first!";
    echo "<br><a href='proj2.html'>Return to Home Page</a>";
}
?>