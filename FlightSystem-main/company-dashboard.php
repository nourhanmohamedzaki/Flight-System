<?php
session_start();  // Start the session

// Check if the user is logged in as a company
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'company') {
    // Redirect to login page if not logged in as company
    header("Location: login.php?type=company");
    exit();
}

$host = 'localhost';
$dbname = 'travel';
$username = 'root';
$password = '';

$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch the company ID from the session
$company_id = $_SESSION['user_id'];  // Assuming the company ID is stored in the session as 'user_id'

$query = "SELECT flight_id, flight_name, departure, arrival FROM flights WHERE company_id = $company_id";
$result = mysqli_query($connect, $query);

$query2 = "SELECT company_name, logo FROM companies WHERE id = $company_id";
$result2 = mysqli_query($connect, $query2);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}

if (!$result2) {
    die("Query failed: " . mysqli_error($connect));
}

$flights = mysqli_fetch_all($result, MYSQLI_ASSOC);
$companyInfo = mysqli_fetch_assoc($result2);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Home</title>
    <link rel="stylesheet" href="../CSS-File/styles.css">
</head>
<body>

    <div class="company-home-container">
        <header class="company-header">
        <img src="<?php echo $companyInfo['logo']; ?>" alt="Company Logo" class="company-logo">
        <h1 class="company-name"><?php echo $companyInfo["company_name"]; ?> </h1>
        </header>

        <div class="flights-list">
            <h2>Flights</h2>
            <table border="1" cellspacing="0" cellpadding="5">
                <thead> 
                    <tr>
                        <th>Flight ID</th>
                        <th>Flight Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Itinerary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($flights)): ?>
                        <tr>
                            <td colspan="3">No flights available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($flights as $flight): ?>
                            <tr onclick="window.location.href='flight-details.php?id=<?= $flight['flight_id'] ?>'">
                                <td><?= htmlspecialchars($flight['flight_id']) ?></td>
                                <td><?= htmlspecialchars($flight['flight_name']) ?></td>
                                <td><?= htmlspecialchars($flight['departure']) ?></td>
                                <td><?= htmlspecialchars($flight['arrival']) ?></td>
                                <td><?= htmlspecialchars($flight['departure'] . " - " . $flight['arrival']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="buttons">
            <button onclick="window.location.href='add-flight.php'">Add Flight</button>
            <button onclick="window.location.href='messages.php'">Messages</button>
            <button onclick="window.location.href='profile.php'">Profile</button>
        </div>

    </div>
    <script src="../JS-File/script.js"></script> 
</body>
</html>
