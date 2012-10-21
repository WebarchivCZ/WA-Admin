<?php
class Tools_Controller extends Template_Controller {

	protected $title = 'Nástroje WebArchivu';

	public function index()
	{
		$view = new View('tools');

		$this->template->content = $view;
	}

	public function metadata_generator($format = 'html')
	{
		$allowed_formats = array('xml', 'html', 'txt');
		if (! in_array($format, $allowed_formats))
		{
			throw new WaAdmin_Exception('Not supported metadata format', "Only {$allowed_formats} are currently allowed");
		}
		$view = new View('tools/metadata_generator');
		$view->resources = Resource_Model::factory('resource')->where(array('resource_status_id' => 5, 'id >' => 7000))->find_all();
		$view->format = $format;

		$file_name = 'media\metadata.'.$format;
		$file = file_put_contents($file_name, "\xEF\xBB\xBF".$view->render());

		if ($file == FALSE)
		{
			throw new WaAdmin_Exception('There has been problem metadata export.',
				'Please return back and try it again or contact system administrator');
		}

		download::force($file_name);
	}

}
