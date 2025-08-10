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


$query = "SELECT * FROM companies WHERE id = $company_id";
$result = mysqli_query($connect, $query);


if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

$companyInfo = mysqli_fetch_assoc($result);

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link rel="stylesheet" href="../CSS-File/styles.css">
</head>
<body>

   
    <div class="profile-container-wrapper">
       
        <div class="profile-container">
            
         
            <header class="profile-header">
                <img src="<?php echo $companyInfo["logo"]; ?>"  alt="Company Logo" class="company-logo"> 
                <h1 class="company-name"><?php echo $companyInfo["company_name"]; ?></h1> 
            </header>
    
          
            <section class="profile-info">
                <h2>Profile Information</h2>
                <p><strong>Bio:</strong> <span id="company-bio"><?php echo $companyInfo["bio"]; ?></span></p>
                <p><strong>Address:</strong> <span id="company-address"><?php echo $companyInfo["address"]; ?></span></p>
                <p><strong>Location:</strong> <span id="company-location"><?php echo $companyInfo["location"]; ?></span></p>
                <p><strong>Email:</strong> <span id="company-email"><?php echo $companyInfo["email"]; ?></span></p>
                <p><strong>Phone:</strong> <span id="company-phone"><?php echo $companyInfo["phone"]; ?></span></p>
            </section>
    
          
            <section class="edit-profile">
                <button onclick="window.location.href='edit-profile.php'">Edit Profile</button>
            </section>
    
          
            <div class="navigation-buttons">
                <button onclick="window.location.href='../HTML-Files/company-dashboard.php'">Back to Dashboard</button>
            </div>
    
        </div>
    </div>
    

    <script src="../JS-File/script.js"></script>
</body>
</html>
