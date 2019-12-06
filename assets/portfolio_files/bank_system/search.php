<?php
echo "<HTML>";
include "dbconfig.php";

#checks for cookies are present
if (isset($_COOKIE["login_successful"])){
  $searchedterm = $_GET["keyword"];
  if(empty($searchedterm)){
      echo ("No keyword entered");
  }
  
  if(!empty($searchedterm) && ($searchedterm != "*")){
  $cookievalue=$_COOKIE[login_successful];  
  ###get user id's
  $connect=mysqli_connect($server,$login,$password,$dbname)
  or die("<br>Cannot connect to DB");
  $statement="SELECT name FROM Customers where id=$cookievalue";
  $answer=mysqli_query($connect, $statement);
  while($rowz=mysqli_fetch_array($answer)){
    $nameofuser=$rowz['name'];
  }

  $con=mysqli_connect($server,$login,$password,$dbname)
  or die("<br>Cannot connect to DB");
  
  $query="SELECT mid, code, type, amount, mydatetime, note, sid FROM $dbname.Money where cid=$cookievalue and note like '%$searchedterm%'";
  # select * from Money where note like '%thing searched%';  
  $result=mysqli_query($con,$query);
  
  if ($result) {
      if(mysqli_num_rows($result)>0){
          echo "The transactions in customer <b>$nameofuser</b> records matched keyword <b>$searchedterm</b> are:";
          echo "<TABLE border=1>";
          echo "<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Date Time<TH>Note<TH>Source";
  
      while($row=mysqli_fetch_array($result)){
          $id=$row['mid'];
          $code=$row['code'];
          $type=$row['type'];
          $amount=$row['amount'];
          $datetime=$row['mydatetime'];
          $note=$row['note'];
          $source=$row['sid'];
          echo "<TR><TD>$id<TD>$code<TD>";
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
          echo "<TD>$datetime<TD>$note<TD>";
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
      }
          echo "</TABLE>";
      
        #adding amounts for total
					$con3=mysqli_connect($server,$login,$password,$dbname)
					or die("<br>Cannot connect to DB");
					$query3="SELECT sum(amount) sum FROM Money WHERE cid=$cookievalue and note like '%$searchedterm%'";
					$result3=mysqli_query($con3,$query3);
					$rows_amount2=$result3->num_rows;
					if($rows_amount2 == 1){	
						while($row2=$result3->fetch_assoc()){
							echo("Total balance: ".$row2['sum']);
						}
					}
        }
      #no records found in database
        else{
          echo "<br>No record found with the search keyword: <b>$searchedterm</b>";
          mysqli_free_result($result);
          }

      


      
      
  }
  #database Query is incorrect
  else{
      echo "<br>Something wrong with SQL query";
  }
  
}


if($searchedterm=="*"){
    $cookievalue=$_COOKIE[login_successful];  
    ###get user id's
    $connect=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    $statement="SELECT name FROM Customers where id=$cookievalue";
    $answer=mysqli_query($connect, $statement);
    while($rowz=mysqli_fetch_array($answer)){
      $nameofuser=$rowz['name'];
    }
  
  
  
    $con=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
    
    $query="SELECT mid, code, type, amount, mydatetime, note, sid FROM $dbname.Money where cid=$cookievalue";
    # select * from Money where note like '%thing searched%';  
    $result=mysqli_query($con,$query);
    
    if ($result) {
        if(mysqli_num_rows($result)>0){
            echo "The transactions in customer <b>$nameofuser</b> records matched keyword <b>$searchedterm</b> are:";
            echo "<TABLE border=1>";
            echo "<TR><TH>ID<TH>Code<TH>Type<TH>Amount<TH>Date Time<TH>Note<TH>Source";
    
        while($row=mysqli_fetch_array($result)){
            $id=$row['mid'];
            $code=$row['code'];
            $type=$row['type'];
            $amount=$row['amount'];
            $datetime=$row['mydatetime'];
            $note=$row['note'];
            $source=$row['sid'];
            echo "<TR><TD>$id<TD>$code<TD>";
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
            echo "<TD>$datetime<TD>$note<TD>";
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
        }
            echo "</TABLE>";
        }
      #adding amounts for total
      $con3=mysqli_connect($server,$login,$password,$dbname)
      or die("<br>Cannot connect to DB");
      $query3="SELECT sum(amount) sum FROM Money WHERE cid=$cookievalue";
      $result3=mysqli_query($con3,$query3);
      $rows_amount2=$result3->num_rows;
      if($rows_amount2 == 1){	
        while($row2=$result3->fetch_assoc()){
          echo("Total balance: ".$row2['sum']);
        }
      }
  
  
        #no records found in database
        else{
            echo "<br>No record found with the search keyword: <b>$searchedterm</b>";
            mysqli_free_result($result);
        }
    }
    #database Query is incorrect
    else{
        echo "<br>Something wrong with SQL query";
    }

  }

}

#if cookies are missing
else{
    echo "Please login first!";
    echo "<br><a href='proj2.html'>Return to Home Page</a>";
}
?>