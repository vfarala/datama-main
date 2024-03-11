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

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["adoptionSave"])) {
        // Insert operation
        $petId = $_POST['petId'];
        $clientId = $_POST['clientId'];
        $clientFName = $_POST['clientFName'];
        $clientMName = $_POST['clientMName'];
        $clientLName = $_POST['clientLName'];
        $adoptionDate = $_POST['adoptionDate'];
        $adoptionFee = $_POST['adoptionFee'];
        $modeOfPayment = $_POST['modeOfPayment'];
        $adoptionStatus = 'Pending'; // Default status when adding new record

        // Check if any field is blank
        if (empty($petId) || empty($clientId) || empty($clientFName) || empty($clientMName) || empty($clientLName) || empty($adoptionDate) || empty($adoptionFee) || empty($modeOfPayment)) {
            $message = "Error: Please fill out all fields.";
        } else {
            // Check if the pet ID has an approved status in TBL_TRANSACTION
            $checkPetApprovedSql = "SELECT * FROM TBL_TRANSACTION WHERE PET_ID = ? AND ADOPTION_STATUS = 'Approved'";
            $stmtCheckPetApproved = mysqli_prepare($conn, $checkPetApprovedSql);
            mysqli_stmt_bind_param($stmtCheckPetApproved, "i", $petId);
            mysqli_stmt_execute($stmtCheckPetApproved);
            mysqli_stmt_store_result($stmtCheckPetApproved);

            if (mysqli_stmt_num_rows($stmtCheckPetApproved) > 0) {
                // Pet has an approved adoption status, do not proceed with insertion
                $message = "Error: This pet has already been successfully adopted.";
            } else {
                // Pet has not been adopted or was rejected before, proceed with insertion
                $insertSql = "INSERT INTO TBL_ADOPTION (PET_ID, CLIENT_ID, CLIENT_FNAME, CLIENT_MNAME, CLIENT_LNAME, ADOPTION_DATE, ADOPTION_FEE, MODE_OF_PAYMENT, ADOPTION_STATUS, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "iisssssssss", $petId, $clientId, $clientFName, $clientMName, $clientLName, $adoptionDate, $adoptionFee, $modeOfPayment, $adoptionStatus, $email, $email);

                if (mysqli_stmt_execute($stmtInsert)) {
                    $message = "Adoption application submitted successfully.";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmtInsert);
            }
            mysqli_stmt_close($stmtCheckPetApproved);
        }
    } elseif (isset($_POST["adoptionUpdate"])) {
        // Get the selected adoption ID
        $adoptionId = $_POST['adoptionId'];
        
        // Retrieve other form values
        $petId = $_POST['petId'];
        $clientId = $_POST['clientId'];
        $clientFName = $_POST['clientFName'];
        $clientMName = $_POST['clientMName'];
        $clientLName = $_POST['clientLName'];
        $adoptionDate = $_POST['adoptionDate'];
        $adoptionFee = $_POST['adoptionFee'];
        $modeOfPayment = $_POST['modeOfPayment'];
        $adoptionStatus = $_POST['adoptionStatus'];
    
        // Require the ADOPTION_ID
        if (empty($adoptionId)) {
            $message = "Error: Adoption ID is required for the update operation";
        } else {
            // Verify if the adoption ID exists
            $checkAdoptionSql = "SELECT * FROM TBL_ADOPTION WHERE ADOPTION_ID = ?";
            $stmtCheckAdoption = mysqli_prepare($conn, $checkAdoptionSql);
            mysqli_stmt_bind_param($stmtCheckAdoption, "i", $adoptionId);
            mysqli_stmt_execute($stmtCheckAdoption);
            mysqli_stmt_store_result($stmtCheckAdoption);
    
            if (mysqli_stmt_num_rows($stmtCheckAdoption) > 0) {
                // Adoption ID exists, proceed with the update
    
                // Verify client ID and associated name fields
                $checkClientSql = "SELECT * FROM TBL_CLIENT WHERE CLIENT_ID = ? AND FIRST_NAME = ? AND MIDDLE_NAME = ? AND LAST_NAME = ?";
                $stmtCheckClient = mysqli_prepare($conn, $checkClientSql);
                mysqli_stmt_bind_param($stmtCheckClient, "isss", $clientId, $clientFName, $clientMName, $clientLName);
                mysqli_stmt_execute($stmtCheckClient);
                mysqli_stmt_store_result($stmtCheckClient);
    
                if (mysqli_stmt_num_rows($stmtCheckClient) > 0) {
                    // Client ID and associated name fields match, proceed with the update
                    $updateSql = "UPDATE TBL_ADOPTION SET PET_ID = ?, CLIENT_ID = ?, CLIENT_FNAME = ?, CLIENT_MNAME = ?, CLIENT_LNAME = ?, ADOPTION_DATE = ?, ADOPTION_FEE = ?, MODE_OF_PAYMENT = ?, ADOPTION_STATUS = ? WHERE ADOPTION_ID = ?";
                    $stmtUpdate = mysqli_prepare($conn, $updateSql);
                    mysqli_stmt_bind_param($stmtUpdate, "iisssssssi", $petId, $clientId, $clientFName, $clientMName, $clientLName, $adoptionDate, $adoptionFee, $modeOfPayment, $adoptionStatus, $adoptionId);
                    if (mysqli_stmt_execute($stmtUpdate)) {
                        $message = "Application updated successfully.";
                    } else {
                        $message = "Error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmtUpdate);
                } else {
                    $message = "Error: Client ID and associated name fields do not match.";
                }
                mysqli_stmt_close($stmtCheckClient);
            } else {
                $message = "Error: Adoption ID does not exist.";
            }
            mysqli_stmt_close($stmtCheckAdoption);
        }
    } elseif (isset($_POST["adoptionDelete"])) {
        // Get the selected adoption ID
        $adoptionId = $_POST['adoptionId'];
        
        // Retrieve other form values
        $clientId = $_POST['clientId'];
        $clientFName = $_POST['clientFName'];
        $clientMName = $_POST['clientMName'];
        $clientLName = $_POST['clientLName'];
    
        // Verify if the adoption ID exists
        $checkAdoptionSql = "SELECT * FROM TBL_ADOPTION WHERE ADOPTION_ID = ?";
        $stmtCheckAdoption = mysqli_prepare($conn, $checkAdoptionSql);
        mysqli_stmt_bind_param($stmtCheckAdoption, "i", $adoptionId);
        mysqli_stmt_execute($stmtCheckAdoption);
        mysqli_stmt_store_result($stmtCheckAdoption);
    
        if (mysqli_stmt_num_rows($stmtCheckAdoption) > 0) {
            // Adoption ID exists, proceed with the delete operation
    
            // Verify client ID and associated name fields
            $checkClientSql = "SELECT * FROM TBL_CLIENT WHERE CLIENT_ID = ? AND FIRST_NAME = ? AND MIDDLE_NAME = ? AND LAST_NAME = ?";
            $stmtCheckClient = mysqli_prepare($conn, $checkClientSql);
            mysqli_stmt_bind_param($stmtCheckClient, "isss", $clientId, $clientFName, $clientMName, $clientLName);
            mysqli_stmt_execute($stmtCheckClient);
            mysqli_stmt_store_result($stmtCheckClient);
    
            if (mysqli_stmt_num_rows($stmtCheckClient) > 0) {
                // Client ID and associated name fields match, proceed with the delete operation
                $deleteSql = "DELETE FROM TBL_ADOPTION WHERE ADOPTION_ID = ?";
                $stmtDelete = mysqli_prepare($conn, $deleteSql);
                mysqli_stmt_bind_param($stmtDelete, "i", $adoptionId);
                if (mysqli_stmt_execute($stmtDelete)) {
                    $message = "Application deleted successfully.";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmtDelete);
            } else {
                $message = "Error: Client ID and associated name fields do not match.";
            }
            mysqli_stmt_close($stmtCheckClient);
        } else {
            $message = "Error: Adoption ID does not exist.";
        }
        mysqli_stmt_close($stmtCheckAdoption);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if approve or reject button was clicked
        if (isset($_POST['approve']) || isset($_POST['reject'])) {
            // Extract common information for both operations
            $adoptionId = $_POST['adoptionId'];
    
            // Determine the new status based on the action taken
            $newStatus = isset($_POST['approve']) ? 'Approved' : 'Rejected';
    
            // Fetch all necessary information from TBL_ADOPTION
            $selectSql = "SELECT * FROM TBL_ADOPTION WHERE ADOPTION_ID = ?";
            $stmtSelect = mysqli_prepare($conn, $selectSql);
            mysqli_stmt_bind_param($stmtSelect, "i", $adoptionId);
            mysqli_stmt_execute($stmtSelect);
            $result = mysqli_stmt_get_result($stmtSelect);
            $adoptionInfo = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmtSelect);
    
            if ($adoptionInfo) {
                // Insert into TBL_TRANSACTION with either 'Approved' or 'Rejected' status
                $insertSql = "INSERT INTO TBL_TRANSACTION (PET_ID, CLIENT_ID, CLIENT_FNAME, CLIENT_MNAME, CLIENT_LNAME, ADOPTION_DATE, ADOPTION_FEE, MODE_OF_PAYMENT, ADOPTION_STATUS, CREATED_BY, MODIFIED_BY)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "iisssssssss", $adoptionInfo['PET_ID'], $adoptionInfo['CLIENT_ID'], $adoptionInfo['CLIENT_FNAME'], $adoptionInfo['CLIENT_MNAME'], $adoptionInfo['CLIENT_LNAME'], $adoptionInfo['ADOPTION_DATE'], $adoptionInfo['ADOPTION_FEE'], $adoptionInfo['MODE_OF_PAYMENT'], $newStatus, $adoptionInfo['CREATED_BY'], $adoptionInfo['MODIFIED_BY']);
                mysqli_stmt_execute($stmtInsert);
                mysqli_stmt_close($stmtInsert);
    
                // Delete from TBL_ADOPTION since the record is either approved or rejected
                $deleteSql = "DELETE FROM TBL_ADOPTION WHERE ADOPTION_ID = ?";
                $stmtDelete = mysqli_prepare($conn, $deleteSql);
                mysqli_stmt_bind_param($stmtDelete, "i", $adoptionId);
                mysqli_stmt_execute($stmtDelete);
                mysqli_stmt_close($stmtDelete);
    
                $message = "Adoption application " . strtolower($newStatus) . ".";
            } else {
                $message = "Error: Adoption information not found.";
            }
        }
    }
    
    
    
    
    
}
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
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="homeAdminVol.php">Overview</a>
    <a class="nav-link text-white fs-5 text-center flex-column flex-grow-1" href="petDatabase.php">Pet Database</a>
    <a class="nav-link text-white active fs-5 text-center flex-column flex-grow-1" href="adoptionProcess.php">Adoption Process</a>
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
                  <li class="breadcrumb-item"><a href="#" class = "text-white" style = "text-decoration: none;">Adoption Process</a></li>
                </ol>
              </nav>
            
        </header>

     
    <!-- TBL_ADOPTION Form -->
    <div class="container p-lg-5">
        <h4>TBL_ADOPTION Form</h4>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bg-white p-4 rounded-4">

                <!-- Display message here -->
                <div id="message">
                    <?php if (isset($message)) : ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Adoption ID -->
                <div class="row mb-3">
                    <label for="adoptionId" class="col-sm-2 col-form-label">Adoption ID</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="adoptionId" name="adoptionId">
                            <option selected disabled>Select Adoption ID</option>
                            <?php
                            // Fetch adoption data from the database
                            $sql = "SELECT ADOPTION_ID FROM TBL_ADOPTION";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and populate the select options
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the adoption ID matches the saved adoption ID
                                    $selected = ($row['ADOPTION_ID'] == $adoptionId) ? 'selected' : '';
                                    echo '<option value="' . $row['ADOPTION_ID'] . '" ' . $selected . '>' . $row['ADOPTION_ID'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Pet ID -->
                <div class="row mb-3">
                    <label for="petId" class="col-sm-2 col-form-label">Pet</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="petId" name="petId">
                            <option selected disabled>Select Pet to Adopt</option>
                            <?php
                            // Fetch pet data from the database
                            $sql = "SELECT PET_ID, FIRST_NAME, LAST_NAME FROM TBL_PET";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and populate the select options
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Display the pet's first name and last name as the option value
                                    echo '<option value="' . $row['PET_ID'] . '">' . $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <!-- Client ID -->
                <div class="row mb-3">
                    <label for="clientId" class="col-sm-2 col-form-label">Client ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientId" name="clientId" placeholder="Enter Client ID" value="<?php echo isset($_POST['clientId']) ? $_POST['clientId'] : ''; ?>">
                    </div>
                </div>

                <!-- Client First Name -->
                <div class="row mb-3">
                    <label for="clientFName" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientFName" name="clientFName" placeholder="Enter First Name" value="<?php echo isset($_POST['clientFName']) ? $_POST['clientFName'] : ''; ?>">
                    </div>
                </div>

                <!-- Client Middle Name -->
                <div class="row mb-3">
                    <label for="clientMName" class="col-sm-2 col-form-label">Middle Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientMName" name="clientMName" placeholder="Enter Middle Name" value="<?php echo isset($_POST['clientMName']) ? $_POST['clientMName'] : ''; ?>">
                    </div>
                </div>

                <!-- Client Last Name -->
                <div class="row mb-3">
                    <label for="clientLName" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="clientLName" name="clientLName" placeholder="Enter Last Name" value="<?php echo isset($_POST['clientLName']) ? $_POST['clientLName'] : ''; ?>">
                    </div>
                </div>

                <!-- Adoption Date -->
                <div class="row mb-3">
                    <label for="adoptionDate" class="col-sm-2 col-form-label">Adoption Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="adoptionDate" name="adoptionDate" value="<?php echo isset($_POST['adoptionDate']) ? $_POST['adoptionDate'] : ''; ?>">
                    </div>
                </div>

                <!-- Adoption Fee -->
                <div class="row mb-3">
                    <label for="adoptionFee" class="col-sm-2 col-form-label">Adoption Fee</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="adoptionFee" name="adoptionFee" placeholder="Enter Adoption Fee" value="<?php echo isset($_POST['adoptionFee']) ? $_POST['adoptionFee'] : ''; ?>">
                    </div>
                </div>

                <!-- Mode of Payment -->
                <div class="row mb-3">
                    <label for="modeOfPayment" class="col-sm-2 col-form-label">Mode of Payment</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="modeOfPayment" name="modeOfPayment">
                            <option value="Cash" <?php if (isset($_POST['modeOfPayment']) && $_POST['modeOfPayment'] == 'Cash') echo 'selected'; ?>>Cash</option>
                            <option value="Credit Card" <?php if (isset($_POST['modeOfPayment']) && $_POST['modeOfPayment'] == 'Credit Card') echo 'selected'; ?>>Credit Card</option>
                            <option value="Debit Card" <?php if (isset($_POST['modeOfPayment']) && $_POST['modeOfPayment'] == 'Debit Card') echo 'selected'; ?>>Debit Card</option>
                            
                        </select>
                    </div>
                </div>


                <!-- Adoption Status -->
                <div class="row mb-3">
                    <label for="adoptionStatus" class="col-sm-2 col-form-label">Adoption Status</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="adoptionStatus" name="adoptionStatus">
                            <option value="Pending">Pending</option>
                            <option value="Approved" disabled>Approved</option>
                            <option value="Rejected" disabled>Rejected</option>
                        </select>
                    </div>
                </div>

                <!-- Additional fields can be added here -->

                <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
                <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">

                <div class="row mb-3">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="adoptionSave">Submit</button>
                        <button type="submit" class="btn btn-success" name="adoptionUpdate">Update</button>
                        <!-- Delete button -->
                        <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                            <button type="submit" class="btn btn-danger" name="adoptionDelete">Delete</button>
                        <?php else : ?>
                            <button type="button" class="btn btn-danger" disabled>Delete</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>


        <!-- TBL_ADOPTION Table -->
<div class="container ps-5 pe-5 pb-5">
    <h4>TBL_ADOPTION Table</h4>
    <table class="table">
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
                <th scope="col">Actions</th>
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
                    echo "<td>
                            <form action='".htmlspecialchars($_SERVER["PHP_SELF"])."' method='post' class='text-left'>
                                <input type='hidden' name='adoptionId' value='".$row['ADOPTION_ID']."'>
                                <button type='submit' name='approve' class='btn btn-success btn-sm' style='width:70px;'>Approve</button>
                                <button type='submit' name='reject' class='btn btn-danger btn-sm' style='width:70px;'>Reject</button>
                            </form>
                          </td>";
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
<div class="container ps-5 pe-5 pb-5">
    <h4>TBL_TRANSACTION Table</h4>
    <table class="table">
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
                
</body>

<!-- JS for live clock and date -->
<script src="liveclock.js"></script>


<!-- JS for profile pic drop down, to account, settings, and logout -->
<script src="account-dropdown"></script>

</html>