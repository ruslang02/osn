<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/api/api.php");
$page = "messages";
$result = mysql_query("SELECT * FROM messages WHERE TOID = '" . getIDByUserName(validate()) . "'");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>My Messages - Social Network.</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
				include_once ($_SERVER['DOCUMENT_ROOT'] . "/src/include/nav.php");
                ?>

                <div class="col-xs-9">
                    <?php
					$users = array();
					while ($row = mysql_fetch_assoc($result)) {
						array_push($users, $row['USERID']);
						array_unique($users);
					}
					array_walk($users,function($item) {
							$result = API("user.getByID", $item);
							echo '
<a href="/message?user=' . $result['ID'] . '" class="media">
<div class="media-left">
<img src="'.$result['Avatar'].'" style="width: 64px; height: 64px;" class="media-object">
</div>
<div class="media-body">
<h4 class="media-heading">'.$result['Name'].' '.$result['Surname'].'</h4>
</div> </a>
';
					});
                    ?>
                </div>
            </div>
        </div>
        <script></script>
    </body>
</html>