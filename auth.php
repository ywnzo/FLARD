<?php
include('config/db_connect.php');
if(isset($_COOKIE['sessionID'])) {
    header("Location: index.php");
}

function test_input($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

enum Method {
    case LOGIN;
    case REGISTER;
}
$currentMethod = null;

if(isset($_GET['method'])) {
    if($_GET['method'] === 'login') {
        $currentMethod = Method::LOGIN;
    }
    if($_GET['method'] === 'register') {
        $currentMethod = Method::REGISTER;
    }
}

function create_user($conn, $username, $email, $password) {
    $passwordHashed = crypt($password, "wretchedwealth");
    $sessionID = uniqid(uniqid(), true);

    $sql = "INSERT INTO users (ID, name, email, password, sessionID) VALUES (UUID(), '$username', '$email', '$passwordHashed', '$sessionID')";
    if(mysqli_query($conn, $sql)) {
        $sql = "SELECT ID FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($result);

        // setcookie('sessionID', $sessionID, time() + (86400 * 30), "/");
        send_email($result['ID'], $username, $email);
        header('Location: ' . 'index.php');
    } else {
        echo "Error creating user!";
    }
}

function send_email($userID, $username, $email) {
    $subject = 'Account verification!';
    $txt = 'Hello this is a test account verification: '. $userID;
    $headers = "From: verification@flard.com" . "\r\n";
    mail($email, $subject, $txt, $headers);
}

$username = $email = $password = '';
$nameErr = $emailErr = $passwordErr = '';
$canProcceed = true;

if(isset($_POST['username'])) {
    $email = test_input($_POST['email']);
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if( empty($email)) {
        $emailErr = 'Enter a valid email!';
        $canProcceed = false;
    } else {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Enter a valid email!';
            $canProcceed = false;       
        }

        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($result);
        if($result && $result['email'] === $email) {
            $emailErr = 'Email already exists!';
            $canProcceed = false;
        }
    }

    if( empty($username)) {
        $nameErr = 'Enter valid username!';
        $canProcceed = false;
    } else {
        if(!preg_match("/^[a-zA-Z-']*$/", $username)) {
            $nameErr = 'Enter valid username!';
            $canProcceed = false;
        }
        
        $sql = "SELECT name FROM users WHERE name = '$username'";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_assoc($result);
        if($result && $result['username'] === $username) {
            $nameErr = 'Username already exists!';
            $canProcceed = false;
        }
    }

    if( empty($password)) {
        $passwordErr = 'Enter a valid password!';
        $canProcceed = false;
    }

    if($canProcceed) {
        create_user($conn, $username, $email, $password);
    }
    
} else {
    if(isset($_POST['email'])) {
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);

        if( empty($email)) {
            $emailErr = 'Enter a valid email!';
            $canProcceed = false;
        } 
        
        if( empty($password)) {
            $passwordErr = 'Enter a valid password!';
            $canProcceed = false;
        }

        if($canProcceed) {
            $sql = "SELECT ID, email, password FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $result = mysqli_fetch_assoc($result);

            if(!$result) {
                echo "User not found!";
            } else {
                $passwordMatch = password_verify($password, $result['password']);
                if($passwordMatch) {
                    $userID = $result['ID'];
                    $timestamp = date("Y-d-m h:i:s");
                    $sessionID = uniqid($userID, true);
                    $sql = "UPDATE users SET sessionID = '$sessionID' WHERE id = '$userID'";
                    mysqli_query($conn, $sql);

                    setcookie('sessionID', $sessionID, time() + (86400 * 30), "/");
                    header('Location: ' . 'index.php');
                } else {
                    $passwordErr = 'Password not match';
                }
            }
        }
    }
}

// mysqli_close($conn);
?>

<?php include('components/menu.php') ?>

<div class="site">
    <div class="content-wrapper">
        <?php if($currentMethod === Method::LOGIN) { include('components/auth/login_form.php'); }?>
        <?php if($currentMethod === Method::REGISTER) { include('components/auth/register_form.php'); }?>
    </div>
</div>

<?php include('components/footer.php') ?>