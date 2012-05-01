<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Screenshot model asociated to resource. Could be thumbnail or full screenshots.<br />
 * There are these config directives in wadmin config file (with example values):<br />
 * <i>$config['url_path_screenshots'] = "/media/screenshots/";</i><br />
 * <i>$config['screenshots_dir'] = "D:\\xampplite\\htdocs\\wadmin\\media\\screenshots\\";</i><br />
 * <i>$config['full_screenshot_prefix'] = 'big_';</i><br />
 * <i>$config['thumbnail_screenshot_prefix'] = 'small_';</i>
 */
class Screenshot_Model extends Model
{
    private $datetime = null;
    private $resource_id = null;

    public static function get_screen_for_resource($resource_id, $datetime = null)
    {
        $instance = new Screenshot_Model();
        $instance->resource_id = $resource_id;

        if ($datetime == null) {
            $resource = new Resource_Model($resource_id);
            if ($resource->screenshot_date != '') {
                $instance->datetime = $resource->screenshot_date;
            } else {
                $instance->datetime = end(self::list_screenshot_dates($resource_id));
            }
        }

        return $instance;
    }

    /**
     * List all screenshots dates of one resource e.g.<br/>
     * <i>20111220</i><br/>
     * <i>20111221</i>
     * @static
     * @param $resource_id
     * @return array of dates
     */
    public static function list_screenshot_dates($resource_id)
    {
        $files = glob("media/screenshots/big_{$resource_id}_*.png");
        $screen_dates = array();
        foreach ($files as $file_path) {
            $screenshot_date = array();
            preg_match("/\\w+_\\d+_(\\d+)\\.png/", $file_path, $screenshot_date);
            $screen_dates[] = $screenshot_date[1];
        }
        return $screen_dates;
    }

    public static function list_resource_screenshots($resource_id)
    {
        $date_list = self::list_screenshot_dates($resource_id);
        $screenshot_array = array();
        foreach ($date_list as $date) {
            $screenshot = new Screenshot_Model();
            $screenshot->resource_id = $resource_id;
            $screenshot->datetime = $date;
            $screenshot_array[] = $screenshot;
        }
        return $screenshot_array;
    }

    public static function get_screens_root()
    {
        return Kohana::config('wadmin.url_path_screenshots');
    }

    public static function get_screens_dir()
    {
        return Kohana::config('wadmin.screenshots_dir');
    }

    public function get_filename($thumbnail = false)
    {
        if ($thumbnail) {
            $prefix = Kohana::config('wadmin.thumbnail_screenshot_prefix');
        } else {
            $prefix = Kohana::config('wadmin.full_screenshot_prefix');
        }
        $filename = $prefix . $this->resource_id . "_" . $this->datetime . ".png";
        return $filename;
    }

    private function get_screenshot_location($thumbnail = false)
    {
        $full_path = url::site(self::get_screens_root() . $this->get_filename($thumbnail));
        return $full_path;
    }

    public function get_thumbnail()
    {
        return $this->get_screenshot_location(true);
    }

    public function get_screenshot()
    {
        return $this->get_screenshot_location(false);
    }

    public function exists()
    {
        $is_screenshot_existing = file_exists(Kohana::config('wadmin.screenshots_dir') . $this->get_filename());
        if (!$is_screenshot_existing) {
            Kohana::log('alert', "Screenshot {$this->get_filename()} doesn't exit");
        }
        return $is_screenshot_existing;
    }

    public function set_datetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function get_datetime()
    {
        return $this->datetime;
    }

    public function set_resource_id($resource_id)
    {
        $this->resource_id = $resource_id;
    }

    public function get_resource_id()
    {
        return $this->resource_id;
    }
}