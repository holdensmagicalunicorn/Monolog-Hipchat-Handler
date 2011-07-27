<?php

namespace Palleas\HipChat\Monolog;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
* 
*/
class RoomHandler extends AbstractProcessingHandler
{
    private $client;
    
    private $room;

    protected $colors = array(
        Logger::DEBUG       => \HipChat::COLOR_YELLOW,
        Logger::INFO        => \HipChat::COLOR_PURPLE,
        Logger::WARNING     => \HipChat::COLOR_YELLOW,
        Logger::ERROR       => \HipChat::COLOR_RED,
        Logger::CRITICAL    => \HipChat::COLOR_RED,
        Logger::ALERT       => \HipChat::COLOR_RED,
    );

    public function __construct(\HipChat $client, $room)
    {
        $this->client = $client;
        $this->room = $room;
    }

    protected function write(array $record)
    {
        $color = $this->getColor($record['level']);
        
        $this->client->message_room($this->room, 'Monolog', $record['formatted'], $this->shouldNotify($record['level']), $color);
    }

    protected function getColor($level) 
    {
        if (!isset($this->colors[$level])) {
            throw new Exception\UnexpectedLevelException(sprintf('Log level was not recognized (%d)', $level));
        }

        return $this->colors[$level];
    }

    protected function shouldNotify($level) 
    {
        return in_array($level, array(Logger::ERROR, Logger::CRITICAL, Logger::ALERT));    
    }

}