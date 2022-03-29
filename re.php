<?php
require __DIR__ . '/vendor/autoload.php';

use Predis\Client;
use AndrewBreksa\RSMQ\RSMQClient;

$predis = new Client(
    [
        'host' => '127.0.0.1',
        'port' => 6379
    ]
);

$rsmq = new RSMQClient($predis);
// $rsmq->createQueue('myqueue');

// $queues = $rsmq->listQueues();
// var_dump($queues);

// $end=$rsmq->deleteQueue('myqueue');
// var_dump($end);

// $attributes =  $rsmq->getQueueAttributes('myqueue');
// echo "visibility timeout: ", $attributes->getVt(), "\n";
// echo "delay for new messages: ", $attributes->getDelay(), "\n";
// echo "max size in bytes: ", $attributes->getMaxSize(), "\n";
// echo "total received messages: ", $attributes->getTotalReceived(), "\n";
// echo "total sent messages: ", $attributes->getTotalSent(), "\n";
// echo "created: ", $attributes->getCreated(), "\n";
// echo "last modified: ", $attributes->getModified(), "\n";
// echo "current n of messages: ", $attributes->getMessageCount(), "\n";
// echo "hidden messages: ", $attributes->getHiddenMessageCount(), "\n";

function gen_uid($l=5){
    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l);
}

$uid=gen_uid();
echo $uid, "\n";

$ary=[];
array_push($ary, $uid);

$id = $rsmq->sendMessage('myqueue', $uid);
echo "Message Sent. ID: ", $id , "\n";

$message = $rsmq->receiveMessage('myqueue');
echo "Message ID: ", $message->getId() , "\n";
echo "Message: ", $message->getMessage() , "\n";
echo "Message: ", $message->getSent(), "\n";

$attributes =  $rsmq->getQueueAttributes('myqueue');
echo "total received messages: ", $attributes->getTotalReceived(), "\n";
echo "current n of messages: ", $attributes->getMessageCount(), "\n";