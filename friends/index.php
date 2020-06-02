<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/api/api.php");
$page = "friends";
$USERINFO;
$result = mysql_query("SELECT Friends FROM users WHERE ID='" . getIDByUserName(validate()) . "'");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Social Network</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
				include_once ($_SERVER['DOCUMENT_ROOT'] . "/src/include/nav.php");
                ?>

                <div class="col-xs-9">
                    <!-- Профиль !-->
                    <div>
                        <ol class="breadcrumb">
                            <li>
                                <a href="/user?id=-1">Account</a>
                            </li>
                            <li class="active">
                                <a href="#">Friends</a>
                            </li>
                        </ol>

                        <div class="page-header">
                            <b>There are <?php echo count(explode(",",mysql_fetch_object($result)->Friends)); ?> friends</b>
                        </div>
                        <?php
						while ($row = mysql_fetch_assoc($result)) {
							$friendsids = explode(",", $row['Friends']);
							array_walk ($friendsids,function($item) {
								$friend = API("user.getByID", $item);
								echo '
						<div class="media" user-id="' . $friend["ID"] . '">
                            <div class="media-left">
                                <a href="/user?id=' . $friend["ID"] . '"> <img style="width:64px;" class="media-object img-thumbnail" src="' . $friend["Avatar"] . '" alt="..."> </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading pull-left">' . $friend["Name"] . ' ' . $friend["Surname"] . '</h4>
                                <div class="pull-right btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-envelope"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
';
							});
						}
                        ?>
                    </div>
                </div>

                <div hidden>
                    <!-- Стена !-->
                    <form>
                        <textarea class="form-control form-control-sm"></textarea>
                        <div class="pull-right" style="padding:5px;">
                            <button class="btn btn-primary btn-sm">
                                Отправить
                            </button>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>
                    <div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#"> <img src="https://freeiconshop.com/files/edd/person-flat.png" style="width: 64px; height: 64px;" class="media-object"> </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">One</h4> Первый пост...
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#"> <img src="http://www.uco.edu.co/idiomas/PublishingImages/teacher.png" style="width: 64px; height: 64px;" class="media-object"> </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">Two</h4> Скоро все будет работать
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
			$(".sn-status .btn-primary").click(function() {
				$.post("/src/api/api.php", {
					action : "status.change",
					status : $(".sn-status input").val()
				}, function() {
					$('a.sn-status').text($(".sn-status input").val());
					$('a.sn-status-pencil').removeClass('hide');
					$("a.sn-status").removeClass('hide')
					$('.sn-status.input-group').addClass('hide');
					$(".sn-statussuccess").removeClass("hide");
				});
			});
        </script>
    </body>
</html>
