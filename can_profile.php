<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>

<!--
check id and program point and program point text
-->
<?php
	//this is for first time
	// $id = htmlentities(isset($_GET['candidate']));
	// echo $id;
	if(htmlentities(isset($_GET['updated_id']))){
		$id = $_GET['updated_id'];
	}
	// echo $id;
	//check if id exists
	$id_exist = in_array($id, array_column($user_candidates, 'can_fk'));
	if($id_exist){
		// get the key of candidate in the candidates
		$can_key = array_search($id, array_column($user_candidates, 'can_fk'));
	
		$candidate = $user_candidates[$can_key];
		$program_point = 'About';
		$program_point_text = $candidate['about'];
		if(isset($_GET['submit'])){
			$submit_value = htmlentities($_GET['submit']);
			switch ($submit_value) {
				case 'about':
					$program_point='About';
					$program_point_text = $candidate['about'];
					break;
				case 'education':
					$program_point='Education';
					$program_point_text = $candidate['education'];
					break;
				case 'health':
					$program_point='Health';
					$program_point_text = $candidate['health'];
					break;
				case 'industry':
					$program_point='Industry';
					$program_point_text = $candidate['industry'];
					break;
				case 'commerce':
					$program_point='Commerce';
					$program_point_text = $candidate['commerce'];
					break;
				case 'appeals':
					$program_point = 'appeal';
					if($candidate['num_appeals']==0){
						$program_point_text = 'candidate has no appeals';
					}else{
						// view the appeals of the candidate
						$program_point_text = 'candidates has '.$candidate['num_appeals'].' appeals';
					}
					break;

				default:
					# code...
					break;
			}
		}
	}else{
		//id is not among candidates
		$msg="This id is not in candidates list";
	}
?>

<!--
insert the comments and replys here before getting them(to get the updated)
we have id and program point from avove to candidate
and also session for comment owner
-->
<?php
	if(filter_has_var(INPUT_POST, 'submit_comment') and isset($_SESSION['user_type'])){
		//get form data
		$comment_type='comment';
		$comment = htmlspecialchars($_POST['comment']);
		require('config/add_comments.php');
	}
	//echo date('d/m/y h:i:sa', $comments[0]['created_at']);
	//$t=time();
	if(filter_has_var(INPUT_POST, 'submit_reply') and isset($_SESSION['user_type'])){
		//get form data
		$comment_type='reply';
		$comment = htmlspecialchars($_POST['reply']);
		$reply_comment_id = htmlentities($_POST['reply_to_comment']);
		require('config/add_comments.php');
	}
?>






<!--
get the comments
-->
<?php include 'config/comments_queries.php';?>
<?php
	//echo var_dump(isset($_SESSION['candidate'])?$_SESSION['user_type']:'voter');
	
	$num_comments = count($comments);

	
	
