<?php

namespace Modules\Twitchstreams\Plugins;

use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Streamer
{
    private $apiKey = '';
    private $streamer;
    private $onlineStreamer = [];

    function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function getOnlineStreamer()
    {
        $mapper = new StreamerMapper();

        $userArray = [];
        foreach ($this->streamer as $streamer) {
            $userArray[] = $streamer->getUser();
        }

        $user = implode(',', $userArray);
        $ch = curl_init('https://api.twitch.tv/kraken/streams?channel='.$user);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: ' . $this->apiKey . ''));
        $data = curl_exec($ch);
        curl_close($ch);
        $allres = json_decode($data);


        foreach ($allres->{'streams'} as $stream) {
            $assoc = $mapper->readByUser($stream->{'channel'}->{'display_name'});
            $model = new StreamerModel();
            $model->setId($assoc['id'])
                ->setUser($assoc['user'])
                ->setTitle($stream->{'channel'}->{'status'})
                ->setOnline($assoc['online'])
                ->setGame($stream->{'game'})
                ->setViewers($stream->{'viewers'})
                ->setPreviewMedium($stream->{'preview'}->{'medium'})
                ->setLink($stream->{'channel'}->{'url'})
                ->setCreatedAt($stream->{'created_at'});
            $this->onlineStreamer[] = $model;
        }

        return $this->onlineStreamer;
    }

    public function setStreamer($streamer)
    {
        $this->streamer = $streamer;
    }
}
