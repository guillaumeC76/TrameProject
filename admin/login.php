<?php
session_start();
include ('../inc/function.php');
include ('../inc/pdo.php');

$errors = array();
$success = false;


if (!empty($_POST['submitted'])) {

    // Protection des failles XSS
    $login    = trim(strip_tags($_POST['login']));
    $password = trim(strip_tags($_POST['password']));

    if (empty($login) || empty($password)) {
        $errors['login'] = 'Veuillez renseigner ce champ';
    } else {
        $sql = "SELECT * FROM users WHERE pseudo = :login OR email = :login";
        $query = $pdo->prepare($sql);
        $query->bindValue(':login',$login,PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch();

        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {

                $_SESSION['login'] = array(
                    'id'     => $user['id'],
                    'pseudo' => $user['pseudo'],
                    'role'   => $user['role'],
                    'ip'     => $_SERVER['REMOTE_ADDR']
                );

                // Debug *_SESSION
                header('location: index.php');

            } else {
                $errors['login'] = 'Pseudo ou email inconnu ou mot de passe oublié';
            }





        } else {
            $errors['login'] = 'Pseudo ou email inconnu';
        }
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

  <title>SB Admin 2 - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Vous revoilà !</h1>
                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Adresse Email">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mot de passe">
                    </div>

                    <a href="index.html" class="btn btn-primary btn-user btn-block" name="submitted">
                      Connexion
                    </a>
                    <hr>

                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Mot de passe oublié ?</a>
                  </div>

                </div>
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
