<form method="POST" class="form-horizontal" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group <?=$this->validation()->hasError('inputUser') ? 'has-error' : '' ?>">
        <label for="inputUser" class="col-lg-2 control-label">
            <?=$this->getTrans('streamer') ?>
        </label>
        <div class="col-lg-2">
            <input class="form-control"
                   type="text"
                   name="inputUser"
                   placeholder="<?=$this->getTrans('username') ?>"
                   value="<?=($this->get('streamer') != '') ? $this->escape($this->get('streamer')->getUser()) : $this->originalInput('inputUser') ?>" />

        </div>
    </div>

    <?=($this->get('streamer') != '') ? $this->getSaveBar('edit') : $this->getSaveBar('add') ?>
</form>
