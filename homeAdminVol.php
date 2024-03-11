<?php
session_start();

// Check if the login flag is set
if (!isset($_SESSION["login_success"])) {
    header("Location: index.php");
    exit();
}

// Access user information
$email = $_SESSION["email"];
$userType = $_SESSION["usertype"];
$firstName = $_SESSION["FIRST_NAME"];

// Include the database connection file
include_once "database.php";

// Fetch data from the database
$sql = "SELECT * FROM TBL_SHELTER";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Query to count the total number of pets
$countSql = "SELECT COUNT(*) AS total_pets FROM TBL_PET";
$countResult = mysqli_query($conn, $countSql);
$countRow = mysqli_fetch_assoc($countResult);
$totalPets = $countRow['total_pets'];

// Query to count the total number of approved transactions
$countApprovedSql = "SELECT COUNT(*) AS total_approved FROM TBL_TRANSACTION WHERE ADOPTION_STATUS = 'Approved'";
$countApprovedResult = mysqli_query($conn, $countApprovedSql);
$countApprovedRow = mysqli_fetch_assoc($countApprovedResult);
$totalApproved = $countApprovedRow['total_approved'];

// Calculate the difference
$availablePets = $totalPets - $totalApproved;

// Count the total rows in TBL_CLIENT
$queryClients = "SELECT COUNT(*) AS totalClients FROM TBL_CLIENT";
$resultClients = mysqli_query($conn, $queryClients);
$rowClients = mysqli_fetch_assoc($resultClients);
$totalClients = $rowClients['totalClients'];

// Query to count the total number of adoption applications
$countAdoptionSql = "SELECT COUNT(*) AS total_applications FROM TBL_ADOPTION";
$countAdoptionResult = mysqli_query($conn, $countAdoptionSql);
$countAdoptionRow = mysqli_fetch_assoc($countAdoptionResult);
$totalApplications = $countAdoptionRow['total_applications'];


