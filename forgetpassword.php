<?php
session_start();


require_once("./utility/connectdb.php");

$usermail = $userotp = $username = $otp = "";

$otp = rand(100000 , 999999);
$errorMsg = [];


if (isset($_POST["get-otp"])) {

    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $usermail = filter_input(INPUT_POST, "usermail", FILTER_SANITIZE_EMAIL);

    if (!empty($usermail) and !empty($username)) {

        $selectresult = mysqli_query($connect, "SELECT * FROM users WHERE usermail = '$usermail' AND username = '$username'");
        $getResult = mysqli_fetch_assoc($selectresult);


        // var_dump($getResult);


        if ($getResult && mysqli_num_rows($selectresult) > 0 && $usermail == $getResult["usermail"] && $username == $getResult["username"]) {

            $fetchedUserid = $getResult["userid"];
            
            $updateData = "UPDATE users SET user_otp = '$otp' WHERE userid = '$fetchedUserid'";
            
            $result = mysqli_query($connect, $updateData);
            
            if ($result) {
                $_SESSION["user_otp"] = $otp;
                $_SESSION["temp_id"] = $fetchedUserid;
                header("Location: forgetpasswordwithotp.php");

                mysqli_close($connect);
                // echo '<script>window.location.href = "./forgetpasswordwithotp";</script>';

                exit();
            } else {
                echo "Error: " . mysqli_error($connect);
            }
        } else {
            $errorMsg['errName'] = "The user name or user email is incorrect.";
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

    <a class=" ms-2 ps-3 pt-1 position-absolute btn btn-outline-dark" href="./<?php if (isset($_SESSION["username"])) {echo "usersetting.php";}else{echo "login.php";} ?>"><i class="fa-solid fa-arrow-left"></i> Go back</a>
    <h4 class="text-center mt-4">Forget your password</h4>


    <div class="d-flex justify-content-center aligin-items-center mt-5 text-center">

        <form class="text-center form-control p-3 w-25 m-auto was-validated" action="./forgetpassword.php" method="post" enctype="multipart/form-data">

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="username" placeholder="Type the email" required value="<?php echo $username; ?>">
                <label for="floatingPassword">Type your username</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="email" name="usermail" placeholder="Type the email" required value="<?php echo $usermail; ?>">
                <label for="floatingPassword">Type your linked email</label>
            </div>




            <input class="my-2 btn btn-outline-success py-2 w-100" type="submit" name="get-otp" value="Send otp"> <br>



            <?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-1">' . $errorMsg['errName'] . "</div>";
            } ?>


        </form>
    </div>
</body>

</html>