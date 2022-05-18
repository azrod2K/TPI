 <!-- 
Auteur: David Machado
Date: 18.05.2022
Projet: Matos     -->

 <!-- la form du resgiter -->
 <div class="container">
 <?php
 
 if ($_SESSION['alertMessage']['type'] != null) {
 ?>
    <div class="alert alert-<?= $_SESSION['alertMessage']['type'] ?> alert-dismissible fade show" role="alert">
             <?= $_SESSION['alertMessage']['message'] ?>
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>


<?php
     $_SESSION['alertMessage'] = [
         "type" => null,
         "message" => null
     ];
 }
 ?>
        <div class="row">
            <div class=col-lg-3></div>
            <div class=col-lg-6>
                <div id="ui">
                <h1 class="text-center">Register</h1>
                    <form method="POST" action="index.php?uc=login&action=validateRegister" class="form-group text-center">
                        <div class="row" >
                            <div class="col-lg-6">
                                <label>First Name :</label>
                                <input type="text" name="prenom" placeholder="Enter your First name .."
                                    class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label>Last Name :</label>
                                <input type="text" name="nom" placeholder="Enter your Last name .." class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row" >
                            <div class="col-lg-6">
                                <label>E-mail :</label>
                                <input type="text" name="email" placeholder="Enter your email .." class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label>Pseudo :</label>
                                <input type="text" name="pseudo" placeholder="Enter your pseudo .." class="form-control">
                            </div>
                        </div>
                        <br>
                        <label>Numéro de téléphone :</label>
                        <input type="text" name="noTel" placeholder="enter your numeber .." class="form-control">
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Password :</label>
                                <input type="password" name="password" placeholder="Enter your password .." class="form-control">
                            </div>
                        </div>
                        <br>
                        <a href="index.php?uc=login&action=show">Déjà membre ? Connectez-vous ici</a>
                        <br>
                        <input type="submit" name="valider" value="Register" class="btn btn-success btn-block btn-lg">
                    </form>
                </div>
            </div>
            <div class=col-lg-3></div>
        </div>
    </div>