<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    header("Location: login.php");
    // echo '<script>window.location.href = "./login.php";</script>';  
    exit();
}
require_once("./utility/connectdb.php");


$fetchUserpostData = "SELECT * FROM userpost ORDER BY posttime DESC;";

$selectresultOfUserpostDB = mysqli_query($connect, $fetchUserpostData);


//  echo "<pre>";
//  while($row = mysqli_fetch_assoc($selectresultOfUserpostDB)){
//          print_r($row);

//  }


function displayData($data)
{
    $data = ucfirst($data); // Capitalize the first letter of the string
    $data = str_replace('_', ' ', $data); // Replace underscores with spaces
    return $data; // Return the modified string
}



$posttitle = $postdescription = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace(' ', '_', $data);
    return $data;
};


if (isset($_POST["submitpost"])) {

    $posttitle = filter_input(INPUT_POST, "posttitle", FILTER_SANITIZE_SPECIAL_CHARS);
    $postdescription = filter_input(INPUT_POST, "postdescription", FILTER_SANITIZE_SPECIAL_CHARS);

    $posttitle = test_input($posttitle);
    $postdescription = test_input($postdescription);

    if (!empty($posttitle) && !empty($postdescription)) {

        $userid = $_SESSION["userid"];
        date_default_timezone_set("Asia/Calcutta"); //India time (GMT+5:30)
        $datetime =  date("d-m-Y_H:i:sa");
        $userimg = "NULL";

        // the file uploading logic
        if (!empty($_FILES['postimg']['name']) || strlen($_FILES['postimg']['name'])) {
            $userimg =  "sakebook_" . time() . "_" . str_replace(" ", "_", $_FILES['postimg']['name']);
            move_uploaded_file($_FILES['postimg']['tmp_name'], "postdata/" . $userimg);
        }

        $uploadDataIntoUserpostDB = "INSERT INTO userpost (which_user_posted, postname, post_description, postimg, posttime) VALUES ('$userid', '$posttitle', '$postdescription', '$userimg', '$datetime') ";

        $resultOfFetchedPost = mysqli_query($connect, $uploadDataIntoUserpostDB);

        if ($resultOfFetchedPost) {
            header("Location: index.php");
        } else {
            echo "data uploding failed";
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rubik+Doodle+Shadow&display=swap" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body class="overflow-hidden">

    <div class="container main-container p-0 ">
        <div class="row m-0 justify-content-between main-box">

            <div class="col-2 left-section-box p-0 mt-2">
                <a class="site-logo" href="">Sakebook</a>
                <ul class="left-section-nav mt-2">
                    <li><a href="./index.php"><i class="fa-solid fa-home pe-2"></i> Home</a></li>
                    <li><a href="./index.php"><i class="fa-solid fa-hashtag pe-2"></i> Explore</a></li>
                    <li><a href="./userprofile.php"><i class="fa-solid fa-user pe-2"></i> Profile</a></li>
                    <li><a href="./usersetting.php"><i class="fa-solid fa-sliders pe-2"></i> More</a></li>
                </ul>

            </div>

            <div class="col-7 main-section-box border p-0">
                <a class=" px-4 py-2 text-dark title-page" href="./index.php">Home</a>
                <div class="w-100 border-bottom "></div>

                <div class="w-100 create-post py-2 px-2 row justify-content-between m-0">

                    <div class="col-1 p-0 create-post-user-img-box">
                        <a class="" href="./userprofile.php">
                            <img class="rounded-circle border border-dark border-2" src="./userdata/<?php echo $_SESSION["userimg"]; ?>" alt="" width="55" height="55">
                        </a>
                    </div>

                    <div class="col-11 create-post-form-wraper p-0">
                        <form class="" action="./index.php" method="post" enctype="multipart/form-data">

                            <div class="row m-0 justify-content-between">
                                <div class="col-8">
                                    <input type="text" name="posttitle" placeholder="Post Title" required>
                                </div>

                                <div class="col-2 createpost-file">
                                    <input type="file" name="postimg" id="upload-photo">
                                </div>

                                <div class="col-9">
                                    <textarea name="postdescription" id="postdescription" placeholder="What on your mind?" required></textarea>
                                </div>

                                <div class="col-3 my-auto">
                                    <input type="submit" name="submitpost" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <a href="./createpost.php">Create post</a> -->
                </div>

                <div class="w-100 border-bottom "></div>

                <div class="content-wraper">
                    <?php while ($row = mysqli_fetch_assoc($selectresultOfUserpostDB)) {


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

                        <div class="content-box px-2 py-2">
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


            <div class="col-3 right-section-box pt-1">
                <a class="search-btn btn ps-3" href=""><i class="fa-solid fa-search me-3"></i> Search</a>
            </div>
        </div>
    </div>

























    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/index.js"></script>
</body>

</html>