<?php
require_once("functions.php");

if(!isset($_SESSION['email'])){
    header("location:index.php");
    exit();
}
else if(isset($_GET['logout'])){
    session_destroy();
    header("location:index.php");
    exit();
}
else if(isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['message'])){
    //Note: CSRF Check is not performed for because of the simplicity of this application
    $send = send_email($_SESSION['token'], $_SESSION['email'], $_POST['to'], $_POST['subject'], $_POST['message']);
    if($send[0]){
        $message = "Message has been sent successfully";
    }
    else{
        $error = $send[1];
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
            
            <h3>Welcome <?php echo $_SESSION['email']; ?>!</h3>
            <span><a href="send-mail.php?logout">Logout</a></span>
            <br>
            <?php
            if(isset($message)){
                echo '<span style="color:green; font-weight:bold">'.$message.'</span><br>';
            }
            if(isset($error)){
                echo '<span style="color:red; font-weight:bold">'.$message.'</span><br>';
            }
            ?>
            <form action="send-mail.php" method="POST">
                <label>From: <?php echo $_SESSION['email']; ?></label><br>
                <label>To: </label>
                <input type="email" name="to" required /><br>
                <label>Subject: </label>
                <input type="text" name="subject" required /><br>
                <label>Message: </label><br>
                <textarea rows="4" cols="50"  name="message" required ></textarea><br>
                <input type="submit" value="Send Email" required /><br>
            </form>
        </div>
    </body>
</html>