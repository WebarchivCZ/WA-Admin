<?php

class Seeds_Controller extends Table_Controller {

    protected $table = 'seeds';
    protected $title = 'Seeds';
    protected $header = 'Semínko';
    protected $columns_ignored = array('id');

    public function add($resource_id = NULL) {
        if (!is_null($resource_id)) {
            $values = array('resource_id' => $resource_id);
            parent::add($values);
        } else {
            parent::add();
        }
    }

    public function generate_list() {
        $view = View::factory('tables/seeds/generate_list');
        $this->template->content = $view;

        $crawl_freq_id = $this->input->post('crawl_freq_id');

        // Archive It seminka
        if ($this->input->post('get_archive_it')) {
            $sql = "SELECT s.url
                        FROM seeds s, contracts c, resources r
                        WHERE r.contract_id = c.id
                        AND r.id = s.resource_id
                        AND r.crawl_freq_id IN (5, 4, 3)
                        AND YEAR( c.date_signed ) = YEAR(CURDATE())
                        AND MONTH( c.date_signed ) = (MONTH(CURDATE())-1)
                        ORDER BY c.date_signed";

            $seedlist = Database::instance()->query($sql);

            $view->seedlist = $seedlist;
            $this->template = $view;
        }
        if ($crawl_freq_id != '') {
            if ($this->input->post('get_seeds')) {
                if ($crawl_freq_id == 'null') {
                    $crawl_limit = "AND r.crawl_freq_id IS NULL";
                } else {
                    $crawl_limit = "AND r.crawl_freq_id IN ({$crawl_freq_id})";
                }
                $sql = "SELECT s.url, r.title
                    FROM seeds s, resources r
                    WHERE r.id = s.resource_id
                    AND r.resource_status_id = 5
                    AND r.contract_id IS NOT NULL
                    {$crawl_limit}
                    AND seed_status_id = 1
                    AND (
                        valid_to > CURDATE( )
                        OR valid_to IS NULL
                    )
                    AND (
                        valid_from < CURDATE( )
                        OR valid_from IS NULL
                    )";

                $seedlist = Database::instance()->query($sql);

                $view->seedlist = $seedlist;
                $this->template = $view;
            } else {
                if ($crawl_freq_id == 'null') {
                    $crawl_freq_id = null;
                }
                $conditions = array('crawl_freq_id' => $crawl_freq_id, 'contract_id IS NOT' => null);
                $resources = ORM::factory('resource')->where($conditions)->find_all();

                $view->resources = $resources;
            }
        }
    }

    protected function redirect($action = '', $url = '') {
        url::redirect('/tables/resources/view/' . $this->record->resource_id);
    }

}

?>