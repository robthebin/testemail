<?php
require_once '../../includes/autoload.php';
include '../../includes/header.php';
use classes\util\DBUtil;
use classes\business\UserManager;
use classes\entity\User;

$formerror="";

$firstName="";
$lastName="";
$email="";
$password="";

if(isset($_REQUEST["submitted"])){
    $firstName=$_REQUEST["firstName"];
    $lastName=$_REQUEST["lastName"];
    $email=$_REQUEST["email"];
    $password=md5($_REQUEST["password"]);
    
    if($firstName!='' && $lastName!='' && $email!='' && $password!=''){
        $UM=new UserManager();
        $user=new User();
        $user->firstName=$firstName;
        $user->lastName=$lastName;
        $user->email=$email;
        $user->password=$password;
        $user->role="user";
		$user->subs="1";
        $existuser=$UM->getUserByEmail($email);
    
        if(!isset($existuser)){
            // Save the Data to Database
            $UM->saveUser($user);
            #header("Location:registerthankyou.php");
			echo '<meta http-equiv="Refresh" content="1; url=./registerthankyou.php">';
        }
        else{
            $formerror="User Already Exist";
        }
    }else{
        $formerror="Please fill in the fields";
    }
}
?>
<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<h1>Registration Form</h1>
<script src='https://www.google.com/recaptcha/api.js'></script>
<div><?=$formerror?></div>
<table width="800">
  <tr>
    <td>First Name</td>
    <td><input type="text" name="firstName" value="<?=$firstName?>" size="50"></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input type="text" name="lastName" value="<?=$lastName?>" size="50"></td>
  </tr>
  <tr>    
    <td>Email</td>
    <td><input type="text" name="email" value="<?=$email?>" size="50"></td>
  </tr>
  <tr>    
    <td>Password</td>
    <td><input type="password" name="password" value="<?=$password?>" size="20"></td>
  </tr>  
  <tr>    
    <td>Confirm Password</td>
    <td><input type="password" name="cpassword" value="<?=$password?>" size="20"></td>
  </tr>
  <tr>
   <td></td>
   <td><br><div class="g-recaptcha" data-sitekey="6LfVQnAUAAAAAFM30OiUYICFVjCRv-qu634-YmGL"></div></td>
  </tr>
  <tr>
   <td>
   </td>
   <td>
       <br>
       <input type="submit" name="submitted" value="Submit">
       <input type="reset" name="reset" value="Reset">
   </td>
  </tr>
</table>
</form>

<?php
include '../../includes/footer.php';
?>