<!DOCTYPE html>
    <head>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(!preg_match("/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/",$_POST['uid']))
                    die("Enter a valid Username");
            $log = 0;
            $username = "root";
            $server = "localhost";
            $dbname = "login";
            $conn = new mysqli($server, $username, "", $dbname);
            if($conn->connect_error)
                die("Connection to $dbname failed");
            $sql = "SELECT * FROM checkdb";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    if(($_POST["uid"] == $row["username"]) && ($_POST["pass"] == $row["password"]))
                        $log = 1;
                }
            }
        }
        ?>
    </head>
    <body>
        <h1 style="text-align: center"><?php if($log == 1){echo "Succesfully Logged In";}else{echo "Invalid User Id or Password!";}?></h1>
    </body>
</html>