<?php
session_start();

require_once("settings.php");

# I think it should be a html file but i just guessed so feel free to change it

# its gonna be a php because it will need t include the header and footer and stuff - Evan
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    else {
        $title = $_POST['title'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first_name_input"]) || empty($_POST["last_name_input"])) {
        echo "Please fill in firstname and lastname.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/",$firstname || $lastname)) {
            echo "Only letters and white space allowed in title, first name, lastname";
            exit;
        }
    }
    else {
        $title = $_POST['title'];
        $firstname = $_POST['first_name_input'];
        $lastname = $_POST['last_name_input']; 
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["date"])) {
        echo "Please fill in date of birth.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $date)) {
            echo "Not a valid date.";
            exit;
        }
    }
    else {
        $date = $_POST['date'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["job_reference_number"])) {
        echo "Please fill in job reference number.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $job_ref_num)) {
            echo "Not a valid job reference number.";
            exit;
        }
    }
    else {
        $job_ref_num = $_POST['job_reference_number'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["street_address"])) {
        echo "Please fill in street address.";
        exit;
        if (!preg_match("/^\d*\s?[A-Za-z\s]+(?:Street|St|Avenue|Ave|Boulevard|Blvd|Road|Rd|Lane|Ln|Drive|Dr)\.?$/i", $street)) {
            echo "Only letters, numbers and white space allowed in street address";
            exit;
        }
    }
    else {
        $street = $_POST['street_address'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["suburb_town"])) {
        echo "Please fill in suburb/town.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $suburb)) {
            echo "Only letters and white space allowed in suburb";
            exit;
        }
    }
    else {
        $suburb = $_POST['suburb_town'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["state"])) {
        echo "Please fill in state.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $state)) {
            echo "Only letters and white space allowed in state";
            exit;
        }
    }
    else {
        $state = $_POST['state'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["postcode"])) {
        echo "Please fill in postcode.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $postcode)) {
            echo "Only numbers allowed in postcode";
            exit;
        }
    }
    else {
        $postcode = $_POST['postcode'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["gender_input"])) {
        echo "Please fill in postcode.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $gender)) {
            echo "Only letters and white space allowed";
            exit;
        }
    }
    else {
        $gender = $_POST["gender_input"];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email_input"])) {
        echo "Please fill in email address.";
        exit;
        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
            exit;
        }
    }
    else {
        $email_address = $_POST['email_input'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["phone_number_input"])) {
        echo "Please fill in phone number.";
        exit;
        if (!preg_match("/^[0-9 ]*$/", $phone_number)) {
            echo "Only numbers allowed in phone number";
            exit;
        }
    }
    else {
        $phone_number = $_POST['phone_number_input'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["technical_skills"])) {
        echo "Please fill in technical skills.";
        exit;
        if (!preg_match("/^[a-zA-Z ]*$/", $technical_skills)) {
            echo "Only letters and white space allowed in technical skills";
            exit;
        }
    }
    else {
        $technical_skills = $_POST['technical_skills'];
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