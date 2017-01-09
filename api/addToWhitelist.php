<?php
 
// get the HTTP body of the request
$input = json_decode(file_get_contents('php://input'),true);

// connect to the mysql database
$link = mysqli_connect('localhost', 'root', '', 'lists');
mysqli_set_charset($link,'utf8');

// create & execute SQL
$sql = "SELECT id FROM `users` WHERE guid='" . $input['guid'] . "'";

$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
$row = mysqli_fetch_array($result);
$owner = $row['id'];
$sql = "SELECT id FROM `userurls` WHERE owner='" .  $owner . "' AND url = '" . $input['url'] . "'";
$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}

$num = $result->num_rows;
if ($num > 0) {
	$sql = "UPDATE `userurls` SET bw = 0 WHERE owner='" .  $owner . "' AND url = '" . $input['url'] . "'";
} else {
	$sql = "INSERT INTO `userurls` (owner, url, bw, public) VALUES (" . $owner . ", '" . $input['url'] . "', 0, 0)";
}
$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}

// print results, insert id or affected row count
echo mysqli_insert_id($link);

// close mysql connection
mysqli_close($link);
?>
