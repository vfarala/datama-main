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

// Initialize variables for form data
$speciesId = isset($_POST['speciesId']) ? $_POST['speciesId'] : '';
$speciesName = isset($_POST['speciesName']) ? $_POST['speciesName'] : '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["speciesSave"])) {
        // Insert operation
        if (!empty($speciesName)) {
            // Check if the species name already exists in the database
            $checkSql = "SELECT * FROM TBL_SPECIES WHERE SPECIES_NAME = ?";
            $stmt = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($stmt, "s", $speciesName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "Error: Species name already exists.";
            } else {
                // Insert data into TBL_SPECIES table
                $insertSql = "INSERT INTO TBL_SPECIES (SPECIES_NAME, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "sss", $speciesName, $email, $email);
                if (mysqli_stmt_execute($stmtInsert)) {
                    $message = "New record created successfully.";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmtInsert);
            }
            mysqli_stmt_close($stmt);
        } else {
            $message = "Error: Species name is required.";
        }
    } elseif (isset($_POST["speciesUpdate"])) {
        // Update operation
        if (!empty($speciesId) && !empty($speciesName)) {
            // Update data in TBL_SPECIES table
            $updateSql = "UPDATE TBL_SPECIES SET SPECIES_NAME = ?, MODIFIED_BY = ? WHERE SPECIES_ID = ?";
            $stmtUpdate = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($stmtUpdate, "sss", $speciesName, $email, $speciesId);
            if (mysqli_stmt_execute($stmtUpdate)) {
                $message = "Record updated successfully.";
            } else {
                $message = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmtUpdate);
        } else {
            $message = "Error: Species ID and name are required.";
        }
    } elseif (isset($_POST["speciesDelete"])) {
        // Delete operation
        if (!empty($speciesId) && !empty($speciesName)) {
            // Check if the provided species name matches the species ID
            $checkSql = "SELECT * FROM TBL_SPECIES WHERE SPECIES_ID = ? AND SPECIES_NAME = ?";
            $stmtCheck = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($stmtCheck, "ss", $speciesId, $speciesName);
            mysqli_stmt_execute($stmtCheck);
            mysqli_stmt_store_result($stmtCheck);
            
            if (mysqli_stmt_num_rows($stmtCheck) > 0) {
                // If the species ID and name match, proceed with deletion
                $deleteSql = "DELETE FROM TBL_SPECIES WHERE SPECIES_ID = ?";
                $stmtDelete = mysqli_prepare($conn, $deleteSql);
                mysqli_stmt_bind_param($stmtDelete, "s", $speciesId);
                
                if (mysqli_stmt_execute($stmtDelete)) {
                    $message = "Record deleted successfully.";
                } else {
                    $message = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmtDelete);
            } else {
                // If species ID and name do not match, inform the user
                $message = "Error: Species ID and Name do not match.";
            }
            
            mysqli_stmt_close($stmtCheck);
        } elseif (empty($speciesId) && empty($speciesName)) {
            $message = "Error: Species ID and name are required.";
        } elseif (empty($speciesId)) {
            $message = "Error: Please select a Species ID.";
        } elseif (empty($speciesName)) {
            $message = "Error: Please enter the Species Name.";
        }
    }
}

// Fetch data from the database for display
$sql = "SELECT * FROM TBL_SPECIES";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <a class="nav-link active text-white fs-5 text-center flex-column flex-grow-1" href="petDatabase.php">Pet Database</a>
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
                <li class="breadcrumb-item"><a href="#" class="text-white" style="text-decoration: none;">Admin</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-white" style="text-decoration: none;">Main Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-white" style="text-decoration: none;">Pet Database</a></li>
            </ol>
        </nav>
    </header>

