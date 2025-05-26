<?php

require("../php/functionality.php");
require_once("../php/settings.php");

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    set_data_response("error",
    "Error",
    "Database connection failed",
    "Unable to connect to the database",
    "There was an issue connecting to the database",
    "Please check your internet and try again.");
    header("Location: ./apply.php");
    die();
}

$error = [];

$EOInumber = rand(1000, 9999);
$gender_input_map = ["Male", "Female"];
$technical_skills_map = ["Knowledge in Troubleshooting", "Understanding of Network Infrastructure", "Knowledge of Computer Hardware", "Proficiency in Operating Systems", "Knowledge of Security Practices", "Familiarity with Database Concepts"];
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
            if (isset($_POST["gender_input"]) && !in_array($_POST["gender_input"], $gender_input_map)) {
                $error[] = "Invalid gender_input: " . $_POST["gender_input"];
            }
            if (!isset($_POST["phone_number_input"])) {
                $error[] = "No phone field was submitted";
            }
            if (isset($_POST["technical_skills"]) && !in_array($_POST["technical_skills"], $technical_skills_map)) {
                $error[] = "Invalid technical_skills: " . $_POST["technical_skills"];
            }
            if (isset($_POST["preferred_skills"]) && !in_array($_POST["preferred_skills"], $preferred_skills_map)) {
                $error[] = "Invalid preferred_skills: " . $_POST["preferred_skills"];
            }
            if (!isset($_POST["other_skills"])) {
                $error[] = "No other field was submitted";
            }
        

        // ------------------------- Empty? -------------------------
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
            if (!preg_match("/^[0-9 ]*$/", $_POST["date"])) {
                $error[] = "Not a valid date.";
            }
            if (!preg_match("/^[IT0-9 ]*$/", $_POST["job_reference_number"])) {
                $error[] = "Not a valid job reference number.";
            }
            if (!preg_match("/^\d*\s?[A-Za-z\s]+(?:Court|Ct|Street|St|Avenue|Ave|Boulevard|Blvd|Road|Rd|Lane|Ln|Drive|Dr)\.?$/i", $_POST["street_address"])) {
                $error[] = "Only letters, numbers and white space allowed in street address";
            }
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST["suburb_town"])) {
                $error[] = "Only letters and white space allowed in suburb";
            }
            if (!preg_match("/^[?:ACT|VIC|NSW|QLD|SA|WA|NT]*$/", $_POST["state"])) {
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
            if (!preg_match("/^[a-zA-Z0-9, ]*$/", $_POST["other_skills"])) {
                $error[] = "Only letters, numbers, commas and white space allowed in other skills";
            }

    // ======================================= INPUT VALIDATION ==========================================

            // ------------------------- Valid Input?  -------------------------
            if (!in_array($_POST["job_reference_number"], ["IT3869", "IT2245", "IT2025"])) {
                $error[] = "Not a valid job reference number. Only IT3869, IT2245, or IT2025 are allowed.";
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
    header("Location: ./apply.php");
    die();
}

$Address = $_POST["street_address"] . ", " . $_POST["suburb_town"] . ", " . $_POST["state"] . ", " . $_POST["postcode"];

$prep = $conn->prepare("INSERT INTO eoi 
    (EOInumber, Job_Ref_Num, Firstname, Lastname, Address, Email_Address, Phone_Number, Technical_Skills, Preferred_Skills, Other_Skills, Status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$prep->bind_param("
    iissssissss", 
    $EOInumber, 
    $Job_Ref_Num, 
    $Firstname, 
    $Lastname, 
    $Address, 
    $Email_Address, 
    $Phone_Number, 
    $Technical_Skills, 
    $Preferred_Skills, 
    $Other_Skills, $Status
);
    
if ($prep->execute()) {
    set_data_response("success", 
    "Success", 
    "Your application has been submitted successfully", 
    "Thank you for applying", 
    "Your application has been received and is being processed", 
    "We appreciate the time you spent to express your interest. We will review it and get back to you soon.");
    header("Location: ./apply.php");
    die();
} else {
    set_data_response("error", 
    "Error", 
    "There was an error submitting your application", 
    "Something went wrong", 
    "We encountered an issue while processing your application", 
    "Please try again later or contact support if the problem persists.");
    header("Location: ./apply.php");
    die();
}

$conn->close();
?>