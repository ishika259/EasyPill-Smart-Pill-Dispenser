<?php
// patient_info.php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $age = trim($_POST["age"]);
    $gender = trim($_POST["gender"]);
    $blood_group = trim($_POST["blood_group"]);
    $disease = trim($_POST["disease"]);
    $symptoms = trim($_POST["symptoms"]);
    $medications = trim($_POST["medications"]);
    $lab_tests = trim($_POST["lab_tests"]);
    
    $sql = "UPDATE patient_profiles SET 
            age = ?, 
            gender = ?, 
            blood_group = ?,
            disease = ?,
            symptoms = ?,
            medications = ?,
            lab_tests = ?
            WHERE user_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssi", $age, $gender, $blood_group, $disease, $symptoms, $medications, $lab_tests, $user_id);
    
    if ($stmt->execute()) {
        header("location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Information</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Complete Your Profile</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Age</label>
                <input type="number" name="age" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Blood Group</label>
                <input type="text" name="blood_group" required>
            </div>
            <div class="form-group">
                <label>Disease/Condition</label>
                <input type="text" name="disease">
            </div>
            <div class="form-group">
                <label>Symptoms</label>
                <textarea name="symptoms"></textarea>
            </div>
            <div class="form-group">
                <label>Current Medications</label>
                <textarea name="medications"></textarea>
            </div>
            <div class="form-group">
                <label>Recent Lab Tests</label>
                <textarea name="lab_tests"></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>