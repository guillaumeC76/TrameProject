<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <title>TrameProyect</title>

    <link rel="stylesheet" href="asset/flexslider/flexslider.css" type="text/css">


</head>
<body>

<header>

    <?php if (!is_logged()) { ?>
    <div class="menufixed">
        <div class="icon-bar" id="responsive_headline">
            <a class="active" href="index.php"><img src="asset/img/home.png" id="home"><p>Accueil</p></a>
            <a href="index.php#premier"><img src="asset/img/question.png" id="question"><p>Qui sommes nous ?</p></a>
            <a href="index.php#deuxieme"><img src="asset/img/envelope.png" id="contact"><p>Contactez nous</p></a>
            <a href="login.php"><img src="asset/img/user.png" id="user"><p>Connexion / Inscription</p></a>
        </div>
    </div>

    <?php }  elseif ($_SESSION['login']['role'] == "admin") { ?>

        <div class="menufixed">
            <div class="icon-bar" id="responsive_headline">
                <a class="active" href="index.php"><img src="asset/img/home.png" id="home"><p>Accueil</p></a>
                <a href="statistique.php"><img src="asset/img/stats.png" id="question"><p>Statistiques</p></a>
                <a href="./admin/tables.php"><img src="asset/img/admin.png" id="admin"><p>Admin</p></a>
                <a href="deconnexion.php"><img src="asset/img/croix.png" id="user"><p>Deconnexion</p></a>
            </div>
        </div>

        <?php }else { ?>
    <div class="menufixed2">
        <div class="icon-bar2" id="responsive_headline">
            <a class="active" href="index.php"><img src="asset/img/home.png" id="home"><p>Accueil</p></a>
            <a href="statistique.php"><img src="asset/img/stats.png" id="question"><p>Statistiques</p></a>
            <a href="deconnexion.php"><img src="asset/img/croix.png" id="user"><p>Deconnexion</p></a>
        </div>
    </div>

    <?php }?>

</header>

