<?php

require "dbh.inc.php";
if (!$connect) {
  die("Connection failed: " . mysqli_connect_error());
}

// Add Booking
if (isset($_POST['add_booking_btn'])) {
  $booking_date = $_POST['booking_Date'];
  $time = $_POST['time'];

  // Validate date and time format
  if (!isValidDate($booking_date) || !isValidTime($time)) {
      $_SESSION['error'] = "Invalid date or time format!";
  } else {
      // Format the date
      $formatted_booking_date = date('Y-m-d', strtotime($booking_date));

      $type_of_service = implode(",", $_POST['Type_of_Service']);
      $type = $_POST['Vehicle_Type'];
      $phone = $_POST['phone'];
      $referral = $_POST['Referral'];
      $cust_id = $_POST['Cust_Id'];
      $manager_id = $_POST['Manager_Id'];
      

  }     

          // Using prepared statements to prevent SQL injection
          $insert_booking_query = "INSERT INTO booking (`booking_Date`, `time`, `Type_of_Service`, `Vehicle_Type`, `phone`, `Referral`, `Cust_Id`, `Manager_Id`)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


$query_run_booking = mysqli_query($connect, $query_booking);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>High Security Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    input[type="date"],
    input[type="time"],
    select,
    input[type="tel"],
    input[type="text"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      width: 100%;
      background-color:blue;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .error {
      color: red;
    }

    h2{
      color:blue;
      text-align:center;
    }
  </style>
</head>
<body>
  
  <div class="container">
    <h2>Book Your Appointment</h2>
    <form  action="booking.php" method="post">
      <div>
        <label for="booking_Date">Date:</label>
        <input type="date" id="booking_Date" name="booking_Date" min="<?php echo date('Y-m-d'); ?>" required>
      </div>
      <div>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>
      </div>
      <div>
        <label for="Type_of_Service">Type of Service:</label>
        <select class="form-control" id="Type_of_Service" name="Type_of_Service[]" multiple required>
                                            <!-- Add options dynamically from your database or define static options -->
                                            
                                            <option value="Oil Change">Oil Change</option>
                                            <option value="Tire Rotation">Tire Rotation</option>
                                            <option value="Fluid Checks and Replacements">Fluid Checks and Replacements</option>
                                            <option value="Air Filter Replacement">Air Filter Replacement</option>
                                            <option value="Cabin Air Filter Replacement">Cabin Air Filter Replacement</option>
                                            <option value="Engine Diagnostics">Engine Diagnostics</option>
                                            <option value="Computerized Diagnostics">Computerized Diagnostics</option>
                                            <option value="Brake System Repair">Brake System Repair</option>
                                            <option value="Suspension and Steering Repair">Suspension and Steering Repair</option>
                                            <option value="Engine Repair">Engine Repair</option>
                                            <option value="Transmission Repair">Transmission Repair</option>
                                            <option value="Electrical System Repair: ">Electrical System Repair: </option>
                                            <option value="Wheel Alignment">Wheel Alignment</option>
                                            <option value="Air Conditioning Service">Air Conditioning Service</option>
                                            <option value="Heating System Service">Heating System Service</option>
                                            <option value="Emission System Service">Emission System Service</option>
                                            <option value="Performance Upgrades">Performance Upgrades</option>
                                            <option value="Interior and Exterior Detailing">Interior and Exterior Detailing</option>
                                            <option value="Paint and Bodywork">Paint and Bodywork</option>
                                            
                                            <!-- Add more options as needed -->

                                        </select>
      </div>

      <div>
                                    <label for="Vehicle_Type">Vehicle Type:</label>
                                            <select id="Vehicle_Type" name="Vehicle_Type" required>
                                            <option value="">Select Vehicle Type</option>
                                            <option value="Bike">Bike</option>
                                            <option value="Car">Car</option>
                                            <option value="Jeep">Jeep</option>
                                            <option value="Truck">Truck</option>
                                            <option value="Bus">Bus</option>
                                            <option value="Van">Van</option>
                                            <option value="TukTuk">TukTuk</option>
                                            <option value="Lorry">Lorry</option>
                                        </select>
      </div>

      <div>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" pattern="[07]{2}[0-9]{8}" required>
      </div>
      <div>
        <label for="Referral">Referral:</label>
        <input type="text" id="Referral" name="Referral" maxlength="20">
      </div>
      <div>
                                        <label for="Cust_Id">Cust Id:</label>
                                        <input type="text" id='Cust_Id' name='Cust_Id' pattern='^[0-9]{9}[vV]|[0-9]{12}$' required>
                                        <span class="error-message" id="Cust_Id-error"></span>
      </div>
      <div>
                                        <label for="Manager_Id">Manager Id:</label>
                                        <input type="text" id='Manager_Id' name='Manager_Id'>
                                        <span class="error-message" id="Cust_Id-error"></span>
      </div>
      <div>
      <button type="submit" name="add_booking_btn">Add Booking</button>
      </div>
    </form>
  </div>

  <script>
  document.getElementById('service').addEventListener('change', function() {
    var selectedService = this.value;
    if (selectedService) {
      document.getElementById('idTypeContainer').style.display = 'block';
    } else {
      document.getElementById('idTypeContainer').style.display = 'none';
      document.getElementById('idNumberField').style.display = 'none';
    }
  });

  document.getElementById('idType').addEventListener('change', function() {
    var idType = this.value;
    var idNumberField = document.getElementById('idNumberField');
    if (idType === 'oldID') {
      idNumberField.style.display = 'block';
      document.getElementById('Cust_Id').setAttribute('pattern', '[0-9]{9}v');
    } else if (idType === 'newID') {
      idNumberField.style.display = 'block';
      document.getElementById('Cust_Id').setAttribute('pattern', '^[0-9]{12}$');
    } else {
      idNumberField.style.display = 'none';
    }
  });

  document.getElementById('registrationForm').addEventListener('submit', function(event) {
    var phone = document.getElementById('phone').value;
    if (!/^07/.test(phone)) {
      alert('Phone number must start with 07.');
      event.preventDefault();
    }
  });

  // Ensure time is not before current time within the current day
  var currentDate = new Date();
  var currentDateString = currentDate.toISOString().split('T')[0];
  document.getElementById('date').setAttribute('min', currentDateString);

  // Update the minimum time whenever the date changes
  document.getElementById('date').addEventListener('change', function() {
    var selectedDate = new Date(this.value);
    if (selectedDate.toDateString() === currentDate.toDateString()) {
      var hours = currentDate.getHours();
      var minutes = currentDate.getMinutes();
      var formattedTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
      document.getElementById('time').setAttribute('min', formattedTime);
    } else {
      // If the selected date is not the current date, there's no minimum time constraint
      document.getElementById('time').removeAttribute('min');
    }
  });
</script>

</body>
</html>