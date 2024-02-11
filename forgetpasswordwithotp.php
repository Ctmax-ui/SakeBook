<?php
session_start();
if (!isset($_SESSION["user_otp"])) {
    header("Location: login.php");
    // echo '<script>window.location.href = "./login.php";</script>';
    exit();
}

require_once("./utility/connectdb.php");

$inputOtp = $newPassword = $confirmPassword = "";

$errorMsg = [];

// var_dump($_SESSION);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fetchedOtp = $_SESSION["user_otp"];
    $tempId = $_SESSION["temp_id"];


    $dataSql =  "SELECT * FROM users WHERE userid='$tempId'";

    $selectresult = mysqli_query($connect, $dataSql);
    $getResult = mysqli_fetch_assoc($selectresult);


    if (isset($_POST["edit-password"])) {


        $arrOtp = $_POST['otp']; // Assuming $_POST['otp'] is an array

        // Sanitize array values as numbers and concatenate them into a single integer
        $inputOtp = '';
        foreach ($arrOtp as $digit) {
            $digit = filter_var($digit, FILTER_SANITIZE_NUMBER_INT); // Sanitize as number
            $inputOtp .= $digit; // Concatenate to form a single integer
        }

        // Convert the concatenated string to an integer
        $inputOtp = intval($inputOtp);

        // var_dump($inputOtp);

        $newPassword =  filter_input(INPUT_POST, "new-password", FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword =  filter_input(INPUT_POST, "new-password-confirm", FILTER_SANITIZE_SPECIAL_CHARS);

        $newPassword = str_replace(' ', '', $newPassword);
        $confirmPassword = str_replace(' ', '', $confirmPassword);


        if (!empty($inputOtp)) {

            if ($inputOtp === $fetchedOtp) {

                if (empty($newPassword)) {
                    $errorMsg['errName'] = "New password is empty!.";
                } else if (empty($confirmPassword)) {
                    $errorMsg['errName'] = "confirm password is empty!.";
                } else {

                    if ($newPassword == $confirmPassword) {
                            // var_dump($inputOtp);
                            // echo "success";

                        $updatePassword = "UPDATE users SET password = '$newPassword' WHERE userid = '$tempId'";



                        $result = mysqli_query($connect, $updatePassword);

                        if ($result) {
                            $userOtpDB = "UPDATE users SET user_otp = Null WHERE userid = '$tempId'";
                            $result = mysqli_query($connect, $userOtpDB);
                            session_unset();
                            session_destroy();
                            
                            mysqli_close($connect);
                            // echo '<script>window.location.href = "./usersetting.php";</script>';
                            header("Location: userprofile.php");
                            exit();
                        } else {
                            echo "Error: " . mysqli_error($connect);
                        }
                    } else {
                        $errorMsg['errName'] = "Check your confirm password ";
                    }
                }
            } else {
                $errorMsg['errName'] = "Invalid OTP.";
            }
        } else {
            $errorMsg['errName'] = "Your OTP is empty";
        }
    }
}

// function maskString($str) {
//     $firstThreeChars = substr($str, 0, 2);
//     $remainingChars = substr($str, 3);
//     $maskedChars = str_repeat('*', strlen($remainingChars));
//     $maskedString = $firstThreeChars . $maskedChars;
//     return $maskedString;
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link href="./css/style.css" rel="stylesheet">

</head>

<body>
        
    <a class=" ms-2 ps-3 pt-1 position-absolute btn btn-outline-dark" href="./<?php if (isset($_SESSION["username"])) {echo "usersetting.php";}else{echo "forgetpassword.php";} ?>"><i class="fa-solid fa-arrow-left"></i> Go back</a>


    <h4 class="text-center mt-4">Update your password</h4>


    <div class="d-flex justify-content-center aligin-items-center mt-3 text-center">

        <form class="text-center form-control p-3 w-25 m-auto was-validated" action="./forgetpasswordwithotp.php" method="post" enctype="multipart/form-data">

            <p class="m-0">Put the OTP we just send.</p>
            <div class="otp-input mb-3">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][0]; ?>">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][1]; ?>">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][2]; ?>">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][3]; ?>">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][4]; ?>">
                <input type="text" class="otp-box" name="otp[]" maxlength="1" oninput="moveToNext(this)" onpaste="handlePaste(event)" onkeypress="return onlyNumbers(event)" value="<?php if (!empty($_POST['otp'])) echo $_POST['otp'][5]; ?>">
            </div>


            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="new-password" placeholder="Create a new pasword" value="<?php echo $newPassword ?>" required>
                <label for="floatingPassword">Create a new password</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="new-password-confirm" placeholder="Create a new pasword" value="<?php echo $confirmPassword ?>" required>
                <label for="floatingPassword">Confirm new password</label>
            </div>


            <input class="my-2 btn btn-outline-primary px-5 w-100" type="submit" name="edit-password" value="Submit"> <br>


            <?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-1">' . $errorMsg['errName'] . "</div>";
            } ?>

        </form>
    </div>



<script src="./js/index.js"></script>
</body>

</html>