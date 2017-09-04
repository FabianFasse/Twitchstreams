<form class="form-horizontal" method="POST" action="">
  <?=$this->getTokenField() ?>
  <div class="table-responsive">
    <table class="table table-hover table-striped">
      <colgroup>
        <col class="icon_width" />
        <col class="icon_width" />
        <col class="icon_width" />
        <col />
        <col class="col-lg-1" />
        <col class="col-lg-3" />
        <col class="col-lg-1" />
      </colgroup>
      <tr>
        <th><?=$this->getCheckAllCheckbox('check_streamer') ?></th>
        <th>
          <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'update']) ?>" alt="<?=$this->getTrans('updateStreams') ?>" title="<?=$this->getTrans('updateStreams') ?>">
            <i class="fa fa-refresh"></i>
          </a>
        </th>
        <th></th>
        <th><?=$this->getTrans('streamer') ?></th>
        <th><?=$this->getTrans('online') ?></th>
        <th><?=$this->getTrans('game') ?></th>
        <th><?=$this->getTrans('viewers') ?></th>
      </tr>
      <?php if ($this->get('streamer') != ''): ?>
        <?php foreach ($this->get('streamer') as $streamer): ?>
          <tr>
            <input type="hidden" name="items[]" value="<?=$streamer->getId() ?>" />
            <td><?=$this->getDeleteCheckbox('check_streamer', $streamer->getId()) ?></td>
            <td><?=$this->getEditIcon(['action' => 'treat', 'id' => $streamer->getId()]); ?></td>
            <td><?=$this->getDeleteIcon(['action' => 'delete', 'id' => $streamer->getId()]) ?></td>
            <td><?=$streamer->getUser() ?></td>
            <td>
              <?php if ($streamer->getOnline() == 1): ?>
                <?=$this->getTrans('yes') ?>
              <?php else: ?>
                <?=$this->getTrans('no') ?>
              <?php endif; ?>
            </td>
            <td><?=$streamer->getGame() ?></td>
            <td><?=number_format($streamer->getViewers(), 0, '','.') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7"><?=$this->getTrans('noStreamer') ?></td>
        </tr>
      <?php endif; ?>
    </table>
  </div>
  <div class="content_savebox">
    <input type="hidden" class="content_savebox_hidden" name="action" value="" />
    <div class="btn-group dropup">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        <?=$this->getTrans('selected') ?> <span class="caret"></span>
      </button>
      <ul class="dropdown-menu listChooser" role="menu">
        <li><a href="#" data-hiddenkey="delete"><?=$this->getTrans('delete') ?></a></li>
      </ul>
    </div>
  </div>
</form>
