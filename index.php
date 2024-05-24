<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <!-- bootstrap general -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <title>Log in | SMRT</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body style="background-color: #d1d8e0;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-5">
                <!-- Adjust the column size as needed -->
                <div class="card shadow">
                    <h1 class="card-header text-center text-light" style="background-color: #6200ee;">SMRT | Sign In</h1>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9 mb-3"><input type="text" class="form-control" name="username" required></div>
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9 mb-3"><input type="password" name="password" class="form-control" required></div>
                                <button type="submit" class="btn btn-sm mt-3 text-light" style="min-width:140px; width:20%; margin: 0 auto; background-color: #7f8fa6; font:bolder;">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        var Toaster = (icon, title) => {
            Toast.fire({
                icon: icon,
                title: title
            });
        }
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                type: 'post',
                url: 'controller/login.php',
                data: formData,
                success: function(res) {
                    res == 0 ? Toaster('error', 'Wrong username or password') : window.location.href = 'controller/check_access.php';
                }
            })
        });
    </script>
</body>

</html>