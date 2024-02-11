<?php
session_start();
if (!isset($_SESSION["login_status"])) {
    // header("Location: login.php");
    echo '<script>window.location.href = "./login.php";</script>';
    exit();
}

require_once("./utility/connectdb.php");

$updatedUsermail = $currentPassword = "";

$errorMsg = [];

$userid = $_SESSION["userid"];
$dataSql =  "SELECT * FROM users WHERE userid='$userid'";
$selectresult = mysqli_query($connect, $dataSql);
$getResult = mysqli_fetch_assoc($selectresult);

if (isset($_POST["edit"])) {

    $updatedUsermail = filter_input(INPUT_POST, "updated-usermail", FILTER_SANITIZE_EMAIL);
    $currentPassword =  filter_input(INPUT_POST, "current-password", FILTER_SANITIZE_SPECIAL_CHARS);


    if (!empty($updatedUsermail)) {

        if (!empty($currentPassword)) {



            
            if ($getResult["password"] == $currentPassword) {
                
                $updateEmailonDB = "UPDATE users SET usermail = '$updatedUsermail' WHERE userid = '$userid'";
                
                $result = mysqli_query($connect, $updateEmailonDB);
                
                if ($result) {
                    mysqli_close($connect);
                    // print_r($getResult);
                    // header("Location: userprofile.php");
                    echo '<script>window.location.href = "./userprofile.php";</script>';

                    exit();
                } else {
                    echo "Error: " . mysqli_error($connect);
                }
            }else{
                $errorMsg['errName'] = "Incorrect Password";
            }
        }
    }
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

    <a class=" ms-2 ps-3 pt-1 position-absolute btn btn-outline-dark" href="./usersetting.php"><i class="fa-solid fa-arrow-left"></i> Go Back</a>

    <a class="me-2 pe-3 pt-1 btn btn-outline-dark  position-absolute" style="right: 0;" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>

    <h4 class="text-center mt-4">Update your email.</h4>


    <div class="d-flex justify-content-center aligin-items-center my-5 text-center">

        <form class="text-center form-control p-3 w-25 m-auto was-validated" action="./editemail.php" method="post" enctype="multipart/form-data">


            <p class="m-0 fw-bold">Your current email is :</p>
            <p class="text-decoration-underline"><?php echo $getResult["usermail"]; ?></p>


            <div class="form-floating mb-3">
                <input class="form-control" type="email" name="updated-usermail" placeholder="Type your email" value="<?php echo $updatedUsermail ?>" required>
                <label for="floatingInput">Put an valid email.</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="current-password" placeholder="Create a new pasword" value="<?php echo $currentPassword ?>" required>
                <label for="floatingPassword">Input your current password.</label>
            </div>


            <input class="my-2 btn btn-outline-primary px-5" type="submit" name="edit" value="Edit"> <br>

            <?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-1">' . $errorMsg['errName'] . "</div>";
            } ?>

        </form>
    </div>
</body>

</html>