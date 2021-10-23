<?php require 'db.php';

	//Create query
	$query = "
	SELECT * FROM users
	LEFT JOIN candidates ON users.id = candidates.can_fk
	UNION
	SELECT * FROM users
	RIGHT JOIN candidates ON users.id = candidates.can_fk

	";

	//$query = "SELECT * FROM users";
	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	// it contains null
	$user_candidates_with_null = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//make a variable without null in can_fk
	foreach ($user_candidates_with_null as $value) {
		if($value['can_fk']){
			$user_candidates[]=$value;
		}
	}
	// var_dump($user_candidates);
	//free result
	mysqli_free_result($result);
	//close connnection
	mysqli_close($conn);
	$num_cans = count($user_candidates);
	$counter = 0;
?>