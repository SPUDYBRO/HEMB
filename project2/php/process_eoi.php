<?php


    // Requires the necessary files for functionality and settings
    require("./functionality.php");
    require_once("./settings.php");


    // Tries to connect to the database using the provided settings
    // If it fails, it sets an error response and redirects to the apply page
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


    // Initialize an array to hold error messages
    $error = [];


    // Generate a random EOI number for the application
    $EOInumber = rand(1000, 9999);


    // Define the valid options for various fields
    $title_map = ["Mr", "Mrs", "Ms", "Miss", "Dr"];
    $gender_input_map = ["Male", "Female"];
    $job_reference_numbers_map = ["IT300", "IT240", "IT350", "IT090"];
    $state_map = ["ACT", "VIC", "NSW", "QLD", "SA", "WA", "NT", "TAS"];
    $technical_skills_map = ["Trouble Shooting", "Networking", "Hardware", "Software", "Security", "Database Management"];
    $preferred_skills_map = ["Communication", "Teamwork", "Time Management", "Autonomous", "Fast Learner"];


    // Check if the request method is POST
    // If it is, proceed with validation and processing of the form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {



        // ======================================= EXISTENCE VALIDATION ==========================================
        

            // ------------------------- Isset? -------------------------

                // Check if all required fields exist in the POST request
                // If any of them are missing, add the relevant error message 
                // to the error array.
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
                if (!isset($_POST["email_input"])) {
                    $error[] = "No email field was submitted";
                }
                if (!isset($_POST["phone_number_input"])) {
                    $error[] = "No phone field was submitted";
                }
                if (!isset($_POST["other_skills"])) {
                    $error[] = "No other skills field was submitted";
                }


                // Explanation: 
                // The reason why gender_input and technical_skills 
                // are checked in this way seperate from the other fields is because they are
                // arrays that would trigger an existence error if they were not populated
                // even though they exist.
                // To work around this, we check if they are set and not empty. This way,
                // we can ensure that the user doesn't get an unnecessary error message
                // when they have not selected any options for these fields.
                // If they are set but empty, we will add an error message later on.


                // Check if the required fields exist and are populated
                // If they are not, add an error message to the error array
                if (!isset($_POST["gender_input"]) || empty($_POST["gender_input"])) {
                    $error[] = "No gender submitted. You must select a gender.";
                }
                if (!isset($_POST["technical_skills"]) || empty($_POST["technical_skills"])) {
                    $error[] = "Not all technical skills submitted. You must select at all technical skills.";
                }



                // error out
                if (count($error) > 0) {
                    set_data_response("error", "Error", "Error in form submission", "Some required fields are missing", "Please ensure all required fields are filled out correctly", "The following errors were found:<br><pre>" . implode("\n", $error) . "</pre>");
                    header("Location: ../apply.php");
                    $conn->close();
                    die();
                }


            // ------------------------- Empty? -------------------------

                // Check if the required fields are empty
                // If they are, add the relevant error message to the error array
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

            // error out
            if (count($error) > 0) {
                set_data_response("error", "Error", "Error in form submission", "Some required fields are empty", "Please ensure all required fields are filled out correctly", "The following errors were found:<br><pre>" . implode("\n", $error) . "</pre>");
                header("Location: ../apply.php");
                $conn->close();
                die();
            }

        // ======================================= RANGE VALIDATION ==========================================


            // ------------------------- Valid? -------------------------

                // Check if the values in the fields are valid
                // If they are not, add the relevant error message to the error array
                if (!empty($_POST["first_name_input"]) && !preg_match("/^[a-zA-Z ]*$/", $_POST["first_name_input"])) {
                    $error[] = "Only letters and white space allowed in firstname";
                }
                if (!empty($_POST["last_name_input"]) && !preg_match("/^[a-zA-Z ]*$/", $_POST["last_name_input"])) {
                    $error[] = "Only letters and white space allowed in lastname";
                }
                if (!empty($_POST["date"]) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST["date"])) {
                    $error[] = "Not a valid date. Please use the format YYYY-MM-DD.";
                }
                if (!empty($_POST["job_reference_number"]) && !preg_match("/^[IT0-9 ]*$/", $_POST["job_reference_number"])) {
                    $error[] = "Not a valid job reference number.";
                }
                if (!empty($_POST["street_address"]) && !preg_match("/^[a-zA-Z0-9 ]*$/", $_POST["street_address"])) {
                    $error[] = "Only letters and white space allowed in street address";
                }
                if (!empty($_POST["suburb_town"]) && !preg_match("/^[a-zA-Z ]*$/", $_POST["suburb_town"])) {
                    $error[] = "Only letters and white space allowed in suburb";
                }
                if (!empty($_POST["postcode"]) && !preg_match("/^[0-9 ]*$/", $_POST["postcode"])) {
                    $error[] = "Only numbers allowed in postcode";
                }
                if (!empty($_POST["email_input"]) && !filter_var($_POST["email_input"], FILTER_VALIDATE_EMAIL)) {
                    $error[] = "Invalid email format. Valid format: (Example@service.com)";
                }
                if (!empty($_POST["phone_number_input"]) && !preg_match("/^[0-9 ]*$/", $_POST["phone_number_input"])) {
                    $error[] = "Only numbers allowed in phone number";
                }


                // If the technical skills field is set, check 
                // that all valid technical skills are selected.
                // If the number of selected skills isn't equal to the 
                // number of skills in the predefined array,
                // add an error message to the error array.
                // This ensures that the user selects all required technical skills.
                if (isset($_POST["technical_skills"])) {
                    $selected_skills = $_POST["technical_skills"];
                    // Check if all possible technical skills are selected
                    if (count(array_diff($technical_skills_map, $selected_skills)) > 0) {
                        $error[] = "You must select all technical skills.";
                    }
                }

                // error out
                if (count($error) > 0) {
                    set_data_response("error", "Error", "Error in form submission", "Some fields contain invalid data", "Please ensure all fields are filled out correctly", "The following errors were found:<br><pre>" . implode("\n", $error) . "</pre>");
                    header("Location: ../apply.php");
                    $conn->close();
                    die();
                }


        // ======================================= SELECTION VALIDATION ==========================================

                // ------------------------- Valid Selection?  -------------------------


                // Checks if the title, job reference number, state and gender selections
                // are valid by checking the selected values against the relevant predefined 
                // arrays. If any of the selected values are not in the predefined arrays, 
                // it adds an error message to the error array.
                // This ensures that only valid options are selected for these fields.
                if (!empty($_POST["title"]) && !in_array($_POST["title"], $title_map)) {
                    $error[] = "Invalid title. Please select from the dropdown.";
                }
                if (!empty($_POST["job_reference_number"]) && !in_array($_POST["job_reference_number"], $job_reference_numbers_map)) {
                    $error[] = "Invalid job reference number. Please select from the dropdown.";
                }
                if (!empty($_POST["state"]) && !in_array($_POST["state"], $state_map)) {
                    $error[] = "Invalid state. Please select from the dropdown.";
                }
                if (!empty($_POST["gender_input"]) && !in_array($_POST["gender_input"], $gender_input_map)) {
                    $error[] = "Invalid gender input. Only Male or Female are allowed.";
                }


                // Checks if the technical skills and preferred skills fields are 
                // set, then it checks the selected values against the relevant predefined 
                // arrays. If any of the selected values are not in the predefined arrays, 
                // it adds an error message to the error array.
                // This ensures that only valid options are selected for these fields.
                if (!empty($_POST["technical_skills"]) && isset($_POST["technical_skills"])) {
                    for ($i = 0; $i < count($_POST["technical_skills"]); $i++) {
                        if (!in_array($_POST["technical_skills"][$i], $technical_skills_map)) {
                            $error[] = "Invalid technical_skills: " . $_POST["technical_skills"][$i];
                        }
                    }
                }
                if (!empty($_POST["preferred_skills"]) && isset($_POST["preferred_skills"])) {
                    for ($i = 0; $i < count($_POST["preferred_skills"]); $i++) {
                        if (!in_array($_POST["preferred_skills"][$i], $preferred_skills_map)) {
                            $error[] = "Invalid preferred_skills: " . $_POST["preferred_skills"][$i];
                        }
                    }
                }


                // error out
                if (count($error) > 0) {
                    set_data_response("error", "Error", "Error in form submission", "Some selections are invalid", "Please ensure all selections are valid", "The following errors were found:<br><pre>" . implode("\n", $error) . "</pre>");
                    header("Location: ../apply.php");
                    $conn->close();
                    die();
                }



        // ======================================= LENGTH VALIDATION ==========================================


                // ------------------------- Valid Length?  ------------------------

                // Checks to make sure that the relevant inputs are in 
                // their respective range of allowed characters.
                if (strlen($_POST["first_name_input"]) < 1 || strlen($_POST["first_name_input"]) > 20) {
                    $error[] = "Firstname must be between 1 and 20 characters long.";
                }
                if (strlen($_POST["last_name_input"]) < 1 || strlen($_POST["last_name_input"]) > 20) {
                    $error[] = "Lastname must be between 1 and 20 characters long.";
                }
                if (strlen($_POST["street_address"]) < 1 || strlen($_POST["street_address"]) > 40) {
                    $error[] = "Street address must be between 1 and 40 characters long.";
                }
                if (strlen($_POST["suburb_town"]) < 1 || strlen($_POST["suburb"]) > 40) {
                    $error[] = "Suburb address must be between 1 and 40 characters long.";
                }
                if (strlen($_POST["postcode"]) != 4) {
                    $error[] = "Postcode must be exactly 4 digits long.";
                }
                if (strlen($_POST["phone_number_input"]) < 8 || strlen($_POST["phone_number_input"]) > 12) {
                    $error[] = "Phone number must be between 8 and 12 digits long.";
                }
    }



    // Once all checks have been complete it checks the error array.
    // If the error is populated (greater than 0) it means that there
    // is an error and the data should not be executed into the database.
    // If it is empty then the data is safe and can be executed to the database. 
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


    // Joins the street, suburb, state and postcode into a variable called 'address'
    $Address = $_POST["street_address"] . ", " . $_POST["suburb_town"] . ", " . $_POST["state"] . ", " . $_POST["postcode"];
    $other_skills = htmlspecialchars($_POST["other_skills"]);


    // Joins the values into one string seperate by commas
    if (isset($_POST["technical_skills"]) && !empty($_POST["technical_skills"])) {
        $technical_skills = implode(", ", $_POST["technical_skills"]);
    }
    else {
        $technical_skills = [];
    }
    if (isset($_POST["preferred_skills"]) && !empty($_POST["preferred_skills"])) {
        $preferred_skills = implode(", ", $_POST["preferred_skills"]);
    }
    else {
        $preferred_skills = [];
    }


    // Inserts the data into the database
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
    

    // Creates the info card to notify the user it was a success
    // Else if an error occurs it notifies the user that there was an error
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