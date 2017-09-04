<?php

namespace Modules\Twitchstreams\Controllers;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $mapper = new StreamerMapper();

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index']);

        if ($this->getConfig()->get('twitchstreams_requestEveryPageCall') == 1) {
            $this->updateAction();
        }

        $this->getView()->set('streamer', $mapper->getStreamer(['online' => 1]));
    }

    public function showAction()
    {
        $mapper = new StreamerMapper();

        $streamer = $mapper->getStreamer(['id' => $this->getRequest()->getParam('id')]);

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index'])
            ->add($streamer[0]->getUser(), ['id' => $this->getRequest()->getParam('id')]);

        if ($this->getConfig()->get('twitchstreams_requestEveryPageCall') == 1) {
            $this->updateAction();
        }

        $this->getView()->set('streamer', $mapper->getStreamer(['id' => $this->getRequest()->getParam('id')]));
    }

    public function updateAction()
    {
        $mapper = new StreamerMapper();

        $mapper->updateOnlineStreamer((string)$this->getConfig()->get('twitchstreams_apikey'));
    }
}
