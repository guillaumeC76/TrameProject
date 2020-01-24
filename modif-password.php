<?php
include ('inc/function.php');
include ('inc/pdo.php');
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
        die(404);
    }

}

include ('inc/header.php'); ?>


<h3 class="headline">Modifier votre mot de passe</h3>

<form action="" method="post" class="formpage">

    <div class="separation">
    <label for="password1">Nouveau mot de passe</label>
    <input type="password" name="password1" id="password1" value="">
    <p class="error"><?php if (!empty($errors['password'])) { echo $errors['password']; } ?></p>
    </div>

    <div class="separation">
    <label for="password2">Confirmez votre nouveaux mot de passe</label>
    <input type="password" name="password2" id="password2" value="">
    </div>

    <input type="submit" name="submitted" id="boutonenvoyer" value="Modifier">

</form>

<?php include ('inc/footer.php');
