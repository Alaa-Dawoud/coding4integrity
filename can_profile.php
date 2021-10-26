<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>

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
					if($candidate['num_appeals']==0){
						$program_point = 'There is No Appeals For This Candidate right now';
						$program_point_text = '';
					}else{
						// view the appeals of the candidate
						$program_point = 'Candidate has '.$candidate['num_appeals'].' appeals';
						$program_point_text = '';
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
	<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:22%">
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
		<h3 class="pad_top"><?php echo $program_point;?></h3>
		<?php if ($program_point=='About'):;?>
			<!--Display the video-->
			<h4>Display Video about candidate in this area</h4>
		<?php endif;?>
		<p><?php echo $program_point_text;?></p>
		<hr>



	</div>
<?php else:;?>
	<h4><?php echo $msg;?></h4>
<?php endif;?>
<?php include 'inc/footer.php';?>
