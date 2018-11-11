<?php
namespace classes\data;

use classes\entity\User;
use classes\util\DBUtil;

class UserManagerDB
{
    public static function fillUser($row){
        $user=new User();
        $user->id=$row["id"];
        $user->firstName=$row["firstname"];
        $user->lastName=$row["lastname"];
        $user->email=$row["email"];
        $user->password=$row["password"];
		$user->role=$row["role"];
		$user->account_creation_time=$row["account_creation_time"];
		$user->subs=$row["subs"];
        return $user;
    }
    public static function getUserByEmailPassword($email,$password){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $password=mysqli_real_escape_string($conn,$password);
        $sql="select * from tb_user where email='$email' and password='$password'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
    public static function getUserByEmail($email){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $email=mysqli_real_escape_string($conn,$email);
        $sql="select * from tb_user where Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
	
	public static function getUserById($id){
        $user=NULL;
        $conn=DBUtil::getConnection();
        $id=mysqli_real_escape_string($conn,$id);
        $sql="select * from tb_user where id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
            }
        }
        $conn->close();
        return $user;
    }
	// changes you made here: added 1 more ?, added 1 more s, added $user->subs
    public static function saveUser(User $user){
        $conn=DBUtil::getConnection();
        $sql="call procSaveUser(?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $user->id,$user->firstName, $user->lastName, $user->email, $user->password, $user->account_creation_time, $user->role, $user->subs); 
        $stmt->execute();
        if($stmt->errno!=0){
            printf("Error: %s.\n",$stmt->error);
        }
        $stmt->close();
        $conn->close();
    }
    public static function updatePassword($email,$password){
        $conn=DBUtil::getConnection();
        $sql="UPDATE tb_user SET password='$password' WHERE email='$email';";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

    }	
	
    public static function deleteAccount($id){
        $conn=DBUtil::getConnection();
        $sql="DELETE from tb_user WHERE id='$id';";
        $stmt = $conn->prepare($sql);
		if ($conn->query($sql) === TRUE) {
			echo "<script>alert(Record deleted successfully)</script>";
		} else {
			echo "Error updating record: " . $conn->error;
		}
		$conn->close();

    }		
    public static function getAllUsers(){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
    public static function searchByEmail($email){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user WHERE email like '%$email%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
	public static function searchByCriteria($firstName, $lastName, $email){
        $users[]=array();
        $conn=DBUtil::getConnection();
        $sql="select * from tb_user ";
		$condition = "";
		
		$condition = self::searchCondition($condition, "firstName" , $firstName, "OR");
		$condition = self::searchCondition($condition, "lastName" , $lastName, "OR");
		$condition = self::searchCondition($condition, "email" , $email, "OR");
		
		if (!($condition == "")){
			$sql = $sql . " WHERE " . $condition;
		}
		
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user=self::fillUser($row);
                $users[]=$user;
            }
        }
        $conn->close();
        return $users;
    }
	public function searchSQL( $firstName, $lastName, $email){
		$sql = " SELECT * FROM tb_user";
		$condition = "";
		
		$condition = self::searchCondition($condition, "firstName" , $firstName, "OR");
		var_dump ($condition);
		$condition = self::searchCondition($condition, "lastName" , $lastName, "OR");
		var_dump ($condition);
		$condition = self::searchCondition($condition, "email" , $email, "OR");
		var_dump ($condition);
		
		if (!($condition == "")){
			$sql = $sql . " WHERE " . $condition;
		}
		return $sql;
	}
	private static function searchCondition($prevCond, $fieldName, $fieldValue, $operator){
		$condition ="";
		IF ($fieldValue ==""){
			$condition = $prevCond;
		} else {
			$condition=$fieldName  . " like '%$fieldValue%'";
			IF ( $prevCond !=="" ) {
				$condition = $prevCond . " " . $operator . " " . $condition;
			}
		}
		
		
		return $condition;
    }
	public static function updateSubscription($email){
        $conn = DBUtil::getConnection();
        
        $sql  = "UPDATE tb_user SET subs='0' WHERE email='$email';";
        if ($conn->query($sql)) {
            $conn->close();
            return true;
        } else {
            $conn->close();
            return false;
        }
        
    }
}
?>