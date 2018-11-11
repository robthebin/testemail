<?php
session_start();
require_once '../../includes/autoload.php';

use classes\business\UserManager;
use classes\entity\User;

ob_start();
include '../../includes/security.php';
include '../../includes/header.php';

$UM=new UserManager();
$users=$UM->getAllUsers();

if(isset($users)){
    ?>
	<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
    <br/><br/>Below is the list of Developers registered in community portal <br/><br/>
    <table class="pure-table pure-table-bordered" width="800">
            <tr>
			<thead>
               <th><b>Id</b></th>
               <th><b>First Name</b></th>
               <th><b>Last Name</b></th>
               <th><b>Email</b></th>
			   <th><b>Operation</b></th>
			   </thead>
            </tr>    
    <?php 
    foreach ($users as $user) {
        if($user!=null){
            ?>
            <tr>
               <td><?=$user->id?></td>
               <td><?=$user->firstName?></td>
               <td><?=$user->lastName?></td>
               <td><?=$user->email?></td>
			   <td>
					<a href='edituser.php?id=<?php echo $user->id ?>'>Edit</a>
					<a href='deleteuser.php?id=<?php echo $user->id ?>'>Delete</a>
			   </td>
			</tr>
            <?php 
        }
    }
}
    ?>
    </table><br/><br/>

Search for user via one of the following fields:

	<form action="userlist.php" method="post">
		Email:<input type="text" name="email"><br>
		<input type="submit" name="search" value="Submit">
	</form>
	
<?php
if(isset($_POST["search"])) {
		?>
		<link rel="stylesheet" href="..\..\css\pure-release-1.0.0\pure-min.css">
		Below is the list of search results<br/><br/>
		<table class="pure-table pure-table-bordered" width="800">
            <tr>
			<thead>
				<th><b>Id</b></th>
				<th><b>First Name</b></th>
				<th><b>Last Name</b></th>
				<th><b>Email</b></th>
			    <th><b>Operation</b></th>
			</thead>
            </tr>
<?php
		$UM=new UserManager();
		$results=$UM->searchByEmail($_POST["email"]);
		foreach($results as $result){
			if($result!=NULL){
				?>
				<tr>
					<td><?=$result->id?></td>
					<td><?=$result->firstName?></td>
					<td><?=$result->lastName?></td>
					<td><?=$result->email?></td>
					<td>
					<a href='edituser.php?id=<?php echo $user->id ?>'>Edit</a>
					<a href='deleteuser.php?id=<?php echo $user->id ?>'>Delete</a>
			   </td>
			</tr>
				</tr>
<?php 
			}
		}
	}
?>
</table>
<?php
include '../../includes/footer.php';
?>