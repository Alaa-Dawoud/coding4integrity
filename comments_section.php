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
