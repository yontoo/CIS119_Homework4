<!-- Class file for the Summoner object. Most of the API parsing happens here. -->

<?php

        class Summoner
        {
            public $name;
            public $level;
            public $rank_info;
            public $json;
            public $summ_id;
            private $json_link;
            private $rank_json;
            private $profile_icon;
            private $key;
            
            public function getJson($json_link)
            {
                try{
                    $this->headers = get_headers($json_link);
                    if($this->headers[0] == "HTTP/1.1 200 OK")
                    {
                        $this->json_contents = file_get_contents($json_link);
                        $this->decoded = json_decode($this->json_contents);
                    }
                    else if($this->headers[0] == "HTTP/1.1 404 Not Found")
                    {
                        throw new Exception("<b>Summoner not found</b><br>");
                    }
                    else
                    {
                        throw new Exception("<b>Fatal error.</b><br>");
                    }
                } catch (Exception $excep)
                {
                    $this->error_count++;
                    $this->error[$this->error_count-1] = $excep->getMessage();
                }
                    return $this->decoded;
            }

            public function getProfileIcon()
            {
                return "http://ddragon.leagueoflegends.com/cdn/".$this->curr_ver."/img/profileicon/".$this->profile_icon.".png";
            }

            public function getChampIcon($champ_id)
            {
                $champ_array = $this->getChamps();
                return "http://ddragon.leagueoflegends.com/cdn/".$this->curr_ver."/img/champion/".$champ_array[$champ_id]["id"].".png";
            }

            public function getId()
            {
                return $this->summ_id;
            }

            private function getKey()
            {
                include "apikey.php";
                return $key;
            }

            public function getChamps()
            {
                //This function populates an array with champion info, using their ID as the key and their name as the value.
                $this->champ_info = $this->getJson("http://ddragon.leagueoflegends.com/cdn/".$this->curr_ver."/data/en_US/champion.json");
                $champions = array();

                    
                foreach($this->champ_info->data as $value)
                {
                    $champions[$value->key] = array("id" => $value->id, "name" => $value->name);
                }

                // For debugging.
                // echo "<pre>";
                // print_r($champions);
                // echo "</pre>";
                return $champions;
            }

            function __construct($name_in)
            {
                $name_in = str_replace(" ","%20",$name_in);
                $this->key = $this->getKey();
                $this->summ_info = $this->getJson("https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/".$name_in."?api_key=".$this->key);
                $this->profile_icon = $this->summ_info->profileIconId;
                $this->name = $this->summ_info->name;
                $this->summ_id = $this->summ_info->id;
                $this->level = $this->summ_info->summonerLevel;
                $this->mastery_info = $this->getMastery();
                $this->rank_json = $this->getJson("https://na1.api.riotgames.com/lol/league/v4/entries/by-summoner/".$this->summ_id."?api_key=".$this->key);
                if(!empty($this->rank_json))
                {
                    $this->rank_queues = array();
                    $count = 0;
                    /*Walks through the rank_json variable and grabs everything that we care about, in this case their total games(wins + losses), their winrate((wins/total games) * 100), their rank tier, division and how many lp(league points) they currently have. That data is put into a multidimensional array. */
                    foreach($this->rank_json as $value)
                    {
                        $this->total_games = $this->rank_json[$count]->wins + $this->rank_json[$count]->losses;
                        $this->winrate = number_format(($this->rank_json[$count]->wins/$this->total_games)*100);
                        $this->rank_queues[$count] = array('tier'=>$this->rank_json[$count]->tier, 'division'=>$this->rank_json[$count]->rank, 'winrate'=>$this->winrate, 'lp'=>$this->rank_json[$count]->leaguePoints, 'queue_type'=>$value->queueType);
                        $count++;
                    }
                }
                $this->curr_ver = $this->getJson("https://ddragon.leagueoflegends.com/api/versions.json")[0];
            }
            private function getMastery()
            {
                return $this->getJson("https://na1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/".$this->summ_id."?api_key=".$this->key);
            }
        }
?>