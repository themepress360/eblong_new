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
    $socket->on('add_user_id', function ($data) use($socket){
        global $usernames,$numUsers;
        $data = explode(',',$data);
        if(!empty($data[1]))
            $user_id     = (int)$data[1];
        if(!empty($data[0]))
            $device_type = $data[0];
        // we store the username in the socket session for this client
        $socket->user_id     = $user_id;
        $socket->device_type = $device_type;
        // add the client's username to the global list
        $usernames[$user_id]['user_id']     = $socket->user_id;
        $usernames[$user_id]['device_type'] = $socket->device_type;
        $usernames[$user_id]['socket_id']   = $socket->id;
        var_dump($usernames[$user_id]);
        ++$numUsers;
        $socket->addedUser = true;
    });

    $socket->on('Conflict_Approve_Popup', function ($data)use($socket){
        $data = json_decode($data,true);
        // var_dump(!empty($GLOBALS['usernames'][$data['driver_user_id']]));
        // var_dump(!empty($GLOBALS['usernames'][$data['driver_user_id']]['socket_id']));
        // exit();
        if(!empty($GLOBALS['usernames'][$data['driver_user_id']]) && !empty($GLOBALS['usernames'][$data['driver_user_id']]['socket_id']))
        {
            var_dump("emit_success ".$GLOBALS['usernames'][$data['driver_user_id']]['socket_id']);
            if(empty($data['packet']['url']))
                $data['packet']['url'] = "";
            if(empty($data['packet']['param']))
                $data['packet']['param'] = (object)[];
            if(empty($data['packet']['type']))
                $data['packet']['type'] = ""; 
                
            if($GLOBALS['usernames'][$data['driver_user_id']]['device_type'] == "android")
            {
                $android_iphone_data = array('body' => $data['popup_message'], 'title'=> "TollPAYS",'type' => $data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1');
            }
            else
            {
                $android_iphone_data = array('to' => "", 'notification' => array('title' => "TollPAYS" , 'text' => $data['popup_message']),'priority'=>'high',"data" => array("data"=>array('type'=>$data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1',"title_text" => "TollPAYS","body" => $data['popup_message'])));
            }
            $socket->broadcast->to($GLOBALS['usernames'][$data['driver_user_id']]['socket_id'])->emit("Conflict_Approve_Popup",$android_iphone_data);
        }
        else
        {
            var_dump("not in array");
            var_dump($GLOBALS['usernames'][$data['driver_user_id']]);
        }
    });
   
    //When driver press the Decline Button This socket is working
    $socket->on('Conflict_Driver_Reject_Request_Announcement', function ($data)use($socket){
        $data = json_decode($data,true);
        var_dump($data);
        if(!empty($GLOBALS['usernames'][$data['contributor_user_id']]) && !empty($GLOBALS['usernames'][$data['contributor_user_id']]['socket_id']))
        {
            var_dump("emit_success Conflict_Driver_Reject_Request_Announcement ".$GLOBALS['usernames'][$data['contributor_user_id']]['socket_id']);
            if(empty($data['packet']['url']))
                $data['packet']['url'] = "";
            if(empty($data['packet']['param']))
                $data['packet']['param'] = (object)[];
            if(empty($data['packet']['type']))
                $data['packet']['type'] = ""; 
                
            if($GLOBALS['usernames'][$data['contributor_user_id']]['device_type'] == "android")
            {
                $android_iphone_data = array('body' => $data['popup_message'], 'title'=> "TollPAYS",'type' => $data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1');
            }
            else
            {
                $android_iphone_data = array('to' => "", 'notification' => array('title' => "TollPAYS" , 'text' => $data['popup_message']),'priority'=>'high',"data" => array("data"=>array('type'=>$data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1',"title_text" => "TollPAYS","body" => $data['popup_message'])));
            }
            var_dump($android_iphone_data);
            $socket->broadcast->to($GLOBALS['usernames'][$data['contributor_user_id']]['socket_id'])->emit("Conflict_Driver_Reject_Request_Announcement",$android_iphone_data);
        }
        else
        {
            var_dump("not in array");
            var_dump($GLOBALS['usernames'][$data['contributor_user_id']]);
        }
    });
    
    //When Conflict Group Annoucements to all the users
    $socket->on('Conflict_Group', function ($data)use($socket){
        $data = json_decode($data,true);
        $duplicate_data = $data;
        if(!empty($data['user_ids']))
        {
            $user_ids  = explode(',',$data['user_ids']);
            foreach ($user_ids as $key => $user_id) 
            {
                if(!empty($GLOBALS['usernames'][$user_id]) && !empty($GLOBALS['usernames'][$user_id]['socket_id']))
                {
                    if(is_array($duplicate_data['popup_message']))
                    {

                        if(!empty($duplicate_data['packet']) && $duplicate_data['packet']['approved_request_user_id'] == $user_id)
                        {
                            $data['popup_message'] = $duplicate_data['popup_message'][0];
                        }
                        else
                        {
                            $data['popup_message'] = $duplicate_data['popup_message'][1];
                        }
                    }
                    else
                        $data['popup_message'] = $duplicate_data['popup_message'];
                    if(empty($data['packet']['url']))
                        $data['packet']['url'] = "";
                    if(empty($data['packet']['param']))
                        $data['packet']['param'] = (object)[];
                    if(empty($data['packet']['type']))
                        $data['packet']['type'] = ""; 
                    if($GLOBALS['usernames'][$user_id]['device_type'] == "android")
                    {
                        $android_iphone_data = array('body' => $data['popup_message'], 'title'=> "TollPAYS",'type' => $data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1');
                    }
                    else
                    {
                        $android_iphone_data = array('to' => "", 'notification' => array('title' => "TollPAYS" , 'text' => $data['popup_message']),'priority'=>'high',"data" => array("data"=>array('type'=>$data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1',"title_text" => "TollPAYS","body" => $data['popup_message'])));
                    }
                    if($data['packet']['type'] == "restart_conflict_process")
                    {
                        var_dump("dekho abb khud");
                        var_dump("emit_success ".$GLOBALS['usernames'][$user_id]['socket_id']);
                    }
                    var_dump($data['packet']['type']);
                    var_dump("emit_success ".$GLOBALS['usernames'][$user_id]['socket_id']);
                    var_dump($user_id);
                    var_dump("--------------------");
                    $socket->broadcast->to($GLOBALS['usernames'][$user_id]['socket_id'])->emit("Conflict_Group",$android_iphone_data); 
                }
                else
                {
                    var_dump("not in array Socket Connection.");
                    var_dump($GLOBALS['usernames'][$user_id]);
                }
            }
        }
        else
        {
            var_dump("There is no users announcement conflict group.");
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

    //Renting Borrowing Socket Working Start
    $socket->on('Renting_Borrowing', function ($data)use($socket){
        $data = json_decode($data,true);
        if(!empty($data['user_ids']))
        {
            $user_ids  = explode(',',$data['user_ids']);
            foreach ($user_ids as $key => $user_id) 
            {
               if(!empty($GLOBALS['usernames'][$user_id]) && !empty($GLOBALS['usernames'][$user_id]['socket_id']))
                {
                    $data['popup_message'] = $data['popup_message'];
                    // if(!empty($data['popup_message']))
                    //     $data['popup_message'] = $data['popup_message'];
                    // else
                    //     $data['popup_message'] = "";
                    if(empty($data['packet']['url']))
                        $data['packet']['url'] = "";
                    if(empty($data['packet']['param']))
                        $data['packet']['param'] = (object)[];
                    if(empty($data['packet']['type']))
                        $data['packet']['type'] = ""; 
                    if($GLOBALS['usernames'][$user_id]['device_type'] == "android")
                    {
                        $android_iphone_data = array('body' => $data['popup_message'], 'title'=> "TollPAYS",'type' => $data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1');
                    }
                    else
                    {
                        $android_iphone_data = array('to' => "", 'notification' => array('title' => "TollPAYS" , 'text' => $data['popup_message']),'priority'=>'high',"data" => array("data"=>array('type'=>$data['packet']['type'],'url'=> $data['packet']['url'],"params" => $data['packet']['param'],"silent_notification" => '1',"title_text" => "TollPAYS","body" => $data['popup_message'])));
                    }
                    var_dump($data['packet']['param']);
                    var_dump($data['packet']['type']);
                    var_dump("emit_success ".$GLOBALS['usernames'][$user_id]['socket_id']);
                    var_dump($user_id);
                    var_dump("--------------------");
                    $socket->broadcast->to($GLOBALS['usernames'][$user_id]['socket_id'])->emit("Renting_Borrowing",$android_iphone_data); 
                }
                else
                {
                    var_dump("Renting Borrowing Socket is disconnect whose user_id = ".$user_id);
                } 
            }
        }
        else
        {
            var_dump("There is no users announcement renting borrowing.");
        }
    });
    //Renting Borrowing Socket Working End

});

if (!defined('GLOBAL_START')) {
    Worker::runAll();
}
