<?php
session_start();
include ('inc/function.php');
include ('inc/pdo.php');


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





include ('inc/header.php'); ?>


<h6>Connexion</h6>

<form action="login.php" method="post" class="inscri">

    <label for="login">Pseudo ou email *</label>
    <input type="text" name="login" id="login" value="<?php if (!empty($_POST['login'])) { echo $_POST['login'];}?>">
    <p class="error"><?php if (!empty($errors['login'])) { echo $errors['login']; } ?></p>

    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" value=""><br>

    <span>Pas de compte ? <a href="register.php">Inscrivez-vous</a></span><br>
    <span class="autrepass">Ou alors vous avez <a href="forgetpassword.php">oublier votre mot de passe ?</a></span>

    <input type="submit" name="submitted" value="connexion">

</form>


<?php include ('inc/footer.php');