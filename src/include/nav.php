<link rel="stylesheet" href="/src/css/bootstrap.min.css">
<link rel="stylesheet" href="/src/css/bootstrap-theme.min.css">
<script src="/src/js/jquery-1.12.3.min.js"></script>
<script src="/src/js/bootstrap.min.js"></script>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">SNetwork</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="/logout">Logout</a>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<div class="col-xs-3">
    <?php if($_SESSION['token']) {
    ?>
    <ul class="nav nav-pills small nav-stacked">
        <li role="presentation" class="<?php
		if ($page == "user") {echo "active";
		}
 ?>">
            <a href="/user?id=-1">Account</a>
        </li>
        <li role="presentation" class="<?php
			if ($page == "messages") {echo "active";
			}
 ?>">
            <a href="/messages">Messages</a>
        </li>
        <li role="presentation" class="<?php
			if ($page == "friends") {echo "active";
			}
 ?>">
            <a href="/friends">Friends</a>
        </li>
    </ul>
    <?php } else { ?>
    <ul class="nav nav-pills small nav-stacked">
        <li role="presentation" class="<?php
		if ($page == "login") {echo "active";
		}
 ?>">
            <a href="/login">Login</a>
        </li>
        <li role="presentation" class="<?php
			if ($page == "register") {echo "active";
			}
 ?>">
            <a href="/register">Register</a>
        </li>
    </ul>
    <?php } ?>
</div>