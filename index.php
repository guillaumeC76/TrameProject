<?php
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
    $errors = emailValid($errors, $email, 'email',5,220);
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

include('inc/header.php'); ?>


    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>

<div class="slideshow-container">

    <div class="mySlides fade">
        <div class="numbertext">1 / 3</div>
        <img src="asset/img/stat2.gif">
    </div>

    <div class="mySlides fade">
        <div class="numbertext">2 / 3</div>
        <img src="asset/img/stat1.png">
    </div>

    <div class="mySlides fade">
        <div class="numbertext">3 / 3</div>
        <img src="asset/img/stat3.jpg">
    </div>

    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<div style="text-align:center">
    <span class="dot" onclick="currentSlide(1)"></span>
    <span class="dot" onclick="currentSlide(2)"></span>
    <span class="dot" onclick="currentSlide(3)"></span>
    <span id="premier"></span>
</div>



<section id="qui">
    <div class="clear"></div>
    <img src="asset/img/question.svg" alt="Point d'intérogation">

    <div class="barreVertical"></div>

    <h2>Qui somme nous ?</h2>
    <div class="text">
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias delectus dolor esse exercitationem fuga laboriosam laborum officiis quas quia, ratione rem vel. A alias animi at autem corporis cum deserunt ducimus error eum ex excepturi expedita illo inventore iure laborum libero magni, minus molestiae nam officiis possimus quaerat quidem quisquam reiciendis repellendus repudiandae, sequi tempora temporibus, tenetur velit! Ipsam itaque iure nostrum nulla perspiciatis! Adipisci amet assumenda doloremque eos in labore odit quae quas quasi sed! Ab aliquid expedita id itaque, laudantium provident? Alias consequatur deserunt dolor excepturi hic illo ipsa modi qui totam. Minus molestiae quae repudiandae vero.</p>
    </div>
    <div class="clear"></div>
</section>



<span id="deuxieme"></span>
<h2 class="h1speciale">Nous contacter</h2>
<div class="bar"></div>
<h5>Envoyez votre message ici</h5>
<section id="pagecontact">
    <div class="formpage">

        <?php if($success) {
            header('Location: success.php');
        } else { ?>
        <form class="" novalidate action="" method="post">
            <input id="nom" type="text" name="nom" placeholder="Votre Nom" value="<?php if (!empty($_POST['nom'])) {echo $_POST['nom'];} ?>">
            <span class="error"><?php if(!empty($errors['nom'])) {echo $errors['nom']; }?></span>

            <input id="prenom" type="text" name="prenom" placeholder="Prénom" value="<?php if (!empty($_POST['prenom'])) {echo $_POST['prenom'];} ?>">
            <span class="error"><?php if(!empty($errors['prenom'])) {echo $errors['prenom']; }?></span>

            <input id="email" type="email" name="email" placeholder="Votre Email" value="<?php if (!empty($_POST['email'])) {echo $_POST['email'];} ?>">
            <span class="error"><?php if(!empty($errors['email'])) {echo $errors['email']; }?></span>

            <input id="sujet" type="" name="objet" placeholder="Objet" value="<?php if (!empty($_POST['objet'])) {echo $_POST['objet'];} ?>">
            <span class="error"><?php if(!empty($errors['objet'])) {echo $errors['objet']; }?></span>

            <textarea name="message" rows="8" cols="8" placeholder="Votre message ..."><?php if (!empty($_POST['message'])) {echo $_POST['message'];} ?></textarea>
            <span class="error"><?php if(!empty($errors['message'])) {echo $errors['message']; }?></span>

            <input id="boutonenvoyer" type="submit" name="submit" value="Envoyer">
        </form> <?php } ?>
    </div>


<script src="asset/js/main.js"></script>

<?php include('inc/footer.php');