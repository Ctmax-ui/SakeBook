<?php
session_start();
if(!isset($_SESSION["login_status"])){
    // header("Location: login.php");
    echo '<script>window.location.href = "./login.php";</script>';
    exit();
}


require_once("./utility/connectdb.php");

$userid = $_SESSION["userid"];
$dataSql =  "SELECT * FROM users WHERE userid='$userid'";
$selectresult = mysqli_query($connect, $dataSql);
$getResult = mysqli_fetch_assoc($selectresult);

$errorMsg = [];


function isUsernameExists($inputUsername, $currentUserId = null) {
    global $connect; // Sanitize input to prevent SQL injection
    $inputUsername = mysqli_real_escape_string($connect, $inputUsername);  // Query to check if the username already exists excluding the current user (if provided)
    
    $query = "SELECT COUNT(*) as count FROM users WHERE username = '$inputUsername'";
    if ($currentUserId !== null) {
        $currentUserId = (int) $currentUserId;
        $query .= " AND userid != $currentUserId";
    }
    $result = mysqli_query($connect, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return ($row['count'] > 0); // Return true if count is greater than 0 (username exists), otherwise false
    } else {
        return false;
    };
}

// var_dump($getResult["userimg"]);

if (!$getResult) {
    // Handle the case where the user with the given ID is not found
    echo "User not found!";
    exit();
}

if (isset($_POST["edit"])) {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    // $usermail = filter_input(INPUT_POST, "usermail", FILTER_SANITIZE_EMAIL);
    // $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    // $userfile = $_FILES["userfile"];

    $username = str_replace(' ', '', $username);
    // $password = str_replace(' ', '', $password);

    if (!empty($username)) {

        $numrows = mysqli_query($connect, "SELECT userid FROM users WHERE username = '$username'");
        $usname = mysqli_query($connect, "SELECT username FROM users WHERE userid = '$userid'");

        // print_r($usname);

        if (isUsernameExists($username, $userid)) {
            $errorMsg['errName'] = "The user name is already exsist.";
            // echo "The user name is already exsist.";
        } 
        
        elseif (preg_match("/^[a-zA-Z-']+[0-9]*$/", $username)) {

            $_SESSION["userid"] = $userid;
                $_SESSION["username"] = $username;
                // $_SESSION["usermail"] = $usermail;
                // $_SESSION["password"] = $password;
                // $_SESSION["userimg"] = $getResult["userimg"];

            //     $filesValue = $getResult["userimg"];

            // if (!empty($userfile["name"])) {
            //     $filesValue =  "simple-form_" .  time() . "_" . str_replace(" ", "_", $userfile["name"]);
            //     move_uploaded_file($userfile["tmp_name"], "userdata/" . $filesValue);
            // } else {
            //     move_uploaded_file($userfile["tmp_name"], "userdata/" . $filesValue);
            // };

            $updateData = "UPDATE users SET username = '$username' WHERE userid = '$userid'";

                

            $result = mysqli_query($connect, $updateData);
            
            if ($result) {  
                mysqli_close($connect);
                // header("Location: userprofile.php");
                echo '<script>window.location.href = "./userprofile.php";</script>';
               
                exit();
            } else {
                echo "Error: " . mysqli_error($connect);
            }
        } else {
            echo "Invalid username or password format!";
        }
    } else {
        echo "Username, email, or password is empty!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UserName</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    
<?php if (isset($_SESSION["userid"])) {
            echo '<a class=" ms-2 ps-3 pt-1 position-absolute btn btn-outline-dark" href="./usersetting.php"><i class="fa-solid fa-arrow-left"></i> Go Back</a>';
        } ?>
        <?php if (isset($_SESSION["userid"])) {
            echo '<a class="me-2 pe-3 pt-1 btn btn-outline-dark  position-absolute" style="right: 0;" href="./logout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>';
        } ?>

<h4 class="text-center mt-4">Change User Name.</h4>

    <div class="d-flex justify-content-center aligin-items-center my-5 text-center">

        <form class="text-center form-control p-3 w-25 m-auto was-validated" action="./editusername.php" method="post" enctype="multipart/form-data">

            <div class="form-floating mb-3">
                <input class="form-control has-validated" type="text" name="username" placeholder="Create a Username" required value="<?php echo $getResult["username"] ?>">
                <label for="floatingInput">Change UserName to</label>
            </div>


            <!-- <div class="form-floating mb-3">
                <input class="form-control" type="email" name="usermail" placeholder="Type your email" required value="<?php echo $getResult["usermail"]; ?>">
                <label for="floatingInput">Put an valid Email</label>
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="password" placeholder="Create a new pasword" required value="<?php echo $getResult["password"] ?>">
                <label for="floatingPassword">Password</label>
            </div>


            <div class=" border border-1 p-2">
                <input class="form-imput" type="file" name="userfile"><br>
                <img class="img-fluid mt-2" style="width: 150px; hight: auto;" src="./userdata/<?php echo $getResult["userimg"] ?>" alt="No Image">
            </div> -->

            <input class="my-2 btn btn-outline-success" type="submit" name="edit" value="Edit"> <br>

            <?php if (!empty($errorMsg['errName'])) {
                echo '<div class="text-danger mt-1">' . $errorMsg['errName'] . "</div>";
            } ?>

        </form>
    </div>
</body>

</html>