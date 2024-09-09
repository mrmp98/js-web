<?php
session_start();
error_reporting(0);
if (!isset($_SESSION['ddos'])) {
    $_SESSION['ddos'] = 0;
}
function GetRealIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$ipkarbar = GetRealIp();
if (!isset($_POST['e'])) {
    $_SESSION['randomNumber1'] = rand(1, 9);
    $_SESSION['randomNumber2'] = rand(1, 9);
    $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
} elseif (isset($_POST['e'])) {
    if (!isset($_SESSION['clicked'])) {
        $_SESSION['clicked'] = true;
        $captchaa = htmlspecialchars($_POST['captchaa']);
        if ($captchaa == $_SESSION['sum']) {
            unset($_SESSION['sum'], $_SESSION['randomNumber1'], $_SESSION['randomNumber2']);
            $name = base64_encode(htmlspecialchars($_POST['name']));
            $user = base64_encode(htmlspecialchars($_POST['username']));
            $email = base64_encode(htmlspecialchars($_POST['email']));
            $passwordd = base64_encode(htmlspecialchars($_POST['password']));
            if (empty($name) || empty($user) || empty($email) || empty($passwordd)) {
                echo "<script>alert('لطفا اطلاعات را درست وارد کنید.');</script>";
                sleep(rand(1, 5));
            } else {
                try {
                    $captchaa = htmlentities($_POST['captchaa']);
                    $servername = "localhost";
                    $username = "mrqwir_mp";
                    $password2 = "R&#[[o_fq!1)";
                    $conn = new PDO("mysql:host=$servername;dbname=mrqwir_mp", $username, $password2);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    sleep(rand(1, 5));
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $tableName = "qw";
                $sql = "INSERT INTO $tableName (name, username, email, paswoord , ip) VALUES (:name, :user, :email, :password , :ip)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':user', $user);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $passwordd);
                $stmt->bindParam(':ip', $ipkarbar);
                if ($stmt->execute()) {
                    echo "<script>alert('اطلاعات شما با موفقیت ذخیره شد.')</script>";
                    sleep(rand(1, 5));
                    header("Location: https://mrqw.ir/");
                }
            }
        } else {
            echo "<script>alert('لطفا اطلاعات کپچا را درست وارد کنید.');</script>";
            sleep(rand(1, 5));
        }
        unset($_SESSION['clicked']);
    } else {
        $_SESSION['ddos'] += 1;
        if ($_SESSION['ddos'] > 10) {
            header("Location: https://www.google.com/");
            unset($_SESSION['ddos']);
            exit;
        } else {
            echo "<script>alert('لطفا تا زمان پردازش قبلی صبر کنید.');</script>";
            unset($_SESSION['sum'], $_SESSION['randomNumber1'], $_SESSION['randomNumber2']);
            $_SESSION['randomNumber1'] = rand(1, 9);
            $_SESSION['randomNumber2'] = rand(1, 9);
            $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
        }
    }
}

