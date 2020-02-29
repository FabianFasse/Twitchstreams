<?php $streamer = $this->get('streamer'); ?>

<link href="<?=$this->getModuleUrl('static/css/streams.css') ?>" rel="stylesheet">

<?php if (!empty($streamer)): ?>
  <?php for ($i = 0; $i < sizeof($streamer); $i++): ?>
    <?php if (isset($streamer[$i])): ?>
        <?php $date = new \Ilch\Date($streamer[$i]->getCreatedAt()); ?>
      <div id="streamer">
        <div class="panel panel-default">
          <div class="panel-heading">
            <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer[$i]->getId()]) ?>">
              <?=$streamer[$i]->getTitle() ?>
            </a>
          </div>
          <div class="panel-body">
            <div  id="show-info">
              <div class="col-md-12 col-lg-4">
                <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer[$i]->getId()]) ?>">
                  <img class="thumbnail" src="<?=$streamer[$i]->getPreviewMedium() ?>" title="<?=$streamer[$i]->getUser().' '.$this->getTrans('playing').' '.$streamer[$i]->getGame() ?>">
                </a>
              </div>
              <div class="col-md-12 col-lg-8">
                <ul class="list-group">
                  <li class="list-group-item">
                    <?=$this->getTrans('streamer') ?>
                    <span class="badge">
                      <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer[$i]->getId()]) ?>">
                        <?=$streamer[$i]->getUser() ?>
                      </a>
                    </span>
                  </li>
                  <li class="list-group-item">
                    <?=$this->getTrans('game') ?>
                    <span class="badge"><?=$streamer[$i]->getGame() ?></span>
                  </li>
                  <li class="list-group-item">
                    <?=$this->getTrans('viewers') ?>
                    <span class="badge"><?=number_format($streamer[$i]->getViewers(), 0, '','.') ?></span>
                  </li>
                  <li class="list-group-item">
                    <?=$this->getTrans('onlineSince') ?>
                    <span class="badge"><?=$date->format("d.m.Y H:i") ?></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endfor; ?>
<?php else: ?>
  <?=$this->getTrans('noStreamer') ?>
<?php endif; ?>
