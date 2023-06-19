<?php

$siteOwnersEmail = 'arina8927088@gmail.com';


if($_POST) {

   $fname = trim(stripslashes($_POST['contactFname']));
   $lname = trim(stripslashes($_POST['contactLname']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // проверка имени
	if (strlen($fname) < 2) {
		$error['fname'] = "Пожалуйста, введите ваше имя";
	}
	// проверка фамилии
	if (strlen($lname) < 2) {
		$error['lname'] = "Пожалуйста, введите вашу фамилию";
	}
	// проверка почты
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Пожалуйста, введите тему обращения";
	}
	// проверка сообщения
	if (strlen($contact_message) < 15) {
		$error['message'] = "Пожалуйста введите ваше сообщение";
	}
   // тема
	if ($subject == '') { $subject = "Отправка контактной формы"; }


	$name = $fname . " " . $lname;

   $message .= "Email from: " . $name . "<br />";
    $message .= "Email address: " . $email . "<br />";
   $message .= "Message: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Это электронное письмо было отправлено с помощью контактной формы вашего сайта. <br />";

   $from =  $name . " <" . $email . ">";

	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail);
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Что-то пошло не так. Пожалуйста, попробуйте снова."; }
		
	}

	else {

		$response = (isset($error['fname'])) ? $error['fname'] . "<br /> \n" : null;
		$response .= (isset($error['lname'])) ? $error['lname'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	}

}

?>