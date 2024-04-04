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
        <nav >
            <a href="index.php"><img id="logo" src="media/web logo.png" alt=""></a>
            <div class="nav-links" id="navLinks">
                <i class="fa-solid fa-xmark" style="color: #ffffff;" onclick="hidemenu()"></i>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <!-- <li><a href="#" id="contact-link">Contact Us</a></li> -->
                    <!-- <li><a href="#" id="nav-users">Users</a></li> -->
                    <!-- <a href="login.html"><button id="login">Login</button></a> -->
                    <a href="registration.php"><button id="signup">Register</button></a>
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
        <h2 style="text-align: center;">LOGIN TO YOUR ACCOUNT</h2>
<?php
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if ($user) {
        if(password_verify($password,$user["password"])){
            session_start();
            $_SESSION["user"]="yes";
            header("Location: index.php");
            die();
        }else{
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    }else{
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }
}
?>
        <form id="loginForm" action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            
            <button type="submit"  value="login" name="login">Login</button>
            <p class="message">Don't have an account?<a href="registration.php"> Register here</a></p>
        </form>
    </div>
</section>
    <footer class="foot">
        <p>&#169 Toto,  All  Rights  Reserved.</p>
    </footer>
</body>
</html>
