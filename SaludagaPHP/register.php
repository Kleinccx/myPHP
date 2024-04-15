<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
    <style>
        .registration-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
         
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5">
        <h1 class="text-center">Registration Page</h1>
        <div class="registration-container">
            <form action="includes/register.inc.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required value="<?= isset($_SESSION['inputs']['email']) ? $_SESSION['inputs']['email'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="pwd" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="firstname" class="form-label">First Name:</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required value="<?= isset($_SESSION['inputs']['firstname']) ? $_SESSION['inputs']['firstname'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name:</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required value="<?= isset($_SESSION['inputs']['lastname']) ? $_SESSION['inputs']['lastname'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="middlename" class="form-label">Middle Name:</label>
                    <input type="text" name="middlename" id="middlename" class="form-control" value="<?= isset($_SESSION['inputs']['middlename']) ? $_SESSION['inputs']['middlename'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="suffix" class="form-label">Suffix:</label>
                    <input type="text" name="suffix" id="suffix" class="form-control" value="<?= isset($_SESSION['inputs']['suffix']) ? $_SESSION['inputs']['suffix'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="date" name="birthday" id="birthday" class="form-control" required value="<?= isset($_SESSION['inputs']['birthday']) ? $_SESSION['inputs']['birthday'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required><?= isset($_SESSION['inputs']['address']) ? $_SESSION['inputs']['address'] : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="contactnum" class="form-label">Contact Number:</label>
                    <input type="tel" name="contactnum" id="contactnum" class="form-control" required value="<?= isset($_SESSION['inputs']['contactnum']) ? $_SESSION['inputs']['contactnum'] : '' ?>">
                </div>

                <div class="mb-3">
                    <label for="profileimage" class="form-label">Profile Image:</label>
                    <input type="file" name="profileimage" id="profileimage" class="form-control">
                </div>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="mb-3">
                        <?php foreach ($_SESSION['errors'] as $error): ?>
                            <p class="text-danger"><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <input type="submit" value="Register" class="btn btn-primary">
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
