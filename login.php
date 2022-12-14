<?php
include('conn.php');
session_start();
if (isset($_SESSION['id'])) {
    header("location:index.php");
}
$message = '';
if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT id,username FROM admin WHERE username = '" . $username . "' AND password = '" . $password . "' ";
    $statement = mysqli_query($db, $query);
    if (mysqli_num_rows($statement) > 0) {
        while ($row = mysqli_fetch_assoc($statement)) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
        }
        header("location:index.php");
    }
} else {
    $message = "<div class='alert alert-danger'>
            <i class='fa fa-exclamation-triangle'></i>
            <strong>Wrong Username / Password</strong>
        </div>";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <title>Login form</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style media="screen">
        body {
            background-image: url(1445466.webp);
            /* width: 100; */
            /* height: 100; */
            filter:blur(10.7);
            cursor: pointer;
            background-repeat: no-repeat;
            background-size: cover;
            object-fit: cover;

        }

        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        .background {
            width: 430px;
            height: 500px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        form {
            height: 430px;
            width: 350px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 12px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 5px;
            font-size: 14px;
            font-weight: 300;
        }

        input[type=text]:focus {
            border: 3px solid #555;
        }

        input[type=password]:focus {
            border: 3px solid #555;
        }

        /* input[type=submit].btn:hover{
         border: 1px solid black;
         } */

        input#sign_in {
            background-color: #4c9ed9;
            color: #ffffff;
            padding: 20px 40px;
            border: 1px solid #111;
        }

        input#sign_in:hover {
            background-color: #ffffff;
            color: #4c9ed9;
            border: 1px solid #111;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            /* background-color: #4c9ed9; */
            background-color: #ffffff;
            /* color: #ffffff;
                padding: 20px 40px; */
            border: 1px solid #111;
            margin-top: 30px;
            width: 100px;
            /* background-color: #ffffff; */
            color: #080710;
            padding: 12px 0;
            font-size: 18px;
            font-weight: 500;
            border-radius: 5px;
            cursor: pointer;

        }

        button:hover {
            background-color: blue;
            color: #ffffff;
            border: 1px solid #111;
        }
    </style>
</head>

<body>

    <form action="" method="post">
        <img src="user.png" width="50px" height="50px" style="border-radius: 50%; margin:auto;  display: block;
        margin-left: auto;
        margin-right: auto;">
        <h4 align="center">Login Here</h4>

        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Email or Phone" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password">

        <button type="submit" name="submit" id="sign_in">Log In</button>

    </form>
</body>

</html>