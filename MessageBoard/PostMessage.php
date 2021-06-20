<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Message</title>
</head>
<body>
    <?php 
        if(isset($_POST["submit"])){
            $Subject = stripslashes($_POST["subject"]);
            $Name = stripslashes($_POST["name"]);
            $Message = stripslashes($_POST["message"]);

            $Subject = str_replace("~", "-", $Subject);
            $Name = str_replace("~", "-", $Name);
            $Message = str_replace("~", "-", $Message);

            $ExistingSubjects = array();
            if(file_exists("messages.txt") && filesize("messages.txt") > 0){
                $MessageArray = file("messages.txt");
                $count = count($MessageArray);
                for($i = 0; $i < $count; ++$i){
                    $CurrMsg = explode("~", $MessageArray[$i]);
                    $ExistingSubjects[] = $CurrMsg[0];
                }
            }

            if(in_array($Subject, $ExistingSubjects)){
                echo "<p>The subject you entered already exists!<br/>\n";
                echo "Please enter a new subject and try again.<br/>\n";
                echo "Your message was not saved!</p>";
                $Subject = "";
            }
            else {
                $MessageRecord = "$Subject~$Name~$Message\n";
                $MessageFile = fopen("messages.txt", "ab");

                if($MessageFile === FALSE){
                    echo "There was an error saving your message!\n";
                }
                else{
                    fwrite($MessageFile, $MessageRecord);
                    fclose($MessageFile);
                    echo "Your message has been saved!\n";
                    $Subject = "";
                    $Message = "";
                }
            }
        }
        else {
            $Subject = "";
            $Name = "";
            $Message = ""; 
        }
    ?>   
    <h1>Post New Message</h1>
    <hr/>
    <form action="PostMessage.php" method="POST">
        <span style="font-weight: bold;">Subject:</span>
        <input type="text" name="subject"  value="<?php echo $Subject; ?>"/>
        <span style="font-weight: bold;">Name:</span>
        <input type="text" name="name" value="<?php echo $Name; ?>" /><br/>
        <textarea name="message" rows="6" cols="80"><?php echo $Message; ?></textarea><br/>
        <input type="submit" value="Post Message" name="submit"/>
        <input type="reset" value="Reset Form" name="reset" />

    </form> 
    <hr/>
    <p>
    <a href="MessageBoard.php">View Messages</a>
    </p>
</body>
</html>