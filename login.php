<!DOCTYPE html>
<?php

    include("includes/config.php");
    include("includes/function.php");
    
    session_start();
    if(isset($_SESSION['login_user']) && isset($_SESSION['login_office'])) {
        if($_SESSION['login_office'] == 'head'){
            header("location: admin/index.php");    
        }else{
            header("location: plant/index.php");
        }
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login Page | Starcrete Manufactoring Corporation</title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

      <form class="login-form" action="login.php" method="post">        
        <div class="login-wrap">
            <p class="login-img"><i class="icon_lock_alt"></i></p>
            <div class="input-group">
              <span class="input-group-addon"><i class="icon_profile"></i></span>
              <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <input class="btn btn-primary btn-lg btn-block" name="login-submit" id="login-submit" type="submit" value="Login">
        </div>
      </form>
    <div class="text-right">
            <div class="credits">
                <!-- 
                    All the links in the footer should remain intact. 
                    You can delete the links only if you purchased the pro version.
                    Licensing information: https://bootstrapmade.com/license/
                    Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
                -->
                <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </div>


  </body>
</html>
<?php

if(isset($_POST['login-submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    // $sql = "SELECT user_id FROM users WHERE username = '$username' AND `password` = '$password'";

    // $result = mysqli_query($db,$sql);
    // $count = mysqli_num_rows($result);

    $stmt = $db->prepare('SELECT user_id, office FROM users WHERE username = ? AND `password` = ?');
    $stmt->bind_param('ss', $username, $password);

    $stmt->execute();
    $count = $stmt->get_result();
    if(mysqli_num_rows($count) == 1) {
        $row = mysqli_fetch_assoc($count);
        session_start();
        $_SESSION['login_user'] = $username;
        $_SESSION['login_office'] = $row['office'];
        if($row['office'] == 'head'){
            header("location: admin/index.php");
        }else if($row['office'] != 'head'){
            header("location: plant/index.php");
        }
    }else{
        phpAlert("Your Username or Password is invalid");
    }
}   

?>
