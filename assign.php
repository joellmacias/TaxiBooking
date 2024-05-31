<!--Joel Macias 21145505 -->
<!--assign.php sets unassigned booking requsests to assigned -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST

    // Create connection
    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the assign button has been pressed
    if (isset($_POST['assign'])) {

        // Get the booking number from the POST
        $booking_number = $_POST['assign'];

        // Update the booking request to assigned
        $sql = "UPDATE booking_requests SET assignment_status = 'Assigned' WHERE booking_number = '$booking_number'";
        $result = mysqli_query($conn, $sql);


        // Display the booking confirmation
        if ($result) {
            echo "<strong>Congratulations! Booking request $booking_number has been assigned!</strong>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } 
    // Close the connection
    mysqli_close($conn);
} else {
    echo "Invalid request method: " . $_SERVER["REQUEST_METHOD"]; 
}
?>