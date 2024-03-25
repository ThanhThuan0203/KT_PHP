<?php
session_start();
require_once("config/db.class.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = new Db();
    $connection = $db->connect();

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->query_execute($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" type="text/css" href="site.css">
</head>
<body>
    <header>Đăng nhập</header>
    <div class="container">
        <form method="post">
            <label for="username">Tên đăng nhập:</label><br>
            <input type="text" name="username" required><br>
            <label for="password">Mật khẩu:</label><br>
            <input type="password" name="password" required><br>
            <input type="submit" value="Đăng nhập">
        </form>
        <?php if (isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
    </div>
</body>
</html>