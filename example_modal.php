<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 17/11/2018
 * Time: 06:20
 */
require("php/required.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php include("partials/header.php") ?>
    <title><?php echo WEBSITE_NAME ?> - Modal</title>
</head>
<body>
    <div class="container-fluid">
        <!-- Button trigger modal -->
        <a class="btn btn-primary" href="index.php" role="button">Index</a>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">
            Exemple de login
        </button>

        <!-- POPUP -->
        <div class="container-fluid">
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Se connecter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <form>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Pseudo" required>
                                        </div>
                                        <div class="col">
                                            <input type="password" class="form-control" placeholder="Mot de passe" required>
                                        </div>
                                    </div>
                                </form>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">S'inscrire</button>
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
