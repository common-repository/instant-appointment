<?php 
$user_id = get_current_user_id(); 
                                                   
$results = insapp_select_all_conversation($user_id);
 
$last = insapp_select_last_conversation($user_id);
 
$last_conversation = $last[0]->id;
$sender_last = $last[0]->sender_id;
$receiver_last = $last[0]->receiver_id;

if(  $user_id == $sender_last){
    $user_last_2 = $receiver_last;
}else{
    $user_last_2 = $sender_last;
}
function fandatestime($daten){
    $date=date_create($daten);
    return date_format($date,"d M Y , H:i");
   }
   function fandtime($daten){
    $date=date_create($daten);
    return date_format($date,"H:i");
   }


?>

<div class="container-fluid" id="insapp_chat_page">

    <div class="card chat-layout">
        <div class="row g-0">
            <div class="col-xxl-4 col-xl-4 col-md-12 col-12 border-end">
                <div class="h-100">
                    <div class="chat-window">
                        <div class="chat-sticky-header sticky-top">
                            <div class="px-4 pt-3 pb-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="mb-0  h3">
                                            <?php _e('Messages')?>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-line-bottom" id="tab" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active py-2" id="recent-tab" data-bs-toggle="pill" href="#recent"
                                        role="tab" aria-controls="recent" aria-selected="true">
                                        <?php _e(' Boite de réception')?>
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <div data-simplebar style="height: 600px; overflow: auto;">

                            <div class="tab-content" id="tabContent">

                                    <div class="tab-pane fade show active" id="recent" role="tabpanel"
                                        aria-labelledby="recent-tab">

                                        <?php if(!empty($results) ){ ?>
                                        <ul class="list-unstyled contacts-list">


                                            <?php foreach ($results as $result) {
                                                        $conver_id = $result->id;
                                                        $sender_id = $result->sender_id;
                                                        $receiver_id = $result->receiver_id;
                                                        if($user_id == $sender_id ){
                                                            $user_id2 = $receiver_id;
                                                        }else{
                                                            $user_id2 = $sender_id;
                                                        } 
                                                        $user_info2 = get_userdata($user_id2); 
                                                        $name2 = $user_info2->display_name;   
                                                        $profile_photo_url = get_user_meta($user_id2, 'wp_user_avatar', true);

                                                        if ($profile_photo_url) {
                                                        $user_img2 = $profile_photo_url;
                                                        } else {
                                                        $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                                        }
                                    
                                                        $conver_status = $result->status;

                                                        $profile_photo_url = get_user_meta($user_id, 'wp_user_avatar', true);

                                                        if ($profile_photo_url) {
                                                        $user_img = $profile_photo_url;
                                                        } else {
                                                        $user_img =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                                        }
                                                
                                                    ?>


                                            <li class="py-3 px-4 chat-item contacts-link" date-r="<?php _e($user_id2) ?>"
                                                date-id="<?php _e($conver_id) ?>">
                                                <div class="d-flex justify-content-between align-items-center">

                                                    <a href="#!" class="text-inherit ">
                                                        <div class="d-flex">
                                                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                                                <img src="<?php echo $user_img2 ?>" alt="Image"class="rounded-circle">
                                                            </div>

                                                            <div class=" ms-2">
                                                                <span class="mb-0 ">
                                                                    <?php echo $name2 ?>
                                                                </span>
                                                                <p class="mb-0 text-muted text-truncate">
                                                                    <?php 
                                                                    $last_messages = insapp_get_last_message_($conver_id);
                                                                    if(!empty($last_messages)){
                                                                        _e(substr($last_messages[0]->smsmessage, 0, 15).'...');
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                </div>

                                                <div class="chat-actions"> </div>
                                            </li>
                                            <?php } ?>


                                        </ul>
                                        <?php }else{ ?>
                                            <h6 class="p-2">
                                                <?php _e('Vous n\'avez pas d\'interlocuteur pour le moment') ?>
                                            </h6>
                                        <?php } ?>
                                    </div>

                               
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xxl-8 col-xl-8 col-md-12 col-12">

                <div class="chat-body w-100 h-100">
                    <div class="card-header sticky-top insapp_discussion_space">

                        <div class="card-body" id="insapp_conversation_list" data-id="<?php _e($last_conversation ) ?>"
                            style="height: 650px; overflow:auto">
                            <input type="hidden" class="insapp_chat_receiver" value="<?php _e($user_last_2) ?>">
                            <input type="hidden" class="insapp_chat_sender" value="<?php _e($user_id) ?>">

                            <?php 
                            $list_messages = insapp_get_all_message_($last_conversation);
                            if(!empty($list_messages)){
                          
                            foreach ($list_messages as $list_message ) {
                            
                                $sender_id = $list_message->sender_id;
                                $receiver_id = $list_message->receiver_id;
                                $message = $list_message->smsmessage;
                                $date_ = $list_message->timestamp;
                                $date_time = fandatestime($date_) ; 
                                $time = fandtime($date_); 
                            
                                    if($user_id == $sender_id ){  
        
                                        $user_info2 = get_userdata($sender_id); 
                                        $name2 = $user_info2->display_name;   
                                        $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);
            
                                        if ($profile_photo_url) {
                                        $user_img2 = $profile_photo_url;
                                        } else {
                                        $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                        }
                                    ?>


                            <div class="d-flex justify-content-end mb-4">
                                <div class="d-flex ">

                                    <div class=" me-3 text-end">
                                        <small>
                                            <?php _e($time) ?>
                                        </small>
                                        <div class="d-flex">
                                            <div class="me-2 mt-2">
                                            </div>

                                            <div class="card mt-2 rounded-top-md-end-0 bg-primary text-white ">
                                                <div class="card-body text-start p-2">
                                                    <p class="mb-0">
                                                        <?php _e($message) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php
                                    
                                }else{
                                   
                                    $user_info2 = get_userdata($sender_id); 
                                    $name2 = $user_info2->display_name;   
                                    $profile_photo_url = get_user_meta($sender_id, 'wp_user_avatar', true);
    
                                    if ($profile_photo_url) {
                                    $user_img2 = $profile_photo_url;
                                    } else {
                                    $user_img2 =  TLPLUGIN_DEFAULT. '/avatar-fallback.jpg';
                                    }
    
                                ?>

                            <div class="d-flex  mb-4">

                                <div class=" ms-3">
                                    <small>
                                        <span class="username">
                                            <?php _e($name2) ?>
                                        </span> ,
                                        <?php _e($time) ?>
                                    </small>
                                    <div class="d-flex">
                                        <div class="card mt-2 rounded-top-md-left-0 border">
                                            <div class="card-body p-2">
                                                <p class="mb-0 text-dark">
                                                    <?php  _e($message) ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="ms-2 mt-2">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php }
                             
                            ?>

                            <?php } } ?>

                        </div>

                    </div>

                    <div class="card-footer border-top-0 chat-footer mt-auto rounded-bottom">
                        <div class="mt-1">
                            <form id="chatinput-form">
                                <div class="position-relative">
                                    <input class="form-control" placeholder="Saisir votre message"
                                        id="insapp_chat_input">
                                </div>
                                <div class="position-absolute end-0 top-0 mt-4 py-1 me-4">
                                    <button type="submit"
                                        class="chat_message input-group-addon btn btn-primary">Envoyer</button>

                                </div>
                            </form>
                        </div>
                        <div class="mt-3 d-flex">
                            <div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>