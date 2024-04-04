<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toto</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5b7efaafb7.js" crossorigin="anonymous"></script>
</head>
<body>
    <section class="header">
        <nav>
            <a href="index.php"><img id="logo" src="media/web logo.png" alt=""></a>
            <div class="nav-links" id="navLinks">
                <i class="fa-solid fa-xmark" style="color: #ffffff;" onclick="hidemenu()"></i>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <!-- <li><a href="#" id="contact-link">Contact Us</a></li> -->
                    <!-- <li><a href="#" id="nav-users">Users</a></li> -->
                    <a href="login.php"><button id="login">Login</button></a>
                    <!-- <a href="registration.html"><button id="signup">Register</button></a> -->
                </ul>
            </div>
            <i class="fa-solid fa-bars" style="color: #ffffff;" onclick="showmenu()"></i>
        </nav>
        </section>
<script>
        var navLinks = document.getElementById("navLinks");
        function showmenu(){
            navLinks.style.right = "0";
        }
        function hidemenu(){
            navLinks.style.right = "-200px";
        }
    </script>
    <section class="register">
    <div class="container" style="width: 40%;">
        <h2 style="text-align: center;">Register to Toto</h2>
<?php
if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeat-password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $errors = array();

    if(empty($username) OR empty($email) OR empty($password) OR empty($repeatpassword)){
        array_push($errors,"All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors,"Email is not valid");
    }
    if (strlen($password)<8) {
        array_push($errors,"Password must be atleast 8 characters long");
    }
    if ($password!==$repeatpassword) {
        array_push($errors,"Password does not match");
    }
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($result);
    if ($rowcount>0) {
        array_push($errors,"Email already exists!");
    }
    if (count($errors)>0) {
        foreach ($errors as $errors) {
            echo "<div class='alert alert-danger'>$errors</div>";
        }
    }else{
        $sql = "INSERT INTO users (username, email, password) VALUES(?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt,"sss",$username,$email,$passwordHash);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are registered successfully</div>";

        }else {
            die("something went wrong");
        }


    }
}
?>
        <form id="registrationForm" action="registration.php" method="POST">
            <div class="form-signup">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">            
            <label for="password">Repeat-Password:</label>
            <input type="password" id="repeat-password" name="repeat-password">            
            <button type="submit" value="Register" name="submit">Register</button>
            <p class="message">Already Registered?<a href="login.php"> Login here</a></p>
        </div>
        </form>
    </div>
</section>
    <script src="script.js"></script>
    <footer class="foot">
        <p>&#169 Toto,  All  Rights  Reserved.</p>
    </footer>
</body>
</html>
