<?php

namespace Modules\Twitchstreams\Models;

class Streamer extends \Ilch\Model {
    protected $id;
    protected $user;
    protected $title;
    protected $online;
    protected $game;
    protected $viewers;
    protected $previewMedium;
    protected $createdAt;
        
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }
    
    public function getOnline()
    {
        return $this->online;
    }
    
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }
    
    public function getGame()
    {
        return $this->game;
    }
    
    public function setViewers($viewers)
    {
        $this->viewers = $viewers;

        return $this;
    }
    
    public function getViewers()
    {
        return $this->viewers;
    }
    
    public function setPreviewMedium($preview)
    {
        $this->previewMedium = $preview;

        return $this;
    }
    
    public function getPreviewMedium()
    {
        return $this->previewMedium;
    }
    
    public function setCreatedAt($createdAd)
    {
        $this->createdAt = $createdAd;

        return $this;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
