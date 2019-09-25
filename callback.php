<?php 
require_once("functions.php");

if(isset($_SESSION['email'])){
    header("location:send-email.php");
    exit();
}

else if(isset($_GET['error'])){
    $error = htmlentities($_GET['error']); //XSS Filter
}
else if(isset($_GET['code'])){
    $token = exchange_authorization_code($_GET['code']);
    if($token[0]){
        $info = get_email($token[1]['access_token']);
        if($info[0]){
            $_SESSION['email'] = $info[1];
            $_SESSION['token'] = $token[1]['access_token'];
            header("location:send-mail.php");
            exit();
        }
        else{
            $error = $info[1];
        }
    }
    else{
        $error = $token[1];
    }
}

?>

<html>
    <header>
        <title>Email Sender</title>
    </header>
    
    <body>
        <div align="center">
            <h1>Email Sender</h1>
            <?php 
            if(isset($error)){
                echo '<span style="color:red; font-weight:bold">'.$error.'</span><br>';
                echo '<a href="index.php">Go Back</a>';
            }
            ?>
        </div>
    </body>
</html>