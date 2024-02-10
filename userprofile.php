<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    header("Location: login.php");
    // echo '<script>window.location.href = "./login.php";</script>';
    echo
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

$selectpostsql = "SELECT * FROM userpost WHERE which_user_posted = '$whichUserPosted' ORDER BY posttime DESC";
$postresult = mysqli_query($connect, $selectpostsql);

// while ($row = mysqli_fetch_assoc($postresult)) {
//     echo "<pre>";
//     print_r($row);

//     echo "</pre>";
// }

function displayData($data)
{
    $data = ucfirst($data); // Capitalize the first letter of the string
    $data = str_replace('_', ' ', $data); // Replace underscores with spaces
    return $data; // Return the modified string
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
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>

    <div class="whole-wraper">

        <?php if (isset($_SESSION["username"])) {
            echo '<a class="ps-3 pt-3 text-light position-absolute" href="./index.php"><i class="fa-solid fa-home"></i> Home</a>';
        } ?>
        <?php if (isset($_SESSION["username"])) {
            echo '<a class="pe-3 pt-3 text-light  position-absolute" style="right: 0;" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>';
        } ?>

        <div class="background-pic"></div>
        <div class="container pt-5">
            <div class="row m-0">
                <div class="col-5">
                    <div class="w-100 d-grid  justify-content-center text-center">
                        <div class="position-relative user-profile-box mb-4">
                            <img src="<?php if ($_SESSION["userimg"] !== "NULL") {
                                            echo "./userdata/" . $_SESSION["userimg"];
                                        } else {
                                        } ?>" alt="No Profile Picture">
                            <a href="./editptofilepic.php"><i class="fa-regular fa-image pe-2"></i> <span> Change</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-7 right-box">
                   <a class="edit-profile" href="./usersetting.php"><i class="fa-solid fa-pen"></i> Edit Profile</a>
                </div>
            </div>


            <h4 class="ms-5 ps-5 fw-bolder mt-1 username-paragraph"><?php echo displayData($fetchedData["username"]) ?></h4>
        </div>
    </div>

    <div class="container mb-2 pe-5">
        <div class="text-end me-5 pe-5">
            <p class="fw-bold"><i class="fa-solid fa-arrow-down-short-wide"></i> All Post From User </p>
        </div>
    </div>

    <div class="small-container">
        <div class="content-wraper">
            <?php while ($row = mysqli_fetch_assoc($postresult)) {
                $whichUserPosted = $row["which_user_posted"];
                $selectSql = "SELECT * FROM users WHERE userid = '$whichUserPosted'";
                $result = mysqli_query($connect, $selectSql);
                $fetchedData = mysqli_fetch_assoc($result);
                // echo "<pre>";
                // print_r($row);
                // var_dump($fetchedData["username"]);
                // var_dump($fetchedData["userimg"]);
                // echo "</pre>";
            ?>

                <div class="px-2 py-2">
                    <div class="d-flex align-items-center">
                        <img class="post-img" src="./userdata/<?php echo $fetchedData["userimg"] ?>" alt="">
                        <h5 class="ms-3 mt-2"><?php echo displayData($row["postname"]); ?></h5>
                        <p class="ms-auto post-date">Posted On <?php echo displayData($row["posttime"]); ?></p>
                    </div>
                    <p class="ms-3 mt-3"><?php echo displayData($row["post_description"]); ?></p>
                    <div class="mt-3 content-img-wraper">
                        <img width="100%" src="./postdata/<?php echo $row["postimg"]; ?>" alt="">
                    </div>


                    <div class="d-flex align-items-center justify-content-around my-2 intract-icon-box">
                        <div class="like-box"><a href=""><i class="fa-regular fa-heart"></i></a> <span>0</span></div>
                        <div class="comment-box"><a href=""><i class="fa-regular fa-comment"></i></a> <span>0</span></div>

                        <a class="shere-box" href=""><i class="fa-regular fa-share-from-square"></i></a>
                    </div>
                </div>
                <div class="w-100 border-bottom "></div>
            <?php } ?>
        </div>
    </div>
</body>

</html>