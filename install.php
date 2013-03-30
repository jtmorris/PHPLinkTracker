<?php
include_once ("config.php");
include_once ("header.php");
?>

<ol>
	<li>
		<?php
		$sstring = "<span style='color: rgb(0,104,0) '>&#10003;</span> ";	//	green check mark
		$fstring = "<span style='color: rgb(104,0,0) '>&#10007;</span> ";	//	red X mark
		$pstring = "<span style='color: #888; '>&#10037;</span> ";	//	grey star

		//	Check DB connection
		if (checkDbConn()) {
			$cont = true;
			echo $sstring;
		}
		else {
			$cont = false;
			echo $fstring;
		}
		?>
		Check Database Connection		
	</li>
	<li>
		<?php
		//	If previous step was successful, try this one
		if ($cont) {
			//	Create database tables
			$cont = false;
			if ($msg = createDbTables() === true) {
				$cont = true;
				echo $sstring;
			}
			else {
				$cont = false;
				echo $fstring;
			}
			
		}
		//	Output the pending string
		else {
			echo $pstring;
		}
		?>

		Create Necessary Database Tables

		<?php
		//	If something went wrong, output the message
		if ($msg !== true) {
			echo "<br /><i>" . $msg . "</i>";
		}
		?>
	</li>
	<li>
		<?php
		if ($cont) {
			echo "<b>Installation Complete!</b>";
		}
		else {
			echo "<b>Installation Failed!</b>";
		}
		?>
	</li>
</ol>

<?php
include_once("footer.php");

function checkDbConn() {
	/*****
		Purpose:
			To see if we can connect to the database by running a quick query on it.
		Parameters:
			none
		Returns:
			Boolean true on success.  Boolean false on failure.
		Sample Usage:
			createDbConn()
	*****/

	$db = new Db();

	//	Run some dumb query on the database that will require a valid connection, but won't
	//	take any excess time to execute.
	if (!$db->runquery("SELECT VERSION()")) {
		return false;
	}

	return true;
}

function createDbTables() {
	/*****
		Purpose:
			To execute the database query required to create the required database tables for this script.
		Parameters:
			none
		Returns:
			Boolean true on success.  String containing error message if failure.
		Sample Usage:
			createDbTables()
	*****/

	$dbprefix = 'plt_';
	$queries = array();

	//	Create link info table
	$queries[] = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "linkinfo` (
		`id` int(11) NOT NULL AUTO_INCREMENT, 
		`visitor` int(11) NOT NULL, 
		`time` datetime NOT NULL,
		`useragent` varchar(1000) NOT NULL,
		`referer` varchar(1000) NOT NULL,
		`goto` varchar(1000) DEFAULT NULL,
		PRIMARY KEY (`id`)
	)";
	
	//	Create visitor info table
	$queries[] = "CREATE TABLE IF NOT EXISTS `" . $dbprefix . "visitorinfo` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`ip` varchar(45) NOT NULL,
		`visits` int(11) NOT NULL,
		PRIMARY KEY (`id`),
		UNIQUE KEY `ip` (`ip`)
	)";


	//	Loop through all queries and run them. If any fail, return false
	$db = new Db();
	foreach ($queries as $x) {
		if (!$db->runquery($x)) {
			return $db->error;
		}		
	}
	
	return true;
}