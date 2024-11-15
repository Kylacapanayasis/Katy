<?php 

include("includes/db.php");
include("functions/functions.php");


// Initialize the database connection
$con = mysqli_connect("localhost", "root", "", "ecom_store");

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$email = $_GET['email'];

// Check the current status of the customer
$sql = "SELECT status FROM customers WHERE customer_email = '$email'";
$result = mysqli_query($con, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $status = $row['status'];

    if ($status == 'approved') {
        // Log the user in and redirect to the homepage
        $user_query = "SELECT * FROM customers WHERE customer_email = '$email'";
        $user_result = mysqli_query($con, $user_query);
        $user_data = mysqli_fetch_assoc($user_result);

        $_SESSION['customer_id'] = $user_data['customer_id'];
        $_SESSION['customer_email'] = $user_data['customer_email'];
        $_SESSION['customer_name'] = $user_data['customer_name'];

        echo "<script>alert('Your account has been approved! You are now logged in.');</script>";
        echo "<script>window.location.href='index.php';</script>";
    } elseif ($status == 'disapproved') {
        // Redirect to the disapproved page
        echo "<script>window.location.href='disapproved.php';</script>";
    }
} else {
    echo "Error retrieving status: " . mysqli_error($con);
}

mysqli_close($con); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting for Admin Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .message-container {
            background-color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .message-container h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .message-container p {
            color: #777;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <div class="message-container">
        <h2>Your account has been verified!</h2>
        <p>Waiting for admin approval. Please try to log in again later.</p>
    </div>

</body>
</html>

<?php ?>
