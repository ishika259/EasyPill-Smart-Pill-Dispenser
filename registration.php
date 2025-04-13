<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
    
    // Basic validation
    if (empty($name) || empty($email) || empty($_POST["password"])) {
        $error = "Please fill all required fields.";
    } else {
        // Check if email exists
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "This email is already registered.";
        } else {
            // Insert user
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $password);
            
            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                
                // Generate patient ID (format: YYYY + random 4 digits)
                $patient_id = date('Y') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
                
                // Insert patient profile
                $sql = "INSERT INTO patient_profiles (user_id, patient_id) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $user_id, $patient_id);
                
                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $user_id;
                    // Registration successful
                    header("location: patient_info.php");
                    exit();
                }
            }
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>