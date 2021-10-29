<?php require 'db.php';
	$query = "
	SELECT * 
	FROM appeals
	";
	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	$appeals = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result
	mysqli_free_result($result);
	if($appeals){
		$num_appeals = count($appeals);
	}else{
		$num_appeals = 0;
	}

	// get data about specific candidate
	$query = "
	SELECT * 
	FROM appeals
	WHERE to_candidate= '".$_GET['updated_id']."'
	";
	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	$candidate_appeals = mysqli_fetch_all($result, MYSQLI_ASSOC);
	//free result
	mysqli_free_result($result);


	$appeals_data = array("mp3"=>array(),
						"mp4"=>array());
	// directory to scan
	$directory = new DirectoryIterator('candidates_appeals/');
	// iterate

	foreach ($directory as $fileinfo) {
	    // file extension
	    $extension = strtolower(pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION));
	    $file_name = pathinfo($fileinfo->getFilename(), PATHINFO_FILENAME);
	    $base_name = pathinfo($fileinfo->getFilename(), PATHINFO_BASENAME);
	    // check if extension match and check if hidden files not exist
	    // check if file_name(appeal id) is the same with candidate
	    $base_candidate = in_array($file_name, array_column($candidate_appeals, 'appeal_id'));
	    if ($extension=='mp3' and $base_candidate and $base_name!='.') {
	        // add to result
	        $appeals_data["mp3"][]=$base_name;
		}elseif($extension=='mp4' and $base_candidate and $base_name!='' and $base_name!='.'){
			$appeals_data["mp4"][]=$base_name;
		}
	}
	mysqli_close($conn);
?>