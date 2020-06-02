<?php
/* Error Codes
 * 0 - No error, login
 * 1 - Uncorrect username and/or password
 * 2 - Token empty or unset
 * 3 - mysql_connect() error
 * */
function error($errorcode) {
	$errortext;
	switch($errorcode) {
		case 1 :
			header("Location:/login?error=1");exit();
			break;
		case 2 :
			$errortext = "Token incorrect or expired.";
			break;
		case 3 :
			$errortext = "Database is not responding.";
			break;
		default:
			$errortext = "Undefined error.";
	}
}
if ($errortext) {
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Error - Social Network</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
				include ("../include/nav.php");
                ?>
                <div class="col-xs-9">
                    <div class="alert alert-danger" role="alert">
                        <b>Not good at all!</b>
						<?php echo $errortext;?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?}?>