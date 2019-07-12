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
                $this->json_contents=file_get_contents($json_link);
                return json_decode($this->json_contents);
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
                    $this->winrate = number_format(($this->rank_json[0]->wins/($this->rank_json[0]->wins + $this->rank_json[0]->losses))*100);
                    $this->rank_info = array('tier'=>$this->rank_json[0]->tier, 'division'=>$this->rank_json[0]->rank, 'winrate'=>$this->winrate);
                }
                $this->curr_ver = $this->getJson("https://ddragon.leagueoflegends.com/api/versions.json")[0];
                // echo "<pre>";
                // print_r($this->rank_json);
                
            }
            private function getMastery()
            {
                return $this->getJson("https://na1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/".$this->summ_id."?api_key=".$this->key);
            }
        }
?>