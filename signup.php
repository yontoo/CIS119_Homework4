<!DOCTYPE html>
<html lang="en">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>
        Login
        </title>
    </head>
    <body>
    <?php
        session_start();
    // TODO: FINISH THIS AND LOGIN PAGE AND GET SESSIONS WORKING
        if(isset($_POST["username"]) && isset($_POST["password"]))
        {
            $server = "localhost";
            $user = "root";
            $pswd = "mysql";
            $db = "projectDB";
            $post_user = $_POST["username"];
            $post_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $post_league = $_POST["league_name"];

            // Create connection
            $conn = new mysqli($server, $user, $pswd, $db);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO users (username, password, leagueName)
            VALUES ('$post_user', '$post_pass', '$post_league')";

            if ($conn->query($sql) === TRUE) {
            echo <<<_END
            Sign up successful.
            Redirecting you to the login page in 3 seconds.
            <script type="text/JavaScript">
                setTimeout("window.location.href = 'login.php';",3000);
            </script>
_END;
            die();  
            } 
            else {
                echo <<<_END
                <b>Something went wrong with sign up.
                <br>Redirecting you to the sign up page in 7 seconds.</b>
                <script type="text/JavaScript">
                    setTimeout("window.location.href = 'signup.php';",7000);
                </script>
_END;
                echo "<br>".$conn->error;
                die();
            }

            $conn->close();
        }
        ?>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand text-white">Summoner Search</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="homework4-form.html">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="homework4.php" method="get">
                <input class="form-control mr-sm-2" type="text" placeholder="Summoner" name="summoner">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>  
</nav>          
        </div>
        <div class="login pt-2">
        <ul>
            <b><p>Sign up</p></b>
            <li>
                <form action="signup.php" method="post">
                    <li class="login-content">Username <input type="text" name="username" required></li>
                    <li class="login-content">Password <input type="password" name="password" required></li>
                    <li class="login-content">Summoner <input type="text" name="league_name"></li>
                    <li><input type="submit">
                </form>
            </li>
        </ul>

        </div>
    </body>
</html>