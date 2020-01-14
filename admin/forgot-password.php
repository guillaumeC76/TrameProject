<?php
include ('../inc/function.php');
include ('../inc/pdo.php');
$title = 'Modifier votre mot de passe';
$errors = array();

if (!empty($_GET['token']) && !empty($_GET['email'])) {

    $token = clean($_GET['token']);
    $email = clean($_GET['email']);

    $token = $_GET['token'];
    $email = $_GET['email'];
    $email = urldecode($email);
    $sql = "SELECT * FROM users where token = :token AND email = :email";
    $query = $pdo->prepare($sql);
$query->bindValue(':token', $token, PDO::PARAM_STR);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();
$user = $query->fetch();

if (!empty($user)) {
if (!empty($_POST['submitted'])) {
// 3 - Password
$password1 = trim(strip_tags($_POST['password1']));
$password2 = trim(strip_tags($_POST['password2']));
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
$sql = "UPDATE users SET password = :password, token = :token WHERE email = :email";
$query = $pdo->prepare($sql);
$query->bindValue(':token', $token, PDO::PARAM_STR);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->bindValue(':password', $hashPassword, PDO::PARAM_STR);
$query->execute();

header('Location: login.php');
}
}
} else {
header('404.php');
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

  <title>SB Admin 2 - Mot de passe oublié</title>

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
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Mot de passe oublié ?</h1>

                  </div>
                  <form class="user">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Adresse Email...">
                    </div>
                    <a href="login.php" class="btn btn-primary btn-user btn-block">
                      Réinitialiser mot de passe
                    </a>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.php">Créer un compte!</a>
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
