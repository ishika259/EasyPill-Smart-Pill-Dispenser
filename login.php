<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT id, name, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                // Password is correct, start a new session
                session_start();
                
                // Store data in session variables
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["name"] = $row["name"];
                
                // Redirect to dashboard
                header("location: dashboard.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>