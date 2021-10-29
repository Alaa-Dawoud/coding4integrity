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

	$num_comments = count($comments);

	
	
?>


<!--appeals form-->
<?php
	if(filter_has_var(INPUT_POST, 'submit_appeal') and isset($_SESSION['user_type'])){
		//get form data
		if(!empty($_POST['submit_appeal_body']) and $_FILES["fileToUpload"]["tmp_name"]!=""){
			require 'config/add_appeals.php';
		}else{
			echo 'please submit all required fields';
		}
	}
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
				<video width="900" height="480" controls>
					<source src="<?php echo '/wevote/candidates_data/can1.mp4';?>" type="video/mp4">
					Your browser does not support the video tag.
				</video>
			<?php endif;?>
			<p><?php echo $program_point_text;?></p>
			<hr>
			<?php include 'comments_section.php';?>
		<?php else:;?>
			<h3 class="pad_top">Appeals</h3>
			<p><?php echo $program_point_text;?></p>
			<!--Form to add appeal-->
			<?php $form_sub = isset($_GET['submit'])?'?submit='.$_GET['submit'].'&updated_id='.$id : '?updated_id='.$id; ?>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'].$form_sub;?>" enctype="multipart/form-data">
				<div class="form-group">
			      <label for="formFile" class="form-label mt-4">Choose File</label>
			      <input name="fileToUpload" class="form-control" type="file" id="formFile">
			    </div>
				<div class="form-group">
					<label>Add description of appeal</label>
					<textarea name="submit_appeal_body" class="form-control"></textarea>
				</div>
				<br>
				<button type="submit" name="submit_appeal" class="btn btn-danger">Add Appeal</button>
			</form>
			<?php if($candidate['num_appeals']!=0):;?>
				<!--Display appeals here-->
				<!--loop over appeals-->

				<?php include 'config/get_appeals.php';?>
				<?php for($i=0;$i<$candidate['num_appeals'];$i++):;?>
					<!--check mp3 appeals-->
					<?php if(count($appeals_data["mp3"])!=0): ;?>
						<h3>MP3 Appeals</h3>
						<?php for($j=0;$j<count($appeals_data["mp3"]);$j++):;?>
							<h4>Appeal <?php echo $i+1;?></h4>
							<audio controls>
								<source src="<?php echo '/wevote/candidates_appeals/'.$appeals_data["mp3"][$j];?>" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>
							<!--get the body of the candidate whose appeal id is the id of the mp3 number because it sotred by appeal id and don't loop over body text from $i variable-->
							<?php $file_name = pathinfo($appeals_data["mp3"][$j], PATHINFO_FILENAME);?>
							<p><span style="font-weight: bold;">Appeal Description:</span> <?php echo $appeals[array_search($file_name, array_column($appeals, 'appeal_id'))]['body'];?></p>
							<!--found an appeal so increase i by 1-->
							<?php $i+=1;?>
						<?php endfor;?>
					<?php endif;?>
					<!--check mp4 appeals-->
					<?php if(count($appeals_data["mp4"])!=0): ;?>
						<h3>MP4 Appeals</h3>
						<?php for($j=0;$j<count($appeals_data["mp4"]);$j++):;?>
							<h4>Appeal <?php echo $i+1;?></h4>
							<video width="320" height="240" controls>
								<source src="<?php echo '/wevote/candidates_appeals/'.$appeals_data["mp4"][$j];?>" type="video/mp4">
								Your browser does not support the video tag.
							</video>
							<!--get the body of the candidate whose appeal id is the id of the mp4 number because it sotred by appeal id and don't loop over body text from $i variable-->
							<?php $file_name = pathinfo($appeals_data["mp4"][$j], PATHINFO_FILENAME);?>
							<p><span style="font-weight: bold;">Appeal Description:</span> <?php echo $appeals[array_search($file_name, array_column($appeals, 'appeal_id'))]['body'];?></p>
							<!--found an appeal so increase i by 1-->
							<?php $i+=1;?>
						<?php endfor;?>
					<?php endif;?>
				<?php endfor;?>
				<hr>
				<?php include 'comments_section.php';?>
			<?php endif;?>
		<?php endif;?>
		
	</div>
<?php else:;?>
	<h4><?php echo $msg;?></h4>
<?php endif;?>
<?php include 'inc/footer.php';?>
