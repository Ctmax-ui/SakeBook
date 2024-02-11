<?php
session_start();
if (!isset($_SESSION["login_status"])) {
    // header("Location: login.php");
    echo '<script>window.location.href = "./login.php";</script>';
    exit();
}

require_once("./utility/connectdb.php");

$oldPassword = $newPassword = $confirmPassword = "";

$errorMsg = [];

$userid = $_SESSION["userid"];
$dataSql =  "SELECT * FROM users WHERE userid='$userid'";
$selectresult = mysqli_query($connect, $dataSql);
$getResult = mysqli_fetch_assoc($selectresult);

if (isset($_POST["edit-password"])) {

    $oldPassword = filter_input(INPUT_POST, "current-password", FILTER_SANITIZE_EMAIL);
    $newPassword =  filter_input(INPUT_POST, "new-password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPassword =  filter_input(INPUT_POST, "new-password-confirm", FILTER_SANITIZE_SPECIAL_CHARS);

    $oldPassword = str_replace(' ', '', $oldPassword);
    $newPassword = str_replace(' ', '', $newPassword);
    $confirmPassword = str_replace(' ', '', $confirmPassword);

    if ($oldPassword == $getResult["password"] && !empty($oldPassword)) {
        
        if (empty($newPassword)) {
            $errorMsg['errName'] = "New password is empty!.";
        } else if (empty($confirmPassword)) {
            $errorMsg['errName'] = "confirm password is empty!.";
        }else{
            
            if($newPassword == $confirmPassword){
                echo $oldPassword;
                echo "success";

                $updatePassword = "UPDATE users SET password = '$newPassword' WHERE userid = '$userid'";

                

                $result = mysqli_query($connect, $updatePassword);
                
                if ($result) {  
                    mysqli_close($connect);
                    // header("Location: userprofile.php");
                    echo '<script>window.location.href = "./usersetting.php";</script>';
                   
                    exit();
                } else {
                    echo "Error: " . mysqli_error($connect);
                }

            }else{
                $errorMsg['errName'] = "Check your confirm password ";
            }


        }


    } else {
        $errorMsg['errName'] = "Incorrect old password.";
    }
}


function maskString($str) {
    $firstThreeChars = substr($str, 0, 2);
    $remainingChars = substr($str, 3);
    $maskedChars = str_repeat('*', strlen($remainingChars));
    $maskedString = $firstThreeChars . $maskedChars;
    return $maskedString;
}

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

    <a class=" ms-2 ps-3 pt-1 position-absolute btn btn-outline-dark" href="./usersetting.php"><i class="fa-solid fa-arrow-left"></i> Go back</a>

    <a class="me-2 pe-3 pt-1 btn btn-outline-dark  position-absolute" style="right: 0;" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a>

    <h4 class="text-center mt-4">Update your password</h4>


    <p class="my-1 mt-3 fw-bold text-center">Your current password is : <span class="text-decoration-underline"><?php echo maskString($getResult["password"]) ?></span></p>
    <div class="d-flex justify-content-center aligin-items-center mt-3 text-center">

        <form class="text-center form-control p-3 w-25 m-auto was-validated" action="./editpassword.php" method="post" enctype="multipart/form-data">




            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="current-password" placeholder="Type your email" value="<?php echo $oldPassword ?>" required>
                <label for="floatingInput">Your old password</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="new-password" placeholder="Create a new pasword" value="<?php echo $newPassword ?>" required>
                <label for="floatingPassword">Create a new password</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="new-password-confirm" placeholder="Create a new pasword" value="<?php echo $confirmPassword ?>" required>
                <label for="floatingPassword">Confirm new password</label>
            </div>


            <input class="my-2 btn btn-outline-success px-5 w-100" type="submit" name="edit-password" value="Submit"> <br>
            <p class="m-0">or</p>
            <a href="./forgetpassword.php" class=" btn btn-outline-primary px-5 w-100" name="forget-password">Forget Password</a>

            <?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-1">' . $errorMsg['errName'] . "</div>";
            } ?>

        </form>
    </div>
</body>

</html>