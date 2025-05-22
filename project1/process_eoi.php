<?php
session_start();

require_once("settings.php");

# I think it should be a html file but i just guessed so feel free to change it

# its gonna be a php because it will need t include the header and footer and stuff - Evan
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$title = $_POST['title'];
$firstname = $_POST['first_name_input'];
$lastname = $_POST['last_name_input'];
$date = $_POST['date'];
$job_ref_num =  $_POST['job_reference_number'];
$street = $_POST['street_address'];
$suburb = $_POST['suburb_town'];
$state = $_POST['state'];
$postcode = $_POST['postcode'];
$gender = $_POST['gender_input'];
$email_address = $_POST['email_input'];
$phone_number = $_POST['phone_number_input'];
$technical_skills = $_POST['technical_skills'];
$preferred_skills = $_POST['preferred_skills'];
$other_skills = $_POST['other_skills'];

    
$prep = $conn->prepare("INSERT INTO users (EOInumber, Job_Ref_Num, Firstname, Lastname, Address, Email_Address, Phone_Number, Technical_Skills, Preferred_Skills, Other_Skills, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$prep->bind_param("iissssissss", $EOInumber, $Job_Ref_Num, $Firstname, $Lastname, $Address, $Email_Address, $Phone_Number, $Technical_Skills, $Preferred_Skills, $Other_Skills, $Status);


# if ($prep->execute()) {
#  echo "New record created successfully";
# } else {
#  echo "Error: " . $prep->error;
# }

$prep->close();
$conn->close();

?>