<?php

namespace Modules\Twitchstreams\Config;

class Config extends \Ilch\Config\Install
{
    public $config = [
        'key' => 'twitchstreams',
        'version' => '1.0',
        'icon_small' => 'fa-twitch',
        'author' => 'Fasse, Fabian',
        'languages' => [
            'de_DE' => [
                'name' => 'Twitchstreams',
                'description' => 'Hier können Twitch-Streamer verwaltet werden.',
            ],
            'en_EN' => [
                'name' => 'Twitchstreams',
                'description' => 'Here you can manage Twitch streamer',
            ],
        ],
        'boxes' => [
            'streamer' => [
                'de_DE' => [
                    'name' => 'Twitchstreams'
                ],
                'en_EN' => [
                    'name' => 'Twitchstreams'
                ]
            ]
        ],
        'ilchCore' => '2.0.0',
        'phpVersion' => '5.6'
    ];

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
        
        $databaseConfig = new \Ilch\Config\Database($this->db());
        $databaseConfig->set('twitchstreams_requestEveryPageCall', '0')
            ->set('twitchstreams_apikey', '');
    }
    
    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_twitchstreams_streamer`');
        $this->db()->queryMulti("DELETE FROM `[prefix]_config` WHERE `key` = 'twitchstreams_requestEveryPageCall';
            DELETE FROM `[prefix]_config` WHERE `key` = 'twitchstreams_apikey';");
    }
    
    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_twitchstreams_streamer` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user` VARCHAR(255) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `online` INT(1) NOT NULL,
            `game` VARCHAR(255) NOT NULL,
            `viewers` INT(11) NOT NULL,
            `previewMedium` VARCHAR(255) NOT NULL,
            `link` VARCHAR(255) NOT NULL,
            `createdAt` DATETIME NOT NULL,
            PRIMARY KEY(`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;';
    }

    public function getUpdate()
    {

    }
}
