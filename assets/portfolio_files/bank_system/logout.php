<?php
setcookie(login_successful,$htmllogin,time()-3600);
echo "<HTML>";
echo "You successfully sign out of your account!";
echo "<br><a href='proj2.html'>Return to Home Page</a>";
?>