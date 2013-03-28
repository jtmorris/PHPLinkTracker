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
	<tr>
		<th>Context Data</th>
		<th># Views</th>
		<th>Last View Date</th>
	</tr>
	<?php
	$arr = getLinkData();

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
		?>
		<tr>
			<td><?php echo $x['context']; ?></td>
			<td><?php echo $x['count']; ?></td>
			<td><?php echo $x['lastdate']; ?></td>
		</tr>
		<?php
	}
	?>
</table>

<?php
include_once("footer.php");

function getUserData($id = false) {
	/*****
		Purpose:
			To execute a SELECT query on the visitor data table and return 
			the results as an array.
		Parameters:
			none
		Returns:
			Numeric array of associative arrays with key = column name 
			and value = to column value.
		Sample Usage:
			getLinkData()
	*****/
	if (!$id) {
		$query = "SELECT * FROM plt_visitorinfo";
	}
	else {
		$query = "SELECT * FROM plt_visitorinfo WHERE id=$id";
	}

	$db = new Db();
	$res = $db->runquery($query);

	$arr = resultToArray($res);

	if (count($arr) == 1) {
		return $arr[0];
	}

	return $arr;
}

function getLinkData() {
	/*****
		Purpose:
			To execute a SELECT all query on the link data table and return 
			the results as an array.
		Parameters:
			none
		Returns:
			Numeric array of associative arrays with key = column name 
			and value = to column value.
		Sample Usage:
			getLinkData()
	*****/
	$query = "SELECT * FROM plt_linkinfo ORDER BY context ASC, time DESC";

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