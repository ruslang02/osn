<?php include($_SERVER['DOCUMENT_ROOT']."/src/api/api.php"); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Log In - Social Network</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <?php
                $page = "login";
				include ("../src/include/nav.php");
                ?>
                <div class="col-xs-9">
                    <form class="form-horizontal" method="post" action="/src/api/api.php">
                        <?php if($_GET['error']) print '<div class="alert alert-danger" role="alert"><b>Not good!</b> You typed a wrong password or login.</div>'; ?>
                        <div class="form-group">
                            <label for="user" class="col-sm-2 control-label">Login:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user" id="user" placeholder="mynickname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pass" class="col-sm-2 control-label">Password:</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="pass" id="pass" placeholder="********">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="action" value="login" />
                                <div class="checkbox disabled">
                                    <label class="disabled">
                                        <input type="checkbox" disabled>
                                        Remember me </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-log-in"></span> Log In
                                </button>
                                or <a href="/register">register for free</a>.
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>