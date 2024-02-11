<?php
// session_start();

// if(!isset($_SESSION["login_status"])){
//     header("Location: login.php");
// }

require_once("./utility/connectdb.php");
$createUsername = $createUsermail = $createPassword = '';

$errorMsg = [];
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(' ', '', $data);
    return $data;
}

if (isset($_POST["create-btn"])) {

    $createUsername = filter_input(INPUT_POST, "create-username", FILTER_SANITIZE_SPECIAL_CHARS);
    $createPassword = filter_input(INPUT_POST, "create-password", FILTER_SANITIZE_SPECIAL_CHARS);
    $createUsermail = $_POST["create-usermail"];

    if (!empty(test_input($createUsername)) && !empty(test_input($createPassword)) && !empty($createUsermail)) {
        $createUsern = test_input($createUsername);
        echo $createUsername;
        $numrows = mysqli_query($connect, "SELECT userid FROM users WHERE username = '$createUsername'");

        if (mysqli_num_rows($numrows) >= 1) {
            $errorMsg['errName'] = "The user name is already exsist.";
        } 
        else if (preg_match("/^[a-zA-Z-']+[0-9]*$/", $createUsername) && preg_match("/^[a-zA-Z0-9@!#\$%^&*:\"';>.,?\/~`+=_\-\\|]+$/", $createPassword)) {

            $filesValue = null;


            // the file uploading logic

            // if (!empty($_FILES['userfile']['name']) || strlen($_FILES['userfile']['name'])) {
            //     $filesValue =  "simple-form_" . time() . "_" . str_replace(" ", "_", $_FILES['userfile']['name']);
            //     move_uploaded_file($_FILES['userfile']['tmp_name'], "userfiledata/" . $filesValue);
            // }

            $uploadData = "INSERT INTO users (username, usermail, password, userimg) VALUES ('$createUsername', '$createUsermail', '$createPassword', '$filesValue') ";

            $result = mysqli_query($connect, $uploadData);
            mysqli_close($connect);

            if ($result) {
                // sendMail($usermail, $createUsername, $createPassword);
                header("Location: login.php");
                // echo '<script>window.location.href = "./login.php";</script>';
                exit();
            } else {
                echo "Error: " . mysqli_error($connect);
            };
        } else if (!preg_match("/^[a-zA-Z-']+[0-9]*$/", $createUsername)) {
            // echo "username start with letter, it cannot contains any space";
            $errorMsg['errName'] = "username start with letter, it cannot contains any space or spacial characters.";
        } else if (!preg_match("/^[a-zA-Z0-9@!#\$%^&*:\"';>.,?\/~`+=_\-\\|]+$/", $createPassword)) {
            // echo "Password cannot contain space";
            $errorMsg['errName'] = "Password cannot contain space";
        } else {
        }
    } 
    else {
        // echo "Username or Pssword is empty!!";
        $errorMsg['errName'] = "Username or Pssword is empty!!";
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <form action="./createacc.php" method="post" enctype="multipart/form-data">
        <h3>Create account</h3>
        <input type="text" name="create-username" placeholder="Username" value="<?php echo $createUsername; ?>" required>
        <input type="email" name="create-usermail" placeholder="Email" value="<?php echo $createUsermail; ?>" required>
        <input type="text" name="create-password" placeholder="Password" value="<?php echo $createPassword; ?>" required>
        <input type="submit" name="create-btn" value="Create User">

        <p><?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-3">' . $errorMsg['errName'] . "</div>";
            } ?></p>
    </form>

</body>

</html>