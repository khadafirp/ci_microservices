<?php
namespace App\Filters\MessageBroker;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Producers {

    public function kirim($header){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        
        $channel->queue_declare($header, false, false, false, false);

        $msg = new AMQPMessage("bismillah");
        $channel->basic_publish($msg, '', $header);

        $channel->close();
        $connection->close();
    }
}