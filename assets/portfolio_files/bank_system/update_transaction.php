<?php
include "dbconfig.php";

#checks for cookies
if (isset($_COOKIE["login_successful"])){
    $valueofthecookie=$_COOKIE[login_successful];  
    #logout function 
    echo ("<a href='logout.php'>User logout</a>");
    #gets all of the data from previous form via POST
    for($i=0;$i<count($_POST["codes_id"]);$i++)  {
        $codes_id[$i]=$_POST["codes_id"][$i];
        $deletedd[$i]=$_POST["deletedd"][$i];
        $noted_id[$i]=$_POST["noted_id"][$i];
      }
      #used for comparison for notes
      $notes_fromDB = array();
      $badnotecodes = array();
      #used to delete transactions
      $badboxcodes = array();
      $i=0;
      #connecting to database to check for differences
      $con=mysqli_connect($server,$login,$password,$dbname)
      or die("<br>Cannot connect to DB");
      $query="SELECT note FROM $dbname.Money where cid=$valueofthecookie";
      $result=mysqli_query($con,$query);
      if ($result) {
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){
                $notefromdb=$row['note'];

                #checkes notes
                if ($notefromdb!=$noted_id[$i]){
                    #gets code from changed note
                    array_push ($badnotecodes, $codes_id[$i]);
                    #gets note that is changed
                    array_push ($notes_fromDB, $noted_id[$i]);
                }
            
                $i++;
            }
        }
    }

    #checks for deletion
 for ($p=0; $p < sizeof($deletedd); $p++){
     if ($deletedd[$p]=='Y'){
         #puts code in array to delete
       array_push ($badboxcodes, $codes_id[$p]);
       }
    }
   echo ("<br>");
   
   #updating DB info
   $update_ctr=0;
  
   $con2=mysqli_connect($server,$login,$password,$dbname)
   or die("<br>Cannot connect to DB");

   for ($z=0; $z<sizeof($badnotecodes); $z++){
   $query2="UPDATE Money SET note='$notes_fromDB[$z]' where cid=$valueofthecookie and code='$badnotecodes[$z]'";
   $result2=mysqli_query($con2,$query2);
   echo ("The Note for code <b>$badnotecodes[$z]</b> has been updated in the database"."<br>");
    $update_ctr++;
    }


    #deleting DB info
    $update_dlt=0;
    $con5=mysqli_connect($server,$login,$password,$dbname)
    or die("<br>Cannot connect to DB");
 
    for ($b=0; $b<sizeof($badboxcodes); $b++){
    $query5="DELETE FROM Money WHERE cid=$valueofthecookie and code='$badboxcodes[$b]'";
    $result5=mysqli_query($con5,$query5);
    echo ("The code <b>$badboxcodes[$b]</b> has been deleted from the database"."<br>");
     $update_dlt++;
     }


    #closing message
    echo ("<br>"."There were $update_ctr updated notes and $update_dlt deleted records");









}

#if cookies are missing
else{
    echo "Please login first!";
    echo "<br><a href='proj2.html'>Return to Home Page</a>";
}


?>