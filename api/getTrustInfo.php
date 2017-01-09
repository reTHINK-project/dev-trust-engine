<?php

// get the HTTP body of the request
$input = json_decode(file_get_contents('php://input'),true);

if (!array_key_exists('use_public', $input)) {
	$use_public = true;
} elseif ($input['use_public'] == 'false') {
	$use_public = false;
} else {
	$use_public = $input['use_public'];
}

// connect to the mysql database
$link = mysqli_connect('localhost', 'root', '', 'lists');
mysqli_set_charset($link,'utf8');

/* check if URL is blacklisted or whitelisted
   returns -1 : unknown GUID
            0 : unlisted URL
            1 : blacklisted URL
            2 : whitelisted URL
 */

// check GUID
$sql = "select id from `users` where guid='" . $input['guid'] . "'";
$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
$num = $result->num_rows;
if ($num == 0) {
	$value = -1;
	goto end;
}

if (!$use_public) {
	goto priv;
}
// check public record
$sql = "select id from `userurls` where url='" . $input['url'] . "' and public and bw";
$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
$num = $result->num_rows;
if ($num > 0) {
	$value = 1;
	goto end;
} else {
	$sql = "select id from `userurls` where url='" . $input['url'] . "' and public and NOT bw";
	$result = mysqli_query($link,$sql);
	if (!$result) {
		http_response_code(404);
		die(mysqli_error());
	}
	$num2 = $result->num_rows;
	if ($num2 > 0) {
		$value = 2;
		goto end;
	}
}

priv:
// check user record
$sql = "select id from `users` where guid='" . $input['guid'] . "'";
$result = mysqli_query($link,$sql);
if (!$result) {
  http_response_code(404);
  die(mysqli_error());
}
$row = mysqli_fetch_array($result);
$sql = "select id from `userurls` where owner=" . $row['id'] . " and url='" . $input['url'] . "' and bw";
$result = mysqli_query($link,$sql);
if (!$result) {
	http_response_code(404);
	die(mysqli_error());
}
$num2 = $result->num_rows;
if ($num2 > 0) {
	$value = 1;
} else {
	$sql = "select id from `userurls` where owner=" . $row['id'] . " and url='" . $input['url'] . "' and NOT bw";
	$result = mysqli_query($link,$sql);
	if (!$result) {
		http_response_code(404);
		die(mysqli_error());
	}
	$num3 = $result->num_rows;
	if ($num3 > 0) {
		$value = 2;
	} else {
		$value = 0;
	}
}

end:
echo $value;

// close mysql connection
mysqli_close($link);
?>
