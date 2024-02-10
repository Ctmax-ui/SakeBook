<?php
    session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Setting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="./css/extra.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <div style="height: 35px;" class=" mb-3 position-relative">
<?php if (isset($_SESSION["userid"])) {
            echo '<a class="mt-2 ms-2 ps-3 pt-1  btn btn-outline-dark position-absolute" href="./index.php"><i class="fa-solid fa-arrow-left"></i> Go Back</a>';
        } ?>
        <?php if (isset($_SESSION["userid"])) {
            echo '<a class="mt-2 me-2 pe-3 pt-1 btn btn-outline-dark position-absolute" style="right: 0;" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>';
        } ?>
</div>
    <div class="container">
        <div class="row m-0">

            <div class="col-4 left-section-box p-0 mt-2">
            <a class="site-logo" href="">User Setting</a>
            <ul class="left-section-nav mt-5 ">
                <li><a style="width: 100%; padding: 20px 30px;" href="./index.php"><i class="fa-solid fa-at pe-2"></i>Edit UserName</a></li>
                <li><a style="width: 100%; padding: 20px 30px;" href="./editptofilepic.php"><i class="fa-solid fa-image pe-2 "></i> Edit Profile Picture</a></li>
                    <li><a style="width: 100%; padding: 20px 30px;" href="./index.php"><i class="fa-solid fa-envelope-circle-check pe-2"></i> Change UserEmail</a></li>
                    <li><a style="width: 100%; padding: 20px 30px;" href="./userprofile.php"><i class="fa-solid fa-unlock-keyhole pe-2"></i> Change Password</a></li>
                </ul>
            </div>

            <div class="col-6"></div>
        </div>
    </div>



    
</body>
</html>