<?php

error_reporting(E_ERROR | E_PARSE);


session_start();
require_once ("variables.php");
require_once ("error.php");
require_once ("validate.php");
mysql_connect($mysqlserver, $mysqluser, $mysqlpassword) or error(3);
mysql_select_db($mysqldatabase);
mysql_query("SET NAMES utf8");
$action = $_POST['action'];
$USERINFO;
if ($_POST['action'] == "test") {
	$result = mysql_query($_POST['sql']);
	while ($row = mysql_fetch_assoc($result)) {
		print_r($row);
	}
}
if ($_GET['action'] == "test") {
	$result = mysql_query($_GET['sql']);
	while ($row = mysql_fetch_assoc($result)) {
		print_r($row);
	}
}
if ($action == "login") {
	$result = mysql_query("SELECT ID, UserName, Password FROM users WHERE UserName='" . $_POST['user'] . "' AND Password='" . $_POST['pass'] . "';");
	if (mysql_num_rows($result) == 1) {
		$_SESSION['token'] = md5(uniqid(NickName . Password, true));
		mysql_query("INSERT INTO tokens VALUES ('','" . $_SESSION['token'] . "','" . $_POST['user'] . "')");
		$id = mysql_fetch_assoc($result);
		header("Location: /user/?id=" . $id["ID"]);
		exit();
	} else {
		error(1);
	}
} else {
	if (validate() !== "") {
		$USERINFO['username'] = validate();
		$USERINFO['id'] = getIDByUserName(validate());
		if ($action === "status.change") {
			$result = mysql_query("UPDATE users SET Status = '" . $_POST['status'] . "' WHERE ID = " . $USERINFO['id']);
		}
		if ($action === "user.get") {
			$query = "SELECT * FROM users";
			$result = mysql_query($query);
			while ($row = mysql_fetch_assoc($result)) {
				if (isset($_POST['ID'])) {
					if ($row['ID'] == $_POST['ID']) {
						echo <<< EOD
{
	"username":"{$row['UserName']}",
	"name":"{$row['Name']}",
	"surname":"{$row['Surname']}",
	"avatar":"{$row['Avatar']}"
}
EOD;
					}
				}

			}
		}

		if ($action === "message.get") {
			$result = mysql_query("
SELECT * FROM messages 
WHERE (TOID = '" . getIDByUserName(validate()) . "' OR USERID = '" . getIDByUserName(validate()) . "') 
AND (TOID='" . $_POST['user'] . "' OR USERID='" . $_POST['user'] . "') ORDER BY ID DESC LIMIT 0,5;");
			echo "[";
			$numrows = mysql_numrows($result);
			$nowrow = 0;
			while ($row = mysql_fetch_assoc($result)) {
				$nowrow = $nowrow + 1;
				echo <<< EOD
{
	"from":"{$row['USERID']}",
	"to":"{$row['TOID']}",
	"message":"{$row['MESSAGE']}"
}
EOD;
				if ($numrows != $nowrow) echo ",";
			}

			echo "]";
		}
		if ($action === "message.add") {
			$query = "INSERT INTO messages VALUES('','" . getIDByUserName(validate()) . "','" . $_POST['TOID'] . "','" . $_POST['MESSAGE'] . "')";
			echo "INSERT INTO messages VALUES('','" . getIDByUserName(validate()) . "','" . $_POST['TOID'] . "','" . $_POST['MESSAGE'] . "')";
			$result = mysql_query($query);
		}
	}
}

function getIDByUserName($user) {
	$result = mysql_query("SELECT ID,UserName FROM users WHERE UserName = '" . $user . "';");
	while ($row = mysql_fetch_assoc($result)) {
		return $row['ID'];
	}
	return "";
}

function API($action) {
	$args = func_get_args();

	if ($action == "user.getByID") {
		$query = "SELECT * FROM users";
		$result = mysql_query($query);
		$arg = $args[1];
		while ($row = mysql_fetch_assoc($result)) {
			if (isset($args[1])) {
				if ($row['ID'] == $arg) {
					return $row;
				}
			}
		}
	}
	if ($action == "user.getByUserName") {
		$query = "SELECT * FROM users";
		$result = mysql_query($query);
		$arg = $args[1];
		while ($row = mysql_fetch_assoc($result)) {
			if (isset($args[1])) {
				if ($row['UserName'] == $arg) {
					return $row;
				}
			}
		}
	}
}
?>

