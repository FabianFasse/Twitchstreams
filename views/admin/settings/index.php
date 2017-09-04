<form method="POST" class="form-horizontal" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group">
        <label for="apiKey" class="col-lg-2 control-label">
            <?=$this->getTrans('apiKeyLabel') ?>
        </label>
        <div class="col-lg-4">
            <input type="text" class="form-control" id="apiKey" name="apiKey" value="<?=$this->get('apiKey') ?>" placeholder="API-Key">
        </div>
    </div>
    <div class="form-group">
        <label for="requestEveryPage" class="col-lg-2 control-label">
            <?=$this->getTrans('requestEveryPage') ?>
        </label>
        <div class="col-lg-2">
            <div class="flipswitch">
                <input type="radio" class="flipswitch-input" name="requestEveryPage" value="1" id="requestEveryPage-on" <?php if ($this->get('requestEveryPage') == '1') { echo 'checked="checked"'; } ?> />
                <label for="requestEveryPage-on" class="flipswitch-label flipswitch-label-on"><?=$this->getTrans('on') ?></label>
                <input type="radio" class="flipswitch-input" name="requestEveryPage" value="0" id="requestEveryPage-off" <?php if ($this->get('requestEveryPage') != '1') { echo 'checked="checked"'; } ?> />
                <label for="requestEveryPage-off" class="flipswitch-label flipswitch-label-off"><?=$this->getTrans('off') ?></label>
                <span class="flipswitch-selection"></span>
            </div>
        </div>
    </div>

    <?=$this->getSaveBar(); ?>
</form>
