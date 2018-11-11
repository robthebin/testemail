<?php
session_start();
use classes\business\UserManager;
use classes\business\Validation;

require_once 'includes/autoload.php';
include 'includes/header.php';
$formerror="";

$email="";
$password="";
$error_auth="";
$error_name="";
$error_passwd="";
$error_email="";
$validate=new Validation();

if(isset($_POST["submitted"])){
    $email=$_POST["email"];
    $password=md5($_POST["password"]);
//	if($validate->check_password($password, $error_passwd))
	{
		$UM=new UserManager();

		$existuser=$UM->getUserByEmailPassword($email,$password);
		if(isset($existuser)){
			
			$_SESSION['email']=$email;
			$_SESSION['id']=$existuser->id;
			$_SESSION['role']=$existuser->role;//added for role
			echo '<meta http-equiv="Refresh" content="1; url=home.php">';
		}else{
			$formerror="Invalid User Name or Password";
		}
	}
}

?>
<link rel="stylesheet" href=".\css\pure-release-1.0.0\pure-min.css">
<h1>Login</h1>
<script src='https://www.google.com/recaptcha/api.js'></script>
<form name="myForm" method="post" class="pure-form pure-form-stacked">
<table border='0' width="100%">
  <tr>    
    <td>Username</td>
    <td><input type="email" name="email" value="<?=$email?>" pattern=".{1,}"   required title="Cannot be empty field" size="30"></td>
	<td><?php echo $error_name?>
  </tr>
  <tr>    
    <td>Password</td>
    <td><input type="password" name="password" value="<?=$password?>"  size="30"></td>
	<td><?php echo $error_passwd?>
  </tr> 
  <tr>
	<td></td>
	<td><br><div class="g-recaptcha" data-sitekey="6LfVQnAUAAAAAFM30OiUYICFVjCRv-qu634-YmGL"></div></td>
  </tr>
  <tr>
    <td></td>
    <td><br><input type="submit" name="submitted" value="Submit" class="pure-button pure-button-primary">
    <input type="reset" name="reset" value="Reset" class="pure-button pure-button-primary"></td>
    </td>
  </tr>
  <tr> <?php echo $formerror?></tr>
  <tr>
  <td></td>
    <td>
       <br><a class="pure-button" href="modules/user/register.php">Register Now</a>
	   <a class="pure-button" href="./forgetpassword.php">Forget Password</a>
    </td>
  </tr>   
</table>
</form>
<?php
include 'includes/footer.php';
?>