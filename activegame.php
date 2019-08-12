<?php
    class ActiveGame
    {
        private $key;
        public $error;

        public function getJson($json_link)
        {
            $this->json_contents=@file_get_contents($json_link);
            $this->decoded = json_decode($this->json_contents);
            // var_dump($this->json_contents);
            if ($this->decoded == null)
            {
                throw new Exception("<br><b>Error getting game information.</b><br>");
            }

            return $this->decoded;
        }

        private function getKey()
        {
            include "apikey.php";
            return $key;
        }

        function __construct($name_in)
        {
            $name_in = str_replace(" ","%20",$name_in);
            $this->key = $this->getKey();
            $this->summ_info = $this->getJson("https://na1.api.riotgames.com/lol/summoner/v4/summoners/by-name/".$name_in."?api_key=".$this->key);
            $this->summ_id = $this->summ_info->id;
            try{
            $this->game_info = $this->getJson("https://na1.api.riotgames.com//lol/spectator/v4/active-games/by-summoner/".$this->summ_id."/?api_key=".$this->key);
            // var_dump($this->game_info);
            } catch (Exception $excep)
            {
                $this->error = $excep->getMessage();
            }
            // echo "<pre>";
            // print_r($this->game_info);
        }




    }

?>