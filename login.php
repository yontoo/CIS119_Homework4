<!-- Page where you log in and are validated against the SQL database. -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>
        Login
        </title>
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand text-white">Summoner Search</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="search.php">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="result.php" method="get">
                <input class="form-control mr-sm-2" type="text" placeholder="Summoner" name="summoner">
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
            </form>  
</nav>
    <?php
        session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
        {
            echo $_SESSION["username"].", you're already logged in!<br>";
            echo <<<_END
           Returning you back to the main page.
            <script type="text/JavaScript">
                setTimeout("window.location.href = 'search.php';",3000);
            </script>
_END;
            die();
        }
        if(isset($_POST["username"]) && isset($_POST["password"]))
        {
            require_once "dbcreds.php";
            $post_user = $_POST["username"];
            $post_pass = $_POST["password"];

            $conn = new mysqli($server, $user, $pswd, $db);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "select * from users where username='$post_user'";
            $result = $conn->query($query);
            if(!$result)
            {
                die("Something went wrong! <a href='login.php'>Go back.</a>");
            }
            if($result->num_rows)
            {
                $row = $result->fetch_assoc();
                $result->close();           
                if(password_verify($post_pass,$row['password']))
                {
                    $_SESSION['loggedin']=true;
                    $_SESSION['username']=$row['username'];
                    $_SESSION['league_name']=$row['leagueName'];
                    echo <<<_END
            Logged in successfully, sending you back to the main page.
            <script type="text/JavaScript">
                setTimeout("window.location.href = 'search.php';",3000);
            </script>
_END;
                }
                else
                {
                    echo "Incorrect password. <a href='login.php'>Go back.</a>";
                } 
            }
            else
            {
                echo "Couldn't find that user, double check that you typed it right. <a href='login.php'>Go back.</a>";
            }
            

            $conn->close();
        }
        else
        {
            echo <<<_END
            </div>
            <div class="login pt-2">
            <ul>
                <b><p>Login</p></b>
                <li>
                    <form action="login.php" method="post">
                        <li class="login-content">Username <input type="text" name="username" required></li>
                        <li class="login-content">Password <input type="password" name="password" required></li>
                        <li><input type="submit"></li>
                    </form>
                    <li>
                    Need to make an account? Click <a href="signup.php">here</a>.
                    </li>
                </li>
            </ul>
            </div>
_END;
        }
        ?>
    </body>
</html>