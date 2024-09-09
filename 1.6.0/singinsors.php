<?php
session_start();
error_reporting(0);

if (!isset($_SESSION['ddos'])) {
    $_SESSION['ddos'] = 0;
}

if (!isset($_POST['a'])) {
    $_SESSION['randomNumber1'] = rand(1, 9);
    $_SESSION['randomNumber2'] = rand(1, 9);
    $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
}

if (isset($_POST["a"])) {
    // نمایش المان کپچا
    echo "<script>document.querySelector('#ddos').style.display = 'flex' ;</script>";

    if (!isset($_SESSION['clicked'])) {
        $_SESSION['clicked'] = true;
        $captchaa = htmlspecialchars($_POST['captchaa']);

        if ($captchaa == $_SESSION['sum']) {
            unset($_SESSION['sum'], $_SESSION['randomNumber1'], $_SESSION['randomNumber2']);

            $x = base64_encode(htmlspecialchars($_POST['username']));
            $hashedPassword = base64_encode(htmlspecialchars($_POST['password']));

            if (empty($x) || empty($hashedPassword)) {
                sleep(rand(1, 5));
                echo "<script>alert('لطفا اطلاعات را پر کنید.');</script>";
                $_SESSION['randomNumber1'] = rand(1, 9);
                $_SESSION['randomNumber2'] = rand(1, 9);
                $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
                echo "<script>document.querySelector('#ddos').style.display = 'none' ;</script>";
            } else {
                try {
                    $servername = "localhost";
                    $username = "mrqwir_mp";
                    $password = "R&#[[o_fq!1)";
                    $conn = new PDO("mysql:host=$servername;dbname=mrqwir_mp", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo "خطا در اتصال به دیتابیس: " . $e->getMessage();
                    exit;
                }

                $sql = "SELECT COUNT(*) AS count FROM qw WHERE username = :user AND paswoord = :password";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user', $x);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['count'] > 0) {
                    $conn = null;
                    echo "<script>alert('با موفقیت وارد شدید.');</script>";
                    sleep(rand(1, 5));
                    header("Location: https://mrqw.ir/");
                    exit;
                } else {
                    $conn = null;
                    sleep(rand(1, 5));
                    echo "<script>alert('لطفا اطلاعات را درست وارد کنید.');</script>";
                    $_SESSION['randomNumber1'] = rand(1, 9);
                    $_SESSION['randomNumber2'] = rand(1, 9);
                    $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
                    echo "<script>document.querySelector('#ddos').style.display = 'none' ;</script>";
                }
            }
        } else {
            $_SESSION['randomNumber1'] = rand(1, 9);
            $_SESSION['randomNumber2'] = rand(1, 9);
            $_SESSION['sum'] = ($_SESSION['randomNumber1'] + $_SESSION['randomNumber2']);
            sleep(rand(1, 5));
            echo "<script>alert('لطفا اعداد کپچا را درست وارد کنید.');</script>";
            echo "<script>document.querySelector('#ddos').style.display = 'none' ;</script>";
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

echo $_SESSION['ddos'];