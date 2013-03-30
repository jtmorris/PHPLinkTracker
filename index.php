<?php

//	Disable errors
error_reporting(0);


@include_once ("config.php");

loglink();




$gt = isset($_GET['goto']) ? $_GET['goto'] : "";
if ($gt !== "") {
	header("Location: " . $gt);
} else {
	include_once ("header.php");

	?>
	<h1>Link Passthrough Script</h1>
	<p>
		Welcome. This page does nothing fancy until you start adding some URL parameters.
		Visit <a href='http://php-plt.jtmorris.net'>http://php-plt.jtmorris.net'</a> for 
		usage instructions.
	</p>
	<?php

	include_once("footer.php");
}


function loglink() {
	/*****
		Purpose:
			To record the link info in the database if they are not already there.
		Parameters:
			none
		Returns:
			void
		Sample Usage:
			loglink();
	*****/
	$ua = $_SERVER['HTTP_USER_AGENT'];
	$rf = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
	$gt = isset($_GET['goto']) ? $_GET['goto'] : "";
	$cx = isset($_GET['context']) ? $_GET['context'] : "";

	if ($gt !== "") {
		$vid = logvisitor();

		$query = "INSERT INTO plt_linkinfo (visitor, time, useragent, referer, goto, context) VALUES (" . $vid . ", NOW(), '$ua', '$rf', '$gt', '$cx')";

		$db = new Db();
		$db->runquery($query);
	}
}

function logvisitor() {
	/*****
		Purpose:
			To record this visitor in the database if they are not already there.
		Parameters:
			none
		Returns:
			void
		Sample Usage:
			logvisitor();
	*****/
	$ip = $_SERVER['REMOTE_ADDR'];

	$query = "INSERT INTO plt_visitorinfo (ip, visits) VALUES ('" . $ip . "', 1) ON DUPLICATE KEY UPDATE visits = (visits+1)";

	$db = new Db();
	$db->runquery($query);

	return mysqli_insert_id($db->conn);
}

function redirect($url) {
	/*****
		Purpose:
			To redirect the user's browser to the specified location.
		Parameters:
			url: String URI value to redirect browser to.
		Returns:
			void
		Sample Usage:
			redirect("http://github.com");

		Warnings:
			Cannot call this after headers have been sent to the user.
			See http://php.net/manual/en/function.header.php for more info.
	*****/
	header("Location: " . url);
}

