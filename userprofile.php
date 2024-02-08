<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    // header("Location: login.php");
    echo '<script>window.location.href = "./login.php";</script>';
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

$selectpostsql = "SELECT * FROM userpost WHERE which_user_posted = '$whichUserPosted'";
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
    <div class="container mb-5 pe-5">
        <div class="text-end me-5 pe-5">

            <h5>All Post From User</h5>
        </div>
    </div>

    <div class="container mt-5">

        <?php while ($row = mysqli_fetch_assoc($postresult)) {


            $whichUserPosted = $row["which_user_posted"];

            $selectSql = "SELECT * FROM users WHERE userid = '$whichUserPosted'";
            $result = mysqli_query($connect, $selectSql);
            $fetchedData = mysqli_fetch_assoc($result);

            // print_r($row);
            // var_dump($fetchedData["username"]);
            // var_dump($fetchedData["userimg"]);

        ?>



            <div class="post-box m-auto card my-3 overflow-hidden">
                <div class="row m-0">
                    <div class="col-12 bg-dark card-box-heading">
                        <div class=" d-flex justify-content-between align-items-center">
                            <div class="d-flex mt-3 mx-3">
                                <h3><?php echo displayData($row["postname"]); ?></h3>
                                <p class="ms-3 post-time">Posted on <?php echo displayData($row["posttime"]); ?></p>
                            </div>
                            <div class="which-user-posted mt-2">
                                <ul>
                                    <li><span>By</span></li>
                                    <li>
                                        <a href=""><?php echo displayData($fetchedData["username"]); ?>
                                            <img src="./userdata/<?php echo $fetchedData["userimg"]; ?>" alt="No img">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <p class="ms-3 text-light"><?php echo displayData($row["post_description"]); ?></p>
                    </div>
                    <div class="col-12 card-box-img bg-dark px-3">
                        <img class="" src="./postdata/<?php echo $row["postimg"]; ?>" alt="">
                    </div>

                    <div class="col-12 d-flex justify-content-around bg-dark py-1 px-3 text-light">
                        <p class="m-0">Like <span>0</span></p>
                        <p class="m-0">Comment <span>0</span></p>
                        <p class="m-0">Shere <span>0</span></p>
                    </div>
                    <div class="col-12 card-user-intraction d-flex justify-content-between bg-dark p-0 px-3 pb-2">
                        <a href=""><i class="fa-regular fa-heart"></i></a>
                        <a href=""><i class="fa-regular fa-comments"></i></a>
                        <a href=""><i class="fa-solid fa-share-nodes"></i></a>
                    </div>
                </div>
            </div>

        <?php }; ?>


    </div>
</body>

</html>