<?php
$token = $_GET["token"];
$APIKey = "<APIKEY>";
// url to validate
$url = 'https://ivle.nus.edu.sg/api/Lapi.svc/Validate?APIKey=' . $APIKey . '&Token=' . $token;
// custom function
function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($ch, CURLOPT_URL, $url );
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
// response returned from the url
$response = file_get_contents_curl($url);
// create an object from the response string
$obj = json_decode($response);
$SuccessResult = $obj->Success;
// if login is successful, show main page
if ($SuccessResult) {
	$html = '<!DOCTYPE html>
<html>
<head>
	<title>Forget Me Not</title>
	<link rel ="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
		body {
			background-color: #1c2e38;
		}
		.sidebar {
			padding: 0px;
			float: left;
			color: white;
		}
		.sidebar .glyphicon:hover {
			background-color: black;
		}
		.sidebar a {
			color: white;
		}
		main {
			background-color: white;
			margin-left: 80px;
			position: absolute;
			padding-left: 20px;
			height: 100%;
			width: 100%;
		}
	</style>
</head>
<body>
<div class = "page-header" style="padding-left: 50px;">
<h1><span style = "color: darkcyan;">Forget Me </span><span style="color: white;">Not</span></h1>
</div>
<div class = "sidebar">
<a href="main.php?token=' . $token . '"><span class = "glyphicon glyphicon-home" style="padding: 30px; background-color: #00a28a;"></span></a><br><br>
<a href="announcements.php?token=' . $token . '"><span class = "glyphicon glyphicon-list-alt" style="padding: 30px;"></span></a><br><br>
<a href="todolist.html"><span class = "glyphicon glyphicon-check" style="padding: 30px;"></span></a><br><br>
<a href="webcast.php?token=' . $token . '"><span class = "glyphicon glyphicon-film" style="padding: 30px;"></span></a><br>
<!--
<a href="http://mint-leaf.com/sarah/modules.php?token=' . $token . '">Modules</a>
<br>
<a href="http://mint-leaf.com/sarah/webcast.php?token=' . $token . '">Webcast</a>
<br>
<a href="http://mint-leaf.com/sarah/announcements.php?token=' . $token . '">Announcements</a>
<br>
-->
</div>
<main>
<h1>MAIN</h1><br>
<p>Click on the buttons on the left to access your todo list, announcements and web lectures.</p>
</main>
</body>
</html>';
	echo $html;
} else {
	print "Login failed";
}
?>
