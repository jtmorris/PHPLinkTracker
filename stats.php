<?php
include_once ("config.php");
include_once ("header.php");
?>

<header>
	<hgroup>
		<h1>Passthrough Link Statistics</h1>
	</hgroup>
</header>
<table>
	<tr><th colspan='3'>Statistics By Context</th></tr>
	<tr>
		<th>Context Data</th>
		<th># Views</th>
		<th>Last View Date</th>
	</tr>
	<?php
	$arr = getLinkData("context");

	$vals = array();
	$count = 1;
	$lastIndex = -1;
	foreach($arr as $x) {
		$lastIndex = count($vals) - 1;		

		if (($lastIndex < 0) || ($x['context'] !== $vals[$lastIndex]['context'])) {
			if ($lastIndex >= 0) {
				$vals[$lastIndex]['count'] = $count;
			}

			$t = new DateTime($x['time']);

			$vals[$lastIndex + 1]['context'] = $x['context'];
			$vals[$lastIndex + 1]['lastdate'] = $t->format('F j, Y @ g:i A');
			$count = 1;
		}
		else {
			$count++;
		}
	}
	$vals[count($vals) - 1]['count'] = $count;
	foreach($vals as $x) {
		if (!isset($x['context']) || !isset($x['lastdate'])) {
			?>
				<tr>
					<td colspan='3'>Nothing to show yet!</td>
				</tr>
			<?php
		}
		else {
			?>
			<tr>
				<td><?php echo $x['context']; ?></td>
				<td><?php echo $x['count']; ?></td>
				<td><?php echo $x['lastdate']; ?></td>
			</tr>
			<?php
		}
	}
	?>
</table>

<table>
	<tr><th colspan='4'>Last Views (max of 500)</th></tr>
	<tr>
		<th>Date</th>
		<th>Directing To</th>
		<th>Context</th>
		<th>User Agent</th>
	</tr>
	
	<?php
	$arr = getLinkData('date', 500);
	foreach ($arr as $x) {
		$t = new DateTime($x['time']);
		?>
			<tr>
				<td><?php echo $t->format('F j, Y @ g:i A'); ?></td>
				<td><?php echo $x['goto']; ?></td>
				<td><?php echo $x['context']; ?></td>
				<td><?php echo $x['useragent']; ?></td>
			</tr>
		<?php
	}
	if (count($arr) < 1) {
		?>
		<tr>
			<td colspan='4'>Nothing to show yet!</td>
		</tr>
		<?php
	}
	?>
</table>

<?php
include_once("footer.php");

function getLinkData($sortby = 'date', $limitnum = 0) {
	/*****
		Purpose:
			To execute a SELECT query on the link data table and return 
			the results as an array.
		Parameters:
			none
		Returns:
			Numeric array of associative arrays with key = column name 
			and value = to column value.
		Sample Usage:
			getLinkData()
	*****/

	if ($sortby === "context") {
		$orderby = "ORDER BY context ASC, time DESC";		
	}
	else {
		$orderby = "ORDER BY time DESC";
	}

	if ($limitnum > 0) {
		$limit = "LIMIT " . $limitnum;
	}
	else {
		$limit="";
	}


	$query = "SELECT * FROM plt_linkinfo " . $orderby . " " . $limit;

	$db = new Db();
	$res = $db->runquery($query);

	return resultToArray($res);
}	//	end getData()

function resultToArray($result) {
    /*****
		Purpose:
			To take a MySQL SELECT result and retrieve the contents as an array of row
			data as an associative arrays.
		Parameters:
			A mysqli query result.
		Returns:
			Array of associative arrays with key = column name and value = to column value
		Sample Usage:
			resultToArray($mysqliselectqueryresult)
	*****/

    $rows = array();
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}	//	end resultToArray()