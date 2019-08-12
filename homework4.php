<!-- Just as a precursor, some of the functions don't work without a valid API key inside of a file called "apikey.php". -->


<!--TODO: 
    Add active match search
        -Add table of participants, 1 column per team and 1 row per player
    More bootstrap
    Maybe TFT if they create an API for it
    Flesh out rank information for player
     -->
<?php
    include "summoner.php";
    include "activegame.php";

    $some_game = new ActiveGame($_GET["summoner"]);
    $summoner_test = new Summoner($_GET["summoner"]);

    function print_players()
    {
        global $some_game, $summoner_test;
        // echo "<pre>";
        // print_r($some_game->game_info->participants);
        echo "<div id=\"game\"><h2>Current Game</h2><table id=\"game\">";
        echo <<<_END
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
        </tr> 
_END;
        for($x = 0; $x < 5; $x++)
        {
            $players = $some_game->game_info->participants;
            echo <<<_END
            <tr>
                <td>
_END;
            echo "<img style=\"height:2.1875em; width:2.1875em;\" src=".$summoner_test->getChampIcon($players[$x]->championId)." alt=\"ChampionIcon\">".$players[$x]->summonerName."</td><td><img style=\"height:2.1875em; width:2.1875em;\" src=".$summoner_test->getChampIcon($players[$x+5]->championId)." alt=\"ChampionIcon\">".$players[$x+5]->summonerName."</td></tr>";
        }   
        echo "</table></div>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
         <link rel="stylesheet" type="text/css" href="style.css">
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
        if($some_game->game_info == null)
        {
            echo $some_game->error;
        }
        echo "<b>Summoner: ".$summoner_test->name."<br></b>";
        echo "<img style=\"height:120px; width:120px;\" src=".$summoner_test->getProfileIcon()." alt=\"ProfileIcon\"><br>";
      
        echo "<b>Highest Champion Mastery: ".$champ_array[$summoner_test->mastery_info[0]->championId]["name"]."</b><br>";
        echo "<img src=".$summoner_test->getChampIcon($summoner_test->mastery_info[0]->championId)." alt=\"ChampionIcon\">";
        echo "<br> Mastery Points: ".number_format($summoner_test->mastery_info[0]->championPoints, 0,'.',',');
        if(empty($summoner_test->rank_queues))
        {
            echo "<b><br>This summoner has not played 8 ranked games yet.</b>";
        }
        else
        {
             //I used the w3schools guide on how to make tabs with javascript for this bit here. https://www.w3schools.com/howto/howto_js_tabs.asp

            /*The main thing I wanted the rank info tabs to be was dynamic, I wanted them to be able to display only the modes that they have placed in.
            So to do this I came up with this system that creates a string of HTML to use in the HEREDOC below. It runs through each array inside of the
            summoner object to gather the ranked information needed to format onto the page. Then it switches on the queue_type key for the values of each
            queue type. Then it will create a div for the tab and the tab's contents, the former just being the name of the queue and the latter being
            their tier, division, winrate and league points. How it's set up now it will create a unique div for each queue type and only for the queue types 
            that the summoner has actually played.  */
            echo "<b><br> Ranked Information:</b>";
            foreach($summoner_test->rank_queues as $value)
                {
                    switch($value['queue_type'])
                    {
                        case "RANKED_SOLO_5x5":
                        $tabs .= '<button class="tablinks" onclick="openRank(event, \'5v5\')" id="defaultOpen">Rift 5v5</button>';
                        $tab_content .= '<div id="5v5" class="tabcontent">';
                        break;
                        case "RANKED_FLEX_SR":
                        $tabs .= '<button class="tablinks" onclick="openRank(event, \'Flex\')" id="defaultOpen">Rift Flex</button>';
                        $tab_content .= '<div id="Flex" class="tabcontent">';
                        break;
                        case "RANKED_TFT":
                        $tabs .= '<button class="tablinks" onclick="openRank(event, \'TFT\')" id="defaultOpen">Teamfight Tactics</button>';
                        $tab_content .= '<div id="TFT" class="tabcontent">';
                        break;
                        case "RANKED_FLEX_TT":
                        $tabs .= '<button class="tablinks" onclick="openRank(event, \'TT\')" id="defaultOpen">Twisted Treeline</button>';
                        $tab_content .= '<div id="TT" class="tabcontent">';
                    }
                    $tab_content .= "Tier: ".$value['tier']."<br>Division: ".$value['division']."<br>".$value['lp']." lp"."<br>Winrate: ".$value['winrate']."%<br></div>";
                    
                }

            echo <<<_END
            <!-- The tabs themselves -->
            <div class="tab">
            $tabs
            </div>
            
            <!-- Tab content -->
            $tab_content
            <!-- First the script will click on the tab with the ID "defaultOpen". Then the function will declare the variables used, get all 
            elements that have a class of "tabcontent" and hide them. Then it will get all the eleemnts with the class "tablinks" 
            and remove the class "active". Then it will show the current tab and add an "active" class to the button that was used to open the tab. -->
            <script>
            document.getElementById("defaultOpen").click();
            function openRank(evt, rankName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(rankName).style.display = "block";
                evt.currentTarget.className += " active";
            }
            </script>
_END;
        }
        if($some_game->game_info != null)
        {
            print_players();
        }
    ?>
    </div>

    </body>
</html>