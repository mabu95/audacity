<?php

class App
{
    protected $config;

    public function __construct()
    {
        $this->config = require 'config.php';
    }

    private function checkCacheTimer()
    {

    }

    public  function getGuildInformations()
    {
        $url = 'https://raider.io/api/v1/guilds/profile?region='.$this->config['region'].'&realm='.$this->config['realm'].'&name='.$this->config['guild'].'&fields=raid_progression%2Craid_rankings';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        curl_close($ch);
        return $data;
    }

    public function getPlayerInformations($player)
    {

        $url = 'https://raider.io/api/v1/characters/profile?region='.$this->config['region'].'&realm='.$this->config['realm'].'&name='.$player.'&fields=gear%2Ccovenant';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        $data = json_decode($result, true);
        curl_close($ch);

        return $data;
    }

    public function getPlayers()
    {
        $data = file_get_contents('player.txt');
        $rows = explode("\n", $data);
        $rows = array_map('trim', $rows);

        $result = [];

        foreach($rows as $i => $row) {
            if(!isset($row[0])) continue;
            $convert = explode('|', $row);
            $result[$i]['name'] = $convert[0];
            $result[$i]['status'] = $convert[1];
        }

        return $result;
    }
}
