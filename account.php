<?php
session_start();

// Check if the login flag is not set
if (!isset($_SESSION["login_success"])) {
    header("Location: index.php");
    exit();
}

// Access user information
$email = $_SESSION["email"];
$userType = $_SESSION["usertype"];
$firstName = $_SESSION["FIRST_NAME"];

// Access the database table used
$table = $_SESSION["table"];

include 'database.php';

// Fetch user information from the respective table
$sql = "SELECT * FROM $table WHERE email = ?";
$stmt = mysqli_stmt_init($conn);
$prepareStmt = mysqli_stmt_prepare($stmt, $sql);

if ($prepareStmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Assign fetched values to variables
        $firstName = $user["FIRST_NAME"];
        $middleName = $user["MIDDLE_NAME"];
        $lastName = $user["LAST_NAME"];
        // ... Continue for other fields

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle the case where the user is not found
        die("User not found");
    }
} else {
    die("Something went wrong");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user information based on form data
    $updatedFirstName = $_POST["firstname"];
    $updatedMiddleName = $_POST["middlename"];
    $updatedLastName = $_POST["lastname"];
    $updatedAge = $_POST["age"];
    $updatedPhoneNum = $_POST["contact_number"];
    $updatedOccupation = $_POST["Occupation"];
    $updatedStreet = $_POST["Street"];
    $updatedCity = $_POST["City"];
    $updatedBarangay = $_POST["Barangay"];
    // ... Continue for other fields

    // Handle radio buttons
    $updatedSex = $_POST["Sex"];
    $updatedOwnedPet = $_POST["owned_pet"];

    //Handle calendar for DOB
    $updatedDoB = $_POST["date_of_birth"];

    // Update the database with the new information
    $updateSql = "UPDATE $table SET FIRST_NAME=?, MIDDLE_NAME=?, LAST_NAME=?, AGE=?, PHONE_NUMBER=?, OCCUPATION=?, STREET=?, CITY=?, BARANGAY=?, SEX=?, OWNED_PET=?, DATE_OF_BIRTH=? WHERE email=?";
    $updateStmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($updateStmt, $updateSql)) {
        mysqli_stmt_bind_param($updateStmt, "sssssssssssss", $updatedFirstName, $updatedMiddleName, $updatedLastName, $updatedAge, $updatedPhoneNum, $updatedOccupation, $updatedStreet, $updatedCity, $updatedBarangay, $updatedSex, $updatedOwnedPet, $updatedDoB, $email);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        // Redirect back to account.php or any other page
        header("Location: account.php");
        exit();
    } else {
        die("Update failed");
    }
}

// Close database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>
    
    <link rel="stylesheet" href="account.css">
    <title>Account</title>
