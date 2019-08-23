<?php
    class ActiveGame
    {
        private $key;
        public $error;

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
                throw new Exception("<b>Summoner not in game.</b><br>");
            }
            else
            {
                throw new Exception("<b>Error getting game information.</b><br>");
            }
        } catch (Exception $excep)
        {
            $this->error_count++;
            $this->error[$this->error_count-1] = $excep->getMessage();
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
            $this->game_info = $this->getJson("https://na1.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/".$this->summ_id."/?api_key=".$this->key);
    
        }




    }

?>