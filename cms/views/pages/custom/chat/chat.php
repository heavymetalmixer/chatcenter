<?php

$limit_contact = 10;
$limit_message = 15;

/*===========================================================
Traemos los contactos
===========================================================*/

$url = "contacts?orderBy=date_updated_contact&orderMode=DESC&startAt=0&endAt=" . $limit_contact;
$method = "GET";
$fields = array();

$getContacts = CurlController::request($url, $method, $fields);
// echo '<pre>$getContacts '; print_r($getContacts); echo '</pre>';

if ($getContacts->status == 200) {
    $contacts = $getContacts->results;

    /*===========================================================
    Traemos la conversación más reciente
    ===========================================================*/

    $url = "messages?linkTo=phone_message&equalTo=" . $contacts[0]->phone_contact . "&orderBy=id_message&orderMode=DESC&startAt=0&endAt=" . $limit_message;
    $getMessages = CurlController::request($url, $method, $fields);
    // echo '<pre>$getMessages '; print_r($getMessages); echo '</pre>';

    if ($getMessages->status == 200) {
        $messages = $getMessages->results;
        // echo '<pre>$messages '; print_r($messages); echo '</pre>';
    }
    else {
        $messages = array();
    }
}
else {
    $contacts = array();
}

?>

<div class="container-fluid p-0">

  <div class="main-container">

  <?php

  include "modules/chat-container/chat-container.php";
  include "modules/contact-list/contact-list.php";

  ?>

  </div>

</div>
