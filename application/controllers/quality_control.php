<?php
class Quality_Control_Controller extends Template_Controller {

    protected $title = 'Kontrola kvality';

    public function index() {
        $view =	new View('quality_control');

        $curator_id = $this->user->id;
		
      	$resources_to_control = Resource_Model::get_to_checkQA($curator_id);

      	if ($this->user->has(ORM::factory('role', 'qa_reviewer'))) {
      		$qa_checks_unsatisfactory = Qa_Check_Model::get_checks(-1);
      		$view->qa_checks_acceptable = Qa_Check_Model::get_checks(0);
      	} else {
        	$qa_checks_unsatisfactory = Qa_Check_Model::get_checks(-1, $curator_id);
      	}
        $view->resources_to_control = $resources_to_control;
        $view->qa_checks_unsatisfactory = $qa_checks_unsatisfactory;
        $this->template->content = $view;
    }

    public function add($resource_id = NULL) {
        if (is_null($resource_id)) {
            message::set_flash('Není nastaveno id zdroje.');
            url::redirect('quality_control');
        }

        $resource = ORM::factory('resource', $resource_id);
        
        $form = $this->generate_form($resource);

        if ($form->validate()) {
            $is_saved = $this->save($form, $resource_id);
            if ($is_saved) {
                message::set_flash('Kontrola byla úspěšně uložena.');
            } else {
                message::set_flash('Vyskytl se problém a kontrola nebyla uložena.');
            }
            url::redirect('quality_control');
        } else {
            $view = View::factory('forms/quality_control_form');
            $view->form = $form;
            $view->resource = $resource;

            $this->template->content = $view;
        }
    }

    public function view ($qa_check_id) {
    	$qa_check = ORM::factory('qa_check', $qa_check_id);
        $this->template->title = 'Zobrazení záznamu';
        $this->view = 'tables/record_qa_view';

        $record_values = $qa_check->as_array();
        $values = array();
        foreach ($record_values as $key => $value) {
            if ($qa_check->__isset($key)) {
                // TODO elegantnejsi vypisovani cizich klicu
                if ($qa_check->is_related(str_replace('_id', '', $key))) {
                    $key = str_replace('_id', '',$key);
                }
                $values[$key] = $qa_check->{$key};
            }
        }

        $url = url::site("/quality_control/edit/{$qa_check_id}");
        $view = View::factory($this->view);
        $view->record = $qa_check;
        $view->bind('values', $values);
        $view->set('header', "Zobrazení kontroly kvality");
        $view->set('edit_url', $url);
        $view->set('qa_check', $qa_check);
        $this->template->content = $view;
    }
    
    public function edit ($qa_check_id) {
    	$this->template->title = 'Editace záznamu';
    	
    	$qa_check = ORM::factory('qa_check', $qa_check_id);
    	$resource = ORM::factory('resource',  $qa_check->resource_id);
    	
    	$form = $this->generate_form($resource, $qa_check, TRUE);
    	
    	$this->template->content = $form;
    }
    
    public function add_solution($qa_check_id) {
    	
    	$this->template->content = View::factory('mockup/add_solution');
    }
    
    /**
     * nastroje pro QA. Napr: kdy bylo url sklizeno, a zda vubec
     */
	public function qa_tools() {
    	
    }

