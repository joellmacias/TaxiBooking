// Joel Macias 21145505
// booking javascript handling the form validation and submission

// function to submit the form and validate the data
function submitForm() {
    var form = document.getElementById("bookingForm"); // get the form

    // validate the form by checking if the required fields are not empty, some may require further validation
    if (document.forms["bookingForm"]["cname"].value === "") {
        document.getElementById("cname-error").textContent = "Please enter your name";
        return;
    } else {
        document.getElementById("cname-error").textContent = "";
    } if (document.forms["bookingForm"]["phone"].value === "") {
        document.getElementById("phone-error").textContent = "Please enter your phone";
        return;
    } else if (!/^\d{10,12}$/.test(document.forms["bookingForm"]["phone"].value)) { // check if phone number is between 10 and 12 digits
        document.getElementById("phone-error").textContent = "Phone number must be 10 to 12 digits";
        return;
    }
    else {
        document.getElementById("phone-error").textContent = "";
    } if (document.forms["bookingForm"]["snumber"].value === "") {
        document.getElementById("snumber-error").textContent = "Please enter your street number";
        return;
    } else {
        document.getElementById("snumber-error").textContent = "";
    } if (document.forms["bookingForm"]["stname"].value === "") {
        document.getElementById("stname-error").textContent = "Please enter your street name";
        return;
    } else {
        document.getElementById("stname-error").textContent = "";
    } if (document.forms["bookingForm"]["date"].value === "") {
        document.getElementById("date-error").textContent = "Please enter a date";
        return;
    } else if (new Date(document.forms["bookingForm"]["date"].value) < new Date().setHours(0, 0, 0, 0)) { // check if date is not in the past
        document.getElementById("date-error").textContent = "Please enter the current date or a future date.";
        return;
    } else {
        document.getElementById("date-error").textContent = "";
    }
    if (document.forms["bookingForm"]["time"].value === "") {
        document.getElementById("time-error").textContent = "Please enter a time";
        return;
    }
    else if (new Date(document.forms["bookingForm"]["date"].value + " " + document.forms["bookingForm"]["time"].value) < new Date()) { // check if time is not in the past
        document.getElementById("time-error").textContent = "Please enter the current time or a future time.";
        return;
    } else {
        document.getElementById("time-error").textContent = "";
    }

    // if the form is valid, send the data to the server
    var data = new FormData(form);
    var dataSource = "booking.php";
    var divID = "reference";
    sendData(dataSource, divID, data);

    // reset the form
    form.reset();
    
}

// function to send data to the server
function sendData(dataSource, divID, data) {
    var xhr = new XMLHttpRequest();
    if (xhr) { // check if the browser supports the XMLHttpRequest object
        var obj = document.getElementById(divID); // get the element to display the response
        xhr.open("POST", dataSource, true); // open the connection
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) { // check if the response is ready
                obj.innerHTML = xhr.responseText;
            }
        }
        xhr.send(data); // send the data
    }
}