<?php

$errors = false;

if ((isset($_POST['email'])) && (!empty($_POST["email"]))) {
	$result['email'] = 'is-valid';
} else {
	$result['email'] = 'is-invalid';
	$errors = true;
}


if ((isset($_POST['username'])) && (!empty($_POST["username"]))) {
	$result['username'] = 'is-valid';
} else {
	$result['username'] = 'is-invalid';
	$errors = true;
}
if ((isset($_POST['telegram'])) && (!empty($_POST["telegram"]))) {
	$result['telegram'] = 'is-valid';
} else {
	$result['telegram'] = 'is-invalid';
	$errors = true;
}

if ((isset($_POST['quest'])) && (!empty($_POST["quest"]))) {
	$result['quest'] = 'is-valid';
} else {
	$result['quest'] = 'is-invalid';
	$errors = true;
}
if (isset($_POST['accept']) && $_POST['accept'] == '1') {
	$result['accept'] = 'is-valid';
} else {
	$result['accept'] = 'is-invalid';
	$errors = true;
}


if ($errors) {
	$result['success'] = 0;
	echo json_encode($result);
	die();
} else {
	$result['success'] = 1;
	echo json_encode($result);
}

if ($_POST['name'] != '') die('spam');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

if (file_exists("/mail.php"))
	include "/mail.php";
$mail->SMTPAutoTLS = false;
//$mail->SMTPAutoTLS = true;
//$mail->SMTPSecure = "tls";
$mail->SMTPAuth = true;

//$mail->setFrom('www@bitbrain.me', 'BITBRAIN');<------>
$mail->setFrom('no-reply@bitbrain.me', 'BITBRAIN');
//$mail->AddAddress('support@bitbrain.me');
$mail->AddAddress('orenlr56@yandex.ru');
$mail->AddAddress('yygula93@gmail.com');
// $mail->AddAddress('fcbteam2016@gmail.com');

$mail->Subject = 'Заявка с сайта PRO BITBRAIN';

foreach ($_POST as $key => $value) {
	if ($value != "") {
		$name = '';
		switch ($key) {
			case "email":
				$name = "E-mail";
				break;
			default:
				$name = $key;
				break;
		}
		if ($key != 'mail-group') {
			$message .= "
				" . (($c = !$c) ? '<tr>' : '<tr style="background-color: #f8f8f8;">') . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;width: 40%;'><b>$name</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;width: 60%;'>$value</td>
			</tr>
			";
		}
	}
}

$body = "<table style='width: 100%;'>$message</table>";
$mail->msgHTML($body);

if ($mail->send()) {
	$result = "success";
} else {
	$result = "error";
}

// Код для отправки на UniSender не включен

// echo json_encode(['success' => $result]);