<!-- Tabbed Navigation -->
<ul class="nav nav-tabs justify-content-center"> <!-- Added 'justify-content-center' class to center align items -->
    <li class="nav-item" style="width: 25%; text-align: center;">
        <a class="nav-link active" id="species-tab" data-bs-toggle="tab" href="#species" role="tab" aria-controls="species" aria-selected="true">Species</a>
    </li>
    <li class="nav-item" style="width: 25%; text-align: center;">
        <a class="nav-link" id="breed-tab" data-bs-toggle="tab" href="#breed" role="tab" aria-controls="breed" aria-selected="false">Breed</a>
    </li>
    <li class="nav-item" style="width: 25%; text-align: center;">
        <a class="nav-link" id="pet-tab" data-bs-toggle="tab" href="#pet" role="tab" aria-controls="pet" aria-selected="false">Pet</a>
    </li>
    <li class="nav-item" style="width: 25%; text-align: center;">
        <a class="nav-link" id="pet-records-tab" data-bs-toggle="tab" href="#pet-records" role="tab" aria-controls="pet-records" aria-selected="false">Pet Records</a>
    </li>
</ul>




    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab for TBL_SPECIES -->
        <div class="tab-pane fade show active" id="species" role="tabpanel" aria-labelledby="species-tab">
        <!-- TBL_SPECIES Form -->
        <div class="container p-lg-5">
        <h4>TBL_SPECIES Form</h4>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bg-white p-4 rounded-4">

            <!-- Display message here -->
            <div id="message">
            <?php if (isset($message)) : ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            </div>
                    <div class="row mb-3">
                        <label for="speciesId" class="col-sm-2 col-form-label">Species ID</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="speciesId" name="speciesId">
                                <option selected disabled>Select Species ID</option>
                                <?php
                                // Fetch species data from the database
                                $sql = "SELECT * FROM TBL_SPECIES";
                                $result = mysqli_query($conn, $sql);

                                // Check if there are any rows returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Loop through each row and populate the select options
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Check if the species ID matches the saved species ID
                                        $selected = ($row['SPECIES_ID'] == $speciesId) ? 'selected' : '';
                                        echo '<option value="' . $row['SPECIES_ID'] . '" ' . $selected . '>' . $row['SPECIES_ID'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="speciesName" class="col-sm-2 col-form-label">Species Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="speciesName" name="speciesName" placeholder="Enter Species Name" value="<?php echo isset($_POST['speciesName']) ? $_POST['speciesName'] : ''; ?>">
                        </div>
                    </div>
                    <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
                    <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">
                    <div class="row mb-3">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" name="speciesSave">Submit</button>
                            <button type="submit" class="btn btn-success" name="speciesUpdate">Update</button>
                            <!-- Delete button -->
                            <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                                <button type="submit" class="btn btn-danger" name="speciesDelete">Delete</button>
                            <?php else : ?>
                                <button type="button" class="btn btn-danger" disabled>Delete</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- TBL_SPECIES Table -->
            <div class="container ps-5 pe-5 pb-5">
                <h4>TBL_SPECIES Table</h4>
                <table class="table">
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
        </div>
        <?php
// Include the database connection file
include_once "database.php";

// Initialize variables for form data
$breedId = isset($_POST['breedId']) ? $_POST['breedId'] : '';
$breedName = isset($_POST['breedName']) ? $_POST['breedName'] : '';
$speciesId = isset($_POST['speciesId']) ? $_POST['speciesId'] : '';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["breedSave"])) {
        // Insert operation
        if (!empty($breedName) && !empty($speciesId)) {
            // Check if the breed name already exists in the database
            $checkSql = "SELECT * FROM TBL_BREED WHERE BREED_NAME = ?";
            $stmt = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($stmt, "s", $breedName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $breedMessage = "Error: Breed name already exists.";
            } else {
                // Insert data into TBL_BREED table
                $insertSql = "INSERT INTO TBL_BREED (BREED_NAME, SPECIES_ID, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmtInsert, "ssss", $breedName, $speciesId, $email, $email);
                if (mysqli_stmt_execute($stmtInsert)) {
                    $breedMessage = "New record created successfully.";
                } else {
                    $breedMessage = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmtInsert);
            }
            mysqli_stmt_close($stmt);
        } else {
            $breedMessage = "Error: Breed name and species ID are required.";
        }
    } elseif (isset($_POST["breedUpdate"])) {
        // Update operation
        if (!empty($breedId) && !empty($breedName) && !empty($speciesId)) {
            // Update data in TBL_BREED table
            $updateSql = "UPDATE TBL_BREED SET BREED_NAME = ?, SPECIES_ID = ?, MODIFIED_BY = ? WHERE BREED_ID = ?";
            $stmtUpdate = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($stmtUpdate, "ssss", $breedName, $speciesId, $email, $breedId);
            if (mysqli_stmt_execute($stmtUpdate)) {
                $breedMessage = "Record updated successfully.";
            } else {
                $breedMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmtUpdate);
        } else {
            $breedMessage = "Error: Breed ID, name, and species ID are required.";
        }
    } elseif (isset($_POST["breedDelete"])) {
        // Delete operation
        if (!empty($breedId) && !empty($breedName) && !empty($speciesId)) {
            // Delete data from TBL_BREED table
            $deleteSql = "DELETE FROM TBL_BREED WHERE BREED_ID = ? AND BREED_NAME = ? AND SPECIES_ID = ?";
            $stmtDelete = mysqli_prepare($conn, $deleteSql);
            mysqli_stmt_bind_param($stmtDelete, "sss", $breedId, $breedName, $speciesId);
            if (mysqli_stmt_execute($stmtDelete)) {
                $breedMessage = "Record deleted successfully.";
            } else {
                $breedMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmtDelete);
        } else {
            $breedMessage = "Error: Breed ID, name, and species ID are required.";
        }
    }
}
?>
       

        <!-- Tab for TBL_BREED -->
    <div class="tab-pane fade" id="breed" role="tabpanel" aria-labelledby="breed-tab">
        <!-- TBL_BREED Form -->
        <div class="container p-lg-5">
            <h4>TBL_BREED Form</h4>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bg-white p-4 rounded-4">

            <!-- Display message here -->
            <div id="breedMessage">
                <?php if (isset($breedMessage)) : ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $breedMessage; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row mb-3">
                <label for="breedId" class="col-sm-2 col-form-label">Breed ID</label>
                <div class="col-sm-10">
                    <select class="form-select" id="breedId" name="breedId">
                        <option selected disabled>Select Breed ID</option>
                        <?php
                        // Fetch breed data from the database
                        $sql = "SELECT * FROM TBL_BREED";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any rows returned
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each row and populate the select options
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check if the breed ID matches the saved breed ID
                                $selected = ($row['BREED_ID'] == $breedId) ? 'selected' : '';
                                echo '<option value="' . $row['BREED_ID'] . '" ' . $selected . '>' . $row['BREED_ID'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="breedName" class="col-sm-2 col-form-label">Breed Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="breedName" name="breedName" placeholder="Enter Breed Name" value="<?php echo isset($_POST['breedName']) ? $_POST['breedName'] : ''; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label for="speciesId" class="col-sm-2 col-form-label">Species</label>
                <div class="col-sm-10">
                    <select class="form-select" id="speciesId" name="speciesId">
                        <option selected disabled>Select Species</option>
                        <?php
                        // Fetch species data from the database
                        $sql = "SELECT * FROM TBL_SPECIES";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any rows returned
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each row and populate the select options
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check if the species ID matches the saved species ID
                                $selected = ($row['SPECIES_ID'] == $speciesId) ? 'selected' : '';
                                echo '<option value="' . $row['SPECIES_ID'] . '" ' . $selected . '>' . $row['SPECIES_NAME'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

            </div>

            <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
            <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">

            <div class="row mb-3">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="breedSave">Submit</button>
                    <button type="submit" class="btn btn-success" name="breedUpdate">Update</button>
                    <!-- Delete button -->
                    <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                        <button type="submit" class="btn btn-danger" name="breedDelete">Delete</button>
                    <?php else : ?>
                        <button type="button" class="btn btn-danger" disabled>Delete</button>
                    <?php endif; ?>
                </div>
            </div>
            </form>
        </div>

    <!-- TBL_BREED Table -->
    <div class="container ps-5 pe-5 pb-5">
        <h4>TBL_BREED Table</h4>
        <table class="table" style="">
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
</div>



    <?php
    // Include the database connection file
    include_once "database.php";

    // Initialize variables for form data
    $petId = isset($_POST['petId']) ? $_POST['petId'] : '';
    $petType = isset($_POST['petType']) ? $_POST['petType'] : '';
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
    $nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
    // Initialize $speciesId as empty initially
    $speciesId = '';
    $breedId = isset($_POST['breedId']) ? $_POST['breedId'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $weight = isset($_POST['weight']) ? $_POST['weight'] : '';
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $size = isset($_POST['size']) ? $_POST['size'] : '';
    $email; // Replace this with the logic to fetch the user's email
    $shelterId = isset($_POST['shelterId']) ? $_POST['shelterId'] : '';

    $petMessage = "";

    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Before handling the insert/update operations, fetch the SPECIES_ID based on the BREED_ID
        if (!empty($breedId)) {
            $breedSql = "SELECT SPECIES_ID FROM TBL_BREED WHERE BREED_ID = ?";
            $breedStmt = mysqli_prepare($conn, $breedSql);
            mysqli_stmt_bind_param($breedStmt, "i", $breedId);
            mysqli_stmt_execute($breedStmt);
            $breedResult = mysqli_stmt_get_result($breedStmt);
            if ($breedRow = mysqli_fetch_assoc($breedResult)) {
                $speciesId = $breedRow['SPECIES_ID'];
            }
            mysqli_stmt_close($breedStmt);
        }

        // INSERT operation
        if (isset($_POST["petSave"])) {
            // First check if pet with same first name, last name, and type exists
            $checkSql = "SELECT * FROM TBL_PET WHERE FIRST_NAME = ? AND LAST_NAME = ? AND PET_TYPE = ?";
            $checkStmt = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($checkStmt, "sss", $firstName, $lastName, $petType);
            mysqli_stmt_execute($checkStmt);
            $checkResult = mysqli_stmt_get_result($checkStmt);
            if ($existingPet = mysqli_fetch_assoc($checkResult)) {
                $petMessage = "Error: A pet with the same first name, last name, and type already exists.";
            } else {
                // If no existing pet, proceed with insert
                $insertSql = "INSERT INTO TBL_PET (PET_TYPE, FIRST_NAME, LAST_NAME, NICKNAME, SPECIES_ID, BREED_ID, AGE, WEIGHT, SEX, COLOR, SIZE, SHELTER_ID, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $insertSql);
                mysqli_stmt_bind_param($stmt, "ssssiiissssiss", $petType, $firstName, $lastName, $nickname, $speciesId, $breedId, $age, $weight, $sex, $color, $size, $shelterId, $email, $email);
                if (mysqli_stmt_execute($stmt)) {
                    $petMessage = "New pet record created successfully.";
                } else {
                    $petMessage = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_stmt_close($checkStmt);
        }
        

        // UPDATE operation
        if (isset($_POST["petUpdate"])) {
            // First check if pet with same first name, last name, and type exists
            $checkSql = "SELECT * FROM TBL_PET WHERE FIRST_NAME = ? AND LAST_NAME = ? AND PET_TYPE = ?";
            $checkStmt = mysqli_prepare($conn, $checkSql);
            mysqli_stmt_bind_param($checkStmt, "sss", $firstName, $lastName, $petType);
            mysqli_stmt_execute($checkStmt);
            $checkResult = mysqli_stmt_get_result($checkStmt);
            // Fetch the current pet's data
            $currentPet = mysqli_fetch_assoc($checkResult);
            // If there is no existing pet with the same details or the existing pet is the same as the one being updated
            if (!$currentPet || ($currentPet['PET_ID'] == $petId)) {
                // Update the record
                $updateSql = "UPDATE TBL_PET SET FIRST_NAME = ?, LAST_NAME = ?, NICKNAME = ?, SPECIES_ID = ?, BREED_ID = ?, AGE = ?, WEIGHT = ?, SEX = ?, COLOR = ?, SIZE = ?, SHELTER_ID = ?, PET_TYPE = ?, MODIFIED_BY = ? WHERE PET_ID = ?";
                $stmt = mysqli_prepare($conn, $updateSql);
                mysqli_stmt_bind_param($stmt, "ssssiiisssissi", $firstName, $lastName, $nickname, $speciesId, $breedId, $age, $weight, $sex, $color, $size, $shelterId, $petType, $email, $petId);
                if (mysqli_stmt_execute($stmt)) {
                    $petMessage = "Pet record updated successfully.";
                } else {
                    $petMessage = "Error: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $petMessage = "Error: A pet with the same first name, last name, and type already exists.";
            }
            mysqli_stmt_close($checkStmt);
        }


        // DELETE operation
        if (isset($_POST["petDelete"])) {
            $deleteSql = "DELETE FROM TBL_PET WHERE PET_ID = ?";
            $stmt = mysqli_prepare($conn, $deleteSql);
            mysqli_stmt_bind_param($stmt, "i", $petId);
            if (mysqli_stmt_execute($stmt)) {
                $petMessage = "Pet record deleted successfully.";
            } else {
                $petMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }

        // SELECT operation
        if (isset($_POST["select"])) {
            $selectSql = "SELECT * FROM TBL_PET WHERE PET_ID = ?";
            $stmt = mysqli_prepare($conn, $selectSql);
            mysqli_stmt_bind_param($stmt, "i", $petId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                // Assign fetched data to variables for form filling
                $firstName = $row['FIRST_NAME'];
                $lastName = $row['LAST_NAME'];
                $nickname = $row['NICKNAME'];
                $speciesId = $row['SPECIES_ID']; // Keep this after fetching pet details to maintain consistency
                $breedId = $row['BREED_ID'];
                $age = $row['AGE'];
                $weight = $row['WEIGHT'];
                $sex = $row['SEX'];
                $color = $row['COLOR'];
                $size = $row['SIZE'];
                $shelterId = $row['SHELTER_ID'];
            } else {
                $petMessage = "No pet found with the specified ID.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    ?>



    <!-- Tab for TBL_PET -->
    <div class="tab-pane fade" id="pet" role="tabpanel" aria-labelledby="pet-tab">
        <!-- TBL_PET Form -->
        <div class="container p-lg-5">
            <h4>TBL_PET Form</h4>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bg-white p-4 rounded-4">

                <!-- Display message here -->
                <div id="petMessage">
                    <?php if (!empty($petMessage)) : ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $petMessage; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row mb-3">
                    <label for="petId" class="col-sm-2 col-form-label">Pet ID</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="petId" name="petId">
                            <option selected disabled>Select Pet ID</option>
                            <?php
                            // Fetch pet data from the database
                            $sql = "SELECT * FROM TBL_PET";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and populate the select options
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the pet ID matches the saved pet ID
                                    $selected = ($row['PET_ID'] == $petId) ? 'selected' : '';
                                    echo '<option value="' . $row['PET_ID'] . '" ' . $selected . '>' . $row['PET_ID'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="petType" class="col-sm-2 col-form-label">Pet Type</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="petType" name="petType">
                            <option selected disabled>Select Pet Type</option>
                            <option value="Rescue" <?php echo isset($_POST['petType']) && $_POST['petType'] === 'Rescue' ? 'selected' : ''; ?>>Rescue</option>
                            <option value="Surrendered" <?php echo isset($_POST['petType']) && $_POST['petType'] === 'Surrendered' ? 'selected' : ''; ?>>Surrendered</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="firstName" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lastName" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="nickname" class="col-sm-2 col-form-label">Nickname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Enter Nickname" value="<?php echo isset($_POST['nickname']) ? $_POST['nickname'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="breedId" class="col-sm-2 col-form-label">Breed</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="breedId" name="breedId">
                            <option selected disabled>Select Breed</option>
                            <?php
                            // Fetch breed data from the database
                            $sql = "SELECT * FROM TBL_BREED";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and populate the select options
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the breed ID matches the saved breed ID
                                    $selected = ($row['BREED_ID'] == $breedId) ? 'selected' : '';
                                    echo '<option value="' . $row['BREED_ID'] . '" ' . $selected . '>' . $row['BREED_NAME'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="age" class="col-sm-2 col-form-label">Age</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter Age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="weight" class="col-sm-2 col-form-label">Weight (kg)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Enter Weight" value="<?php echo isset($_POST['weight']) ? $_POST['weight'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sex" class="col-sm-2 col-form-label">Sex</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="sex" name="sex">
                            <option selected disabled>Select Sex</option>
                            <option value="Male" <?php echo $sex === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $sex === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="color" class="col-sm-2 col-form-label">Color</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="color" name="color" placeholder="Enter Color" value="<?php echo isset($_POST['color']) ? $_POST['color'] : ''; ?>">
                    </div>
                </div>

                <div class="row mb-3">
                <label for="size" class="col-sm-2 col-form-label">Size</label>
                <div class="col-sm-10">
                    <select class="form-select" id="size" name="size">
                        <option selected disabled>Select Size</option>
                        <option value="small" <?php echo isset($_POST['size']) && $_POST['size'] == 'small' ? 'selected' : ''; ?>>Small</option>
                        <option value="medium" <?php echo isset($_POST['size']) && $_POST['size'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
                        <option value="large" <?php echo isset($_POST['size']) && $_POST['size'] == 'large' ? 'selected' : ''; ?>>Large</option>
                    </select>
                </div>

                
            </div>

            <div class="row mb-3">
                    <label for="shelterId" class="col-sm-2 col-form-label">Shelter</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="shelterId" name="shelterId">
                            <option selected disabled>Select Shelter</option>
                            <?php
                            // Fetch breed data from the database
                            $sql = "SELECT * FROM TBL_SHELTER";
                            $result = mysqli_query($conn, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                // Loop through each row and populate the select options
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Check if the breed ID matches the saved breed ID
                                    $selected = ($row['SHELTER_ID'] == $shelterId) ? 'selected' : '';
                                    echo '<option value="' . $row['SHELTER_ID'] . '" ' . $selected . '>' . $row['SHELTER_NAME'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
                <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">

                <div class="row mb-3">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary" name="petSave">Save</button>
                        <button type="submit" class="btn btn-success" name="petUpdate">Update</button>
                        <!-- Delete button -->
                        <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                            <button type="submit" class="btn btn-danger" name="petDelete">Delete</button>
                        <?php else : ?>
                            <button type="button" class="btn btn-danger" disabled>Delete</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
<!-- TBL_PET Table -->
<div class="container ps-5 pe-5 pb-5">
    <h4>TBL_PET Table</h4>
    <table class="table">
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
                <th scope="col">Created By</th>
                <th scope="col">Modified By</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to fetch data from TBL_PET table with species and breed details, ordered by Pet ID in ascending order
            $sql = "SELECT p.PET_ID, p.PET_TYPE, p.FIRST_NAME, p.LAST_NAME, p.NICKNAME, s.SPECIES_NAME, b.BREED_NAME, p.AGE, p.WEIGHT, p.SEX, p.COLOR, p.SIZE, p.CREATED_BY, p.MODIFIED_BY 
                    FROM TBL_PET p 
                    INNER JOIN TBL_SPECIES s ON p.SPECIES_ID = s.SPECIES_ID 
                    INNER JOIN TBL_BREED b ON p.BREED_ID = b.BREED_ID
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
                    //echo "<td>" . $row['SHELTER_ID'] . "</td>";
                    echo "<td>" . $row['CREATED_BY'] . "</td>";
                    echo "<td>" . $row['MODIFIED_BY'] . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no rows returned, display a message
                echo "<tr><td colspan='15'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


</div>










<?php
// Include the database connection file
include_once "database.php";

// Initialize variables for form data
$petId = isset($_POST['petId']) ? $_POST['petId'] : '';
$lastMedExam = isset($_POST['lastMedExam']) ? $_POST['lastMedExam'] : '';
$vaccinationStatus = $_POST['vaccinationStatus'] ?? ''; // Set default value to empty string if key is not set
$medications = isset($_POST['medications']) ? $_POST['medications'] : '';
$medicalNotes = isset($_POST['medicalNotes']) ? $_POST['medicalNotes'] : '';
$email; // Replace this with the logic to fetch the user's email

$recordMessage = "";

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if medications field is empty and set it to "None" if so
    if (empty($medications)) {
        $medications = "None";
    }
    // Check if medicalNotes field is empty and set it to "None" if so
    if (empty($medicalNotes)) {
        $medicalNotes = "None";
    }

    // INSERT operation
    if (isset($_POST["recordSave"])) {
        // Check if there is a row where PET_ID exists
        $checkSql = "SELECT * FROM TBL_RECORDS WHERE PET_ID = ?";
        $checkStmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($checkStmt, "i", $petId);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        if ($existingRecord = mysqli_fetch_assoc($checkResult)) {
            $recordMessage = "Error: A record with the same pet ID already exists.";
        } else {
            // If no existing record, proceed with insert
            $insertSql = "INSERT INTO TBL_RECORDS (PET_ID, LAST_MED_EXAM, VACCINATION_STAT, MEDICATIONS, MEDICAL_NOTES, CREATED_BY, MODIFIED_BY) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "issssss", $petId, $lastMedExam, $vaccinationStatus, $medications, $medicalNotes, $email, $email);
            if (mysqli_stmt_execute($stmt)) {
                $recordMessage = "New record created successfully.";
            } else {
                $recordMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_stmt_close($checkStmt);
    }

    // UPDATE operation
    if (isset($_POST["recordUpdate"])) {
        // Require the PET_ID
        if (empty($petId)) {
            $recordMessage = "Error: Pet ID is required for update operation.";
        } else {
            // Update the record
            $updateSql = "UPDATE TBL_RECORDS SET LAST_MED_EXAM = ?, VACCINATION_STAT = ?, MEDICATIONS = ?, MEDICAL_NOTES = ?, MODIFIED_BY = ? WHERE PET_ID = ?";
            $stmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($stmt, "sssssi", $lastMedExam, $vaccinationStatus, $medications, $medicalNotes, $email, $petId);
            if (mysqli_stmt_execute($stmt)) {
                $recordMessage = "Record updated successfully.";
            } else {
                $recordMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }

    // DELETE operation
    if (isset($_POST["recordDelete"])) {
        // Require the PET_ID
        if (empty($petId)) {
            $recordMessage = "Error: Pet ID is required for delete operation.";
        } else {
            // Delete the record
            $deleteSql = "DELETE FROM TBL_RECORDS WHERE PET_ID = ?";
            $stmt = mysqli_prepare($conn, $deleteSql);
            mysqli_stmt_bind_param($stmt, "i", $petId);
            if (mysqli_stmt_execute($stmt)) {
                $recordMessage = "Record deleted successfully.";
            } else {
                $recordMessage = "Error: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>




<!-- Tab for TBL_RECORDS -->
<div class="tab-pane fade" id="pet-records" role="tabpanel" aria-labelledby="pet-records-tab">
    <!-- TBL_RECORDS Form -->
    <div class="container p-lg-5">
        <h4>Pet Records Form</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="bg-white p-4 rounded-4">

            <!-- Display message here -->
            <div id="recordMessage">
            <?php if (isset($recordMessage)) : ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $recordMessage; ?>
                </div>
            <?php endif; ?>



            <div class="row mb-3">
                <label for="recordId" class="col-sm-2 col-form-label">Record ID</label>
                <div class="col-sm-10">
                    <select class="form-select" id="recordId" name="recordId">
                        <option selected disabled>Select Record ID</option>
                        <?php
                        // Fetch all record IDs from TBL_RECORDS
                        $sql = "SELECT RECORD_ID FROM TBL_RECORDS";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any rows returned
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each row and populate the select options
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check if the record ID matches the saved record ID
                                $selected = ($_POST['recordId'] == $row['RECORD_ID']) ? 'selected' : '';
                                echo '<option value="' . $row['RECORD_ID'] . '" ' . $selected . '>' . $row['RECORD_ID'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="petId" class="col-sm-2 col-form-label">Pet</label>
                <div class="col-sm-10">
                    <select class="form-select" id="petId" name="petId">
                        <option selected disabled>Select Pet ID</option>
                        <?php
                        // Fetch PET_ID along with first name and last name from TBL_PET
                        $sql = "SELECT PET_ID, FIRST_NAME, LAST_NAME FROM TBL_PET";
                        $result = mysqli_query($conn, $sql);

                        // Check if there are any rows returned
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through each row and populate the select options
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check if the pet ID matches the saved pet ID
                                $selected = ($_POST['petId'] == $row['PET_ID']) ? 'selected' : '';
                                echo '<option value="' . $row['PET_ID'] . '" ' . $selected . '>' . $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="row mb-3">
                <label for="lastMedExam" class="col-sm-2 col-form-label">Last Medical Exam</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="lastMedExam" name="lastMedExam" value="<?php echo isset($_POST['lastMedExam']) ? $_POST['lastMedExam'] : ''; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Vaccination Status</label>
                <div class="col-sm-10">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vaccinationStatus" id="vaccinated" value="Vaccinated" <?php echo (isset($_POST['vaccinationStatus']) && $_POST['vaccinationStatus'] == 'Vaccinated') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="vaccinated">
                            Vaccinated
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="vaccinationStatus" id="unvaccinated" value="Unvaccinated" <?php echo (isset($_POST['vaccinationStatus']) && $_POST['vaccinationStatus'] == 'Unvaccinated') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="unvaccinated">
                            Unvaccinated
                        </label>
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <label for="medications" class="col-sm-2 col-form-label">Medications</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="medications" name="medications" rows="3"><?php echo isset($_POST['medications']) ? $_POST['medications'] : ''; ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label for="medicalNotes" class="col-sm-2 col-form-label">Medical Notes</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="medicalNotes" name="medicalNotes" rows="3"><?php echo isset($_POST['medicalNotes']) ? $_POST['medicalNotes'] : ''; ?></textarea>
                </div>
            </div>
            <!-- Hidden fields for createdBy and modifiedBy -->
            <input type="hidden" name="createdBy" value="<?php echo $email; ?>">
            <input type="hidden" name="modifiedBy" value="<?php echo $email; ?>">
            <div class="row mb-3">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="recordSave">Submit</button>
                    <button type="submit" class="btn btn-success" name="recordUpdate">Update</button>
                    <!-- Delete button -->
                    <?php if ($userType !== '3') : ?> <!-- Check if user type is not equal to 'Volunteer' -->
                        <button type="submit" class="btn btn-danger" name="recordDelete">Delete</button>
                    <?php else : ?>
                        <button type="button" class="btn btn-danger" disabled>Delete</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- TBL_RECORDS Table -->
<div class="container ps-5 pe-5 pb-5">
    <h4>Pet Records Table</h4>
    <table class="table">
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





    </div>

    
    
</div>
                
</body>

<!-- JS for live clock and date -->
<script src="liveclock.js"></script>


<!-- JS for profile pic drop down, to account, settings, and logout -->
<script src="account-dropdown"></script>

</html>
