<?php 
require_once(LIB_PATH.DS.'initialize.php');

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

	
}


?>