<!-- Just as a precursor, some of the functions don't work without a valid API key inside of a file called "apikey.php". -->
<?php
    include "summoner.php";

    $summoner_test = new Summoner($_GET["summoner"]);
    // echo "<h3>Summoner: ".$summoner_test->name."</h3><br>";
    // echo "<img src=".$summoner_test->getChampIcon($summoner_test->mastery_info[0]->championId)." alt=\"ChampionIcon\">";
    // echo "<br> Mastery Points: ".number_format($summoner_test->mastery_info[0]->championPoints, 0,'.',',');

    // echo "<br>".$summoner_test->getId();
    // echo "<br>".$summoner_test->level."<br>";
    // var_dump("<pre>");
    // var_dump($summoner_test);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>
            <?php echo $summoner_test->name; ?>
        </title>
    </head>
    <body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand text-white">Summoner Search</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="homework4-form.html">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="homework4.php" method="get">
                <input class="form-control mr-sm-2" type="text" placeholder="Summoner" name="summoner">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div>
    <?php
        // echo $_POST["summoner"]
        // $summoner_test = new Summoner($_POST["summoner"]);
        $champ_array = $summoner_test->GetChamps();
        if($summoner_test->mastery_info[0]->championId == "62")
        {
            $champ_array["62"] = "Wukong";
        }
        echo "<b>Summoner: ".$summoner_test->name."<br>";
        echo $champ_array[$summoner_test->mastery_info[0]->championId]."</b><br>";
        echo "<img src=".$summoner_test->getChampIcon($summoner_test->mastery_info[0]->championId)." alt=\"ChampionIcon\">";
        echo "<br> Mastery Points: ".number_format($summoner_test->mastery_info[0]->championPoints, 0,'.',',');
    ?>
    </div>

    </body>
</html>