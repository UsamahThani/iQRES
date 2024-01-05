<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" href="https://i.imgur.com/DnvtJhq.png">
    <title>Login | iQReS</title>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="logo_campus">
                <img src="https://i.ibb.co/f2WhHr0/876fsafs9.png" alt="iQReS logo" class="logo">
                <span class="campus"><sub>UiTM</sub></span>
            </div>
        </div>
        <div class="wrapper">
            <form action="function_login.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="userId" placeholder="Student Number" autocomplete="off" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="userPass" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>