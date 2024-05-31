// Joel Macias 21145505
// get data from the backend and database and assignbooking function for the requests

// function to get data from the backend
function getData(dataSource, divID, data){
    var xhr = new XMLHttpRequest();
    if (xhr) {
        var obj = document.getElementById(divID); // get the element to display the response
        xhr.open("POST", dataSource, true); // open the connection
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // set the header
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                obj.innerHTML = xhr.responseText;
            } 
        } 
        var sendData = "bsearch=" + encodeURIComponent(data); // encode the data
        xhr.send(sendData);  // send the data
    }
}

// function to assign booking for requests
function assignBooking(bookingRef){
    var xhr = new XMLHttpRequest();
    if (xhr) {
        var obj = document.getElementById("confirm");
        xhr.open("POST", "assign.php", true); // open the connection
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");  // set the header
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                obj.innerHTML = xhr.responseText;
                document.getElementById('status_' + bookingRef).textContent = 'Assigned'; // update the status
            } 
        } 
        var sendData = "assign=" + encodeURIComponent(bookingRef);  // encode the data
        xhr.send(sendData);  // send the data
    }
}