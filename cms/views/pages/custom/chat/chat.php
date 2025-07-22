<?php 

/*=============================================
Límites
=============================================*/

$limitContact = 10;
$limitMessage = 15;
$lastIdMessage = 0;

/*=============================================
Traemos los contactos
=============================================*/

$url = "contacts?orderBy=date_updated_contact&orderMode=DESC&startAt=0&endAt=".$limitContact;
$method = "GET";
$fields = array();

$getContacts = CurlController::request($url,$method,$fields);

if($getContacts->status == 200){

  $contacts = $getContacts->results;

  /*=============================================
  Traemos la conversación de acuerdo al link del contacto
  =============================================*/

  if(isset($_GET["phone"])){

    $url = "messages?linkTo=phone_message&equalTo=".explode("_",$_GET["phone"])[0]."&orderBy=id_message&orderMode=DESC&startAt=0&endAt=".$limitMessage;
  
  /*=============================================
  Traemos la conversación más reciente
  =============================================*/

  }else{

    $url = "messages?linkTo=phone_message&equalTo=".$contacts[0]->phone_contact."&orderBy=id_message&orderMode=DESC&startAt=0&endAt=".$limitMessage;
  }
 
  $getMessages = CurlController::request($url,$method,$fields);
 
  if($getMessages->status == 200){

    $messages = $getMessages->results;
    $lastIdMessage = $messages[0]->id_message;

  
  }else{

    $messages = array();

  }
 
}else{

  $contacts = array();

}

?>

<div class="container-fluid p-0">

  <audio id="chatSound" src="/views/assets/files/68143a7deacde37.mp3" preload="auto"></audio>
  <audio id="messageSound" src="/views/assets/files/68143bbc3cafe56.mp3" preload="auto"></audio>

  <div class="main-container">

    <?php 

      include "modules/chat-container/chat-container.php";
      include "modules/contact-list/contact-list.php";

    ?>

  </div>

</div>

<script src="/views/assets/js/chat/chat.js"></script>