<?php

require("./functionality.php");
require_once("./settings.php");

try {
    $conn = new mysqli($host, $user, $pwd, $sql_db);
} catch (Exception $e) {
    set_data_response("error", 
    "Database Connection Error", 
    "Unable to connect to the database", 
    "Please check your database settings", 
    "The application could not connect to the database. Please ensure that the database server is running and the credentials are correct.", 
    "If the problem persists, contact support.");
    header("Location: ../apply.php");
    die();
}


$error = [];

$EOInumber = rand(1000, 9999);
$gender_input_map = ["Male", "Female"];
$job_reference_numbers_map = ["IT300", "IT240", "IT350", "IT090"];
$state_map = ["ACT", "VIC", "NSW", "QLD", "SA", "WA", "NT", "TAS"];
$technical_skills_map = ["Trouble Shooting", "Networking", "Hardware", "Software", "Security", "Database Management"];
$preferred_skills_map = ["Communication", "Teamwork", "Time Management", "Autonomous", "Fast Learner"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // ======================================= EXISTENCE VALIDATION ==========================================
    

        // ------------------------- Isset? -------------------------
            if (!isset($_POST["title"])) {
                $error[] = "No title field was submitted";
            }
            if (!isset($_POST["first_name_input"])) {
                $error[] = "No firstname field was submitted";
            }
            if (!isset($_POST["last_name_input"])) {
                $error[] = "No lastname field was submitted";
            }
            if (!isset($_POST["date"])) {
                $error[] = "No date field was submitted";
            }
            if (!isset($_POST["job_reference_number"])) {
                $error[] = "No job reference number field was submitted";
            }
            if (!isset($_POST["street_address"])) {
                $error[] = "No street address field was submitted";
            }
            if (!isset($_POST["suburb_town"])) {
                $error[] = "No suburb town field was submitted";
            }
            if (!isset($_POST["state"])) {
                $error[] = "No state field was submitted";
            }
            if (!isset($_POST["postcode"])) {
                $error[] = "No postcode field was submitted";
            }
            if (!isset($_POST['gender_input'])) {
                $error[] = "No gender field was submitted";
            }
            if (!isset($_POST["phone_number_input"])) {
                $error[] = "No phone field was submitted";
            }
            if (isset($_POST["technical_skills"])) {
                for ($i = 0; $i < count($_POST["technical_skills"]); $i++) {
                    if (!in_array($_POST["technical_skills"][$i], $technical_skills_map)) {
                        $error[] = "Invalid technical_skills: " . $_POST["technical_skills"][$i];
                    }
                }
            }
            if (isset($_POST["preferred_skills"])) {
                for ($i = 0; $i < count($_POST["preferred_skills"]); $i++) {
                    if (!in_array($_POST["preferred_skills"][$i], $preferred_skills_map)) {
                        $error[] = "Invalid preferred_skills: " . $_POST["preferred_skills"][$i];
                    }
                }
            }
            if (!isset($_POST["other_skills"])) {
                $error[] = "No other field was submitted";
            }
        

        // ------------------------- Empty -------------------------
            if (empty($_POST["title"])) {
                $error[] = "Title field is empty.";
            }
            if (empty($_POST["first_name_input"])) {
                $error[] = "Firstname field is empty.";
            }
            if (empty($_POST["last_name_input"])) {
                $error[] = "Lastname field is empty.";
            }
            if (empty($_POST["date"])) {
                $error[] = "Date field is empty.";
            }
            if (empty($_POST["job_reference_number"])) {
                $error[] = "Job reference number field is empty.";
            }
            if (empty($_POST["street_address"])) {
                $error[] = "Street address field is empty.";
            }
            if (empty($_POST["suburb_town"])) {
                $error[] = "Suburb town field is empty.";
            }
            if (empty($_POST["state"])) {
                $error[] = "State field is empty.";
            }
            if (empty($_POST["postcode"])) {
                $error[] = "Postcode field is empty.";
            }
            if (empty($_POST["gender_input"])) {
                $error[] = "Gender field is empty.";
            }
            if (empty($_POST["email_input"])) {
                $error[] = "Email field is empty.";
            }
            if (empty($_POST["phone_number_input"])) {
                $error[] = "Phone number field is empty.";
            }
            if (empty($_POST["technical_skills"])) {
                $error[] = "Technical skills field is empty.";
            }


    // ======================================= RANGE VALIDATION ==========================================


        // ------------------------- Valid? -------------------------
            if (!preg_match("/^(Mr|Mrs|Miss|Ms|Dr)$/i", $_POST["title"])) {
                $error[] = "Invalid title. Only Mr, Mrs, Miss, Ms, Dr are allowed.";
            }
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["first_name_input"]) || !preg_match("/^[a-zA-Z ]*$/", $_POST["last_name_input"])) {
                $error[] = "Only letters and white space allowed in first name, lastname";
            }
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST["date"])) {
                $error[] = "Not a valid date. Please use the format YYYY-MM-DD.";
            }
            if (!preg_match("/^[IT0-9 ]*$/", $_POST["job_reference_number"])) {
                $error[] = "Not a valid job reference number.";
            }
            if (strlen($_POST["street_address"]) < 1 || strlen($_POST["street_address"]) > 40) {
                $error[] = "Street address must be between 1 and 40 characters long.";
            }
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["suburb_town"])) {
                $error[] = "Only letters and white space allowed in suburb";
            }
            if (!in_array($_POST["state"], $state_map)) {
                $error[] = "Only valid Austrlian states allowed in state";
            }
            if (!preg_match("/^[0-9 ]*$/", $_POST["postcode"])) {
                $error[] = "Only numbers allowed in postcode";
            }
            if (!filter_var($_POST["email_input"], FILTER_VALIDATE_EMAIL)) {
                $error[] = "Invalid email format";
            }
            if (!preg_match("/^[0-9 ]*$/", $_POST["phone_number_input"])) {
                $error[] = "Only numbers allowed in phone number";
            }

            if (isset($_POST["technical_skills"])) {
                $selected_skills = $_POST["technical_skills"];
                // Check if all possible technical skills are selected
                if (count(array_diff($technical_skills_map, $selected_skills)) > 0) {
                    $error[] = "You must select all technical skills.";
                }
            } else {
                $error[] = "Technical skills field is missing.";
            }

    // ======================================= INPUT VALIDATION ==========================================

            // ------------------------- Valid Input?  -------------------------
            if (!in_array($_POST["job_reference_number"], $job_reference_numbers_map)) {
                $error[] = "Invalid job reference number. Please select from the dropdown.";
            } 
            if (!in_array($_POST["gender_input"], $gender_input_map)) {
                $error[] = "Invalid gender_input. Only Male or Female are allowed.";
            }
}