</head>
<body onload=display_ct();>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand fs-1 text-uppercase" id href="#"><img src="petLogo.png" alt="LOGO" id="logo">Pet Adoption</a>

    <!-- Navbar -->
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item d-flex flex-column" style="display: inline-flex; justify-content: center; align-items: right;">
                    <!-- displays currently logged in user's first name -->
                    <span style="padding-right: 15px;" class="fs-4 fw-bold text-white">
                    Welcome, <?php echo ucfirst($_SESSION['FIRST_NAME']);?>
                    </span>
                    
                    <span id='ct7' class="text-white" style="background-color: none"></span>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu"> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-pic">
                        <img src="https://source.unsplash.com/250x250?girl" alt="Profile Picture">
                    </div>

                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="account.php"><i class="fas fa-sliders-h fa-fw"></i>Account</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-fw"></i>Log Out</a></li>
                      </ul>
                </li>
            </ul>

    </div>
  </nav>
        
        <div class="container" style="padding: 10px; margin-top: 10px;">
            <h1>Edit Profile</h1>
              <hr>
            <div class="row-cols-lg-1">
              <!-- left column -->
              <div class="col-md-3">
                <div class="text-center">
                  <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                  <h6 class="mt-3 mb-3">Upload a different photo...</h6>
                  
                  <input type="file" class="form-control">
                </div>
              </div>
              
              <!-- edit form column -->
              <div class="col-md-10 personal-info">
                <div class="alert alert-info alert-dismissable mt-3">
                  <a class="panel-close close" data-dismiss="alert" style="text-decoration: none; float: right;" id="close">×</a> 
                  <i class="fa fa-exclamation-circle" style="color: red;"></i>
                    Please fill out information.
                </div>
                <h3 style="padding-bottom: 10px; padding-top: 10px;">Personal Information</h3>
                
                <form class="form-horizontal" role="form" form action="account.php" method="Post" style="font-size: 15px;">
                <div class="form-group row">
                  <label class="col-lg-2 control-label">First name:</label>
                  <div class="col-lg-2">

                  <!-- Display FIRST_NAME depending on current user -->
                      <input class="form-control" type="text" value="<?php echo $firstName; ?>" name="firstname" style="font-size: 15px;">
                  </div>

                  <label class="col-lg-2 control-label">Middle name:</label>
                  <div class="col-lg-2">
                    <!-- Display MIDDLE_NAME depending on current user -->
                      <input class="form-control" type="text" value="<?php echo $middleName; ?>" name="middlename" style="font-size: 15px;">
                  </div>

                  <label class="col-lg-2 control-label">Last name:</label>
                  <div class="col-lg-2">
                      <input class="form-control" type="text" value="<?php echo $lastName; ?>" name="lastname" style="font-size: 15px;">
                  </div>
              </div>

                  <div class="form-group row">
                    <label class="col-lg-2 control-label">Age:</label>
                    <div class="col-lg-2">
                    <input class="form-control" type="text" id="age" name="age" value="<?php echo $user["AGE"]; ?>" style="font-size: 15px;">
                    </div>

                    <label class="col-lg-2 control-label">Contact Number:</label>
                    <div class="col-lg-2">
                    <input class="form-control" type="text" name="contact_number" value="<?php echo $user["PHONE_NUMBER"]; ?>" style="font-size: 15px;">
                    </div>

                    <label class="col-lg-2 control-label">Email Address:</label>
                    <div class="col-lg-2">
                    <input class="form-control" type="text" placeholder="jdcruz@gmail.com" value="<?php echo $email; ?>" name="email" style="font-size: 15px;">
                    </div>

                  </div>

                  <div class="form-group row">
                  <label class="col-lg-2 control-label">Date of Birth:</label>
                  <div class="col-lg-2">
                  <input class="form-control" type="date" id="date_of_birth" name="date_of_birth" style="font-size: 15px;" value="<?php echo $user["DATE_OF_BIRTH"]; ?>">

                  </div>

                    <label class="col-lg-2 control-label">Occupation:</label>
                    <div class="col-lg-2">
                      <input class="form-control" type="text" name="Occupation" value="<?php echo $user["OCCUPATION"]; ?>" style="font-size: 15px;">
                    </div>

                    <label class="col-lg-2 control-label">Owned a pet before?</label>
                    <div class="col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="owned_pet" id="owned_yes" value="Yes" style="font-size: 15px;" <?php echo ($user["OWNED_PET"] === "Yes") ? "checked" : ""; ?>>
                            <label class="form-check-label" for="owned_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="owned_pet" id="owned_no" value="No" style="font-size: 15px;" <?php echo ($user["OWNED_PET"] === "No") ? "checked" : ""; ?>>
                            <label class="form-check-label" for="owned_no">No</label>
                        </div>
                    </div>
                  </div>

                  

                <div class="form-group row">
                <label class="col-lg-2 control-label">Identification Number:</label>
                <div class="col-lg-2">
                    <?php
                    if ($userType === '1') { // Check if user type is staff
                        echo '<input class="form-control" type="text" name="identification_number" value="' . $user["STAFF_ID"] . '" style="font-size: 15px;" readonly>';
                    } elseif ($userType === '2') { // Check if user type is client
                        echo '<input class="form-control" type="text" name="identification_number" value="' . $user["CLIENT_ID"] . '" style="font-size: 15px;" readonly>';
                    } elseif ($userType === '3') { // Check if user type is volunteer
                        echo '<input class="form-control" type="text" name="identification_number" value="' . $user["VOLUNTEER_ID"] . '" style="font-size: 15px;" readonly>';
                    } else {
                        echo 'Invalid user type';
                    }
                    ?>
                </div>


                    <label class="col-lg-2 control-label">Sex:</label>
                    <div class="col-lg-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Sex" id="sex1" value="Male" style="font-size: 15px;" <?php echo ($user["SEX"] === "Male") ? "checked" : ""; ?>>
                            <label class="form-check-label" for="sex1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="Sex" id="sex2" value="Female" style="font-size: 15px;" <?php echo ($user["SEX"] === "Female") ? "checked" : ""; ?>>
                            <label class="form-check-label" for="sex2">Female</label>
                        </div>
                    </div>


                    <label class="col-lg-2 control-label" style="display: hidden;"></label>
                    <div class="col-lg-2">
                    <input class="form-control" type="text" name="salary" style="font-size: 15px; display: none;">
                    </div>

                    
                </div>
                <hr>

                    
                <h3 style="padding-bottom: 10px; padding-top: 10px;">Address</h3>

                    <div class="form-group row">
                        <label class="col-lg-2 control-label">City:</label>
                        <div class="col-lg-2">
                        <input class="form-control" type="text" name="City" value="<?php echo $user["CITY"]; ?>" placeholder="Manila">
                        </div>

                        <label class="col-lg-2 control-label">Street:</label>
                        <div class="col-lg-2">
                        <input class="form-control" type="text" name="Street" value="<?php echo $user["STREET"]; ?>" placeholder="Sampaloc Street">
                        </div>

                        <label class="col-lg-2 control-label">Barangay:</label>
                        <div class="col-lg-2">
                        <input class="form-control" type="text" name="Barangay" value="<?php echo $user["BARANGAY"]; ?>" placeholder="Tondo">
                        </div>
                    </div>
                    <hr>
                    
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="container mt-1">
                       <button type="submit" name="update" value="Update" class="btn btn-primary mr-2">Save Changes</button>
                       <?php
                            $cancelLink = ($userType === '1' || $userType === '3') ? "homeAdminVol.php" : "home.php";
                        ?>
                        <a href="<?php echo $cancelLink; ?>" class="btn btn-secondary">Cancel</a>

                    </div>
                  </div>
                </form>
              </div>
          </div>
        </div>
   
</body>

<!-- JS for live clock and date -->
<script src="liveclock.js"></script>

<!-- JS for profile pic drop down, to account, settings, and logout -->
<script src="account-dropdown"></script>

<script>
                    // Function to calculate age based on date of birth
                    function calculateAge(dateOfBirth) {
                        const today = new Date();
                        const dob = new Date(dateOfBirth);
                        let age = today.getFullYear() - dob.getFullYear();
                        const month = today.getMonth() - dob.getMonth();

                        if (month < 0 || (month === 0 && today.getDate() < dob.getDate())) {
                            age--;
                        }

                        return age;
                    }

                    // Function to update age field based on the selected date of birth
                    function updateAgeField() {
                        const dateOfBirth = document.getElementById("date_of_birth").value;
                        const ageField = document.getElementById("age");
                        const age = calculateAge(dateOfBirth);
                        ageField.value = age;
                    }

                    // Event listener for date input change
                    document.getElementById("date_of_birth").addEventListener("input", updateAgeField);

                    // Initial calculation on page load
                    updateAgeField();
                </script>
</html>