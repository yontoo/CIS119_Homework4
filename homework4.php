<!--Tray Harris
    CIS119-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Homework 4
        </title>
    </head>
    <body>
    <?php
        $key = "RGAPI-444b8855-0200-4825-82d1-b86e560cb894";
        class Summoner
        {
            public $name;
            public $level;
            private $id;
            private $json_link;
            private $json_contents;
            private $json;

            function __construct($name_in)
            {
                // $this->json_link = "https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/".$name_in."?api_key=".$key;
                $this->json_link = "https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/gerbilstore?api_key=RGAPI-444b8855-0200-4825-82d1-b86e560cb894";
                $this->json_contents=file_get_contents($json_link);
                $this->json=json_decode($json_contents);
                $this->name = $json->name;
            }
            
        }
        $summoner_test = new Summoner("GerbilStore");
        echo $summoner_test->name;
    ?>
    </body>
</html>