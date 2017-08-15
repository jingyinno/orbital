<?php
$token = $_GET["token"];
$APIKey = "<APIKEY>";
$duration = 0;
$IncludeAllInfo = "false";
$modulesurl = "https://ivle.nus.edu.sg/api/Lapi.svc/Modules?APIKey=" . $APIKey . "&AuthToken=" . $token . "&Duration=" . $duration . "&IncludeAllInfo=" . $IncludeAllInfo;
// custom function
function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($ch, CURLOPT_URL, $url );
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
$response = file_get_contents_curl($modulesurl);
// object created from response string
$obj = json_decode($response);
// $modsArray is the array of all the module objects
$modsArray = $obj->Results;
// create a new array to store the courseIDs
$courseIDs = array();
$len = count($courseIDs);
// add the courseID of each mod to the array
foreach ($modsArray as $mod) {
	$ID = $mod->ID;
	$courseIDs[$ID] = $mod->CourseCode;
	$len += 1;
}
$announcmentsHTML = '';
foreach($courseIDs as $ID=>$CourseCode) {
	// print CourseCode
	$CourseCodeHTML = '<div class = "accordion"><h2>' . $CourseCode . '</h2><br>';
	$announcmentsHTML .= $CourseCodeHTML;
	$url = "https://ivle.nus.edu.sg/API/Lapi.svc/Announcements?APIKey=" . $APIKey . "&AuthToken=" . $token . "&CourseID=" . $ID . "&Duration=" . $duration . "&TitleOnly=false";
	$response = file_get_contents_curl($url);
	$obj = json_decode($response);
	$annArray = $obj->Results;
	$announcmentsHTML .= '<div class = "content">';
	foreach ($annArray as $annObj) {
		$title = $annObj->Title;
		$description = $annObj->Description;
		$code = '<h4>' . $title . '</h4><br>' . $description . '<br>';
		$announcmentsHTML .= $code;
	}
	$announcmentsHTML .= '<br></div></div><br>';
}
$script = '<script type="text/javascript">
	var accList = document.getElementsByClassName("accordion");
	for (var i = 0; i < accList.length; i++) {
		accList[i].onclick = function() {
			this.classList.toggle("active");
			var conList = this.getElementsByClassName("content");
			var con = conList[0];
			if (con.style.display == "block") {
				con.style.display = "none";
			} else {
				con.style.display = "block";
			}
		}
	}
</script>';
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
		.accordion {
			padding: 10px;
			background-color: whitesmoke;
		}
		.accordion.active, .accordion:hover {
			background-color: gainsboro;
		}
		.content {
			display: none;
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
<a href="main.php?token=' . $token . '"><span class = "glyphicon glyphicon-home" style="padding: 30px;"></span></a><br><br>
<a href="announcements.php?token=' . $token . '"><span class = "glyphicon glyphicon-list-alt" style="padding: 30px; background-color: #00a28a;"></span></a><br><br>
<a href="todolist.html"><span class = "glyphicon glyphicon-check" style="padding: 30px;"></span></a><br><br>
<a href="webcast.php?token=' . $token . '"><span class = "glyphicon glyphicon-film" style="padding: 30px;"></span></a><br>
</div>
<main>
<h1>ANNOUNCEMENTS</h1><br>
<p>' . $announcmentsHTML . '</p>'
. $script .
'</main>
</body>
</html>';
echo $html;
?>
