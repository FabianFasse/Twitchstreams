<?php
$streamer = $this->get('streamer')[0];
$date = new \Ilch\Date($streamer->getCreatedAt());
?>

<link href="<?=$this->getModuleUrl('static/css/streams.css') ?>" rel="stylesheet">

<?php if ($streamer != ''): ?>
  <div id="streamer">
    <div class="panel panel-default">
      <div class="panel-heading">
        <?=$streamer->getTitle() ?>
      </div>
      <div class="panel-body">
        <div class="col-md-12 col-lg-4">
          <img class="thumbnail" src="<?=$streamer->getPreviewMedium() ?>" title="<?=$streamer->getUser().' '.$this->getTrans('playing').' '.$streamer->getGame() ?>">
        </div>
        <div class="col-md-12 col-lg-8">
          <ul class="list-group">
            <li class="list-group-item">
              <?=$this->getTrans('streamer') ?>
              <span class="badge">
                <a href="https://www.twitch.tv/<?=$streamer->getUser() ?>" target="_blank">
                  <?=$streamer->getUser() ?>
                </a>
              </span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('game') ?>
              <span class="badge"><?=$streamer->getGame() ?></span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('viewers') ?>
              <span class="badge"><?=number_format($streamer->getViewers(), 0, '','.') ?></span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('onlineSince') ?>
              <span class="badge"><?=$date->format("d.m.Y H:i") ?></span>
            </li>
          </ul>
        </div>
        <div class="clearfix"></div>

        <div class="clearfix" id="stream-chat-box" style="display: none;">
          <div id="stream-box" style="display: none;">
            <iframe frameborder="0"
                    scrolling="no"
                    allowfullscreen="true"
                    id="stream-embed"
                    src="https://player.twitch.tv/?channel=<?=$streamer->getUser() ?>&muted=true"
                    height="400px"
                    width="100%">
            </iframe>
          </div>
          <div id="chat-box" style="display: none;">
            <iframe frameborder="0"
                    scrolling="no"
                    id="chat-embed"
                    src="https://www.twitch.tv/embed/<?=$streamer->getUser() ?>/chat"
                    height="400px"
                    width="100%">
            </iframe>
          </div>
        </div>
      </div>
      <div class="panel-footer clearfix">
        <div class="pull-left">
          <button id="stream-popup" class="btn-default btn" href="javascript: void(0)" onclick="window.open('https://player.twitch.tv/?channel=<?=$streamer->getUser() ?>', '', 'width=800, height=450');">
            <?=$this->getTrans('streamPopUp') ?>
          </button>
          <button id="chat-popup" class="btn-default btn" href="javascript: void(0)" onclick="window.open('https://www.twitch.tv/embed/<?=$streamer->getUser() ?>/chat', '', 'width=800, height=450');">
            <?=$this->getTrans('chatPopUp') ?>
          </button>
        </div>
        <div class="pull-right">
          <button id="stream" class="btn-primary btn">
            <?=$this->getTrans('showStream') ?>
          </button>
            <button id="chat" class="btn-primary btn">
                <?=$this->getTrans('showChat') ?>
            </button>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <?=$this->getTrans('noStreamer') ?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function() {
  $('#chat, #stream').click(function() {
    if ($('#stream-chat-box').is(":hidden")) {
      $('#stream-chat-box').show();
    }
  });

  $('#stream').click(function() {
    var link = $(this);
    $('#stream-box').slideToggle('slow', function() {
      if ($(this).is(":visible")) {
        $('#stream-embed').prop('src', 'https://player.twitch.tv/?channel=<?=$streamer->getUser() ?>');
        link.removeClass('btn-primary').addClass('btn-danger');
        link.text('<?=$this->getTrans('hideStream') ?>');
      } else {
        $('#stream-embed').prop('src', '');
        link.removeClass('btn-danger').addClass('btn-primary');
        link.text('<?=$this->getTrans('showStream') ?>');
      }
    });
  });

  $('#chat').click(function() {
    var link = $(this);
    $('#chat-box').slideToggle('slow', function() {
      if ($(this).is(":visible")) {
        $('#chat-embed').prop('src', 'https://twitch.tv/embed/<?=$streamer->getUser() ?>/chat');
        link.removeClass('btn-primary').addClass('btn-danger');
        link.text('<?=$this->getTrans('hideChat') ?>');
      } else {
        link.removeClass('btn-danger').addClass('btn-primary');
        link.text('<?=$this->getTrans('showChat') ?>');
      }
    });
  });

  (function() {
    if ($('#stream-box').is(":hidden") && $('#chat-box').is(":hidden")) {
      $('#stream-chat-box').slideUp();
    }

    setTimeout(arguments.callee);
  })();
});
</script>
