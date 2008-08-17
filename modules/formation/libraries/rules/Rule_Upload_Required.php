<?php

class Rule_Upload_Required_Core extends Rule{

	public function is_valid($upload=null)
	{
		$this->message_vars['filename']=$upload['name'];
				
		$this->set_message_vars($upload);
		if (empty($upload) OR $upload['error'] === UPLOAD_ERR_NO_FILE)
		{
			return false;
		}
		return true;
	}	
}