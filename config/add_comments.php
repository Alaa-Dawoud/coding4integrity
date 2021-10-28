<?php require 'db.php';
	$query = "
	SELECT * 
	FROM comments_replys
	WHERE is_reply=0
	";
	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result
	mysqli_free_result($result);

	if($comment_type=='comment'){
		$is_reply=0;
		$num = count($comments)+1;
	}else{
		$is_reply=1;
		$num = $reply_comment_id;
	}
	
	//check if comment owner is candidate or voter
	$owner = (isset($_SESSION['candidate']))?'candidate':'voter';

	$query = "
	INSERT INTO `comments_replys` (id, `comment_id`, body, `to_candidate`, `program_point`, `is_reply`, `created_at`) 
	VALUES('".$_SESSION[$owner]['id']."', '".$num."', '".$comment."', '".$_GET['updated_id']."', '".strtolower($program_point)."', '".$is_reply."', '".time()."')
	";

	mysqli_query($conn, $query);
	//close connnection
	mysqli_close($conn);
?>
