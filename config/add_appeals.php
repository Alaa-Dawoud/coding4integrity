<?php
require 'get_appeals.php';
require 'config/db.php';
//move uploded file to directory
$target_dir = "candidates_appeals/";
$extin = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
$body = $_POST['submit_appeal_body'];
$target_file = $target_dir . ($num_appeals+1) .'.'.$extin;
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
//check if comment owner is candidate or voter
$owner = (isset($_SESSION['candidate']))?'candidate':'voter';

//save uploaded file to database
$query = "
INSERT INTO appeals(id, appeal_id, to_candidate, body, created_at) 
VALUES('".$_SESSION[$owner]['id']."', '".($num_appeals+1)."', '".$_GET['updated_id']."', '".$body."', '".time()."')
";
mysqli_query($conn, $query);
//increase the number of num_appeals of the candidate by one because he got an appeal
//get the num_appeals of candidate
$query = "
SELECT num_appeals 
FROM candidates
WHERE can_fk='".$_GET['updated_id']."'
";
//Get the result
$result = mysqli_query($conn, $query);
//fetch the data
$can_num_appeals = mysqli_fetch_assoc($result);

$query = "
UPDATE candidates SET num_appeals='".($can_num_appeals['num_appeals']+1)."'
WHERE can_fk='".$_GET['updated_id']."'
";
mysqli_query($conn, $query);
//free result
mysqli_free_result($result);
//close connnection
mysqli_close($conn);
?>