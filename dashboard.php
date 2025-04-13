<?php
// dashboard.php
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

// Get patient data
$sql = "SELECT u.name, p.* 
        FROM users u 
        JOIN patient_profiles p ON u.id = p.user_id 
        WHERE u.id = ?";
        
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<style>
    /* Reset and base styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f5f5f5;
    padding: 20px;
}

.dashboard-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header {
    background-color: #E8F4F4;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e0e0e0;
}

.header h2 {
    color: #333;
    font-size: 24px;
}

.patient-id {
    background-color: #ff99cc;
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 14px;
}

.patient-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.profile-section, .medical-section {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #e0e0e0;
}

.profile-section h3, .medical-section h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 18px;
    border-bottom: 2px solid #E8F4F4;
    padding-bottom: 10px;
}

.profile-section p, .medical-section p {
    margin: 10px 0;
    color: #666;
    line-height: 1.5;
}

.profile-section p strong, .medical-section p strong {
    color: #333;
    display: inline-block;
    width: 120px;
}

.actions {
    padding: 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    background-color: #f9f9f9;
    border-top: 1px solid #e0e0e0;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
}

.btn:first-child {
    background-color: #E8F4F4;
    color: #333;
}

.btn:last-child {
    background-color: #ff99cc;
    color: white;
}

.btn:hover {
    opacity: 0.9;
}

/* Responsive design */
@media (max-width: 600px) {
    .patient-info {
        grid-template-columns: 1fr;
    }
    
    .header {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}
    </style>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h2>Patient Dashboard</h2>
            <div class="patient-id">ID: <?php echo htmlspecialchars($patient["patient_id"]); ?></div>
        </div>
        
        <div class="patient-info">
            <div class="profile-section">
                <h3>Patient Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($patient["name"]); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($patient["age"]); ?></p>
                <p>Gender: <?php echo htmlspecialchars($patient["gender"]); ?></p>
                <p>Blood Group: <?php echo htmlspecialchars($patient["blood_group"]); ?></p>
            </div>
            
            <div class="medical-section">
                <h3>Medical Information</h3>
                <p>Disease/Condition: <?php echo htmlspecialchars($patient["disease"]); ?></p>
                <p>Symptoms: <?php echo htmlspecialchars($patient["symptoms"]); ?></p>
                <p>Current Medications: <?php echo htmlspecialchars($patient["medications"]); ?></p>
                <p>Recent Lab Tests: <?php echo htmlspecialchars($patient["lab_tests"]); ?></p>
            </div>
        </div>
        
        <div class="actions">
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
</body>
</html>