<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/morph.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>SV | Homepage</title>
</head>
<body class="bg-white">
<header class="container">
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SV</a>
            <ul class="navbar-nav ms-auto flex-row">
                <li class="nav-item me-2">
                    <a class="btn btn-info" href="#">Login</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="#">Register</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<section class="main-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="listing-header p-4">
                    <form action="#" method="POST" class="d-inline my-3" id="reg-form">
                        <h2 class="h3 mb-3 fw-bold">Register an account.</h2>
                        <div class="form-group mb-3">
                            <label>Select one</label><br>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input class="form-check-input mb-0" type="radio" name="role" id="role1" checked>
                                    <label class="form-check-label mb-0 fw-normal" for="role1">I am Content
                                        Creator</label>
                                </div>
                                <div class="form-check ms-3">
                                    <input class="form-check-input mb-0" type="radio" name="role" id="role2">
                                    <label class="form-check-label mb-0 fw-normal" for="role2">I want to follow and
                                        vote</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group mb-4">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required id="password">
                            <div class="small text-danger d-none password-alert">Password must be at least 8 characters
                                long and contains letters and numbers.
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label>Repeat Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required
                                   id="password_confirmation">
                            <div class="small text-danger d-none confirm-password-alert">Password confirmation failed.
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <button class="btn btn-outline-primary me-2">Cancel</button>
                            <button class="btn btn-primary" id="register-btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-light p-4">
    <div class="text-center">&copy; Copyrights 2023, All Rights Reserved.</div>
</footer>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $('#reg-form').validate({
        rules: {
            password: {
                required: true,
                pwcheck: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
        },
        messages: {
            password: {
                pwcheck: "Password must be at least 8 characters long and contains letters and numbers."
            },
            password_confirmation: {
                equalTo: "Both passwords must match."
            }
        }
    });

    $.validator.addMethod("pwcheck", function (value) {
        return /^(?=.*\d)(?=.*[a-zA-Z]).{8,20}$/.test(value)
    });
</script>
</body>
</html>
