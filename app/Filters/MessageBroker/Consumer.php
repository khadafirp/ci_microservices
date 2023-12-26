<?php
namespace App\Filters\MessageBroker;

use App\Controllers\ThirdPartyController;
use App\Filters\Dto\MessageBrokerDto;
use App\Models\ListToken;
use App\Models\Pengguna;
use CodeIgniter\API\ResponseTrait;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer{
    use ResponseTrait;
    public function menerima($queue, $token){

        $status = false;
        $sendToElastic = new ThirdPartyController();
        $listTokenModel = new ListToken();
        $getUser = new Pengguna();
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $getTokenUser = $listTokenModel->where(['token' => $token])->first();
        $data = $getUser->where(['pengguna_id' => $getTokenUser['pengguna_id']])->first();

        try{
            $result =($channel->basic_get($queue, true, null))->getBody();

            if($result != null || !empty($result)){
                $channel->queue_delete($queue);
            }
                    
            $channel->close();
            $connection->close();
        }catch(Exception $e){
            $sendToElastic->index($data, $token);
            return $e->getMessage();
        }
    }
}