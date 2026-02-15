<?php
session_start();
include 'db.php';

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
if (!isset($_SESSION['lock_time'])) {
    $_SESSION['lock_time'] = 0;
}

$remaining = $_SESSION['lock_time'] - time();

// LOCKOUT SCREEN
if ($remaining > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="login.css">
        <link rel="icon" href="reg.png" type="image/png">
        <title>LOGIN LOCKED</title>
        <style>
            #lock-message {
                margin-top: 20px;
                font-size: 18px;
                color: red;
                font-weight: bold;
                text-align: center;
            }
            #countdown{
                margin-top: 20px;
                font-size: 18px;
                color: green;
                font-weight: bold;
                text-align: center;
            }
            .btnsubmit:disabled {
                background-color: #ccc;
                cursor: not-allowed;
            }
        </style>
    </head>
    <body>
    <div class="container">
        <div class="form-box login">
            <form>
                <h1 class="login">Login</h1>
                <div id="lock-message">
                    Too many failed attempts.<br>
                    Try again in <span id="countdown"><?php echo $remaining; ?></span> seconds.
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Username" disabled>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password" disabled>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button class="btnsubmit" type="submit" disabled>LOGIN</button>
            </form>
        </div>
    </div>

    <script>
        let timeLeft = <?php echo $remaining; ?>;
        const countdownEl = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            if (timeLeft <= 0) {
                clearInterval(timer);
                location.reload();
            }
        }, 1000);
    </script>
    </body>
    </html>
    <?php
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $_SESSION['attempts'] += 1;
        $stmt->close();
        $conn->close();

        if ($_SESSION['attempts'] >= 3) {
            $_SESSION['lock_time'] = time() + 30;
            $_SESSION['attempts'] = 0;
        }
        echo "<script>alert('Invalid username!'); window.location.href='login.html';</script>";
        exit();
    } else {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['attempts'] = 0;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['attempts'] += 1;
            if ($_SESSION['attempts'] >= 3) {
                $_SESSION['lock_time'] = time() + 30;
                $_SESSION['attempts'] = 0;
            }
            echo "<script>alert('Invalid password!'); window.location.href='login.html';</script>";
            exit();
        }
    }

    $stmt->close();
    $conn->close();
}
?>
