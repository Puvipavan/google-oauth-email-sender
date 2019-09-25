<?php
require_once("functions.php");

if(isset($_SESSION['email'])){
    header("location:send-email.php");
    exit();
}

?>

<html>
    <header>
        <title>Email Sender</title>
    </header>
    
    <body>
        <h1>Email Sender</h1>
        <p><strong><a href="<?php echo $login_url; ?>">Click Here</a> to login with your google account and start sending email from here.</strong><p>
    </body>
</html>