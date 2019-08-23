<!-- Page for users with an account. 
They can unlink a summoner if they already have one linked or link a summoner if they didn't do it at sign up.-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>
        Profile
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
                    <a class="nav-link" href="search.php">Home<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="result.php" method="get">
                <input class="form-control mr-sm-2" type="text" placeholder="Summoner" name="summoner" required>
                <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
            </form>
            <?php
                session_start();
                require_once "dbcreds.php";
                $post_league = $_POST["league_name"];
                $sesh_user = $_SESSION['username'];
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
                {
                    echo "<b class='text-white my-2 my-sm-0 ml-2'>".$_SESSION["username"]."</b>";
                    echo '<a class="btn btn-dark my-2 my-sm-0 ml-2" href="logout.php">Logout</a>';
                }
                else
                {
                    echo '<a class="btn btn-dark my-2 my-sm-0 ml-2" href="login.php">Login</a>';
                }
            ?>
        </div>
    </nav>

        <?php
                if(isset($_POST["choice"]) && $_POST["choice"] == "yes")
                {
                    $conn = new mysqli($server, $user, $pswd, $db);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $query = "UPDATE users SET leagueName = '' where username = '$sesh_user'";
                    $query2 = "select leaguename from users where username = '$sesh_user'";

                    if ($conn->query($query) === TRUE) 
                    {

                        $result = $conn->query($query2);
                        if(!$result)
                        {
                            $result->close();
                            $conn->close();
                            die("Something went wrong! <a href='profile.php'>Go back.</a>");
                        }
                        if($result->num_rows)
                        {
                            echo <<<_END
                            Summoner unlinked.
                            Redirecting you to the main page in 3 seconds.
                            <script type="text/JavaScript">
                                setTimeout("window.location.href = 'search.php';",3000);
                            </script>
_END;
                            $row = $result->fetch_assoc();
                            $result->close();
                            $_SESSION['league_name'] = $row['leaguename'];
                            $conn->close();
                            die();  
                        }  
                    } 
                    else 
                    {
                        echo <<<_END
                        <b>Something went wrong.
                        <br> Redirecting you to your profile in 7 seconds.</b>
                        <script type="text/JavaScript">
                            setTimeout("window.location.href = 'profile.php';",7000);
                        </script>
_END;
                        echo "<br>".$conn->error;
                        $conn->close();
                        die();
                    }
                }
                if(!$_SESSION['league_name'])
                {
                    if(isset($_POST['league_name']))
                    {
                        // Create connection
                        $conn = new mysqli($server, $user, $pswd, $db);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $query = "UPDATE users SET leagueName = '$post_league' where username = '$sesh_user'";
                        $query3 = "select leaguename from users where username = '$sesh_user'";

            
                        if ($conn->query($query) === TRUE) 
                        {

                            $result = $conn->query($query3);
                            if(!$result)
                            {
                                $result->close();
                                $conn->close();
                                die("Something went wrong! <a href='profile.php'>Go back.</a>");
                            }
                            if($result->num_rows)
                            {
                                echo <<<_END
                                Summoner linked.
                                Redirecting you to the main page in 3 seconds.
                                <script type="text/JavaScript">
                                    setTimeout("window.location.href = 'search.php';",3000);
                                </script>
_END;
                                $row = $result->fetch_assoc();
                                $result->close();
                                $_SESSION['league_name'] = $row['leaguename'];
                                $conn->close();
                                die();  
                            }
                        }
                            else 
                            {
                                echo <<<_END
                                <b>Something went wrong.
                                <br> Redirecting you to your profile in 7 seconds.</b>
                                <script type="text/JavaScript">
                                    setTimeout("window.location.href = 'profile.php';",7000);
                                </script>
_END;
                                echo "<br>".$conn->error;
                                $conn->close();
                                die();
                            }
                    }
                    else
                    {
                        echo <<<_END
                        <div class="login pt-2">
                        <ul>
                            <b><p>Link Summoner</p></b>
                            <li>
                                <form action="profile.php" method="post">
                                    <li class="login-content">Add a summoner to account <input type="text" name="league_name" required></li>
                                    <li><input type="submit">
                                </form>
                            </li>
                        </ul>
                        </div>

_END;
                    }
                    
                }


                else
                {
                    $sesh_league =  $_SESSION['league_name'];
                    echo <<<_END
                    <div class="login pt-2">
                    <ul>
                        <b><p>Unlink Summoner: $sesh_league</p></b>
                        <li>
                            <form action="profile.php" method="post">
                                <li class="login-content">Yes<input type="radio" name="choice" value="yes"></li>
                                <li class="login-content">No<input type="radio" name="choice" value="no" checked></li>
                                <li><input type="submit"></li>
                            </form>
                        </li>
                    </ul>
                    </div>
_END;
                    die();
                }
        ?>
        </div>
    </body>
</html>