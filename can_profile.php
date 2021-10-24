<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>

<?php
	//this is for first time
	$id = htmlentities(isset($_GET['candidate']));

	if(htmlentities(isset($_GET['updated_id']))){
		$id = $_GET['updated_id'];
	}

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
				case 'edit':
					// got to edit form (for candidate users only)
					break;
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
					if($candidate['num_appeals']==0){
						$program_point = 'There is No Appeals For This Candidate right now';
						$program_point_text = '';
					}else{
						// view the appeals of the candidate
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
<?php if($id_exist):;?>
	<div class="container">
		<img src="./candidates_data/can1.png" style="width:18rem;">
		<h2><?php echo $candidate['name'];?></h2>
			<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
				<div class="btn-group-vertical">
				<!--This button for candidate useers only-->
					<button type="submit" name="submit" value="edit" class="btn btn-primary">Edit Profile</button>
					<button type="submit" name="submit" value="about" class="btn btn-info">About</button>
					<button type="submit" name="submit" value="education" class="btn btn-info">Education</button>
					<button type="submit" name="submit" value="health" class="btn btn-info">Health</button>
					<button type="submit" name="submit" value="industry" class="btn btn-info">Industry</button>
					<button type="submit" name="submit" value="commerce" class="btn btn-info">Commerce</button>
					<button type="submit" name="submit" value="appeals" class="btn btn-danger">Appeals</button>
					<input type="hidden" name="updated_id" value="<?php echo $id;?>">
				</div>
			</form>
			<h3><?php echo $program_point;?></h3>
			<?php if ($program_point=='About'):;?>
				<!--Display the video-->
				<h4>Display Video about candidate in this area</h4>
			<?php endif;?>
			<p><?php echo $program_point_text;?></p>
	</div>
<?php else:;?>
	<h4><?php echo $msg;?></h4>
<?php endif;?>
<?php include 'inc/footer.php';?>
