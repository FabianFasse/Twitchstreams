<?php

namespace Modules\Twitchstreams\Plugins;

use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Streamer
{
    private $apiKey = '';
    private $streamer;
    private $onlineStreamer = [];

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getOnlineStreamer()
    {
        $mapper = new StreamerMapper();

        $userArray = [];
        if (is_array($this->streamer) || is_object($this->streamer)) {
            foreach ($this->streamer as $streamer) {
                $userArray[] = 'user_login=' . $streamer->getUser();
            }
        }
        $user = implode('&', $userArray);

        $ch = curl_init('https://api.twitch.tv/helix/streams?' . $user);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Client-ID: ' . $this->apiKey]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        $allres = json_decode($data);

        foreach ($allres->{'data'} as $stream) {
            $assoc = $mapper->readByUser($stream->{'user_name'});

            $ga = curl_init('https://api.twitch.tv/helix/games?id=' . $stream->{'game_id'});
            curl_setopt($ga, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ga, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Client-ID: ' . $this->apiKey]);
            curl_setopt($ga, CURLOPT_SSL_VERIFYPEER, false);
            $gaData = curl_exec($ga);
            curl_close($ga);
            $gameres = json_decode($gaData);

            $model = new StreamerModel();
            $model->setId($assoc['id'])
                ->setUser($stream->{'user_name'})
                ->setTitle($stream->{'title'})
                ->setViewers($stream->{'viewer_count'})
                ->setOnline($stream->{'type'})
                ->setPreviewMedium(str_replace('{width}x{height}', '1920x1080', $stream->{'thumbnail_url'}))
                ->setCreatedAt($stream->{'started_at'});

            foreach ($gameres->{'data'} as $game) {
                $model->setGame($game->{'name'});
            }

            $this->onlineStreamer[] = $model;
        }

        return $this->onlineStreamer;
    }

    public function setStreamer($streamer)
    {
        $this->streamer = $streamer;
    }
}
