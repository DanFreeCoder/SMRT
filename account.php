<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.min.css">
    <!-- bootstrap general -->
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <title>Document</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            text-decoration: none;
        }

        label {
            color: gray;
        }
    </style>
</head>

<body style="background-color: #d1d8e0;">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-5">
                <!-- Adjust the column size as needed -->
                <div class="card shadow">
                    <h1 class="card-header text-center text-light" style="background-color: #6200ee;"><a href="<?php echo $_SESSION['access_type'] == 2 ? 'user.php' : 'manager.php' ?>" class="text-light">SMRT</a> | Account</h1>
                    <div class="card-body">
                        <form id="accountForm">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">First Name</label>
                                <div class="col-sm-9 mb-3"><input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $_SESSION['firstname'] ?>" required></div>
                                <label class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9 mb-3"><input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $_SESSION['lastname'] ?>" required></div>
                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9 mb-3"><input type="text" class="form-control" name="username" id="username" value="<?php echo $_SESSION['username'] ?>" required readonly></div>
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9 mb-3"><input type="password" name="password" id="password" class="form-control"></div>
                                <label class="col-sm-3 col-form-label">Confirm Password</label>
                                <div class="col-sm-9 mb-3"><input type="password" name="confirm_password" id="confirm_password" class="form-control"></div>
                                <button type="submit" class="btn btn-sm mt-3 text-light" style="min-width:140px; width:20%; margin: 0 auto; background-color: #6200ee; font:bolder;">Update</button>
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
        $('#accountForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var pass = $('#password').val();
            var pass_com = $('#confirm_password').val();
            if (pass_com != pass) {
                Toaster('error', `Password doesn't match!`)
                return false;
            }
            var type = '';
            if (pass_com != '' && pass != '') {
                type = 'with';
            } else {
                type = 'out';
            }
            $.ajax({
                type: 'post',
                url: `controller/upd_account.php?type=${type}`,
                data: formData,
                success: function(res) {
                    if (res > 0) {
                        Toaster('success', 'Account has been updated.')
                        setTimeout(() => {
                            window.location.href = 'controller/logout.php';
                        }, 2000)
                    } else {
                        Toaster('error', 'Update failed.')
                    }

                }
            })
        });

        // < !--USERNAME AUTO GENERATE-- >

        $('#firstname').blur(function(e) {
            e.preventDefault();

            var str = $('#firstname').val();
            var fname = str.replace(/\s/g, '');
            var f = fname.toLowerCase();
            var str1 = $('#lastname').val();
            var lname = str1.replace(/\s/g, '');
            var l = lname.toLowerCase();
            var uname = f.concat('.').concat(l);
            $('#username').val(uname);
        })
        $('#lastname').blur(function(e) {
            e.preventDefault();

            var str = $('#firstname').val();
            var fname = str.replace(/\s/g, '');
            var f = fname.toLowerCase();
            var str1 = $('#lastname').val();
            var lname = str1.replace(/\s/g, '');
            var l = lname.toLowerCase();
            var uname = f.concat('.').concat(l);
            $('#username').val(uname);
        })
    </script>
</body>

</html>