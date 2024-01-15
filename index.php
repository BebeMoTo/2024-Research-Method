<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>StudentGuard Pro || Log-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        @media all and (max-width: 400px) {
            .toast {
                width: 90%;
            }
        }

        .form {
            background-color: #fff;
            display: block;
            padding: 1rem;
            max-width: 350px;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .form-title {
            font-size: 1.25rem;
            line-height: 1.75rem;
            font-weight: 600;
            text-align: center;
            color: #000;
        }

        .input-container {
            position: relative;
        }

        .input-container input,
        .form button {
            outline: none;
            border: 1px solid #e5e7eb;
            margin: 8px 0;
        }

        .input-container input {
            background-color: #fff;
            padding: 1rem;
            padding-right: 3rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            width: 300px;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .submit {
            display: block;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            background-color: #07111a;
            color: #ffffff;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            width: 100%;
            border-radius: 0.5rem;
            text-transform: uppercase;
        }

        .signup-link {
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-align: center;
        }

        .signup-link a {
            text-decoration: underline;
        }

        @media all and (max-width: 400px) {
            .formLogIn {
                position: absolute;
                top: 50%;
                left: 50%;
                translate: -50% -50%;
            }
        }

        @media all and (min-width: 401px) {
            .formLogIn {
                position: absolute;
                top: 75px;
                right: 20px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="images/favicon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    StudentGuard Pro: Log-In
                </a>
            </div>
        </nav>

        <div class="formLogIn">
            <form class="form" method="POST" action="includes/indexLogin.php">
                <p class="form-title">LOG-IN TO YOUR ACCOUNT</p>
                <div class="input-container">
                    <input type="text" placeholder="Enter ID" required name="username">
                    <span>
                    </span>
                </div>
                <div class="input-container">
                    <input type="password" placeholder="Enter password" required name="password">
                </div>
                <button type="submit" class="submit">
                    Log In
                </button>

                <p class="signup-link">

                </p>
            </form>
        </div>

    </header>

    <div class="toast" id="EpicToast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger">
            <strong class="me-auto text-white">Error!!!</strong>
            <small class="text-white">Sheeesh</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            The account was not found in database.
        </div>
    </div>

    <div class="toast" id="EpicToast1" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger">
            <strong class="me-auto text-white">Error!!!</strong>
            <small class="text-white">Sheeesh</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            There must be a problem on the server side.
        </div>
    </div>

    <div class="toast" id="EpicToast2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success">
            <strong class="me-auto text-white">Logged Out</strong>
            <small class="text-white">...</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Logged Out Successfully
        </div>
    </div>

    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        var option = {
            animation: true,
            delay: 3000
        }


        if (window.location.href.includes("notInDB")) {
            var toastHTMLElement = document.getElementById("EpicToast");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        } else if (window.location.href.includes("loginError")) {
            var toastHTMLElement = document.getElementById("EpicToast1");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        } else if (window.location.href.includes("logout")) {
            var toastHTMLElement = document.getElementById("EpicToast2");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        }
    </script>
</body>

</html>