<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbc.inc.php";
        $query = "SELECT id, pwd FROM users WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashedPwd = $row["pwd"];

            if (password_verify($pwd, $hashedPwd)) {
                session_start();
                $_SESSION["id"] = $row["id"];
                echo "<script>alert('Successfully Login!'); window.location.href='../index.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid Login Credentials'); window.location.href='../login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid Login Credentials'); window.location.href='../login.php';</script>";
            exit();
        }

        $pdo = null;
        $stmt = null;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>