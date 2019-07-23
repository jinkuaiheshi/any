<?php

use AliyunMNS\Client;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Exception\MnsException;

class CreateQueueAndSendMessage
{
    private $accessId;
    private $accessKey;
    private $endPoint;
    private $client;

    public function __construct($accessId, $accessKey, $endPoint)
    {
        $this->accessId = $accessId;
        $this->accessKey = $accessKey;
        $this->endPoint = $endPoint;
    }

    public function run()
    {

   
        $this->client = new Client($this->endPoint, $this->accessId, $this->accessKey);
        $queueName ='aliyun-iot-a11vz5r3Vs6';
//        // 1. create queue
//        $request = new CreateQueueRequest($queueName);
//        try
//        {
//            $res = $this->client->createQueue($request);
//            echo "QueueCreated! \n";
//        }
//        catch (MnsException $e)
//        {
//            echo "CreateQueueFailed: " . $e;
//            return;
//        }
        $queue = $this->client->getQueueRef($queueName);

        // 2. send message
//        $messageBody = "test";
//        // as the messageBody will be automatically encoded
//        // the MD5 is calculated for the encoded body
//        $bodyMD5 = md5(base64_encode($messageBody));
//        $request = new SendMessageRequest($messageBody);
//        try
//        {
//            $res = $queue->sendMessage($request);
//            echo "MessageSent! \n";
//        }
//        catch (MnsException $e)
//        {
//            echo "SendMessage Failed: " . $e;
//            return;
//        }

        // 3. receive message
        $receiptHandle = NULL;
        try
        {
            // when receiving messages, it's always a good practice to set the waitSeconds to be 30.
            // it means to send one http-long-polling request which lasts 30 seconds at most.
            $res = $queue->receiveMessage(30);

            if ($res->getMessageBodyMD5())
            {

                $data =  $res->getMessageBody();
                return json_decode($data);
                //return base64_decode(json_decode($data)->payload);
            }
            $receiptHandle = $res->getReceiptHandle();
        }
        catch (MnsException $e)
        {
            echo "ReceiveMessage Failed: " . $e;
            return;
        }

        // 4. delete message
//        try
//        {
//            $res = $queue->deleteMessage($receiptHandle);
//            echo "DeleteMessage Succeed! \n";
//        }
//        catch (MnsException $e)
//        {
//            echo "DeleteMessage Failed: " . $e;
//            return;
//        }

        // 5. delete queue
//        try {
//            $this->client->deleteQueue($queueName);
//            echo "DeleteQueue Succeed! \n";
//        } catch (MnsException $e) {
//            echo "DeleteQueue Failed: " . $e;
//            return;
//        }
    }
}

$accessId = "LTAI32xr6egWoWsF";
$accessKey = "YdY7ZvRZqEzxDPG62f7wm6uxmjFfzh";
$endPoint = "http://1504563645010586.mns.cn-shanghai.aliyuncs.com/";

if (empty($accessId) || empty($accessKey) || empty($endPoint))
{
    echo "Must Provide AccessId/AccessKey/EndPoint to Run the Example. \n";
    return;
}


$instance = new CreateQueueAndSendMessage($accessId, $accessKey, $endPoint);
//$instance->run();

?>
