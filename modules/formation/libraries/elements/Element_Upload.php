<?php
class Element_Upload_core extends Element_Input {
	
	protected $attr = array
	(

	);
	// Upload data
	protected $upload;

	// Upload directory and filename
	protected $directory;
	protected $filename;

	protected $filepath;
	
	public function __construct($name, $filename = FALSE,$validation=null)
	{
		parent::__construct($name,null,$validation);

		if ( ! empty($_FILES[$name]))
		{
			if (empty($_FILES[$name]['tmp_name']) OR is_uploaded_file($_FILES[$name]['tmp_name']))
			{
				// Cache the upload data in this object
				$this->upload = $_FILES[$name];
				
				// Hack to allow file-only inputs, where no POST data is present
				$_POST[$name] = $this->upload['name'];

				// Set the filename
				$this->filename = empty($filename) ? FALSE : $filename;
			}
			else
			{
				// Attempt to delete the invalid file
				is_writable($_FILES[$name]['tmp_name']) and unlink($_FILES[$name]['tmp_name']);

				// Invalid file upload, possible hacking attempt
				unset($_FILES[$name]);
			}
		}
	}	
	/**
	 * Sets the upload directory.
	 *
	 * @param   string   upload directory
	 * @return  void
	 */
	public function set_directory($dir = NULL)
	{
		// Use the global upload directory by default
		empty($dir) and $dir = Config::item('upload.upload_directory');

		// Make the path asbolute and normalize it
		$dir = str_replace('\\', '/', realpath($dir)).'/';

		// Make sure the upload director is valid and writable
		if ($dir === '/' OR ! is_dir($dir) OR ! is_writable($dir))
			throw new Kohana_Exception('upload.not_writable', $dir);
		
		$this->directory = $dir;
	}
	/**
	 * Get upload directory
	 *
	 * @return unknown
	 */
	public function get_directory()
	{
		if(empty($this->directory))
		{
			$this->set_directory();
		}
		return $this->directory;
	}
	/**
	 * Validate upload
	 *
	 * @return unknown
	 */
	public function validate()
	{
		// The upload directory must always be set
		empty($this->directory) and $this->set_directory();

		// By default, there is no uploaded file
		$filename = '';

		if ($status = parent::validate() AND $this->upload['error'] === UPLOAD_ERR_OK)
		{
			
			// Set the filename to the original name
			$filename = $this->upload['name'];

			if (Config::item('upload.remove_spaces'))
			{
				// Remove spaces, due to global upload configuration
				$filename = preg_replace('/\s+/', '_', $this->upload['name']);
			}

			if (file_exists($filepath = $this->directory.$filename))
			{
				if ($this->filename !== TRUE OR ! is_writable($filepath))
				{
					// Prefix the file so that the filename is unique
					$filepath = $this->directory.'uploadfile-'.uniqid(time()).'-'.$this->upload['name'];
				}
			}
			
			// Move the uploaded file to the upload directory
			move_uploaded_file($this->upload['tmp_name'], $filepath);
			
			if ( ! empty($_POST[$this->name]))
			{
				// Reset the POST value to the new filename
				$this->value = $_POST[$this->name] = $filepath;
			}			
		}
		

		return $status;
	}
	protected function html_element()
	{
		$data = $this->attr;
		$data['name']=$this->name;
		
		return form::upload($data);
	}	
}
?>