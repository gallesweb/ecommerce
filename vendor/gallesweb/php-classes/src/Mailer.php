<?php 

namespace gallesweb;

use Rain\Tpl;

class Mailer{

	const USERNAME = "user11premium@gmail.com";
	const PASSWORD = "useruser11";
	const NAME_FROM = "GallesWeb Store";

	private $mail;

	public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
	{

		$config = array(
						"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/", //a patir do root procure a pasta tal
						"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
						"debug"         => false // set to false to improve the speed
					   );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

		//Create a new PHPMailer instance
		$this->mail = new \PHPMailer;

		//Tell PHPMailer to use SMTP
		$this->mail->isSMTP(); //Metodo que prepara para enviar um email
		$this->mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		//Enable SMTP debugging
		// 0 = off (for production use) - Quando estiver em produção
		// 1 = client messages - Para testes
		// 2 = client and server messages - Para quando estiver desenvolvendo
		$this->mail->SMTPDebug = 0;

		$this->mail->Debugoutput = 'html';

		//Set the hostname of the mail server
		$this->mail->Host = 'smtp.gmail.com'; //smtp-mail.outlook.com
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$this->mail->Port = 587; //No caso do gmail

		//Set the encryption system to use - ssl (deprecated) or tls
		$this->mail->SMTPSecure = 'tls';

		//Whether to use SMTP authentication
		$this->mail->SMTPAuth = true;

		//Username to use for SMTP authentication - use full email address for gmail
		$this->mail->Username = Mailer::USERNAME;

		//Password to use for SMTP authentication
		$this->mail->Password = Mailer::PASSWORD;

		//Set who the message is to be sent from
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM); //Quem esta enviando

		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last'); //Email não responda

		//Set who the message is to be sent to
		$this->mail->addAddress($toAddress, $toName); //Para quem vai enviar, destinatário

		//Set the subject line
		$this->mail->Subject = $subject; //Assunto do email

		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$this->mail->msgHTML($html); //É o conteûdo html do email

		//Replace the plain text body with one created manually
		$this->mail->AltBody = 'This is a plain-text message body'; //Se não funcionar o html esse é o texto 

		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png'); //Caminho de anexos

	}

	public function send()
	{

		return $this->mail->send();

	}

}

 ?>