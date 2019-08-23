<html>
    <head>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <!-- Links the font awesome icons cdn -->
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
            <!-- Links bootstrap css framework -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Summoner Search</title>
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-center">
            <a class="navbar-brand text-white">Summoner Search</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
                <?php
                session_start();
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
                {
                    if($_SESSION["league_name"])
                    {
                        echo "<b class='text-white my-2 my-sm-0 ml-2'>".$_SESSION['username']."</b>";
                        echo "<a href='profile.php'><span class='fas fa-cog text-info ml-2'></span></a>";
                        echo "<a href='result.php?summoner=".$_SESSION["league_name"]."'><span class='fas fa-user text-info ml-2'></span></a>";
                    }
                    else
                    {
                        echo "<b class='text-white my-2 my-sm-0 ml-2'>".$_SESSION['username']."</b>";
                        echo "<a href='profile.php'><span class='fas fa-cog text-info ml-2'></span></a>";
                    }
                    
                    echo '<a class="btn btn-dark my-2 my-sm-0 ml-2" href="logout.php">Logout</a>';
                    
                }
                else
                {
                    echo '<a class="btn btn-dark my-2 my-sm-0 ml-2" href="login.php">Login</a>';
                }
                ?>
    </nav>
    
    <div class="container h-auto">
        <div class="row justify-content-center">
            <div class="col-md-4 align-self-center">
            <form class="col align-self-center" action="result.php" method="get">
                Summoner: <input type="text" name="summoner" required="required" placeholder="Summoner Name"><br>
                <input type="submit">
            </form>
            </div>
        </div>
    </div>
    </body>
</html> 