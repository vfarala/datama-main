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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.36/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.css"/>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.36/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Custom CSS -->
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
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="homeAdminVol.php">Overview</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="petDatabase.php">Pet Database</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="adoptionProcess.php">Adoption Process</a>
    <a class="nav-link text-white active fs-5 text-center flex-column flex-grow-1" href="export.php">Reports and Analytics</a>
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
                  <li class="breadcrumb-item"><a href="#" class = "text-white" style = "text-decoration: none;">Reports and Analytics</a></li>
                </ol>
              </nav>
            
        </header>

     <div class="container p-5">

        <!-- TBL_CLIENT Table -->
        <div class="container pb-4">
            <h4>Client Information</h4>
            <table class="table" id="clientTable">
                <thead>
                    <tr>
                        <th scope="col">Client ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Street</th>
                        <th scope="col">City</th>
                        <th scope="col">Barangay</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Age</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Occupation</th>
                        <th scope="col">Owned Pet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM TBL_CLIENT";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['CLIENT_ID'] . "</td>";
                            echo "<td>" . $row['FIRST_NAME'] . "</td>";
                            echo "<td>" . $row['MIDDLE_NAME'] . "</td>";
                            echo "<td>" . $row['LAST_NAME'] . "</td>";
                            echo "<td>" . $row['ROLE'] . "</td>";
                            echo "<td>" . $row['PHONE_NUMBER'] . "</td>";
                            echo "<td>" . $row['EMAIL'] . "</td>";
                            echo "<td>" . $row['STREET'] . "</td>";
                            echo "<td>" . $row['CITY'] . "</td>";
                            echo "<td>" . $row['BARANGAY'] . "</td>";
                            echo "<td>" . $row['SEX'] . "</td>";
                            echo "<td>" . $row['AGE'] . "</td>";
                            echo "<td>" . $row['DATE_OF_BIRTH'] . "</td>";
                            echo "<td>" . $row['OCCUPATION'] . "</td>";
                            echo "<td>" . $row['OWNED_PET'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='15'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_STAFF Table -->
<div class="container pb-4">
    <h4>Staff Information</h4>
    <table class="table" id="staffTable">
        <thead>
            <tr>
                <th scope="col">Staff ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Role</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Email</th>
                <th scope="col">Street</th>
                <th scope="col">City</th>
                <th scope="col">Barangay</th>
                <th scope="col">Sex</th>
                <th scope="col">Age</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Occupation</th>
                <th scope="col">Owned Pet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM TBL_STAFF";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['STAFF_ID'] . "</td>";
                    echo "<td>" . $row['FIRST_NAME'] . "</td>";
                    echo "<td>" . $row['MIDDLE_NAME'] . "</td>";
                    echo "<td>" . $row['LAST_NAME'] . "</td>";
                    echo "<td>" . $row['ROLE'] . "</td>";
                    echo "<td>" . $row['PHONE_NUMBER'] . "</td>";
                    echo "<td>" . $row['EMAIL'] . "</td>";
                    echo "<td>" . $row['STREET'] . "</td>";
                    echo "<td>" . $row['CITY'] . "</td>";
                    echo "<td>" . $row['BARANGAY'] . "</td>";
                    echo "<td>" . $row['SEX'] . "</td>";
                    echo "<td>" . $row['AGE'] . "</td>";
                    echo "<td>" . $row['DATE_OF_BIRTH'] . "</td>";
                    echo "<td>" . $row['OCCUPATION'] . "</td>";
                    echo "<td>" . $row['OWNED_PET'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='15'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- TBL_VOLUNTEER Table -->
<div class="container pb-4">
    <h4>Volunteer Information</h4>
    <table class="table" id="volunteerTable">
        <thead>
            <tr>
                <th scope="col">Volunteer ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Middle Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Role</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Email</th>
                <th scope="col">Street</th>
                <th scope="col">City</th>
                <th scope="col">Barangay</th>
                <th scope="col">Sex</th>
                <th scope="col">Age</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Occupation</th>
                <th scope="col">Owned Pet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM TBL_VOLUNTEER";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['VOLUNTEER_ID'] . "</td>";
                    echo "<td>" . $row['FIRST_NAME'] . "</td>";
                    echo "<td>" . $row['MIDDLE_NAME'] . "</td>";
                    echo "<td>" . $row['LAST_NAME'] . "</td>";
                    echo "<td>" . $row['ROLE'] . "</td>";
                    echo "<td>" . $row['PHONE_NUMBER'] . "</td>";
                    echo "<td>" . $row['EMAIL'] . "</td>";
                    echo "<td>" . $row['STREET'] . "</td>";
                    echo "<td>" . $row['CITY'] . "</td>";
                    echo "<td>" . $row['BARANGAY'] . "</td>";
                    echo "<td>" . $row['SEX'] . "</td>";
                    echo "<td>" . $row['AGE'] . "</td>";
                    echo "<td>" . $row['DATE_OF_BIRTH'] . "</td>";
                    echo "<td>" . $row['OCCUPATION'] . "</td>";
                    echo "<td>" . $row['OWNED_PET'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='15'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



        <!-- TBL_SHELTER -->
        <div class="pb-4">
            <h3>Shelter</h3>
            <table class="table" id="shelterTable">
                <thead>
                    <tr>
                        <th scope="col">Shelter ID</th>
                        <th scope="col">Shelter Name</th>
                        <th scope="col">Shelter Description</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Opening Hour</th>
                        <th scope="col">Closing Hour</th>
                        <th scope="col">Street</th>
                        <th scope="col">City</th>
                        <th scope="col">Barangay</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Modified By</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Query to fetch data from TBL_SPECIES table
                $sql = "SELECT * FROM TBL_SHELTER";
                $result = mysqli_query($conn, $sql);
                // Loop through the data and echo it in the table
                if (mysqli_num_rows($result) > 0 ) {
                    while ($row = mysqli_fetch_assoc($result)) {
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
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_SPECIES Table -->
        <div class="container pb-4">
            <h4>Species</h4>
            <table class="table" id="speciesTable">
                <thead>
                    <tr>
                        <th scope="col">Species ID</th>
                        <th scope="col">Species Name</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Modified By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_SPECIES table
                    $sql = "SELECT * FROM TBL_SPECIES";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['SPECIES_ID'] . "</td>";
                            echo "<td>" . $row['SPECIES_NAME'] . "</td>";
                            echo "<td>" . $row['CREATED_BY'] . "</td>";
                            echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='4'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_BREED Table -->
        <div class="container pb-4">
            <h4>Breeds</h4>
            <table id="breedTable" class="table">
                <thead>
                    <tr>
                        <th scope="col">Breed ID</th>
                        <th scope="col">Breed Name</th>
                        <th scope="col">Species</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Modified By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_BREED table with species name
                    $sql = "SELECT b.BREED_ID, b.BREED_NAME, s.SPECIES_NAME, b.CREATED_BY, b.MODIFIED_BY 
                            FROM TBL_BREED b 
                            INNER JOIN TBL_SPECIES s ON b.SPECIES_ID = s.SPECIES_ID";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['BREED_ID'] . "</td>";
                            echo "<td>" . $row['BREED_NAME'] . "</td>";
                            echo "<td>" . $row['SPECIES_NAME'] . "</td>"; // Display species name
                            echo "<td>" . $row['CREATED_BY'] . "</td>";
                            echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='5'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_PET Table -->
        <div class="container pb-4">
            <h4>Pets</h4>
            <table class="table" id="petTable">
                <thead>
                    <tr>
                        <th scope="col">Pet ID</th>
                        <th scope="col">Pet Type</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Nickname</th>
                        <th scope="col">Species</th>
                        <th scope="col">Breed</th>
                        <th scope="col">Age</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Sex</th>
                        <th scope="col">Color</th>
                        <th scope="col">Size</th>
                        <th scope="col">Shelter ID</th>
                        <th scope="col">Created By</th>
                        <th scope="col">Modified By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_PET table with species and breed details, ordered by Pet ID in ascending order
                    $sql = "SELECT p.PET_ID, p.PET_TYPE, p.FIRST_NAME, p.LAST_NAME, p.NICKNAME, s.SPECIES_NAME, b.BREED_NAME, p.AGE, p.WEIGHT, p.SEX, p.COLOR, p.SIZE, sh.SHELTER_ID, p.CREATED_BY, p.MODIFIED_BY 
                            FROM TBL_PET p 
                            INNER JOIN TBL_SPECIES s ON p.SPECIES_ID = s.SPECIES_ID 
                            INNER JOIN TBL_BREED b ON p.BREED_ID = b.BREED_ID
                            INNER JOIN TBL_SHELTER sh ON p.SHELTER_ID = sh.SHELTER_ID
                            ORDER BY p.PET_ID ASC";
                    
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['PET_ID'] . "</td>";
                            echo "<td>" . $row['PET_TYPE'] . "</td>"; // Display the pet type
                            echo "<td>" . $row['FIRST_NAME'] . "</td>";
                            echo "<td>" . $row['LAST_NAME'] . "</td>";
                            echo "<td>" . $row['NICKNAME'] . "</td>";
                            echo "<td>" . $row['SPECIES_NAME'] . "</td>";
                            echo "<td>" . $row['BREED_NAME'] . "</td>";
                            echo "<td>" . $row['AGE'] . "</td>";
                            echo "<td>" . $row['WEIGHT'] . "</td>";
                            echo "<td>" . $row['SEX'] . "</td>";
                            echo "<td>" . $row['COLOR'] . "</td>";
                            echo "<td>" . $row['SIZE'] . "</td>";
                            echo "<td>" . $row['SHELTER_ID'] . "</td>";
                            echo "<td>" . $row['CREATED_BY'] . "</td>";
                            echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='13'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_RECORDS Table -->
        <div class="container pb-4">
            <h4>Pet Records</h4>
            <table class="table" id="recordsTable">
                <thead>
                    <tr>
                        <th scope="col">Record ID</th>
                        <th scope="col">Pet Name</th>
                        <th scope="col">Last Medical Exam</th>
                        <th scope="col">Vaccination Status</th>
                        <th scope="col">Medications</th>
                        <th scope="col">Medical Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_RECORDS table joined with TBL_PET to get pet names
                    $sql = "SELECT r.RECORD_ID, p.FIRST_NAME, p.LAST_NAME, r.LAST_MED_EXAM, r.VACCINATION_STAT, r.MEDICATIONS, r.MEDICAL_NOTES
                            FROM TBL_RECORDS r
                            INNER JOIN TBL_PET p ON r.PET_ID = p.PET_ID";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['RECORD_ID'] . "</td>";
                            echo "<td>" . $row['FIRST_NAME'] . " " . $row['LAST_NAME'] . "</td>";
                            echo "<td>" . $row['LAST_MED_EXAM'] . "</td>";
                            echo "<td>" . $row['VACCINATION_STAT'] . "</td>"; // corrected column name
                            echo "<td>" . $row['MEDICATIONS'] . "</td>";
                            echo "<td>" . $row['MEDICAL_NOTES'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='6'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_ADOPTION Table -->
        <div class="container pb-4">
            <h4>Pending Applications for Adoption</h4>
            <table class="table" id="adoptionTable">
                <thead>
                    <tr>
                        <th scope="col">Adoption ID</th>
                        <th scope="col">Pet</th>
                        <th scope="col">Client ID</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Adoption Date</th>
                        <th scope="col">Adoption Fee</th>
                        <th scope="col">Mode of Payment</th>
                        <th scope="col">Adoption Status</th>
                        <!-- Hidden <th scope="col">Created By</th> -->
                        <!-- <th scope="col">Modified By</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_ADOPTION table along with associated pet's information
                    $sql = "SELECT A.ADOPTION_ID, A.PET_ID, A.CLIENT_ID, A.CLIENT_FNAME, A.CLIENT_MNAME, A.CLIENT_LNAME, 
                    A.ADOPTION_DATE, A.ADOPTION_FEE, A.MODE_OF_PAYMENT, A.ADOPTION_STATUS, 
                    A.CREATED_BY, A.MODIFIED_BY, 
                    CONCAT(P.FIRST_NAME, ' ', P.LAST_NAME) AS PET_NAME
                    FROM TBL_ADOPTION A
                    INNER JOIN TBL_PET P ON A.PET_ID = P.PET_ID";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['ADOPTION_ID'] . "</td>";
                            echo "<td>" . $row['PET_NAME'] . "</td>";
                            echo "<td>" . $row['CLIENT_ID'] . "</td>";
                            echo "<td>" . $row['CLIENT_FNAME'] . " " . $row['CLIENT_MNAME'] . " " . $row['CLIENT_LNAME'] . "</td>";
                            echo "<td>" . $row['ADOPTION_DATE'] . "</td>";
                            echo "<td>" . $row['ADOPTION_FEE'] . "</td>";
                            echo "<td>" . $row['MODE_OF_PAYMENT'] . "</td>";
                            echo "<td>" . $row['ADOPTION_STATUS'] . "</td>";
                            // Hidden echo "<td>" . $row['CREATED_BY'] . "</td>";
                            // Hidden echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                            // Add approve and reject buttons
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='12'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- TBL_TRANSACTION Table -->
        <div class="container pb-4">
            <h4>Transactions</h4>
            <table class="table" id="transactionTable">
                <thead>
                    <tr>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Pet</th>
                        <th scope="col">Client ID</th>
                        <th scope="col">Client Name</th>
                        <th scope="col">Adoption Date</th>
                        <th scope="col">Adoption Fee</th>
                        <th scope="col">Mode of Payment</th>
                        <th scope="col">Adoption Status</th>
                        <!-- Hidden <th scope="col">Created By</th> -->
                        <!-- <th scope="col">Modified By</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch data from TBL_TRANSACTION table
                    $sql = "SELECT T.TRANSACTION_ID, T.PET_ID, T.CLIENT_ID, T.CLIENT_FNAME, T.CLIENT_MNAME, T.CLIENT_LNAME, 
                    T.ADOPTION_DATE, T.ADOPTION_FEE, T.MODE_OF_PAYMENT, T.ADOPTION_STATUS, 
                    T.CREATED_BY, T.MODIFIED_BY,
                    CONCAT(P.FIRST_NAME, ' ', P.LAST_NAME) AS PET_NAME
                    FROM TBL_TRANSACTION T
                    INNER JOIN TBL_PET P ON T.PET_ID = P.PET_ID";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row and display the data in table rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['TRANSACTION_ID'] . "</td>";
                            echo "<td>" . $row['PET_NAME'] . "</td>";
                            echo "<td>" . $row['CLIENT_ID'] . "</td>";
                            echo "<td>" . $row['CLIENT_FNAME'] . " " . $row['CLIENT_MNAME'] . " " . $row['CLIENT_LNAME'] . "</td>";
                            echo "<td>" . $row['ADOPTION_DATE'] . "</td>";
                            echo "<td>" . $row['ADOPTION_FEE'] . "</td>";
                            echo "<td>" . $row['MODE_OF_PAYMENT'] . "</td>";
                            echo "<td>" . $row['ADOPTION_STATUS'] . "</td>";
                            // Hidden echo "<td>" . $row['CREATED_BY'] . "</td>";
                            // Hidden echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no rows returned, display a message
                        echo "<tr><td colspan='10'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
     </div>




    </div>
                
</body>

<!-- JS for live clock and date -->
<script src="liveclock.js"></script>

<!-- JS for profile pic drop down, to account, settings, and logout -->
<script src="account-dropdown"></script>

<!-- JavaScript libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables and its extensions -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.36/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/datatables.min.js"></script>
    
    <!-- Initialize DataTable with export buttons -->
    <script>
    $(document).ready(function() {
        $('#transactionTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#breedTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#speciesTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#petTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#recordsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#shelterTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#adoptionTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#clientTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#staffTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('#volunteerTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>

</html>