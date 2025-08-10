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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flight_name = mysqli_real_escape_string($connect, $_POST['name']);
    $flight_id = mysqli_real_escape_string($connect, $_POST['id']);
    $itinerary = mysqli_real_escape_string($connect, $_POST['itinerary']);
    $from = mysqli_real_escape_string($connect, $_POST['from']);
    $to = mysqli_real_escape_string($connect, $_POST['to']);
    $fees = mysqli_real_escape_string($connect, $_POST['fees']);
    $passengers = mysqli_real_escape_string($connect, $_POST['passengers']);
    $time = mysqli_real_escape_string($connect, $_POST['time']);

    $query = "INSERT INTO flights (flight_name, flight_id, itinerary, departure, arrival, fees, num_of_passengers, flight_time, company_id)
              VALUES ('$flight_name', '$flight_id', '$itinerary', '$from', '$to', '$fees', '$passengers', '$time', '$company_id')";
    
    if (mysqli_query($connect, $query)) {
        // Redirect to home page after successful flight addition
        header("Location:/WebProject/HTML-Files/company-dashboard.php");
        exit(); // Ensure no further code is executed
    } else {
        echo "Error adding flight: " . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link rel="stylesheet" href="../CSS-File/styles.css">
</head>
<body>
    <div class="add-flight-page">
        <div class="form-container">
            <form action="#" method="post" class="add-flight-form">
                <h1>Add New Flight</h1>
                
                <div class="form-group">
                    <label for="name">Flight Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter flight name" required>
                </div>

                <div class="form-group">
                    <label for="id">Flight ID</label>
                    <input type="text" id="id" name="id" placeholder="Enter flight ID" required>
                </div>

                <div class="form-group">
                    <label for="itinerary">Itinerary</label>
                    <textarea id="itinerary" name="itinerary" rows="4" placeholder="Enter flight itinerary" required></textarea>
                </div>
                <div class="form-group">
                    <label for="from">From</label>
                    <input type="text" id="from" name="from" placeholder="Enter your origin city" required>
                </div>
                <div class="form-group">
                    <label for="to">To</label>
                    <input type="text" id="to" name="to" placeholder="Enter your destination city" required>
                </div>

                <div class="form-group">
                    <label for="fees">Fees</label>
                    <input type="number" id="fees" name="fees" placeholder="Enter flight fees" required>
                </div>

                <div class="form-group">
                    <label for="passengers">Number of Passengers</label>
                    <input type="number" id="passengers" name="passengers" placeholder="Enter number of passengers" required>
                </div>

                <div class="form-group">
                    <label for="time">Flight Time</label>
                    <input type="datetime-local" id="time" name="time" required>
                </div>

                <button type="submit" class="submit-btn">Add Flight</button>
            </form>
        </div>
    </div>
    <script src="../JS-File/script.js"></script>
</body>
</html>