if (count($error) > 0) {

    $error_msg = "";

    if (count($error) == 1) { $preview_message = $error[0]; }
    else { $preview_message = "Click for more info";}

    foreach ($error as $err) {
        $error_msg .= $err . "\n";
    }
    set_data_response("error", 
    "Error", 
    $preview_message, 
    "The values you submitted didn't meet the requirements to be passed", 
    "Something in the application you submitted wasn't accepted and caused an error", 
    "The following are the errors that were found:<br><pre>" . $error_msg . "</pre>");
    header("Location: ../apply.php");
    die();
}

$Address = $_POST["street_address"] . ", " . $_POST["suburb_town"] . ", " . $_POST["state"] . ", " . $_POST["postcode"];


$other_skills = htmlspecialchars($_POST["other_skills"]);
if (isset($_POST["technical_skills"]) && !empty($_POST["technical_skills"])) {
    $technical_skills = implode(", ", $_POST["technical_skills"]);
}
else {
    $preferred_skills = [];
}
if (isset($_POST["preferred_skills"]) && !empty($_POST["preferred_skills"])) {
    $preferred_skills = implode(", ", $_POST["preferred_skills"]);
}
else {
    $preferred_skills = [];
}

$prep = $conn->prepare("INSERT INTO eoi 
    (EOInumber, Job_Ref_Num, Firstname, Lastname, Address, Email_Address, Phone_Number, Technical_Skills, Preferred_Skills, Other_Skills) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$prep->bind_param(
    "isssssssss", 
    $EOInumber, 
    $_POST["job_reference_number"], 
    $_POST['first_name_input'], 
    $_POST['last_name_input'],
    $Address,
    $_POST['email_input'],
    $_POST['phone_number_input'],
    $technical_skills,
    $preferred_skills,
    $other_skills
);


if ($prep->execute()) {
    set_data_response("success", 
    "Success", 
    "Your application has been submitted successfully", 
    "Thank you for applying", 
    "Your application has been received and is being processed", 
    "We appreciate the time you spent to express your interest. We will review it and get back to you soon.");
    header("Location: ../apply.php");
    
    die();
} else {
    $conn->close();
    set_data_response("error", 
    "Error", 
    "There was an error submitting your application", 
    "Something went wrong", 
    "We encountered an issue while processing your application", 
    "Please try again later or contact support if the problem persists.");
    header("Location: ../apply.php");
    die();
}
?>