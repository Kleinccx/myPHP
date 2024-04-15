<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["id"])) {
    $userId = $_SESSION["id"];

    try {
        require_once "includes/dbc.inc.php";
        $query = "SELECT email, firstname, lastname, middlename, suffix, birthday, address, contactnum, profileimage FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userDetails) {
            // Output user details
            echo '<div class="container text-center">';
            if (!empty($userDetails["profileimage"])) {
                echo '<div style="border-radius: 50%; overflow: hidden; display: inline-block; margin-bottom: 20px; border: 2px solid #000; padding: 2px;">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($userDetails["profileimage"]) . '" alt="Profile Image" style="width: 150px; height: 150px;">';
                echo '</div>';
            }
            echo '<h1 class="display-4">Welcome, ' . $userDetails["firstname"] . '!</h1>';
            echo '<h2>Profile Information</h2>';
            echo "<p class='fs-6'>Email: " . $userDetails["email"] . "</p>";
            echo "<p class='fs-6'>First Name: " . $userDetails["firstname"] . "</p>";
            echo "<p class='fs-6'>Last Name: " . $userDetails["lastname"] . "</p>";
            echo "<p class='fs-6'>Middle Name: " . $userDetails["middlename"] . "</p>";
            echo "<p class='fs-6'>Suffix: " . $userDetails["suffix"] . "</p>";
            echo "<p class='fs-6'>Birthday: " . $userDetails["birthday"] . "</p>";
            echo "<p class='fs-6'>Address: " . $userDetails["address"] . "</p>";
            echo "<p class='fs-6'>Contact Number: " . $userDetails["contactnum"] . "</p>";
            echo '</div>';
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
       
            <?php if (isset($_SESSION['id'])): ?>
                <a class="navbar-brand" href="logout.php">Logout</a>
            <?php else: ?>
                <a class="navbar-brand" href="login.php">Login</a>
                <a class="navbar-brand" href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['success_message'])): ?>
            <p class="alert alert-success"><?= $_SESSION['success_message'] ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (!isset($_SESSION['id']) || !$userDetails): ?>
            <!-- Additional content for users not logged in -->
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
