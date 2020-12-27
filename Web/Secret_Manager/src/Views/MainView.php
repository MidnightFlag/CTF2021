<?php
if(isset($_SESSION['pseudo'])) header("Location:?page=home");
else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Secret Master.">
    <meta name="author" content="Worty">
    <meta name="keywords" content="Store all your secrets!">

    <!-- Title Page-->
    <title>Secret Master - Connexion</title>

    <!-- Icons font CSS-->
    <link href="./assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="./assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="./assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="./assets/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Secret Master - Connexion</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=validPseudo">
                    <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                          if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                    ?>
                        <div class="form-row">
                            <div class="name">Pseudo</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="pseudo" required>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn--radius-2 btn--red" type="submit">Connect</button>
                        </div>
                        <br />
                        <p>Just give us a pseudo and store your personal secrets securely!</a>.</p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="./assets/vendor/select2/select2.min.js"></script>
    <script src="./assets/vendor/datepicker/moment.min.js"></script>
    <!-- Main JS-->
    <script src="./assets/js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
}
?>