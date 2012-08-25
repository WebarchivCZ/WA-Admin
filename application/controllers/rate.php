<?php
class Rate_Controller extends Template_Controller {

	protected $title = 'Hodnocení zdrojů';

	public function index()
	{
		$view = new View('rate');

		$status_array = array('resources_new'        => RS_NEW,
							  'resources_reevaluate' => RS_RE_EVALUATE);

		foreach ($status_array as $key => $status)
		{
			$view->{$key} = $this->get_rated_resources($status, FALSE);

			$view->{"rated_".$key} = $this->get_rated_resources($status, TRUE);
		}

		$this->template->content = $view;
	}

	public function count_to_rate($resource_status = RS_NEW)
	{
		$resources = Rating_Model::find_resources($resource_status, FALSE);
		if (is_array($resources))
		{
			return count($resources);
		} else
		{
			return 0;
		}
	}

	public function count_rated($resource_status = RS_NEW)
	{
		return count(Rating_Model::find_resources($resource_status, TRUE));
	}

	public function get_rated_resources($resource_status, $only_rated)
	{
		$id_array = Rating_Model::find_resources($this->user->id, $resource_status, $only_rated);
		$resources = ORM::factory('resource')
			->in('id', $id_array)
			->orderby('date', 'ASC')
			->find_all();
		return $resources;
	}
}

?>