<table>
	<tr>
		<th>Name</th>
		<th>Type</th>
	</tr>
<?php
include "./php/utils/connHelper.php";
$error = array ();
if (empty ( $_GET ["kw"] )) {
	$error [] = "Please input a searching key word";
} else {
	$kw = $_GET ["kw"];
}
if (empty ( $_GET ["sc"] )) {
	$error [] = "Please select one searching condition";
} else {
	$sc = $_GET ["sc"];
}
if (empty ( $error )) {
	if ($_GET ["sc"] == "Search by User's Name") {
		$sql = "select * from user where user_name like %'$kw'%";
		$res = mysqli_query ( $dbc, $sql );
		if (! $res) {
			echo "Query Failed";
		} else {
			if (isset ( $res )) {
				$person_infos = array ();
				while ( $row = mysqli_fetch_assoc ( $res ) ) {
					$person_info ["uname"] = $row ["user_name"];
					$person_info ["uemail"] = $row ["user_email"];
					$person_info ["ucell"] = $row ["user_cellphone"];
					$person_info ["uaddr"] = $row ["user_address"];
					array_push ( $person_infos, $person_info );
				}
				foreach ( $person_infos as $ele ) {
					$uname = $ele["uname"]; $uemail = $ele["uemail"]; $ucell = $ele["ucell"]; $uaddr = $ele["uaddr"];
					echo "<tr><td>$uname</td><td>$uemail</td><td>$ucell</td>".
							"<td>$uaddr</td>"."<td><a href = \"#\"><input type = \"submit\" value = \"Add Friend\"></input></a></td></tr>";
				}
			}
		}
	}
	elseif ($_GET["sc"] == "Search by User's Email"){
		$sql = "select * from user where user_email like %'$kw'%";
		$res = mysqli_query ( $dbc, $sql );
		if (! $res) {
			echo "Query Failed";
		} else {
			if (isset ( $res )) {
				$person_infos = array ();
				while ( $row = mysqli_fetch_assoc ( $res ) ) {
					$person_info ["uname"] = $row ["user_name"];
					$person_info ["uemail"] = $row ["user_email"];
					$person_info ["ucell"] = $row ["user_cellphone"];
					$person_info ["uaddr"] = $row ["user_address"];
					array_push ( $person_infos, $person_info );
				}
				foreach ( $person_infos as $ele ) {
					$uname = $ele["uname"]; $uemail = $ele["uemail"]; $ucell = $ele["ucell"]; $uaddr = $ele["uaddr"];
					echo "<tr><td>$uname</td><td>$uemail</td><td>$ucell</td>".
							"<td>$uaddr</td>"."<td><a href = \"#\"><input type = \"submit\" value = \"Add Friend\"></input></a></td></tr>";
				}
			}
		}
	}
	elseif ($_GET["sc"] == "Search by User's Cellphone"){
		$sql = "select * from user where user_cellphone like %'$kw'%";
		$res = mysqli_query ( $dbc, $sql );
		if (! $res) {
			echo "Query Failed";
		} else {
			if (isset ( $res )) {
				$person_infos = array ();
				while ( $row = mysqli_fetch_assoc ( $res ) ) {
					$person_info ["uname"] = $row ["user_name"];
					$person_info ["uemail"] = $row ["user_email"];
					$person_info ["ucell"] = $row ["user_cellphone"];
					$person_info ["uaddr"] = $row ["user_address"];
					array_push ( $person_infos, $person_info );
				}
				foreach ( $person_infos as $ele ) {
					$uname = $ele["uname"]; $uemail = $ele["uemail"]; $ucell = $ele["ucell"]; $uaddr = $ele["uaddr"];
					echo "<tr><td>$uname</td><td>$uemail</td><td>$ucell</td>".
							"<td>$uaddr</td>"."<td><a href = \"#\"><input type = \"submit\" value = \"Add Friend\"></input></a></td></tr>";
				}
			}
		}
	}
	else{
		$sql = "select * from user where user_address like %'$kw'%";
		$res = mysqli_query ( $dbc, $sql );
		if (! $res) {
			echo "Query Failed";
		} else {
			if (isset ( $res )) {
				$person_infos = array ();
				while ( $row = mysqli_fetch_assoc ( $res ) ) {
					$person_info ["uname"] = $row ["user_name"];
					$person_info ["uemail"] = $row ["user_email"];
					$person_info ["ucell"] = $row ["user_cellphone"];
					$person_info ["uaddr"] = $row ["user_address"];
					array_push ( $person_infos, $person_info );
				}
				foreach ( $person_infos as $ele ) {
					$uname = $ele["uname"]; $uemail = $ele["uemail"]; $ucell = $ele["ucell"]; $uaddr = $ele["uaddr"];
					echo "<tr><td>$uname</td><td>$uemail</td><td>$ucell</td>".
							"<td>$uaddr</td>"."<td><a href = \"#\"><input type = \"submit\" value = \"Add Friend\"></input></a></td></tr>";
				}
			}
		}
	}
}
else{
	echo '<ol>';
	foreach ( $error as $key => $values ) {
			
		echo '	<li>' . $values . '</li>';
	}
	echo '</ol>';
}
mysqli_close($dbc);
?>
</table>