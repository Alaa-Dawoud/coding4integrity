<?php include 'config/get_candidates.php';?>
<?php include 'inc/header.php';?>
<div class="container">
	<h3>Candidates</h3>
	<table>
		<?php for($i=0;$i<ceil($num_cans/3);$i++):?>
			<tr>
				<?php for($j=0;$j<3;$j++): ?>
					<td>
						<div class="container" style="width:18rem;">
							<div class="card mb-3">
							  <img src="./candidates_data/can1.png">
							  <div class="card-body">
							  	<h3 class="card-header"><?php print_r($user_candidates[$counter]['name']);?></h3>
							    <p class="card-text"><?php print_r(substr($user_candidates[$counter]['about'],0, 70));?></p>
							  </div>
							  <div class="card-body">
							    <a href="/wevote/can_profile.php?candidate=<?php echo $user_candidates[$counter]['id']?>" class="card-link">View Profile</a>
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
