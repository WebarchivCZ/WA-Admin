<?php

class Rule_Upload_Size_Core extends Rule_Upload_Required{

	public function __construct($size)
	{
		
		$this->set_size($size);		
	}
	public function set_size($size)
	{	
		$this->message_vars['max_size']=(int) $size;
		
		return $this;
	}	
	public function is_valid($upload=null)
	{
		$size=$this->message_vars['max_size'];
		
		$this->message_vars['filename']=$upload['name'];
		
		$this->set_message_vars($upload);
		
		$bytes = $size;

		switch (substr($size, -2))
		{
			case 'GB': $bytes *= 1024;
			case 'MB': $bytes *= 1024;
			case 'KB': $bytes *= 1024;
			default: break;
		}
		
		$this->message_vars['max_bytes']=$bytes;
		
		if (empty($upload['size']) OR $upload['size'] > $bytes)
		{
			return false;
		}
		return true;
	}

}