    private function save($form, $resource_id) {
        $qa_check = ORM::factory('qa_check');

        $qa_check->resource_id = $resource_id;
        $qa_check->date_checked = date('Y-m-d h:i:s');
        $qa_check->date_crawled = $form->date_crawled->value;
        $qa_check->ticket_no = $form->ticket_no->value;

        $problems = ORM::factory('qa_problem')->find_all();

        $qa_check->result = $form->result->value;
        $qa_check->comments = $form->comments->value;
        $qa_check->add_curator(Auth::instance()->get_user());
        $qa_check->proxy_problems = $form->proxy_problems->value;

        $qa_check->save();
        
    	foreach ($problems as $problem) {
            // pokud je FALSE pridame problem
            if ($form->{$problem->problem}->value == 'FALSE') {
                $qa_check_problem = ORM::factory('qa_check_problem');
                $qa_check_problem->qa_check_id = $qa_check->id;
                $qa_check_problem->qa_problem_id = $problem->id;
                $qa_check_problem->url = $form->{$problem->problem."_url"}->value;
                $qa_check_problem->comments = $form->{$problem->problem."_comments"}->value;
                $qa_check_problem->save();
                if ($qa_check_problem->saved == FALSE) {
                	return FALSE;
                }
            }
        }
        
        if ($qa_check->saved == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function generate_form($resource, $qa_check = NULL, $edit = FALSE) {
        $bool_values = array('TRUE'=>'Ano', 'FALSE'=>'Ne');
        $check_result_values = Qa_Check_Model::get_result_array();
        $wayback_url = Kohana::config('wadmin.wayback_url').$resource->url;

        $problems = ORM::factory('qa_problem')->find_all();
        
        $resource_url = html::anchor(url::site('/tables/resources/view/'.$resource->id), $resource->title);

        $form = Formo::factory('qa_form');
        $form->add_html("<p><label>Název:</label>{$resource_url}</p>");
        $form->add_html("<p><label>URL:</label>".html::anchor($resource->url, $resource->url, array('target'=>'_blank'))."</p>");
        $form->add_html("<p><label>Wayback:</label>".html::anchor($wayback_url, 'otevřít wayback', array('target'=>'_blank'))."</p>");
        $form->add('date_crawled')->label('Sklizeno dne');
        $form->add('ticket_no')->label('Číslo ticketu');
        if ( ! $edit) {
            foreach ($problems as $problem) {
                $form->add_group($problem->problem, $bool_values)
                        ->label($problem->question)
                        ->check($problem->problem, 'ano');
                $form->{$problem->problem}->group_open = '<span class="problem">';
    
                $problem_url_input = $problem->problem.'_url';
                $form->add($problem_url_input)
                 	 ->label('URL problému');
                $form->{$problem_url_input}->open = '<p class="hidden" id="'.$problem_url_input.'">';
                 	 
                $problem_comments_input = $problem->problem.'_comments';
                $form->add('textarea', $problem_comments_input)
                	 ->label('Komentář problému');
                $form->{$problem_comments_input}->open = '<p class="hidden" id="'.$problem_comments_input.'">';
            }
    		$form->add_group('proxy_fine', $bool_values)
    			 ->label('V proxy je vše v pořádku')
    			 ->check('ano');
    		$form->add('textarea', 'proxy_problems')
    			 ->label('Problémy v proxy')
    			 ->set('proxy_problems', 'open', '<p class="hidden" id="proxy_comments">');
        }	 
        $form->add_select('result', $check_result_values)
                ->label('Výsledek kontroly');

        $form->add('textarea', 'comments')->label('Komentář');
        $form->add('submit', 'save')->value('Uložit');
        
        if ( ! is_null($qa_check) AND $edit === TRUE) {
        	$form = $this->generate_edit_subform($form, $qa_check);
        }
        
        return $form;
    }
    
    private function generate_edit_subform($form, $qa_check) {
    	$values = $qa_check->as_array();
        	foreach ($values as $column => $value) {
        		$form->{$column}->value = $value;
        	}
        	
			$problems = $qa_check->qa_check_problems; 
			foreach ($problems as $problem) {
				$pr_title = $problem->qa_problem->problem;
				
				$form->{$pr_title}->ne->checked = true;
				$form->{$pr_title.'_url'}->value = $problem->url;
				$form->{$pr_title.'_comments'}->value = $problem->comments;
								
				$form->{$pr_title.'_url'}->open = '<p id="'.$pr_title.'_url'.'">';
				$form->{$pr_title.'_comments'}->open = '<p id="'.$pr_title.'_comments'.'">';
			}
			return $form;
    }
}
?>
