<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $middlename = $_POST["middlename"];
    $suffix = $_POST["suffix"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $contactnum = $_POST["contactnum"];
    $pwd = $_POST["pwd"];
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $profileImage = $_FILES["profileimage"];

    $_SESSION['inputs'] = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'middlename' => $middlename,
        'suffix' => $suffix,
        'birthday' => $birthday,
        'address' => $address,
        'contactnum' => $contactnum,
        'email' => $email
    ];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors']['email'] = "Invalid email address.";
    }
    if (empty($email)) {
        $_SESSION['errors']['email'] = "Email address is a required field.";
    }
    if (empty($pwd)) {
        $_SESSION['errors']['pwd'] = "Password is a required field.";
    }

    if (isset($_SESSION['errors'])) {
        header('Location: ../register.php');
        exit();
    }

    try {
        require_once "dbc.inc.php";

        $query = "SELECT * FROM users WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $_SESSION['errors']['email'] = "Email already taken.";
            header('Location: ../register.php');
            exit();
        }
        if ($profileImage && $profileImage['error'] === UPLOAD_ERR_OK) {
            $imageData = file_get_contents($profileImage['tmp_name']);
            $query = "INSERT INTO users (firstname, lastname, middlename, suffix, birthday, address, contactnum, email, pwd, profileimage) 
                      VALUES (:firstname, :lastname, :middlename, :suffix, :birthday, :address, :contactnum, :email, :pwd, :profileimage);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":profileimage", $imageData, PDO::PARAM_LOB);
        } else {
            $query = "INSERT INTO users (firstname, lastname, middlename, suffix, birthday, address, contactnum, email, pwd) 
                      VALUES (:firstname, :lastname, :middlename, :suffix, :birthday, :address, :contactnum, :email, :pwd);";
            $stmt = $pdo->prepare($query);
        }

        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":middlename", $middlename);
        $stmt->bindParam(":suffix", $suffix);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":contactnum", $contactnum);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":pwd", $hashedPwd);
        $stmt->execute();

        $stmt = null;
        $pdo = null;

        $_SESSION['success_message'] = "Successfully registered!";
        header('Location: ../login.php');
        exit();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}