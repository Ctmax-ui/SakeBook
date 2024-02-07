<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    header("Location: login.php");
    exit();
}
// if ($userid != $fetchedData["userid"]) {
//     header("Location: login.php");
//     exit();
// }


require_once("./utility/connectdb.php");




$userid = $_SESSION["userid"];
// print_r($_SESSION);



$selectSql = "SELECT * FROM users WHERE userid = '$userid'";

$result = mysqli_query($connect, $selectSql);

$fetchedData = mysqli_fetch_assoc($result);
// print_r($fetchedData);

$_SESSION["userid"] = $fetchedData["userid"];
$_SESSION["username"] = $fetchedData["username"];
$_SESSION["usermail"] = $fetchedData["usermail"];
$_SESSION["password"] = $fetchedData["password"];
$_SESSION["userimg"] = $fetchedData["userimg"];


$whichUserPosted = $fetchedData["userid"];

$selectpostsql = "SELECT * FROM userpost WHERE which_user_posted = '$whichUserPosted'";
$postresult = mysqli_query($connect, $selectpostsql);

 while($row = mysqli_fetch_assoc($postresult)){
    echo "<pre>";
    print_r($row);
    
    echo "</pre>";
 }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="./css/extra.css" rel="stylesheet">
</head>

<body>

    <div class="whole-wraper">
    
    <?php if(isset($_SESSION["username"])){
          echo '<a class="ps-3 pt-3 text-light position-absolute" href="./index.php"><i class="fa-solid fa-home"></i> Home</a>';}?>

        <div class="background-pic"></div>
        <div class="container pt-5">
            <div class="row m-0">
                <div class="col-5">
                    <div class="w-100 d-grid  justify-content-center text-center">
                        <div class="position-relative border border-dark border-2 rounded-pill user-profile-box mb-4">
                            <img src="<?php if ($_SESSION["userimg"] !== "NULL") {
                                            echo "./userdata/" . $_SESSION["userimg"];
                                        } else {
                                        } ?>" alt="No Profile Picture">
                            <a href="./edituser.php"><i class="fa-solid fa-user-pen"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-7 right-box">
                        <p class="text-left"><span class="fw-bold">Username : </span><?php echo $fetchedData["username"]; ?></p>
                        <p class=" text-left"><span class="fw-bold">Email : </span><?php echo $fetchedData["usermail"]; ?></p>
                        <p class=" text-left"><span class="fw-bold">Password : </span><?php echo $fetchedData["password"]; ?></p>
                </div>
            </div>


        </div>
    </div>
    <div class="container mt-4">
        <h5>All Post From User</h5>
    </div>
</body>

</html>