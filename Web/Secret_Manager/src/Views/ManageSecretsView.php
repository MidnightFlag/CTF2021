<?php
if(!isset($_SESSION['pseudo'])) header("Location:?page=/");
else{
    require_once("Model/SecretDAO.php");
    $allSecrets = SecretDAO::getInstance()->findSecretOfUser(htmlspecialchars($_SESSION['pseudo']));
    $toStore = [];
    $nbToStore = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Secret Master.">
        <meta name="author" content="Worty">
        <meta name="keywords" content="Help you to store your secrets!">

        <!-- Title Page-->
        <title>Secret Master - Manage Secrets</title>

        <!-- Bootstrap CSS & JS-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="./assets/js/manageSecrets.js"></script>
    </head>

    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Secret Master - Manage Secrets</a>
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
    <br />
    <form method="POST" action="?page=manageOneSecret">
    <div class="container">
        <div class="row">
            <?php if(isset($_SESSION['msgE'])) echo '<p class="lead" style="color: red;">'.$_SESSION['msgE'].'</p>';
            if(isset($_SESSION['msg'])) echo '<p class="lead" style="color: green;">'.$_SESSION['msg'].'</p>';
            ?>
            <?php if($allSecrets){ ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Content</th>
                            <th scole="col">Action</th> 
                        </tr>
                    </thead>
                    <tbody id="array">
                        <?php $i=1; foreach($allSecrets as $secret){ ?>
                            <?php if($i < 11){ ?>
                                <tr id="cell<?=$i;?>">
                                    <th scope="row"><?=$i;?></th>
                                    <td><?=$secret->getContent();?></td>
                                    <td><button type="submit" name='<?=$secret->getId();?>' class="btn btn-warning">Modify</button></td>
                                </tr>
                            <?php $toStore[] = [$secret->getId(),$secret->getContent()]; $nbToStore++; }else{ $toStore[] = [$secret->getId(),$secret->getContent()]; $nbToStore++; }?>
                        <?php $i++; } ?>
                    </tbody>
                </table>
                <div class="col-md-11 text-center">
                    <select id="nbPage">
                        <option value="1">1</option>
                        <?php for($i=1; $i<intval($nbToStore/10)+1; $i++){
                            echo '<option value="'.$i++.'">'.$i++.'</option>';
                        }
                        ?>
                    </select>
                    <a id="next" onclick="changePage();" href="#">>>></a>
                </div>
            <?php }else{ ?>
                <p class="lead"><br>No secrets were found. Maybe you want to <a href="?page=addSecret">add</ad> a secret?</p>
            <?php } ?>
        </div>
    </div>
    </form>
    <?php echo '<script>storeSecrets('.json_encode($toStore).');</script>'; ?>
    <?php echo '<script>storeMaxSecrets('.(intval($nbToStore/10)+1).');</script>'; ?>
</body>
</html>
<?php
$_SESSION['msg'] = "";
$_SESSION['msgE'] = "";
?>