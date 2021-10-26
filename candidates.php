<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>

<?php
	$candidates_fk = array_column($user_candidates, 'can_fk');
	$num_cans = count($candidates_fk);
	$counter=0;
?>


<div class="container">
	<?php if(isset($_SESSION['user_type'])):;?>
		<?php if(isset($_SESSION['candidate'])):;?>
			<h2 class="pad_top">Welcome candidate <?php echo $_SESSION['candidate']['name'];?></h2>
		<?php else:;?>
			<h2 class="pad_top">Welcome voter <?php echo $_SESSION['voter']['name'];?></h2>
		<?php endif;?>
	<?php else:;?>
		<h2 class="pad_top">Welcome Guest</h2>
	<?php endif;?>
	<hr>
	<h3>Candidates List</h3>
	<table>
		<?php for($i=0;$i<ceil($num_cans/3);$i++):?>
			<tr>
				<?php if($counter==$num_cans)break;?>
				<?php for($j=0;$j<3;$j++): ?>
					<!--Get next candidate-->
					<?php $can_fk = $candidates_fk[$counter];
							$id= array_search($can_fk, array_column($user_candidates, 'can_fk'))
					?>
					<td>
						<div class="container" style="width:18rem;">
							<div class="card mb-3">
							  <img src="./candidates_data/can1.png">
							  <div class="card-body">
							  	<h3 class="card-header"><?php print_r($user_candidates[$id]['name']);?></h3>
							    <p class="card-text"><?php print_r(substr($user_candidates[$id]['about'],0, 70));?></p>
							  </div>
							  <div class="card-body">
							    <a href="/wevote/can_profile.php?updated_id=<?php echo $user_candidates[$id]['id']?>" class="card-link">View Profile</a>
							  </div>
							</div>
						</div>
						<?php
							$counter+=1;
							if($counter==$num_cans)
								break;
						?>
					</td>
					
				<?php endfor; ?>

			</tr>
		<?php endfor;?>
	</table>
</div>

<?php include 'inc/footer.php';?>
