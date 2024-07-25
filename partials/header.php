<?php session_start();
if (!isset($_SESSION['fullname'])) {
    header('Location: controller/logout.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SMRT</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/styles.css" rel="stylesheet" />
    <!-- bootstrap general -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap2.min.css">
    <link rel="stylesheet" href="assets/datatables/dataTables.bootstrap5.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="assets/datepicker.min.css">
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/jquery/animate.min.css" />
    <link rel="stylesheet" href="assets/jquery/jquery-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/picker/picker.min.css">

</head>

<body style="background-color: #d1d8e0;">
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $_SESSION['access_type'] == 2 ? 'user.php' : 'manager.php' ?>">SMRT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <input type="text" value="<?php echo $_SESSION['id'] ?>" id="session_id" hidden>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#"> <i class="fa-regular fa-user"></i> <?php echo $_SESSION['fullname'] ?></a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="reminder.php"><i class="fa-regular fa-bell"></i> Reminder</a></li>
                            <li><a class="dropdown-item" href="account.php"><i class="fa-solid fa-gear"></i> Account Setting</a></li>
                            <li><a class="dropdown-item" href="controller/logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></li>
                        </ul>
                    </div>
                </ul>
            </div>
        </div>
    </nav>