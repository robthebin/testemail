<?php
session_start();
//require 'vendor/autoload.php';
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/header.php';

?>

<?php

$formerror="";
$firstName="";
$lastName="";
$email="";
$password="";
$passwordc="";

//Next two brought outside if statement to become global


if (isset($_POST["unsubscribe"])){
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    //var_dump($email);
    //var_dump($password);
    //if($validate->check_password($password, $error_passwd)){
			$UM=new UserManager();
        
        $existuser = $UM->getUserByEmailPassword($email, $password);
        //var_dump($existuser);
        if(isset($existuser)){
            
            $_SESSION['email']=$email;
            $_SESSION['id']=$existuser->id;
            $_SESSION['role']=$existuser->role;
           UserManager::updateSubscription($_SESSION["email"]);
            
            //echo "You have unsubscribed." ;
            echo '<meta http-equiv="Refresh" content="1; url=unsubscribethankyou.php">';
        }else{
            $formerror="Invalid User Name or Password";
        }
    }

?>


<link rel="stylesheet" href="..\..\bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="..\..\ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="..\..\bootstrap/3.3.7/js/bootstrap.min.js"></script>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<div><h1 class="title">Unsubscribe Confirmation</h1></div>
<div><label class="title">Email:</label><input autocomplete="on" type="text" name="email" ></div>
<div><label class="title">Password:</label><input type="password" name="password" ></div>
</div>
</div>
<div><input type="submit" name="unsubscribe" value="Unsubscribe"></div>


</p>
</form>
</body>
</html>