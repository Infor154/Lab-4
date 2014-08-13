<?php
//puts the tweets into an array
function tweets2array($tweets){
    $records = array();
    foreach($tweets as $tweet){
        $t = new stdClass();
        $t->id = strval($tweet->id);
        $t->date=$tweet->created_at;
        $t->from_user_id=$tweet->user->id;
        $t->from_user_name=$tweet->user->name;
        $t->to_user_id = $tweet->in_reply_to_user_id;
        $t->to_user_name=$tweet->in_reply_to_screen_name;
        $t->geo=$tweet->geo;
        $t->profile_image_url=$tweet->user->profile_image_url;
        $t->text=$tweet->text;
        
        $records[]=$t;
    }
    return $records;
}
?>
