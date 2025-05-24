<?php
session_start();

require_once("settings.php");

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* Note from Evan:

When organising the code there are 3 sections / types of validation you need to do:

1. Existence validation. Here you will check if what was submitted exists or not. and if it is empty or not.
2. Type checking. Here you check if the data entered is of what you expect. for example if you require a string but get a number.
3. range checking. Here is where you check if the data is within the limits of what you expect. for example does it only contain A-Z or 0-9.



I have added These sections into your code. And organized your code into 4 sections. 3 being validation and the last being the database insertion.
*/

require_once("functionality.php");

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // ======================================= EXISTENCE VALIDATION ==========================================
    

        // ------------------------- Isset? -------------------------
            if (!isset($_POST["title"])) {
                #set error using my function `set_data_response()` found in functionality.php
                #Then redirect them and die()
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
            if (!isset($_POST["email_input"])) {
                $error[] = "No email field was submitted";
            }
            if (!isset($_POST["phone_number_input"])) {
                $error[] = "No phone field was submitted";
            }
            if (!isset($_POST["technical_skills"])) {
                $error[] = "No technical field was submitted";
            }
            if (!isset($_POST["preferred_skills"])) {
                $error[] = "No preferred field was submitted";
            }
            if (!isset($_POST["other_skills"])) {
                $error[] = "No other field was submitted";
            }
        
        // ------------------------- Empty? -------------------------
            if (!empty($_POST["title"])) {
                $error[] = "Title field is empty.";
            }
            if (!empty($_POST["first_name_input"])) {
                $error[] = "Firstname field is empty.";
            }
            if (!empty($_POST["last_name_input"])) {
                $error[] = "Lastname field is empty.";
            }
            if (!empty($_POST["date"])) {
                $error[] = "Date field is empty.";
            }
            if (!empty($_POST["job_reference_number"])) {
                $error[] = "Job reference number field is empty.";
            }
            if (!empty($_POST["street_address"])) {
                $error[] = "Street address field is empty.";
            }
            if (!empty($_POST["suburb_town"])) {
                $error[] = "Suburb town field is empty.";
            }
            if (!empty($_POST["state"])) {
                $error[] = "State field is empty.";
            }
            if (!empty($_POST["postcode"])) {
                $error[] = "Postcode field is empty.";
            }
            if (!empty($_POST["gender_input"])) {
                $error[] = "Gender field is empty.";
            }
            if (!empty($_POST["email_input"])) {
                $error[] = "Email field is empty.";
            }
            if (!empty($_POST["phone_number_input"])) {
                $error[] = "Phone number field is empty.";
            }
            if (!empty($_POST["technical_skills"])) {
                $error[] = "Technical skills field is empty.";
            }
            if (!empty($_POST["preferred_skills"])) {
                $error[] = "Preferred skills field is empty.";
            }
            if (!empty($_POST["other_skills"])) {
                $error[] = "Other skills field is empty.";
            }
        



        
    // ======================================= TYPE VALIDATION ==========================================


        # Code for this. Not everything needs to be type validated. just stuff that needs to be integers or something like that.

    

    // ======================================= RANGE VALIDATION ==========================================

        # Code for this. This would include the !preg_match() stuff you have in your code.






        # once all the validation is done. You can check if you got any errors by making an array an inserting the errors into it.
        # then if the array has an element in it. use the `set_php_response()` function to set the error message and redirect them back to the form.
        # this will make the info card i showed you pop up with the error message
        # if you dont know what to put in the `set_php_response()` function. look in functionality.php and i have written a comment on what to put in there.

    // ======================================= DATABASE INSERTION ==========================================

        # You don't need to make a giant list turning the $_POST data into variables. You can just use the $_POST data directly in the SQL statement.
        # on top. at this point you can assume that the data is valid and safe to use. (still use prepared statements though)

}

$prep = $conn->prepare("INSERT INTO eoi (EOInumber, Job_Ref_Num, Firstname, Lastname, Address, Email_Address, Phone_Number, Technical_Skills, Preferred_Skills, Other_Skills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$prep->bind_param("iissssissss", $EOInumber, $Job_Ref_Num, $Firstname, $Lastname, $Address, $Email_Address, $Phone_Number, $Technical_Skills, $Preferred_Skills, $Other_Skills, $Status);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])) {
        echo "Please fill in title.";
        exit;
        if (!preg_match("/^(Mr|Mrs|Miss)$/i", $title)) {
            echo "Invalid title. Only Mr, Mrs,, Ms, Miss, Dr are allowed.";
            exit;
        }
    }

    if (empty($_POST["first_name_input"]) || empty($_POST["last_name_input"])) {
        echo "Please fill in firstname and lastname.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname || $lastname)) {
            echo "Only letters and white space allowed in title, first name, lastname";
            exit;
        }
    }

    if (empty($_POST["date"])) {
        echo "Please fill in date of birth.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $date)) {
            echo "Not a valid date.";
            exit;
        }
    }

    if (empty($_POST["job_reference_number"])) {
        echo "Please fill in job reference number.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $job_ref_num)) {
            echo "Not a valid job reference number.";
            exit;
        }
    }

    if (empty($_POST["street_address"])) {
        echo "Please fill in street address.";
        exit;
        if (!preg_match("/^\d*\s?[A-Za-z\s]+(?:Street|St|Avenue|Ave|Boulevard|Blvd|Road|Rd|Lane|Ln|Drive|Dr)\.?$/i", $street)) {
            echo "Only letters, numbers and white space allowed in street address";
            exit;
        }
    }

    if (empty($_POST["suburb_town"])) {
        echo "Please fill in suburb/town.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $suburb)) {
            echo "Only letters and white space allowed in suburb";
            exit;
        }
    }

    if (empty($_POST["state"])) {
        echo "Please fill in state.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $state)) {
            echo "Only letters and white space allowed in state";
            exit;
        }
    }

    if (empty($_POST["postcode"])) {
        echo "Please fill in postcode.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $postcode)) {
            echo "Only numbers allowed in postcode";
            exit;
        }
    }

    if (empty($_POST["gender_input"])) {
        echo "Please fill in postcode.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $gender)) {
            echo "Only letters and white space allowed";
            exit;
        }
    }

    if (empty($_POST["email_input"])) {
        echo "Please fill in email address.";
        exit;
        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit;
        }
    }

    if (empty($_POST["phone_number_input"])) {
        echo "Please fill in phone number.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $phone_number)) {
            echo "Only numbers allowed in phone number";
            exit;
        }
    }

    if (empty($_POST["technical_skills"])) {
        echo "Please fill in technical skills.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $technical_skills)) {
            echo "Only letters and white space allowed in technical skills";
            exit;
        }
    }
}

$preferred_skills = $_POST['preferred_skills'];
$other_skills = $_POST['other_skills'];

    
# if ($prep->execute()) {
#  echo "New record created successfully";
# } else {
#  echo "Error: " . $prep->error;
# }


$conn->close();
?>