// Fetch the data into an associative array
$shelterData = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["save"])) {
        // Handle save operation
        // Check if the form fields are set and not empty
        if (!empty($_POST["shelterName"])) {
            $shelterName = $_POST["shelterName"];

            // Prepare the SQL statement to check for existing shelter name
            $checkExistingQuery = "SELECT * FROM TBL_SHELTER WHERE SHELTER_NAME = ?";
            $stmtCheckExisting = mysqli_prepare($conn, $checkExistingQuery);
            mysqli_stmt_bind_param($stmtCheckExisting, "s", $shelterName);
            mysqli_stmt_execute($stmtCheckExisting);
            mysqli_stmt_store_result($stmtCheckExisting);

            // If a record with the given shelter name already exists, display an error message
            if (mysqli_stmt_num_rows($stmtCheckExisting) > 0) {
                echo "Error: Shelter with name $shelterName already exists.";
            } else {
                // Record doesn't exist, proceed with insertion
                // Retrieve data from the form inputs
                $shelterDescription = $_POST["shelterDescription"];
                $phoneNumber = $_POST["phoneNumber"];
                $openingHour = $_POST["openingHour"];
                $closingHour = $_POST["closingHour"];
                $street = $_POST["street"];
                $city = $_POST["city"];
                $barangay = $_POST["barangay"];
                $createdBy = $_POST["createdBy"];
                $modifiedBy = $_POST["modifiedBy"];

                // Prepare the SQL statement for insertion
                $sql = "INSERT INTO TBL_SHELTER (SHELTER_NAME, SHELTER_DESCRIPTION, PHONE_NUMBER, OPENING_HOUR, CLOSING_HOUR, STREET, CITY, BARANGAY, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssssssss", $shelterName, $shelterDescription, $phoneNumber, $openingHour, $closingHour, $street, $city, $barangay, $createdBy, $modifiedBy);

                // Execute the statement
                mysqli_stmt_execute($stmt);

                // Check if the insertion was successful
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    echo "Data inserted successfully.";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            }

            // Close the statement for checking existing records
            mysqli_stmt_close($stmtCheckExisting);
        }

        // Redirect after saving
        header("Location: homeAdminVol.php?action=save");
        exit();
    } elseif (isset($_POST["update"])) {
        // Handle update operation
        // Check if the form fields are set and not empty
        if (!empty($_POST["shelterId"]) && !empty($_POST["shelterName"])) {
            // Retrieve data from the form inputs
            $shelterId = $_POST["shelterId"];
            $shelterName = $_POST["shelterName"];
            $shelterDescription = $_POST["shelterDescription"];
            $phoneNumber = $_POST["phoneNumber"];
            $openingHour = $_POST["openingHour"];
            $closingHour = $_POST["closingHour"];
            $street = $_POST["street"];
            $city = $_POST["city"];
            $barangay = $_POST["barangay"];
            $modifiedBy = $_POST["modifiedBy"];

            // Prepare the SQL statement for update
            $sql = "UPDATE TBL_SHELTER SET SHELTER_NAME=?, SHELTER_DESCRIPTION=?, PHONE_NUMBER=?, OPENING_HOUR=?, CLOSING_HOUR=?, STREET=?, CITY=?, BARANGAY=?, MODIFIED_BY=? WHERE SHELTER_ID=?";
            
            // Bind parameters and execute the statement
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssssss", $shelterName, $shelterDescription, $phoneNumber, $openingHour, $closingHour, $street, $city, $barangay, $modifiedBy, $shelterId);
            mysqli_stmt_execute($stmt);

            // Check if the update was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Data updated successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }

        // Redirect after updating
        header("Location: homeAdminVol.php?action=update");
        exit();
    } elseif (isset($_POST["delete"])) {
        // Handle delete operation
        // Check if the form field is set and not empty
        if (!empty($_POST["shelterId"])) {
            // Retrieve shelter ID from the form input
            $shelterId = $_POST["shelterId"];

            // Prepare the SQL statement for deletion
            $sql = "DELETE FROM TBL_SHELTER WHERE SHELTER_ID = ?";

            // Bind parameters and execute the statement
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $shelterId);
            mysqli_stmt_execute($stmt);

            // Check if the deletion was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Data deleted successfully.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }

        // Redirect after deleting
        header("Location: homeAdminVol.php?action=delete");
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
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
    <link rel="stylesheet" href="home.css">
    <title>Admin Access</title>
</head>
<style>
  nav > a {
    border-radius: 5px;
    margin: 10px;
    width: 170px !important;
  }

  nav > a:hover {
      color: black !important;
      font-weight: bold;
      background: #30AFB4;
  }

  nav > .active {
      color: black !important;
      font-weight: bold;
      background: #30AFB4;
  }
</style>
<body onload=display_ct(); style = "Overflow-X: hidden;">
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

  <!-- Navigation -->
  <nav class="nav justify-content-center d-flex align-items-center">
    <a class="nav-link text-white active fs-5 text-center flex-column flex-grow-1" href="homeAdminVol.php">Overview</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="petDatabase.php">Pet Database</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="adoptionProcess.php">Adoption Process</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="export.php">Reports and Analytics</a>
</nav>



    <!-- Content for Home -->
    <div class="container" style="background: #5CE1E6;">
        <header>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="fw-bold">Home</h3>
                <h4 class="fw-bold text-white">Pet Availables</h4>
            </div>                       
            <nav aria-label="breadcrumb" class="bg-transparent">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#" class = "text-white" style = "text-decoration: none;">Admin</a></li>
                  <li class="breadcrumb-item"><a href="#" class = "text-white" style = "text-decoration: none;">Main Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="#" class = "text-white" style = "text-decoration: none;">Home</a></li>
                </ol>
              </nav>
            
        </header>

        <div class="row row-cols-3 gx-2 p-4" >
            <div class="col">
                <div class="card">
                    <img src="corgi.png" class="card-img-top" alt="Cute Corgi">
                    <div class="card-body d-flex justify-content-between">
                        <span>Pets Available for Adoption</span>
                        <span><?php echo $availablePets; ?></span>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <img src="corgi.png" class="card-img-top" alt="Los Angeles Skyscrapers">
                    <div class="card-body d-flex justify-content-between">
                        <span>Total Adopters</span>
                        <span><?php echo $totalClients; ?></span>
                    </div>
                </div>
            </div>
 
            <div class="col">
                <div class="card">
                    <img src="corgi.png" class="card-img-top" alt="Cute Corgi">
                    <div class="card-body d-flex justify-content-between">
                        <span>Pending Adoption Applications</span>
                        <span><?php echo $totalApplications; ?></span>
                    </div>
                </div>
            </div>
 
        </div>

        <!-- FORM -->

        <div class="container p-lg-5">
        <form action="homeAdminVol.php" method="POST" class="bg-white p-4 rounded-4">
          <h1 class="pb-4">Shelter Information</h1>
          <!-- Display error or success messages here -->
          <?php if (!empty($errorMessage)) : ?>
              <div class="alert alert-danger" role="alert">
                  <?php echo $errorMessage; ?>
              </div>
          <?php endif; ?>
          <?php if (!empty($_GET['action']) && ($_GET['action'] == 'save')) : ?>
              <div class="alert alert-success" role="alert">
                  Data saved successfully.
              </div>
          <?php elseif (!empty($_GET['action']) && ($_GET['action'] == 'update')) : ?>
              <div class="alert alert-success" role="alert">
                  Data updated successfully.
              </div>
          <?php elseif (!empty($_GET['action']) && ($_GET['action'] == 'delete')) : ?>
              <div class="alert alert-success" role="alert">
                  Data deleted successfully.
              </div>
          <?php endif; ?>
                    
          <!-- Shelter ID -->
          <div class="row mb-3">
              <label for="shelterId" class="col-sm-2 col-form-label">Shelter ID</label>
              <div class="col-sm-10">
              <input type="text" class="form-control" id="shelterId" name="shelterId" value="<?php echo isset($shelterData[0]['SHELTER_ID']) ? $shelterData[0]['SHELTER_ID'] : ''; ?>" readonly>
              </div>
          </div>

          <!-- Shelter Name -->
          <div class="row mb-3">
              <label for="shelterName" class="col-sm-2 col-form-label">Shelter Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="shelterName" name="shelterName" value="<?php echo isset($shelterData[0]['SHELTER_NAME']) ? $shelterData[0]['SHELTER_NAME'] : ''; ?>">
              </div>
          </div>

          <!-- Shelter Description -->
          <div class="row mb-3">
              <label for="shelterDescription" class="col-sm-2 col-form-label">Shelter Description</label>
              <div class="col-sm-10">
                  <textarea class="form-control" id="shelterDescription" name="shelterDescription"><?php echo isset($shelterData[0]['SHELTER_DESCRIPTION']) ? $shelterData[0]['SHELTER_DESCRIPTION'] : ''; ?></textarea>
              </div>
          </div>

          <!-- Phone Number -->
          <div class="row mb-3">
              <label for="phoneNumber" class="col-sm-2 col-form-label">Phone Number</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?php echo isset($shelterData[0]['PHONE_NUMBER']) ? $shelterData[0]['PHONE_NUMBER'] : ''; ?>">
              </div>
          </div>

          <!-- Opening Hour and Closing Hour -->
          <div class="row mb-3">
              <label for="openingHour" class="col-sm-2 col-form-label">Opening Hour</label>
              <div class="col-sm-4">
                  <input type="time" class="form-control" id="openingHour" name="openingHour" value="<?php echo isset($shelterData[0]['OPENING_HOUR']) ? $shelterData[0]['OPENING_HOUR'] : ''; ?>">
              </div>

              <label for="closingHour" class="col-sm-2 col-form-label">Closing Hour</label>
              <div class="col-sm-4">
                  <input type="time" class="form-control" id="closingHour" name="closingHour" value="<?php echo isset($shelterData[0]['CLOSING_HOUR']) ? $shelterData[0]['CLOSING_HOUR'] : ''; ?>">
              </div>
          </div>

          <!-- Street -->
          <div class="row mb-3">
              <label for="street" class="col-sm-2 col-form-label">Street</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="street" name="street" value="<?php echo isset($shelterData[0]['STREET']) ? $shelterData[0]['STREET'] : ''; ?>">
              </div>
          </div>

          <!-- City -->
          <div class="row mb-3">
              <label for="city" class="col-sm-2 col-form-label">City</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($shelterData[0]['CITY']) ? $shelterData[0]['CITY'] : ''; ?>">
              </div>
          </div>

          <!-- Barangay -->
          <div class="row mb-3">
              <label for="barangay" class="col-sm-2 col-form-label">Barangay</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo isset($shelterData[0]['BARANGAY']) ? $shelterData[0]['BARANGAY'] : ''; ?>">
              </div>
          </div>



            <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
            <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">

            <button type="submit" class="btn btn-primary" name="save" <?php echo (count($shelterData) > 0) ? 'disabled title="Data already exists"' : ''; ?>>Save</button>
            <button type="submit" class="btn btn-success" name="update">Update</button>
            <!-- Delete button -->
            <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
            <?php else : ?>
                <button type="button" class="btn btn-danger" disabled>Delete</button>
            <?php endif; ?>

        </form>
        
    </div>
    <div class="ps-5 pe-5 pb-5">
            <!-- Table to display data -->
            <h3>TBL_SHELTER</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Shelter ID</th>
                        <th>Shelter Name</th>
                        <th>Shelter Description</th>
                        <th>Phone Number</th>
                        <th>Opening Hour</th>
                        <th>Closing Hour</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>Barangay</th>
                        <th>Created By</th>
                        <th>Modified By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Loop through the data and echo it in the table
                foreach ($shelterData as $row) {
                    echo "<tr>";
                    echo "<td>{$row['SHELTER_ID']}</td>";
                    echo "<td>{$row['SHELTER_NAME']}</td>";
                    echo "<td>{$row['SHELTER_DESCRIPTION']}</td>";
                    echo "<td>{$row['PHONE_NUMBER']}</td>";
                    echo "<td>{$row['OPENING_HOUR']}</td>";
                    echo "<td>{$row['CLOSING_HOUR']}</td>";
                    echo "<td>{$row['STREET']}</td>";
                    echo "<td>{$row['CITY']}</td>";
                    echo "<td>{$row['BARANGAY']}</td>";
                    echo "<td>{$row['CREATED_BY']}</td>";
                    echo "<td>{$row['MODIFIED_BY']}</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
      

    </div>
                
                
</body>

<!-- JS for live clock and date -->
<script src="liveclock.js"></script>


<!-- JS for profile pic drop down, to account, settings, and logout -->
<script src="account-dropdown"></script>

</html>