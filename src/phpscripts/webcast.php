<?php
$token = $_GET["token"];
$APIKey = "<APIKEY>";
$duration = 0;
$IncludeAllInfo = "false";
$modsurl = "https://ivle.nus.edu.sg/api/Lapi.svc/Modules?APIKey=" . $APIKey . "&AuthToken=" . $token . "&Duration=" . $duration . "&IncludeAllInfo=" . $IncludeAllInfo;
// custom function
function file_get_contents_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
  curl_setopt($ch, CURLOPT_URL, $url );
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
$modsResponse = file_get_contents_curl($modsurl);
// object created from response string
$modsObj = json_decode($modsResponse);
// $modsArray is the array of all the module objects
$modsArray = $modsObj->Results;
// create a new array to store the courseIDs
$courseIDs = array();
$len = 0;
// add the courseID of each mod to the array
foreach ($modsArray as $mod) {
	$ID = $mod->ID;
	$courseIDs[$ID] = $mod->CourseCode;
	$len += 1;
}
$webcastHTML = '';
foreach ($courseIDs as $CourseID => $CourseCode) {
	$CourseCodeHTML = '<div class = "accordion"><h2>' . $CourseCode . '</h2><br>';
	$webcastHTML .= $CourseCodeHTML;
	$url = "https://ivle.nus.edu.sg/api/Lapi.svc/Webcasts?APIKey=" . $APIKey . "&AuthToken=" . $token . "&CourseID=" . $CourseID . "&Duration=" . $duration . "&MediaChannelID=&TitleOnly=false";
	$response = file_get_contents_curl($url);
	$obj = json_decode($response);
	$innerArr = $obj->Results;
	$innerObj = $innerArr[0];
	$itemGroups = $innerObj->ItemGroups;
	$firstItem = $itemGroups[0];
	$files = $firstItem->Files;
	$webcastHTML .= '<div class = "content">';
	if (!is_null($files)) {
		$webcasturlArray = array();
		$count = 0;
		// add the webcast MP4 links to the array
		foreach ($files as $webcastObj) {
			$title = $webcastObj->FileTitle;
			$webcasturlArray[$title] = $webcastObj->MP4;
			$count += 1;
		}
		// write the HTML code to show the webcasts links
		foreach ($webcasturlArray as $title => $webcastLink) {
			$code = '<a href="' . $webcastLink . '">' . $title . '</a><br>';
			$webcastHTML .= $code;
		}
	}
	$webcastHTML .= '<br></div></div>';
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
			margin: 10px;
			float: left;
			width: 25%;
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
<a href="announcements.php?token=' . $token . '"><span class = "glyphicon glyphicon-list-alt" style="padding: 30px;"></span></a><br><br>
<a href="todolist.html"><span class = "glyphicon glyphicon-check" style="padding: 30px;"></span></a><br><br>
<a href="webcast.php?token=' . $token . '"><span class = "glyphicon glyphicon-film" style="padding: 30px; background-color: #00a28a;"></span></a><br>
</div>
<main>
<h1>WEBCASTS</h1><br>
<p>' . $webcastHTML . '</p>'
. $script .
'</main>
</body>
</html>';
echo $html;
?>
