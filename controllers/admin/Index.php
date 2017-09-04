<?php

namespace Modules\Twitchstreams\Controllers\Admin;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;
use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use Ilch\Validation;

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $items = [
            [
                'name' => 'menuStreamer',
                'active' => false,
                'icon' => 'fa fa-th-list',
                'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'index']),
                [
                    'name' => 'add',
                    'active' => false,
                    'icon' => 'fa fa-plus-circle',
                    'url' => $this->getLayout()->getUrl(['controller' => 'index', 'action' => 'treat'])
                ]
            ],
            [
                'name' => 'settings',
                'active' => false,
                'icon' => 'fa fa-cogs',
                'url' => $this->getLayout()->getUrl(['controller' => 'settings', 'action' => 'index'])
            ]
        ];

        if ($this->getRequest()->getActionName() == 'treat') {
            $items[0][0]['active'] = true;
        } else {
            $items[0]['active'] = true;
        }

        $this->getLayout()->addMenu
        (
            'twitchstreams',
            $items
        );
    }

    public function indexAction()
    {
        $mapper = new StreamerMapper();

        $this->getLayout()->getAdminHmenu()
            ->add($this->getTranslator()->trans('twitchstreams'), ['controller' => 'index', 'action' => 'index'])
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index']);

        if ($this->getRequest()->getPost('check_streamer')) {
            if ($this->getRequest()->getPost('action') == 'delete') {
                foreach ($this->getRequest()->getPost('check_streamer') as $id) {
                    $mapper->delete($id);
                }
            }
        }

        $this->getView()->set('streamer', $mapper->getStreamer());
    }

    public function treatAction()
    {
        $mapper = new StreamerMapper();

        if ($this->getRequest()->getParam('id')) {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('twitchstreams'), ['action' => 'index'])
                ->add($this->getTranslator()->trans('edit'), ['action' => 'treat']);

            $this->getView()->set('streamer', $mapper->readById($this->getRequest()->getParam('id')));
        } else {
            $this->getLayout()->getAdminHmenu()
                ->add($this->getTranslator()->trans('twitchstreams'), ['controller' => 'index', 'action' => 'index'])
                ->add($this->getTranslator()->trans('add'), ['action' => 'treat']);
        }

        if ($this->getRequest()->getParam('id')) {
            $streamerArray = $mapper->readById($this->getRequest()->getParam('id'));
            $streamerModel = new StreamerModel();
            $streamerModel->setId($streamerArray['id'])
                ->setUser($streamerArray['user'])
                ->setOnline($streamerArray['online'])
                ->setGame($streamerArray['game']);

            $this->getView()->set('streamer', $streamerModel);
        }

        if ($this->getRequest()->isPost()) {
            $mapper = new StreamerMapper();
            $model = new StreamerModel();

            Validation::setCustomFieldAliases([
                'inputUser' => 'streamer'
            ]);

            $validation = Validation::create($this->getRequest()->getPost(), [
                'inputUser' => 'required'
            ]);

            if ($validation->isValid()) {
                if ($this->getRequest()->getParam('id')) {
                    $model->setId($this->getRequest()->getParam('id'));
                }

                $model->setUser($this->getRequest()->getPost('inputUser'))
                    ->setOnline(0);
                $mapper->save($model);

                $mapper->updateOnlineStreamer($this->getConfig()->get('twitchstreams_apiKey'));

                $this->redirect()
                    ->withMessage('saveSuccess')
                    ->to(['action' => 'index']);
            }

            $this->addMessage($validation->getErrorBag()->getErrorMessages(), 'danger', true);
            $this->redirect()
                ->withInput()
                ->withErrors($validation->getErrorBag())
                ->to(['action' => 'treat']);
        }
    }

    public function updateAction()
    {
        $mapper = new StreamerMapper();

        $mapper->updateOnlineStreamer($this->getConfig()->get('twitchstreams_apiKey'));

        $this->redirect()
            ->withMessage('updateSuccess')
            ->to(['action' => 'index']);
    }

    public function deleteAction()
    {
        if ($this->getRequest()->isSecure()) {
            if ($this->getRequest()->getParam('id')) {
                $mapper = new StreamerMapper();
                $mapper->delete($this->getRequest()->getParam('id'));

                $this->redirect()
                    ->withMessage('deleteSuccess')
                    ->to(['action' => 'index']);
            }
        }

        $this->redirect()
            ->to(['action' => 'index']);
    }
}
