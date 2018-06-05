<!DOCTYPE html>
    <head>

    </head>
    <body>
        <?php
        $source = "";
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(!preg_match("/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",$_POST['fname']." ".$_POST['lname']))
            {
                $source = "name";
                include_once 'loginPage.html';
            }
            if(($_POST['dobd'] == "0") || ($_POST['dobm'] == "0") || ($_POST['doby'] == "0"))
            {
                $source = "dob";
                include_once 'loginPage.html';
            }
            if(!preg_match("/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/",$_POST['uname']))
            {
                $source = "uid";
                include_once 'loginPage.html';
            }
            if($_POST['pass1'] != $_POST['pass2'])
            {
                $source = "pass";
                include_once 'loginPage.html';
            }
            if(!preg_match("/^[6-9]\d{9}$/",$_POST['mob']))
            {
                $source = "mob";
                include_once 'loginPage.html';
            }
            if(!(isset($_POST['gender'])))
            {
                $source = "gender";
                include_once 'loginPage.html';
            }

            if($source == "")
            {
                $name = $_POST["fname"]." ".$_POST["lname"]; 
                $dobd = $_POST['dobd'];
                $dobm = $_POST['dobm'];
                $doby = $_POST['doby'];
                $uname = $_POST['uname'];
                $pass1 = $_POST['pass1'];
                $pass2 = $_POST['pass2'];
                $mob = $_POST['mob'];
                $gender = $_POST['gender'];

                $server = "localhost";
                $username = "root";
                $dbname = "login";
                $conn = new mysqli($server, $username, "", $dbname);
                if($conn->connect_error)
                    die("Some error occured! Please try again");

                $sql = "SELECT username FROM CHECKDB";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                        if($uname == $row['username'])
                        {
                            echo "<script>alert('The email id is already registered. Try with a different one');window.location='loginPage.html'</script>";
                        }
                }

                $sql = "INSERT INTO CHECKDB (username, password)
                        VALUES ('$uname', '$pass1')";
                if($conn->query($sql) == true)
                    $source = "";
                else
                    die("Some error occurred durin registration, please try again");
            }
        }
        ?>
        <h3 style="text-align: center"><?php if($source==""){echo "Username: <b>".$name."</b><br>"."Date of Birth: <b>".$dobd."</b>/<b>".$dobm."</b>/<b>".$doby."</b><br>"."User ID: <b>".$uname."</b><br>".
        "First Password: <b>".$pass1."</b><br>"."Second Password: <b>".$pass2."</b><br>"."Mobile Number: <b>".$mob."</b><br>"."Gender: <b>".$gender;} ?><br><br></h3>
        <h2 style="text-align: center"><?php if($source==""){echo "Successfully Registered";}?></h2>
    </body>
</html>