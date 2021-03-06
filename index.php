<?php
session_start();
include ('inc/function.php');
include ('inc/pdo.php');
$errors = array();
$success = false;

if (!empty($_POST['submit'])) {

    $nom             = clean($_POST['nom']);
    $prenom          = clean($_POST['prenom']);
    $email           = clean($_POST['email']);
    $objet           = clean($_POST['objet']);
    $message         = clean($_POST['message']);

    // VALIDATION AVEC LES FONCTIONS //


    $errors = textValid($errors, $nom, 'nom',2, 150);
    $errors = textValid($errors, $prenom, 'prenom',2, 150);
    $errors = emailValid($errors, $email, 'email');
    $errors = textValid($errors, $objet, 'objet',3, 200);
    $errors = textValid($errors, $message, 'message',10,4000);

    if (count($errors) == 0) {
        $success = true;
        $sql = "INSERT INTO contact VALUES(null ,:nom ,:prenom ,:email ,:objet ,:message)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->bindValue(':objet', $objet, PDO::PARAM_STR);
        $query->bindValue(':message',$message, PDO::PARAM_STR);
        $query->execute();
    }
}

// debug($_SESSION['login']['role']);

include('inc/header.php'); ?>

<div class="diapo">
<div class="flexslider">
    <ul class="slides">
        <li>
            <img src="asset/img/imgReseau1.jpg" />
        </li>
        <li>
            <img src="asset/img/imgReseau2.jpg" />
        </li>
        <li>
            <img src="asset/img/imgReseau3.jpg" />
        </li>
    </ul>
</div>
</div>



<section id="qui">
    <span id="premier"></span>

    <h2 class="tagline"><span>Qui</span> sommes nous ?</h2>

    <div class="avatarEtLogo">
        <div class="avatarSeul">
            <div class="avatar1 imgAvatar">
                <img src="asset/img/samuel.jpg" alt="Photo de Samuel (Mr. Propre)" class="avatar">
                <p>Samuel<br>Lacaille</p>
            </div>

            <div class="imgAvatar">
               <img src="asset/img/guillaume.png" alt="Photo de Guillaume" class="avatar">
                <p>Guillaume<br>Colombel</p>
            </div>

            <div class="imgAvatar">
               <img src="asset/img/benjamin.jpg" alt="Photo de Benjamin" class="avatar">
                <p>Benjamin<br>Plesant</p>
            </div>

            <div class="imgAvatar">
                <img src="asset/img/avthomas.png" alt="Photo de Thomas" class="avatar">
                <p>Thomas<br>Vasseur</p>
            </div>
        </div>

        <div class="logoLogiciel">
            <h2 class="titreLanguage">Languages maitrisés</h2>

            <ul class="logoImg">
                <li class="loga"><img src="asset/img/html.png" alt="Logo de HTML" class="logo"></li>
                <li class="loga"><img src="asset/img/css.svg" alt="Logo de CSS" class="logoCSS"></li>
                <li class="loga"><img src="asset/img/js.png" alt="Logo de JavaScript" class="logoJS"></li>
                <li class="loga"><img src="asset/img/php.png" alt="Logo de PHP" class="logo"></li>
                <li class="loga"><img src="asset/img/sql.png" alt="Logo de MySQL" class="logo"></li>
            </ul>
            <div class="espace"></div>
        </div>
    </div>

    <div class="barreVertical"></div>


    <div class="text">
        <p>Nous sommes des élèves de la Nfactory School en première année Bachelor. Notre projet était de créer un site web sur les trames réseaux. L'objectif est <span class="italic">d' analyser des trames réseaux et les transmettre sous forme de statistiques</span> beaucoup plus clair et plus compréhensible.</p><br>
        <p>Nous étions 4 pour réaliser ce projet dans un temps imparti de 2 semaines. Nous sommes des développeurs en développement, c'est notre seule devise. Pour plus d'information, contactez nous par mail juste en dessous. Sinon, pour acceder à la totalité du contenu et sniffer à volonter, inscrivez-vous et connectez-vous.</p><br>
        <p>Toute l'équipe vous remercie.</p>
    </div>
    <div class="clear"></div>
</section>


    <span id="deuxieme"></span>

<h3 class="headline">Nous contacter</h3>

<div class="bar"></div>
<h4 id="formulaireAncre">Envoyez votre message ici</h4>
    <section id="pagecontact"></section>
    <div class="formpage">

        <?php if($success) {
            echo '<p class="success">Votre message à bien été envoyé<br><a class="recharge" href="index.php">Recharger la page</a></p>';
        } else { ?>
        <form class="formulaireEffet" novalidate action="index.php#formulaireAncre" method="post">

            <div class="separation">
                <input id="nom" type="text" name="nom" placeholder="Votre Nom" class="input1" value="<?php if (!empty($_POST['nom'])) {echo $_POST['nom'];} ?>">
                <span class="error"><?php if(!empty($errors['nom'])) {echo $errors['nom']; }?></span>
            </div>

            <div class="separation">
                <input id="prenom" type="text" name="prenom" placeholder="Prénom" class="input2" value="<?php if (!empty($_POST['prenom'])) {echo $_POST['prenom'];} ?>">
                <span class="error"><?php if(!empty($errors['prenom'])) {echo $errors['prenom']; }?></span>
            </div>

            <div class="separation">
                <input id="email" type="email" name="email" placeholder="Votre Email" class="input3" value="<?php if (!empty($_POST['email'])) {echo $_POST['email'];} ?>">
                <span class="error"><?php if(!empty($errors['email'])) {echo $errors['email']; }?></span>
                </div>

            <div class="separation">
                <input id="sujet" type="text" name="objet" placeholder="Objet" class="input4" value="<?php if (!empty($_POST['objet'])) {echo $_POST['objet'];} ?>">
                <span class="error"><?php if(!empty($errors['objet'])) {echo $errors['objet']; }?></span>
            </div>

            <textarea name="message" rows="8" cols="8" class="input5" placeholder="Votre message ..."><?php if (!empty($_POST['message'])) {echo $_POST['message'];} ?></textarea>
            <span class="error"><?php if(!empty($errors['message'])) {echo $errors['message']; }?></span>

            <input id="boutonenvoyer" type="submit" name="submit" class="input6" value="Envoyer" onclick="animation()">
        </form> <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="asset/js/main.js"></script>






<?php include('inc/footer.php');