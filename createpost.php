<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    // header("Location: login.php");
    echo '<script>window.location.href = "./login.php";</script>';
    exit();
}

require_once("./utility/connectdb.php");

// print_r($_SESSION);


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

        $uploadData = "INSERT INTO userpost (which_user_posted, postname, post_description, postimg, posttime) VALUES ('$userid', '$posttitle', '$postdescription', '$userimg', '$datetime') ";

        $result = mysqli_query($connect, $uploadData);

        if ($result) {
            // echo $userid . " " . $posttitle . " " . $postdescription . " " . $userimg;
            mysqli_close($connect);
            // header("Location: index.php");
            echo '<script>window.location.href = "./login.php";</script>';
            exit();
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
    <title>Create a post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link href="./css/extra.css" rel="stylesheet">
</head>

<body>
    <?php require_once("./utility/header.php"); ?>

    <div class="container mt-5">
        <form class="d-grid justify-content-center align-items-center create-post-form-elem" action="./createpost.php" method="post" enctype="multipart/form-data">

            <input type="text" name="posttitle" placeholder="Post Title" required>

            <textarea name="postdescription" placeholder="What on your mind?" required></textarea>


                <input type="file" name="postimg" id="upload-photo">
            

            <input type="submit" name="submitpost" value="Create">

        </form>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>