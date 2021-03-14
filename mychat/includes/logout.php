<?php 

//finding the user id for the logout
if(isset($_SESSION['userid'])){

    unset($_SESSION['userid']);
}
$info->logged_in = false;
echo json_encode($info);


?>