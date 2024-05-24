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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <style>
        .active {
            border-bottom: 2px solid #6200ee;
        }

        .custom-btn {
            background-color: #6200ee;
            color: #fff;
        }

        .todo-item {
            cursor: pointer;
        }

        .clicked-todo {
            background-color: #dfe6e9;
        }

        option:checked {
            background: #dcdde1;
        }

        p,
        a,
        button {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
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
                    <li class="nav-item"><a class="nav-link" style="text-decoration:underline;" href="account.php"><?php echo $_SESSION['fullname'] ?></a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="controller/logout.php">Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>