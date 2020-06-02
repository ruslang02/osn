<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/api/api.php");
$page = "messages";
$result = mysql_query("
SELECT * FROM messages 
WHERE (TOID = '" . getIDByUserName(validate()) . "' OR USERID = '" . getIDByUserName(validate()) . "') 
AND (TOID='" . $_GET['user'] . "' OR USERID='" . $_GET['user'] . "') ORDER BY ID DESC;");
$myprofile = API("user.getByUserName",validate());
$dialogprofile = API("user.getByID",$_GET['user']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Dialogue: <?php echo $myprofile['Name']; ?> и <?php echo $dialogprofile['Name'];?> - Social Network</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
				include_once ($_SERVER['DOCUMENT_ROOT'] . "/src/include/nav.php");
                ?>

                <div class="col-xs-9">
                    <ol class="breadcrumb">
                        <li>
                            <a href="/user/?id=-1">Account</a>
                        </li>
                        <li>
                            <a href="/messages">Messages</a>
                        </li>
                        <li class="active">
                            Dialogue: <?php echo $myprofile['Name']; ?> и <?php echo $dialogprofile['Name'];?>
                        </li>
                    </ol>
                    <div class="well">
                        <form id="addmessage" class="input-group">
                            <input class="form-control" type="text">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" aria-label="Help">
                                    <span class="glyphicon glyphicon-camera"></span>
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </form>
                        <br>
                        <div id="messages">
                        <?php
						while ($row = mysql_fetch_assoc($result)) {
							if($row['USERID'] == getIDByUserName(validate())) {
								echo '<div class="media"><div class="media-left"><a href="/user/?id=-1"><img style="width:64px;height:64px;" class="media-object" src="' . $myprofile['Avatar'] . '"></a></div><div class="media-body"><h4 class="media-heading">' . $myprofile['Name'] . " " . $myprofile['Surname'] . '</h4>' . $row['MESSAGE'] . '</div></div>';
							} else {
								echo '<div class="media"><div class="media-left"><a href="/user/?id=' . $dialogprofile['ID'] . '"><img style="width:64px;height:64px;" class="media-object" src="' . $dialogprofile['Avatar'] . '"></a></div><div class="media-body"><h4 class="media-heading">' . $dialogprofile['Name'] . " " . $dialogprofile['Surname'] . '</h4>' . $row['MESSAGE'] . '</div></div>';
							}
						}
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
        	$("#addmessage").submit(function(e) {
        		e.preventDefault();
        		$.post("/src/api/api.php",{action:"message.add",TOID: "<?php echo $dialogprofile['ID'];?>",MESSAGE: $("#addmessage input").val()},function() {
        			reloadMsgs();
        		});        		
        	});
        	
        	function reloadMsgs() {
        		$.post("/src/api/api.php",{action:"message.get",user: "<?php echo $dialogprofile['ID'];?>"},function(a,b,c) {
        			var messages = $.parseJSON(c.responseText);
        			$("#messages").empty();
        			messages.forEach(function(item) {
        				$.post("/src/api/api.php",{action: "user.get",ID:item.from},function(a,b,c) {
        					var userInfo = $.parseJSON(a);
        					$("#messages").append('<div class="media"><div class="media-left"><a href="/user/?id=' + item.from + '"><img style="width:64px;height:64px;" class="media-object" src="' + userInfo.avatar + '"></a></div><div class="media-body"><h4 class="media-heading">' + userInfo.name + ' ' + userInfo.surname + '</h4>' + item.message + '</div></div>');
        				});
        			});
        		});
        	}
        	
        </script>
    </body>
</html>