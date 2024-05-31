<!--Joel Macias 21145505 -->
<!--booking.php handles the backend booking form to send to the SQL and recieve confirmation back-->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST

    // Create connection
    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the current booking number
    $sql = "SELECT * FROM booking_requests";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $booking_count = mysqli_num_rows($result); // Get the number of bookings
    } else {
        $booking_count = 0; // If there are no bookings, set the count to 0
    }

    // set the variables from the POST and create the booking number
    $booking_number = "BRN" . str_pad($booking_count + 1, 5, "0", STR_PAD_LEFT);
    $cname = $_POST['cname'];
    $phone = $_POST['phone'];
    $snumber = $_POST['snumber'];
    $stname = $_POST['stname'];
    $sbname = $_POST['sbname'];
    $dsbname = $_POST['dsbname'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = "Unassigned";

    // Insert the booking into the database
    $sql = "INSERT INTO booking_requests (booking_number, customer_name, phone_number, street_number, street_name, suburb, destination_suburb, pick_up_date, pick_up_time, assignment_status) VALUES ('$booking_number','$cname', '$phone', '$snumber', '$stname','$sbname', '$dsbname','$date', '$time', '$status')";
    $result = mysqli_query($conn, $sql);

    // Format the date into DD/MM/YYYY
    $date = date("d/m/Y", strtotime($date));
    
    // Display the booking confirmation
    if ($result) {
        echo "<h2>Thank you for your booking!</h2>";
        echo "<p><strong>Booking reference number:</strong> $booking_number</p>";
        echo "<p><strong>Pickup time:</strong> $time</p>";
        echo "<p><strong>Pickup date:</strong> $date</p>";
    } else {
        echo "Error: " . mysqli_error($conn); // Display an error if the booking fails
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo "Invalid request method"; // Display an error if the request method is not POST
}
?>