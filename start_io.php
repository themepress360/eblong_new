<?php
// composer autoload
require_once("vendor/autoload.php");
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

$io = new SocketIO(2020);
global $usernames;
$io->on('connection', function($socket){  
    $socket->addedUser = false;
    // when the client emits 'add user id ', this listens and executes
    //This Event is insert data
    $socket->on('add-user', function ($data) use($socket){
        var_dump($data);
        global $usernames,$numUsers;
        if(!empty($data))
            $user_id     = (int)$data['userId'];
        // we store the username in the socket session for this client
        $socket->user_id     = $user_id;
        // add the client's username to the global list
        $usernames[$user_id]['user_id']     = $socket->user_id;
        $usernames[$user_id]['socket_id']   = $socket->id;
        var_dump($usernames[$user_id]);
        ++$numUsers;
        $socket->addedUser = true;
    });

    $socket->on('chat-message', function ($data)use($socket){
        var_dump($data);
        if(!empty($GLOBALS['usernames'][$data['user_id']]) && !empty($GLOBALS['usernames'][$data['user_id']]['socket_id']))
        {
            var_dump("emit_success ".$GLOBALS['usernames'][$data['user_id']]['socket_id']);
            $socket->broadcast->to($GLOBALS['usernames'][$data['user_id']]['socket_id'])->emit("chat-message",$data);
        }
        else
        {
            var_dump("not in array");
            var_dump($GLOBALS['usernames'][$data['user_id']]);
        }
    });

    // when the user disconnects.. perform this
    $socket->on('disconnect', function () use($socket) {
        global $usernames,$numUsers;
        // remove the username from global usernames list
        if($socket->addedUser) {
            print_r("disconnect user id = ".$socket->user_id);
            unset($usernames[$socket->user_id]);
            --$numUsers;
        }
    });

});

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
