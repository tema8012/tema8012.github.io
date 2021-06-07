<?php
include 'myincludes/config.php';
$today = date("d/m/Y в g:i ");


 /* Здесь проверяется существование переменных */
$orderFieldset = " Заявка на ($today) ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['name']) && !empty($_POST['phone'])){
        if (isset($_POST['name'])) {
            if (!empty($_POST['name'])){
                $name = strip_tags($_POST['name']);
                $nameFieldset = "Имя: ";
            }
        }

        if (isset($_POST['phone'])) {
            if (!empty($_POST['phone'])){
                $phone = strip_tags($_POST['phone']);
                $phoneFieldset = "Телефон: ";
            }
        }
        if (isset($_POST['theme'])) {
            if (!empty($_POST['theme'])){
                $theme = strip_tags($_POST['theme']);
                $themeFieldset = "Заказали: ";
            }




        }
           /* А здесь прописывается текст сообщения, \n - перенос строки */
        $mes = "Тема: Поступил новый заказ!\nТелефон: $phone\nИмя: $name\nIP-адрес посетителя: $ipadres\nВремя заказа: $vremyazakaza";

        /* А эта функция как раз занимается отправкой письма на указанный вами email */
        $sub='Заявка на Гамак '; //сабж
        $email='<Заказ>'; // от кого
        $send = mail ($address,$sub,$mes,"Content-type:text/plain; charset = utf-8\r\nFrom:$email");

        ini_set('short_open_tag', 'On');
        $arr = array(
            $orderFieldset => $order,
            $nameFieldset => $name,
            $phoneFieldset => $phone,
            $themeFieldset => $theme,
            $vremyazakazaFieldset => $vremyazakaza
        );
        foreach($arr as $key => $value) {
            $txt .= "<b>".$key."</b> ".$value."%0A";
        };
        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
        if ($sendToTelegram) {
echo '';
        } else {
            echo '<p class="fail"><b>Ошибка. Сообщение не отправлено!</b></p>';
			exit();
        }
    } else {
        echo '<p class="fail">Ошибка. Вы заполнили не все обязательные поля!</p>';
		exit();
    }
} else {
    header ("Location: /");
	exit();
}

header('Refresh: 100; /');
?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta http-equiv='refresh' content='500; url=/' />
<title>Поздравляем! Ваша заявка принята!</title>
<style type="text/css">
    body {
        line-height: 1;
        height: 100%;
        font-family: Arial;
        font-size: 15px;
        color: #313e47;
        width: 100%;
        height: 100%;
        padding: 0;
        margin: 0;
        background: url('data:image/jpeg;base64,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');
    }
    h2 {
        margin: 0;
        padding: 0;
        font-size: 36px;
        line-height: 44px;
        color: #34920b;
        text-align: center;
        font-weight: bold;
    }
    a {
        color: #34920b;
    }
    .list_info li span {
        width: 150px;
        display: inline-block;
        font-weight: bold;
        font-style: normal;
    }
    .list_info {
        text-align: left;
        display: inline-block;
        list-style: none;
        margin-top: -10px;
        margin-bottom: -11px;
    }
    .list_info li {
        margin: 11px 0px;
    }
    .fail {
        margin: 10px 0 20px 0px;
        text-align: center;
    }
    .email {
        position: relative;
        text-align: center;
        margin-top: 40px;
    }
    .email input {
        height: 30px;
        width: 200px;
        font-size: 14px;
        padding-right: 10px;
        padding-left: 10px;
        outline: none;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #B6B6B6;
        margin-bottom: 10px;
    }
    .block_success {
        max-width: 960px;
        padding: 100px 30px 70px 30px;
        margin: -50px auto;
    }
    .success {
        text-align: center;
    }
	.success a {
        text-align: center;
		font-size:20px;
    }
    .perenapravl{
        text-align: center;
		font-size:24px;
    }
	    .perenapravl1{
        text-align: center;
		font-size:20px;
    }
</style>

</head>

 <body>

    <div class="block_success">
            <h2 style="text-transform: uppercase;">Спасибо за заказ!<br />Ваша заявка принята!</h2>
            <p class="success">
                В ближайшее время с Вами свяжется оператор для подтверждения заказа. Пожалуйста, включите Ваш контактный телефон.
            </p>
			<p class="perenapravl">
            Вы указали следующие данные для обратной связи:<br><hr></p>
<p class="perenapravl1">Имя:
<?php
 echo $_POST['name'];
 ?><br>
 Телефон:
 <?php
 echo $_POST['phone'];
 ?>
 <p style="text-align:center"><span style="color:#e74c3c">- Если вы ошиблись при заполнении данных ,&nbsp; пожалуйста</span></p>

<p style="text-align:center"><a href="/">заполните заявку еще раз</a></p>

<


</html>