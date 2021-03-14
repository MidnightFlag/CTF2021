<?php
session_start();
if(isset($_POST['search'])){
    if(filter_var($_POST['search'], FILTER_VALIDATE_URL)){
        if(preg_match("/localhost/i",$_POST['search']) || preg_match("/127.0.0.1/i",$_POST['search'])){
            $_SESSION['msgE'] = 'Unauthorized.';
        }else{
            $content = file_get_contents($_POST['search']);
        }
    }else{
        $_SESSION['msgE'] = 'Invalid URL.';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Alpha version</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Browser in browser</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./">Home</a>
                </li>
                <?php if(!isset($_SESSION['username'])){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                <?php }else{ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                <?php } ?>
                <li class="nav-item active">
                    <a class="nav-link" href="./search.php">Search <span class="sr-only">(current)</span></a>
                </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>Search on the internet!</h1>
                    <?php if(isset($_SESSION['msgE'])) echo '<p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p>'; ?>
                    <form method="POST" action="./search.php">
                        <input type="text" class="form-control" placeholder="search..." name="search">
                        <br/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <?php if(isset($content)) echo($content); ?>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
$_SESSION['msgE'] = '';
?>