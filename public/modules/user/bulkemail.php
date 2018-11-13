 <?php
//require_once '../../includes/autoload.php';

//use classes\business\UserManager;
//use classes\entity\User;

use vendor\PHPMailer\PHPMailer\PHPMailerAutoload;
use vendor\PHPMailer\PHPMailer\Exception;

require '../../../vendor/autoload.php';

function sendmail($subject,$message)
{
		
		$mail = new PHPMailer(true);                // Passing `true` enables exceptions
		$mail->isSMTP();							//Tell PHPMailer to use SMTP
		$mail->SMTPDebug = 2;						//Enable SMTP debugging // 0 = off (for production use), 1 = client messages, 2 = client and server messages
		$mail->Host = 'smtp.gmail.com';				//Set the hostname of the mail server
		$mail->Port = 587;							//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$mail->SMTPSecure = 'tls';					//Set the encryption system to use - ssl (deprecated) or tls
		$mail->SMTPAuth = true;						//Whether to use SMTP authentication
		$mail->Username = "username";	//Username to use for SMTP authentication - use full email address for gmail
		$mail->Password = "password";			//Password to use for SMTP authentication
		$mail->setFrom('robthebintest@gmail.com', 'ACWD Mailer');	//Set who the message is to be sent from
		$mail->addAddress('robthebintest@gmail.com', 'ACWD Mailer');	//Set who the message is to be sent to
        $mail->isHTML(true);
		$mail->Subject = $subject;
		$rootlink="http://localhost/phpcrudsample/public/modules/user/";
		$link=$rootlink."unsubscribe.php ";
		$mail->Body = $message . "<br><br>" . "To stop receiving newsletters, click <a href=" . $link . ">here</a>" . "<br>";
		
		
			$conn = mysqli_connect("127.0.0.1", "root", "root123", "phpcrudsample");
			$sql = "SELECT  `email` FROM  `tb_user` WHERE  `subs` =1";
			$result = $conn->query($sql);
    
			foreach($result as $row){
			$mail->addBCC($row["email"]);
			}
			
    if (!$mail->send()) {
			echo "Message could not be sent.";
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {echo "Email sent successfully.";}
}

if ($_SERVER['REQUEST_METHOD']=='POST'){
		
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        sendmail($subject,$message);		//send bulk email
		}

?>

<link rel="stylesheet" href="..\..\bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="..\..\ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="..\..\bootstrap/3.3.7/js/bootstrap.min.js"></script>
<h1>Mass Mailer Client</h1>
<form method="POST" action="">
<p><label for="subject">Subject:</label><br/>
<input type="text" id="subject" name="subject" size="50" /></p>
<p><label for="message">Message:</label><br/>
<textarea rows="5" cols="50" maxlength="256" name="message"></textarea><br/><br/>
<button type="submit" name="submit" value="submit">Submit</button>
</form>
