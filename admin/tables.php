<?php

include_once '../inc/pdo.php';
include_once '../inc/function.php';


$sql = "SELECT * FROM users";
$query = $pdo->prepare($sql);
$query->execute();

$user = $query->fetchAll();


$sql = "SELECT * FROM contact";
$query = $pdo->prepare($sql);
$query->execute();

$contact = $query->fetchAll();


$errors = array();
$success = false;

// Traitement de formulaire

if (!empty($_POST['submitted'])) {

    // Protection des failles XSS
    $pseudo = trim(strip_tags($_POST['pseudo']));
    $email = trim(strip_tags($_POST['email']));
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
        $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
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
        $query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $hashPassword, PDO::PARAM_STR);
        $query->bindValue(':token', $token, PDO::PARAM_STR);
        $query->execute();
        $success = true;




        header('Location: tables.php');
    }
}
/*
if (!empty($_POST['delete'])) {

    $sql = "DELETE FROM contact WHERE  id = $contact[$i]['id'] ";
    $query = $pdo->prepare($sql);
    $query->execute();
    header('Location: tables.php');
} */
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin TrameProyect - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>


<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->

        <!-- Divider -->


        <!-- Heading -->
        <div class="sidebar-heading">
            Addons
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Login Screens:</h6>
                    <a class="collapse-item" href="login.php">Connexion</a>
                    <a class="collapse-item" href="register.php">Register</a>
                    <a class="collapse-item" href="forgot-password.php">Mot de passe oublié</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Autres Pages:</h6>
                    <a class="collapse-item" href="404.php">Page 404</a>
                    <a class="collapse-item" href="blank.html">Blank Page</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item active">
            <a class="nav-link" href="tables.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">




                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Administrateur</span>
                            <img class="img-profile rounded-circle"
                                 src="https://i.ytimg.com/vi/j3iG_T9qIA4/maxresdefault.jpg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">


                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Déconnexion
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Tables</h1>
                <p class="mb-4"> Les differentes tables.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Table users</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>pseudo</th>
                                    <th>email</th>
                                    <th>role</th>
                                    <th>created_at</th>
                                    <th>supprimer</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                echo '<tr>';
                                for ($i = 0; $i < count($user); $i++) {
                                    echo '<td>' . $user[$i]['id'] . '</td>';
                                    echo '<td>' . $user[$i]['pseudo'] . '</td>';
                                    echo '<td>' . $user[$i]['email'] . '</td>';
                                    echo '<td>' . $user[$i]['role'] . '</td>';
                                    echo '<td>' . $user[$i]['created_at'] . '</td>';
                                    echo '<td><a href="tables.php?id=' . $user[$i]['id'] .'" >' . '<img src="img/delete.png"' .'</a>'.'</td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                            <h3>Ajouter un nouvel utilisateur :</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>pseudo</th>
                                        <th>email</th>
                                        <th>mot de passe</th>
                                        <th>retaper mot de passe</th>
                                        <th>role</th>

                                    </tr>
                                    </thead>

                                    <tbody>

                                    <tr>
                                        <form action="tables.php" method="post">
                                            <td>id</td>
                                            <td><input type="text" name="pseudo" id="pseudo"></td>
                                            <td><input type="text" name="email" id="email"></td>
                                            <td><input type="password" name="password1" id="password1"></td>
                                            <td><input type="password" name="password2" id="password2"></td>
                                            <td><input type="text" name="role" id="role"></td>
                                            <td><input type="submit" name="submitted" value="Ajouter"></td>
                                        </form>
                                    </tr>

                                    </tbody>
                                </table>

                                <h3>Modifier un utilisateur : </h3>

                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Table contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>nom</th>
                                        <th>prenom</th>
                                        <th>email</th>
                                        <th>objet</th>
                                        <th>message</th>
                                        <th>supprimer</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    echo '<tr>'; ?>
                                    <form action="tables.php" method="post"> <?php
                                    for ($i = 0; $i < count($contact); $i++) {
                                        echo '<td>' . $contact[$i]['id'] . '</td>';
                                        echo '<td>' . $contact[$i]['nom'] . '</td>';
                                        echo '<td>' . $contact[$i]['prenom'] . '</td>';
                                        echo '<td>' . $contact[$i]['email'] . '</td>';
                                        echo '<td>' . $contact[$i]['objet'] . '</td>';
                                        echo '<td>' . $contact[$i]['message'] . '</td>';
                                        echo '<td>' . '<input type="submit" name="delete" value="supprimer">'.'</td>';
                                     //   echo '<td><a href="tables.php?id=' . $contact[$i]['id'] .'" >' . '<img src="img/delete.png"' .'</a>'.'</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Trameproyect 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt pour partir ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Etes-vous sur de vouloir quitter ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-primary" href="login.php">déconnexion</a>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
