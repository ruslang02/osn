<?php
session_start();
mysql_connect();
mysql_select_db();
mysql_query("SET NAMES utf8");
function validate() {// Token exists?
	$result = mysql_query("SELECT * FROM tokens WHERE TOKEN = '" . $_SESSION['token'] . "'");
	while ($row = mysql_fetch_assoc($result)) {
		return $row['USERNAME'];
		// Return the username if it is.
	}
	return "";
	// Else, return an empty string.
}
?>
