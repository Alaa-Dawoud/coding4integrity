<?php
include 'inc/header.php';
include 'config/get_candidates.php';
include 'config/db.php';

function get_outcome($value1, $value2){
	//Create query
	include 'config/db.php';
	$query = "
	SELECT $value1, $value2 FROM users
	LEFT JOIN candidates ON users.id = candidates.can_fk
	UNION
	SELECT $value1, $value2 FROM users
	RIGHT JOIN candidates ON users.id = candidates.can_fk
	ORDER BY $value2 DESC
	";

	//$query = "SELECT * FROM users";
	//Get the result
	$result = mysqli_query($conn, $query);
	//fetch the data
	// it contains null
	$outcome_with_null = mysqli_fetch_all($result, MYSQLI_ASSOC);
	foreach ($outcome_with_null as $value) {
		if(isset($value[$value2])){
			$outcome[]=$value;
		}
	}
	mysqli_free_result($result);
	mysqli_close($conn);
	return array($outcome, $value2);
}
if(htmlentities(isset($_GET['submit']))){
	switch ($_GET['submit']) {
		case 'nappeals':
			list($outcome, $value2) = get_outcome('name', 'num_appeals');
			break;
		case 'rappeals':
			list($outcome, $value2) = get_outcome('name', 'nreply_appeals');
			break;
		case 'ncomments':
			list($outcome, $value2) = get_outcome('name', 'num_comments');
			break;
		case 'rcomments':
			list($outcome, $value2) = get_outcome('name', 'nreply_comments');
			break;
		default:
			# code...
			break;
	}
}

?>

<div class="container">
	<form method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>" style="padding-top: 40px;padding-bottom: 20px;">
		<button type="submit" name="submit" value="nappeals" class="btn btn-primary">Number of appeals</button>
		<button type="submit" name="submit" value="rappeals" class="btn btn-primary">Number replied appeals</button>
		<button type="submit" name="submit" value="ncomments" class="btn btn-primary">Number of comments</button>
		<button type="submit" name="submit" value="rcomments" class="btn btn-primary">Number replied comments</button>
	</form>
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="col">Candidate Name</th>
				<th scope="col" style="width:50%;"><?php echo $value2;?></th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<count($outcome);$i++):;?>
				<tr>
					<td><?php echo $outcome[$i]['name'];?></td>
					<td><?php echo $outcome[$i][$value2];?></td>
				</tr>
			<?php endfor;?>
		</tbody>
	</table>
</div>
<?php include 'inc/footer.php';?>