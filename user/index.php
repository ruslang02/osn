<?php
include ($_SERVER['DOCUMENT_ROOT'] . "/src/api/api.php");
$page = "user";
$USERINFO;
$result = mysql_query("SELECT * FROM users");
while ($row = mysql_fetch_assoc($result)) {
	$id = $_GET['id'];
	if($id == -1) $id = getIDByUserName(validate());
	if ($row['ID'] == $id) {
		$USERINFO['fullname'] = $row['Surname'] . " " . $row['Name'];
		$USERINFO['firstname'] = $row['Name'];
		$USERINFO['lastname'] = $row['Surname'];
		$USERINFO['dateofbirth'] = date("d.m.Y", strtotime($row['BirthDate']));
		$USERINFO['avatar'] = $row['Avatar'];
		$USERINFO['username'] = $row["UserName"];
		$USERINFO['status'] = $row["Status"];
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>My Page - Social Network</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
				include_once ($_SERVER['DOCUMENT_ROOT'] . "/src/include/nav.php");
 ?>
                
                <div class="col-xs-9">
                    <!-- Профиль !-->
                    <div class="col-xs-4">
                        <a href="#" class="thumbnail"> <img src="<?php echo $USERINFO['avatar']; ?>" alt="Image"> </a>
                    </div>
                    <div class="col-xs-8">
                        <div class="alert alert-success hide sn-statussuccess" onclick="$(this).addClass('hide')" style="position:fixed;top:10px;right:10px;width:350px;"><b>Выполнено! </b> Статус изменен!</div>
                        <b><?php echo $USERINFO['fullname']; ?></b><br>
                        <?php if(validate() === $USERINFO['username']) {  ?>
                        <div class="input-group input-group-sm hide sn-status">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick="$('.sn-status,.sn-status-pencil').toggleClass('hide');">
                                    <span class="glyphicon glyphicon-collapse-up"></span>
                                </button>
                            </span>
                            <input type="text" class="form-control" value="<?php echo $USERINFO['status']; ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">
                                    <span class="glyphicon glyphicon-bullhorn"></span>
                                </button>
                            </span>
                        </div>
                        <a href=# class="small sn-status" onclick="$('.sn-status,.sn-status-pencil').toggleClass('hide');"><?php echo $USERINFO['status']; ?></a> <a href="#" class="small sn-status-pencil" onclick="$('.sn-status,.sn-status-pencil').toggleClass('hide');"><span class="glyphicon glyphicon-pencil"></span><br></a>
                        <?php } else { ?>
                        <span class="small"><?php echo $USERINFO['status']; ?></span>
                        <br>
                        <?php } ?>
                        <br>
                        <div class="row">
                            <div class="col-sm-4 col-xs-5 col-md-3">
                                <b>Birth Date:</b>
                            </div>
                            <div class="col-sm-8 col-xs-7 col-md-9">
                                <?php echo $USERINFO['dateofbirth']; ?>
                            </div>
                        </div>
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
                                <h4 class="media-heading">Someone</h4> Первый пост...
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#"> <img src="http://www.uco.edu.co/idiomas/PublishingImages/teacher.png" style="width: 64px; height: 64px;" class="media-object"> </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">Another one</h4> Скоро все будет работать
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
        		$.post("/src/api/api.php",{action:"status.change",status: $(".sn-status input").val()},function() {
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
