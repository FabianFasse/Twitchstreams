<?php

namespace Modules\Twitchstreams\Config;

class Config extends \Ilch\Config\Install
{
    public $config = array
    (
        'key' => 'twitchstreams',
        'icon_small' => 'twitchstreams.png',
        'languages' => array
        (
            'de_DE' => array
            (
                'name' => 'Twitchstreams',
                'description' => 'Hier können Twitch-Streamer verwaltet werden.',
            ),
            'en_EN' => array
            (
                'name' => 'Twitchstreams',
                'description' => 'Here you can manage Twitch streamer',
            ),
        )
    );
    
    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
        
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('twitchstreams_requestEveryPageCall', '0');
    }
    
    public function uninstall()
    {
        $this->db()->queryMulti("DROP TABLE `[prefix]_twitchstreams_streamer`");
        $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = `twitchstreams_requestEveryPageCall`");
    }
    
    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_twitchstreams_streamer` (
                  `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `user` VARCHAR(255) COLLATE NOT NULL,
                  `title` VARCHAR(255) COLLATE NOT NULL,
                  `online` INT(2) NOT NULL,
                  `game` VARCHAR(255) COLLATE NOT NULL,
                  `viewers` INT(11) NOT NULL,
                  `previewMedium` VARCHAR(255) NOT NULL,
                  `link` VARCHAR(255) COLLATE NOT NULL,
                  `createdAt` DATETIME NOT NULL,
                  PRIMARY KEY(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
    }
    
}