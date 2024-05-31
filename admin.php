<!--Joel Macias 21145505 -->
<!--admin.php requests booking requests -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the request method is POST

    // Create connection
    require_once ("../../files/settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the booking number from the POST
    $bsearch = $_POST['bsearch'];
    $result = null;

    // Check if the search button has been pressed
    if (isset($_POST['bsearch'])) {
        if (empty($bsearch)) { // Check if the search field is empty
            $current_time = date('Y-m-d H:i:s', time());
            // Get the booking requests that are unassigned and within the next 2 hours
            $sql = "SELECT * FROM booking_requests  WHERE assignment_status = 'Unassigned' AND CONCAT(pick_up_date, ' ', pick_up_time) BETWEEN NOW() AND NOW() + INTERVAL 2 HOUR";
            $result = mysqli_query($conn, $sql);
        } elseif (preg_match('/^BRN\d{5}$/', $bsearch)) { // Check if the search field is a booking number
            // Get the booking request with the booking number
            $sql = "SELECT * FROM booking_requests WHERE booking_number = '$bsearch'";
            $result = mysqli_query($conn, $sql);
        } else { // Display an error if the booking number is invalid
            echo "Please enter a booking number (BRN*****).";
        }

        // Display the booking requests
        if ($result) {

            // Display the booking requests in a table
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<thead><tr><th>Booking Reference Number</th> <th>Customer Name</th> <th>Phone</th> <th>Pick Up Suburb</th><th>Destination Suburb</th><th>Pick Up Date and Time</th><th>Status</th><th>Assign</th</tr></thead>";
            echo "<tbody>";

            // Display the booking requests in a table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['booking_number'] . "</td>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['phone_number'] . "</td>";
                echo "<td>" . $row['suburb'] . "</td>";
                echo "<td>" . $row['destination_suburb'] . "</td>";
                echo "<td>" . date("d/m/Y", strtotime($row['pick_up_date'])) . " " . $row['pick_up_time'] . "</td>";
                echo "<td id='status_" . $row['booking_number'] . "'>" . $row['assignment_status'] . "</td>";
                echo "<td><button type='button' onclick='assignBooking(\"" . $row['booking_number'] . "\")'>Assign</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo "Invalid request method:";
}
?>