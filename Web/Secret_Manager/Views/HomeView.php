<?php
if(!isset($_SESSION['pseudo'])) header("Location:?page=/");
else{
    $_SESSION['msgE'] = "";
    $_SESSION['msg'] = "";
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Winventory.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you if you read a lot of books!">

        <!-- Title Page-->
        <title>Secret Master - HomePage</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Secret Master - Home Page</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="?page=home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
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
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2>What is Secret Master?</h2>
                <p>Secret Master is an online service to store your heaviest secrets, and those without a password!<br>

                    All you have to do is provide us with a nickname, we'll take care of the rest! You can find your secrets <a href="?page=manageSecrets">here</a>. <br>

                    With Secret Master, your secrets will remain a mystery! <br>
            </div>
            <div class="col-12 text-center">
                <p class="lead">Thanks for choosing Secret Master. Maybe you want to <a href="?page=addSecret">store</a> a secret ?</p>
            </div>
        </div>
    </div>
    </body>
</html>
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
?>