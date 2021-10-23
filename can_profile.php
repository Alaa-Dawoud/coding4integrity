<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>

<?php
	$id = htmlentities($_GET['candidate']);
	$candidate = $user_candidates['id'==$id];
	$program_point = 'About';
	$program_point_text = $candidate['about'];
	if(isset($_POST['submit'])){
		$submit_value = $_POST['submit'];
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
?>
<div class="container">
	<img src="./candidates_data/can1.png" style="width:18rem;">
	<h2><?php echo $candidate['name'];?></h2>
		<form method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?candidate='.$id;?>">
			<div class="btn-group-vertical">
			<!--This button for candidate useers only-->
				<button type="submit" name="submit" value="edit" class="btn btn-primary">Edit Profile</button>
				<button type="submit" name="submit" value="about" class="btn btn-info">About</button>
				<button type="submit" name="submit" value="education" class="btn btn-info">Education</button>
				<button type="submit" name="submit" value="health" class="btn btn-info">Health</button>
				<button type="submit" name="submit" value="industry" class="btn btn-info">Industry</button>
				<button type="submit" name="submit" value="commerce" class="btn btn-info">Commerce</button>
				<button type="submit" name="submit" value="appeals" class="btn btn-danger">Appeals</button>
			</div>
		</form>
		<h3><?php echo $program_point;?></h3>
		<?php if ($program_point=='About'):;?>
			<!--Display the video-->
			<h4>Display Video about candidate in this area</h4>
		<?php endif;?>
		<p><?php echo $program_point_text;?></p>
</div>
<?php include 'inc/footer.php';?>
