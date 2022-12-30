<?php
require('connection.inc.php');
require('functions.inc.php');

$name=get_safe_value($con,$_POST['name']);
$email=get_safe_value($con,$_POST['email']);
$address=get_safe_value($con,$_POST['address']);
$mobile=get_safe_value($con,$_POST['mobile']);
$password=get_safe_value($con,$_POST['password']);
$password2=get_safe_value($con,$_POST['password2']);

if($email != null && $email != "") 
  {
$check_user=mysqli_num_rows(mysqli_query($con,"select * from users where email='$email'"));
if($check_user>0){
	echo "email_present";
}else{
	if($password===$password2){
		$encryptedPassword = md5($password);
		$added_on=date('Y-m-d h:i:s');
		mysqli_query($con,"insert into users(name,email,address,mobile,password,added_on) values('$name','$email','$address','$mobile','$encryptedPassword','$added_on')");
		echo "insert";
	}else{
		echo "password_wrong";
	}
}
	}
?>