<?php 
require_once(LIB_PATH.DS.'initialize.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Comment extends DatabaseObject {
	protected static $table_name="comments";
	protected static $db_fields = array('photograph_id','created','author','body');
	public $id;
	public $photograph_id;
	public $created;
	public $author;
	public $body;


	public static function build($photograph_id, $author="Anonymous", $body){

		if(!empty($photograph_id) && !empty($body)){
			$comment = new Comment();
			$comment->photograph_id = $photograph_id;
			$comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
			$comment->author = $author;
			$comment->body = $body;
			return $comment;
		}else{
			return false;
		}
	}

	public function send_email(){

		$to_name = "Stefano Rusmigo";
		$to = "stefo29@msn.com";
		$subject = "Mail test at ".strftime("%T",time());
		$from_name = "Photo Gallery";
		$from = "stefanorusmigo@hotmail.com";
		$created = datetime_to_text($this->created);
		$message = <<<EMAILBODY

A new comment has been received in the Photo Gallery.

{$created}, {$this->author} wrote:

{$this->body}


EMAILBODY;

		$mail = new PHPMailer(true);
		try{
		$mail->IsSMTP();
		$mail->host = "smtp-mail.outlook.com";
		$mail->port = "587";
		$mail->SMTPAuth = false;
		$mail->username = "stefanorusmigo@hotmail.com";
		$mail->password = "play129081990";


		$mail->setFrom($from, $from_name);
		$mail->addAddress($to,$to_name);
		$mail->Subject = $subject;
		$mail->Body = $message;


		$result = $mail->Send();
		} catch (Exception $e) {
		    echo 'Message could not be sent.';
		    echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}
	
}


?>