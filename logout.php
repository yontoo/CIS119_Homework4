<!-- Destination page for logging out -->

<!DOCTYPE html>
<html>
     <head>   
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <title>Summoner Search</title>
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
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        session_start();
        session_unset();
        session_destroy();
        $_SESSION = array();
        echo "<h3>Successfully Logged out</h3>";
    }
    else
    {
        echo "<h3>You're not logged in.</h3>";
    }
    ?>
    Sending you to your previous page.
        <script type="text/JavaScript">
            setTimeout("window.history.back();",3000);
        </script>
    </body>
</html>