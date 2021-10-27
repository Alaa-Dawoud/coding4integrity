<?php require 'db.php';
	//Create query

	$query = "
	SELECT * 
	FROM comments_replys
	WHERE to_candidate='".$_GET['updated_id']."' and program_point='".strtolower($program_point)."' and is_reply=0
	ORDER BY created_at DESC
	";

	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);


	//free result
	mysqli_free_result($result);
	//close connnection
	mysqli_close($conn);
?>