?>
<?php if($id_exist):;?>
	<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:22%;">
		<div class="container">
			<img src="./candidates_data/can1.png" style="width:18rem;">
			<h2><?php echo $candidate['name'];?></h2>
				<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<button type="submit" name="submit" value="about" class="w3-bar-item w3-button">About</button>
					<button type="submit" name="submit" value="education" class="w3-bar-item w3-button">Education</button>
					<button type="submit" name="submit" value="health" class="w3-bar-item w3-button">Health</button>
					<button type="submit" name="submit" value="industry" class="w3-bar-item w3-button">Industry</button>
					<button type="submit" name="submit" value="commerce" class="w3-bar-item w3-button">Commerce</button>
					<button type="submit" name="submit" value="appeals" class="w3-bar-item w3-button btn-danger">Appeals</button>
					<input type="hidden" name="updated_id" value="<?php echo $id;?>">
				</form>
		</div>
	</div>
	<div style="margin-left:25%">
		<!--Candidate program points or appeals-->
		<?php if($program_point!='appeal'):;?>
			<h3 class="pad_top"><?php echo $program_point;?></h3>
			<?php if ($program_point=='About'):;?>
				<!--Display the video-->
				<h4>Display Video about candidate in this area</h4>
			<?php endif;?>
			<p><?php echo $program_point_text;?></p>
			<hr>
		<?php else:;?>
			<h3 class="pad_top">Appeals</h3>
			<p><?php echo $program_point_text;?></p>
			<?php if($candidate['num_appeals']!=0):;?>
				<!--Display appeals here-->

			<?php endif;?>
		<?php endif;?>
		<!--comments form-->
		
		<?php $form_sub = isset($_GET['submit'])?'?submit='.$_GET['submit'].'&updated_id='.$id : '?updated_id='.$id; ?>
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'].$form_sub;?>">
			<div class="form-group">
				<textarea name="comment" class="form-control"></textarea>
			</div>
			<br>
			<button type="submit" name="submit_comment" class="btn btn-primary">Add Comment</button>
		</form>
		<h2>Comments:</h2>
		<!--loop over comments and replys-->
		<?php for($i=0;$i<$num_comments;$i++):; ?>
			<?php 
				require 'config/db.php';
				//replys
				$query = "
				SELECT name
				FROM users
				WHERE id='".$comments[$i]['id']."'
				";

				//Get the result
				$result = mysqli_query($conn, $query);
				//fetch the data
				$comment_name = mysqli_fetch_assoc($result);
				//free result
				mysqli_free_result($result);
				//close connnection
				mysqli_close($conn);

			?>
			<p style="font-weight:bold;margin-bottom: 0px;"><?php echo $comment_name['name'].' '. date('d/m/Y h:i:sa', $comments[$i]['created_at']);?></p>
			<!--Display comment-->
			<p><?php echo $comments[$i]['body'];?></p>
			<!--Get replys here-->

			<!--replys form-->
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'].$form_sub.'&updated_id='.$id;?>" style="margin-left: 60px;">
				<div class="form-group">
					<textarea name="reply" class="form-control"></textarea>
				</div>
				<br>
				<input type="hidden" name="reply_to_comment" value="<?php echo $comments[$i]['comment_id'];?>">
				<button type="submit" name="submit_reply" class="btn btn-primary">Add Reply</button>
			</form>

			<?php 
				require 'config/db.php';
				//replys
				$query = "
				SELECT * 
				FROM comments_replys
				WHERE to_candidate='".$_GET['updated_id']."' and program_point='".strtolower($program_point)."' and is_reply=1 and comment_id='".$comments[$i]['comment_id']."'
				ORDER BY created_at DESC
				";

				//Get the result
				$result = mysqli_query($conn, $query);
				//fetch the data
				$replys = mysqli_fetch_all($result, MYSQLI_ASSOC);
				//free result
				mysqli_free_result($result);
				//close connnection
				mysqli_close($conn);

			?>
			<!--loop over replys-->
			<h4 style="margin-left: 60px;">Replys:</h4>
			<?php for($j=0;$j<count($replys);$j++):;?>
				<?php 
				require 'config/db.php';
				//replys
				$query = "
				SELECT name
				FROM users
				WHERE id='".$replys[$j]['id']."'
				";

				//Get the result
				$result = mysqli_query($conn, $query);
				//fetch the data
				$reply_name = mysqli_fetch_assoc($result);
				//free result
				mysqli_free_result($result);
				//close connnection
				mysqli_close($conn);

				?>
				<p style="font-weight:bold;margin-left: 60px;margin-bottom: 0px;"><?php echo $reply_name['name'].' '. date('d/m/Y h:i:sa', $replys[$i]['created_at']);?></p>
				<p style="margin-left: 60px;"><?php echo $replys[$j]['body'];?></p>
			<?php endfor;?>
			<hr>
		<?php endfor;?>

	</div>
<?php else:;?>
	<h4><?php echo $msg;?></h4>
<?php endif;?>
<?php include 'inc/footer.php';?>
