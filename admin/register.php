<?php
session_start();
include ('../inc/function.php');
include ('../inc/pdo.php');
$title = 'Inscription';
$errors = array();
$success = false;

// Traitement de formulaire

if (!empty($_POST['submitted'])) {

    // Protection des failles XSS
    $pseudo    = trim(strip_tags($_POST['pseudo']));
    $email     = trim(strip_tags($_POST['email']));
    $password1 = trim(strip_tags($_POST['password1']));
    $password2 = trim(strip_tags($_POST['password2']));

    // Validation de chaque champs
    // 1 - Pseudo
    if (empty($pseudo)) {
        $errors['pseudo'] = 'Veuillez renseigner ce champs';
    } elseif (mb_strlen($pseudo) > 120) {
        $errors['pseudo'] = 'Votre pseudo doit contenir moins de 120 caractères';
    } elseif (mb_strlen($pseudo) < 2) {
        $errors['pseudo'] = 'Votre pseudo doit contenir plus de 2 caractères';
    } else {
        $sql = "SELECT id FROM users WHERE pseudo = :pseudo LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
        $query->execute();
        $verifpseudo = $query->fetch();
        if (!empty($verifpseudo)) {
            $errors['pseudo'] = 'Ce pseudo existe dejà !';
        }
    }

    // 2 - Email
    if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'Veuillez renseigner un email valide';
    } else {
        $sql = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $verifemail = $query->fetch();
        if (!empty($verifemail)) {
            $errors['email'] = 'Cet email existe dejà !';
        }
    }

    // 3 - Password
    if (!empty($password1)) {
        if ($password1 != $password2) {
            $errors['password'] = 'Vos mots de passe doivent être identiques';
        } elseif (mb_strlen($password1) <= 5) {
            $errors['password'] = 'Le mot de passe doit contenir minimum 6 caractères';
        }
    } else {
        $errors['password'] = 'Veuillez renseigner un mot de passe';
    }

    if (count($errors) == 0) {
        // Password Hasher
        $hashPassword = password_hash($password1, PASSWORD_BCRYPT);
        $token = generatorToken(120);

        // Insert
        $sql = "INSERT INTO users VALUES (null,:pseudo,:email,:password,:token,'abonne',NOW())";
        $query = $pdo->prepare($sql);
        $query->bindValue(':pseudo',$pseudo,PDO::PARAM_STR);
        $query->bindValue(':email',$email,PDO::PARAM_STR);
        $query->bindValue(':password',$hashPassword,PDO::PARAM_STR);
        $query->bindValue(':token',$token,PDO::PARAM_STR);
        $query->execute();
        $success = true;

        // Redirection vers la connexion
        header('Location: login.php');
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Inscription</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Créer un compte !</h1>
              </div>
              <form action="login.php" method="post" class="user">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Prénom">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Nom">
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Adresse Email">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mot de passe">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Retapez le mot de passe">
                  </div>
                </div>
                 <input name="submitted" class="btn btn-primary btn-user btn-block" type="submit" value="Inscription">

                <hr>


              </form>

              <div class="text-center">
                <a class="small" href="forgot-password.php">Mot de passe oublié?</a>
              </div>
              <div class="text-center">
                <a class="small" href="login.php">Déjà un compte ? Connexion !</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
