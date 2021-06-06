<?php

/* https://api.telegram.org/bot1625993128:AAGU77GtOjzBh44OQvezyPmU0tUIx3PdrXg/getUpdates,
где, XXXXXXXXXXXXXXXXXXXXXXX - токен вашего бота, полученный ранее */

$txt = "";
$name = $_POST['user_name'];
$phone = $_POST['user_phone'];
$token = "1625993128:AAGU77GtOjzBh44OQvezyPmU0tUIx3PdrXg";
$chat_id = "-586452562";
$arr = array(
  'Имя пользователя: ' => $name,
  'Телефон: ' => $phone,
);
foreach($arr as $key => $value) {
  $txt .= "<b>".$key."</b> ".$value."%0A";
};

$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

if ($sendToTelegram) {
  header('Location: thank-you.html');
} else {
  echo "Error";
}
?>