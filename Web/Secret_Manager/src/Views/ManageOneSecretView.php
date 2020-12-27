<?php
if($_SERVER['REQUEST_METHOD'] === "GET" && !isset($_SESSION['currentSecretId'])) header("Location:?page=manageSecrets");
else{
    if(!isset($_SESSION['pseudo'])) header("Location:?page=/");
    require_once("Model/SecretDAO.php");
    $isOkay = True;
    if(isset($_SESSION['currentSecretId']) && !empty($_SESSION['currentSecretId'])){
        $id = $_SESSION['currentSecretId'];
        $currentSecret = SecretDAO::getInstance()->findOneSecret($id);
        if(!is_bool($currentSecret)){
            if($_SESSION['pseudo'] !== $currentSecret->getPseudo()){
                $_SESSION['msgE'] = 'This is not your secret. Get out.';
                die(header("Location:?page=manageSecrets"));
            }
        }else{
            $currentSecret = "Id error.";
            $isOkay = False;
        }
    }else{
        foreach(array_keys($_POST) as $key){
            $id = $key;
        }
        if($id !== -1){
            $currentSecret = SecretDAO::getInstance()->findOneSecret($id);
            if(!is_bool($currentSecret)){
                if(isset($_SESSION['pseudo'])){
                    if($_SESSION['pseudo'] !== $currentSecret->getPseudo()){
                        $_SESSION['msgE'] = 'This is not your secret. Get out.';
                        header("Location:?page=manageSecrets");
                    }
                }
            }else{
                $currentSecret = "Error.";
                $isOkay = False;
            }
        }else{
            $currentSecret = "Id error.";
            $isOkay = False;
        }
    }
}
if($isOkay === True){
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Secret Manager.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you to store your secrets!">

        <!-- Title Page-->
        <title>Secret Manager - Modify Secret</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Secret Master - Modify Secret</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Secrets
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageSecrets">Manage</a>
                    <a class="dropdown-item" href="?page=addSecret">Add</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Modify Secret</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=modifySecret">
                    <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                          if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                    ?>
                        <div class="name">Content</div>
                        <div class="value">
                            <div class="input-group">
                                <?php if(isset($_SESSION['retContent']) && !empty($_SESSION['retContent'])){ ?>
                                <input class="input--style-5" type="text" value="<?php echo(htmlspecialchars($_SESSION['retContent']));?>" name="content" required>
                                <?php }else{ ?>
                                <input class="input--style-5" type="text" value="<?=$currentSecret->getContent();?>" name="content" required>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <input type="text" hidden value="<?=$currentSecret->getId();?>" name="idSecret">
                    <div class="form-row m-b-55" style="margin-left: 125px;">
                        <div class="value">
                            <div class="row row-space">
                                <div class="col-6">
                                    <div class="input-group-desc">
                                    <div>
                                        <button class="btn btn--radius-2 btn--red" value="modify" name="action" type="submit">Modify this secret</button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group-desc">
                                    <div>
                                        <button class="btn btn--radius-2 btn--red" value="delete" name="action" type="submit">Delete this secret</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </form>
                    </div>
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

    </body>
</html>
<?php }else{ ?>
    <!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Secret Manager.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you to store your secrets!">

        <!-- Title Page-->
        <title>Secret Manager - Modify Secret</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Secret Master - Modify Secret</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link" href="?page=home">Home</a>
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Secrets
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="?page=manageSecrets">Manage</a>
                    <a class="dropdown-item" href="?page=addSecret">Add</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Modify Secret</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="?page=modifySecret">
                    <?php if(isset($_SESSION['msgE'])) echo('<div class="col text-center"><p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p></div>');
                          if(isset($_SESSION['msg'])) echo ('<div class="col text-center"><p class="lead" style="color: green;">'.$_SESSION['msg'].'</p></div>');
                    ?>
                        <div class="name">Content</div>
                        <div class="value">
                            <div class="input-group">
                                <p class="lead" style="color: red;">Error while recovering secret, please try again.</p>
                            </div>
                        </div>
                    </div>
                    </form>
                    </div>
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

    </body>
</html>
<?php
}
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
$_SESSION['prix'] = "";
$_SESSION['retContent'] = "";
$_SESSION['currentSecretId'] = "";
?>
