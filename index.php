<?php
session_start();

if (!isset($_SESSION["login_status"])) {
    header("Location: login.php");
    exit();
}
require_once("./utility/connectdb.php");


$fetchPost = "SELECT * FROM userpost ORDER BY posttime DESC;";

$selectresult = mysqli_query($connect, $fetchPost);


//  echo "<pre>";
//  while($row = mysqli_fetch_assoc($selectresult)){
//          print_r($row);

//  }


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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <?php require_once("./utility/header.php"); ?>

    <div class="container mb-2">
        <a href="./createpost.php"><i class="fa-solid fa-edit"></i>Create a post</a>
    </div>

    <div class="container">

        <?php while ($row = mysqli_fetch_assoc($selectresult)) {


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
                                <p class="ms-3">Posted on <?php echo displayData($row["posttime"]); ?></p>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>