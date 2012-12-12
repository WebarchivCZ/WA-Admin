<?php
class app {

	public static function get_value($key)
	{
		$app_info = new App_Info_Model($key);
		return $app_info->get_value();
	}

	/**
	 * Return version of deployed DB. This version number is increased with each migrate.
	 * @static
	 * @return int version number (e.g. 8)
	 */
	public static function get_db_version()
	{
		return (int)self::get_value('database_version');
	}

	/**
	 * Check if application is in debug mode. Application could change it's behvaior according to that.
	 * E.g. profiler could be shown, error messages can have set lower threshold etc.
	 * @static
	 * @return bool TRUE if app is in debug mode
	 */
	public static function in_debug_mode()
	{
		$session = Session::instance();
		$is_debug = $session->get('is_debug', NULL);
		if ($is_debug == NULL)
		{
			$user_role_is_debug = FALSE;
			$user = Auth::instance()->get_user();
			if ($user)
			{
				$user_role_is_debug = $user->has(ORM::factory('role', 'debug'));
			}
			$is_debug = (self::get_value('application_debug_mode') == 'FALSE' OR $user_role_is_debug) ? FALSE : TRUE;
			$session->set('is_debug', $is_debug);
		}
		return $is_debug;
	}

	/**
	 * Return string representation of app version.
	 * @static
	 * @return string application version in format MAJOR.MINOR (e.g. 2.35)
	 */
	public static function get_full_version()
	{
		$major = self::get_value('application_version');
		$minor = self::get_value('application_build');

		return "$major.$minor";
	}
}
