<?php
session_start(); // Start the session
// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    // Redirect to login page if not logged in as company
    header("Location: login.php?type=company");
    exit();
}
$company_id = $_SESSION['user_id']; 


$host = 'localhost';
$dbname = 'travel';
$username = 'root';
$password = '';

$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

$companyInfo = null;  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $company_name = mysqli_real_escape_string($connect, $_POST['company_name']);
    $company_bio = mysqli_real_escape_string($connect, $_POST['company_bio']);
    $company_address = mysqli_real_escape_string($connect, $_POST['company_address']);
    $company_location = mysqli_real_escape_string($connect, $_POST['company_location']);
    $company_email = mysqli_real_escape_string($connect, $_POST['company_email']);
    $company_phone = mysqli_real_escape_string($connect, $_POST['company_phone']);
    
    $company_logo = ''; 
    if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] == 0) {
        $company_logo = 'uploads/' . basename($_FILES['company_logo']['name']);
        move_uploaded_file($_FILES['company_logo']['tmp_name'], $company_logo);
    }
    
    $query = "UPDATE companies 
              SET company_name = '$company_name', 
                  bio = '$company_bio', 
                  address = '$company_address', 
                  location = '$company_location', 
                  email = '$company_email', 
                  phone = '$company_phone', 
                  logo = '$company_logo' 
              WHERE id = $company_id";
    
    if (mysqli_query($connect, $query)) {
        echo "Company information updated successfully!";
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}

$query = "SELECT * FROM companies WHERE id = $company_id";
$result = mysqli_query($connect, $query);

if ($result) {
    $companyInfo = mysqli_fetch_assoc($result);
} else {
    echo "Error fetching company information: " . mysqli_error($connect);
}

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../CSS-File/editProfile.css">
</head>
<body>

<div class="edit-profile-container-wrapperr">
    <div class="edit-profile-box">
        <h1>Edit Profile</h1>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="company-name">Company Name</label>
                <input type="text" id="company-name" name="company_name" placeholder="Enter company name" value="<?php echo htmlspecialchars($companyInfo['company_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="company-bio">Bio</label>
                <textarea id="company-bio" name="company_bio" placeholder="Enter company bio" rows="4" required><?php echo htmlspecialchars($companyInfo['bio']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="company-address">Address</label>
                <input type="text" id="company-address" name="company_address" placeholder="Enter company address" value="<?php echo htmlspecialchars($companyInfo['address']); ?>" required>
            </div>

            <div class="form-group">
                <label for="company-location">Location</label>
                <input type="text" id="company-location" name="company_location" placeholder="Enter company location" value="<?php echo htmlspecialchars($companyInfo['location']); ?>">
            </div>

            <div class="form-group">
                <label for="company-email">Email</label>
                <input type="email" id="company-email" name="company_email" placeholder="Enter company email" value="<?php echo htmlspecialchars($companyInfo['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="company-phone">Phone</label>
                <input type="tel" id="company-phone" name="company_phone" placeholder="Enter company phone" value="<?php echo htmlspecialchars($companyInfo['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="company-logo">Logo</label>
                <input type="file" id="company-logo" name="company_logo" accept="image/*">
            </div>

            <div class="form-buttons">
            <button type="submit" onclick="window.location.href='profile.php'">Save Changes</button>
            <button type="button" onclick="window.location.href='profile.php'">Cancel</button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
