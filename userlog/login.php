<?php include '../config/get_candidates.php'; ?>
<?php
	session_start();
	$msg = '';
	$mgsClass = '';
	//check for submit
	if(filter_has_var(INPUT_POST, 'submit')){
		//get form data
		$email = htmlspecialchars($_POST['email']);
		$password = htmlspecialchars($_POST['password']);
		//check requierd fields
		if(!empty($email) && !empty($password)){
			//passed
			if(filter_var($email, FILTER_VALIDATE_EMAIL)===false){
				//failed
				$msg = 'Please use a valid email';
				$mgsClass = 'alert-danger';
				$direct_url = $_SERVER['PHP_SELF'];
			}else{
				//check if email in database
				$email_exist = in_array($email, array_column($user_candidates_with_null, 'email'));
				if($email_exist){
					//get the user
					$user_key = array_search($email, array_column($user_candidates_with_null, 'email'));
					$user = $user_candidates_with_null[$user_key];
					//check for password
					$user_password = $user['password'];
					if($user_password == $password){
						$direct_url = 'success';
						//check if user from candidates else voter
						$email_exist = in_array($email, array_column($user_candidates, 'email'));
						if($email_exist){
							//this is a candidate
							//change session to candidate
							$_SESSION['user_type']='candidate';
							//get the candidate
							$_SESSION['candidate'] = $user;
							header('Location: /wevote/candidates.php');
						}else{
							//this is a voter
							//change session to voter
							$_SESSION['user_type']='voter';
							$_SESSION['voter']=$user;
							header('Location: /wevote/candidates.php');
						}
					}else{
						//failed
						$msg = 'Wrong Password';
						$mgsClass = 'alert-danger';
						$direct_url = $_SERVER['PHP_SELF'];
					}

				}else{
					//failed
					$msg = 'This user is not in database';
					$mgsClass = 'alert-danger';
				}
			}
			
		}else{
			//failed
			$msg = 'Please fill in all fields';
			$mgsClass = 'alert-danger';
		}


	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>We Vote</title>
	<link rel="stylesheet" href="https://bootswatch.com/5/cosmo/bootstrap.min.css">
</head>
<body>
	<?php if($msg!=''): ?>
		<div class="alert <?php echo $mgsClass?>"><?php echo $msg?></div>
	<?php endif ?>
	<div class="container">
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" value="<?php echo isset($email)?$email:'';?>" class="form-control">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control">
			</div>
			<br>
			<button type="submit" name="submit" class="btn btn-primary">Log In</button>
		</form>
	</div>
</body>
</html>