<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * URL helper class.
 *
 * $Id: url.php 3917 2009-01-21 03:06:22Z zombor $
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class url_Core {

	/**
	 * Fetches the current URI.
	 *
	 * @param   boolean  include the query string
	 * @return  string
	 */
	public static function current($qs = FALSE)
	{
		return ($qs === TRUE) ? Router::$complete_uri : Router::$current_uri;
	}

	/**
	 * Base URL, with or without the index page.
	 *
	 * If protocol (and core.site_protocol) and core.site_domain are both empty,
	 * then
	 *
	 * @param   boolean  include the index page
	 * @param   boolean  non-default protocol
	 * @return  string
	 */
	public static function base($index = FALSE, $protocol = FALSE)
	{
		if ($protocol == FALSE)
		{
			// Use the default configured protocol
			$protocol = Kohana::config('core.site_protocol');
		}

		// Load the site domain
		$site_domain = (string) Kohana::config('core.site_domain', TRUE);

		if ($protocol == FALSE)
		{
			if ($site_domain === '' OR $site_domain[0] === '/')
			{
				// Use the configured site domain
				$base_url = $site_domain;
			}
			else
			{
				// Guess the protocol to provide full http://domain/path URL
				$base_url = ((empty($_SERVER['HTTPS']) OR $_SERVER['HTTPS'] === 'off') ? 'http' : 'https').'://'.$site_domain;
			}
		}
		else
		{
			if ($site_domain === '' OR $site_domain[0] === '/')
			{
				// Guess the server name if the domain starts with slash
				$base_url = $protocol.'://'.$_SERVER['HTTP_HOST'].$site_domain;
			}
			else
			{
				// Use the configured site domain
				$base_url = $protocol.'://'.$site_domain;
			}
		}

		if ($index === TRUE AND $index = Kohana::config('core.index_page'))
		{
			// Append the index page
			$base_url = $base_url.$index;
		}

		// Force a slash on the end of the URL
		return rtrim($base_url, '/').'/';
	}

	/**
	 * Fetches an absolute site URL based on a URI segment.
	 *
	 * @param   string  site URI to convert
	 * @param   string  non-default protocol
	 * @return  string
	 */
	public static function site($uri = '', $protocol = FALSE)
	{
		if ($path = trim(parse_url($uri, PHP_URL_PATH), '/'))
		{
			// Add path suffix
			$path .= Kohana::config('core.url_suffix');
		}

		if ($query = parse_url($uri, PHP_URL_QUERY))
		{
			// ?query=string
			$query = '?'.$query;
		}

		if ($fragment = parse_url($uri, PHP_URL_FRAGMENT))
		{
			// #fragment
			$fragment =  '#'.$fragment;
		}

		// Concat the URL
		return url::base(TRUE, $protocol).$path.$query.$fragment;
	}

	/**
	 * Return the URL to a file. Absolute filenames and relative filenames
	 * are allowed.
	 *
	 * @param   string   filename
	 * @param   boolean  include the index page
	 * @return  string
	 */
	public static function file($file, $index = FALSE)
	{
		if (strpos($file, '://') === FALSE)
		{
			// Add the base URL to the filename
			$file = url::base($index).$file;
		}

		return $file;
	}

	/**
	 * Merges an array of arguments with the current URI and query string to
	 * overload, instead of replace, the current query string.
	 *
	 * @param   array   associative array of arguments
	 * @return  string
	 */
	public static function merge(array $arguments)
	{
		if ($_GET === $arguments)
		{
			$query = Router::$query_string;
		}
		elseif ($query = http_build_query(array_merge($_GET, $arguments)))
		{
			$query = '?'.$query;
		}

		// Return the current URI with the arguments merged into the query string
		return Router::$current_uri.$query;
	}

	/**
	 * Convert a phrase to a URL-safe title.
	 *
	 * @param   string  phrase to convert
	 * @param   string  word separator (- or _)
	 * @return  string
	 */
	public static function title($title, $separator = '-')
	{
		$separator = ($separator === '-') ? '-' : '_';

		// Replace accented characters by their unaccented equivalents
		$title = utf8::transliterate_to_ascii($title);

		// Remove all characters that are not the separator, a-z, 0-9, or whitespace
		$title = preg_replace('/[^'.$separator.'a-z0-9\s]+/', '', strtolower($title));

		// Replace all separator characters and whitespace by a single separator
		$title = preg_replace('/['.$separator.'\s]+/', $separator, $title);

		// Trim separators from the beginning and end
		return trim($title, $separator);
	}

	/**
	 * Sends a page redirect header and runs the system.redirect Event.
	 *
	 * @param  mixed   string site URI or URL to redirect to, or array of strings if method is 300
	 * @param  string  HTTP method of redirect
	 * @return void
	 */
	public static function redirect($uri = '', $method = '302')
	{
		if (Event::has_run('system.send_headers'))
		{
			return FALSE;
		}

		$codes = array
		(
			'refresh' => 'Refresh',
			'300' => 'Multiple Choices',
			'301' => 'Moved Permanently',
			'302' => 'Found',
			'303' => 'See Other',
			'304' => 'Not Modified',
			'305' => 'Use Proxy',
			'307' => 'Temporary Redirect'
		);

		// Validate the method and default to 302
		$method = isset($codes[$method]) ? (string) $method : '302';

		if ($method === '300')
		{
			$uri = (array) $uri;

			$output = '<ul>';
			foreach ($uri as $link)
			{
				$output .= '<li>'.html::anchor($link).'</li>';
			}
			$output .= '</ul>';

			// The first URI will be used for the Location header
			$uri = $uri[0];
		}
		else
		{
			$output = '<p>'.html::anchor($uri).'</p>';
		}

		// Run the redirect event
		Event::run('system.redirect', $uri);

		if (strpos($uri, '://') === FALSE)
		{
			// HTTP headers expect absolute URLs
			$uri = url::site($uri, request::protocol());
		}

		if ($method === 'refresh')
		{
			header('Refresh: 0; url='.$uri);
		}
		else
		{
			header('HTTP/1.1 '.$method.' '.$codes[$method]);
			header('Location: '.$uri);
		}

		exit('<h1>'.$method.' - '.$codes[$method].'</h1>'.$output);
	}
	
/** * get_2nd_level_name( string $url ) * Attempts to establish the 2nd level domain of a given URL * * @return string 2nd-level domain on success, or FALSE on failure */ /** 
     * get_2nd_level_name( string $url ) 
     * Attempts to establish the 2nd level domain of a given URL 
     * 
     * @return string 2nd-level domain on success, or FALSE on failure 
     */
    
    static function get_2nd_level_name($url) {
        
        // a list of decimal-separated TLDs 
        static $doubleTlds = array ('co.uk', 'me.uk', 'net.uk', 'org.uk', 'sch.uk', 'ac.uk', 'gov.uk', 'nhs.uk', 'police.uk', 'mod.uk', 'asn.au', 'com.au', 'net.au', 'id.au', 'org.au', 'edu.au', 'gov.au', 'csiro.au', 'br.com', 'com.cn', 'com.tw', 'cn.com', 'de.com', 'eu.com', 'hu.com', 'idv.tw', 'net.cn', 'no.com', 'org.cn', 'org.tw', 'qc.com', 'ru.com', 'sa.com', 'se.com', 'se.net', 'uk.com', 'uk.net', 'us.com', 'uy.com', 'za.com' );
        
        // sanitize the URL 
        $url = trim ( $url );
        
        // if no hostname, use the current by default 
        if (empty ( $url ) || '/' == $url [0]) {
            $url = $_SERVER ['HTTP_HOST'] . $url;
        }
        
        // if no scheme, use `http://` by default 
        if (FALSE === strpos ( $url, '://' )) {
            $url = 'http://' . $url;
        }
        
        // can we successfully parse the URL? 
        if ($host = parse_url ( $url, PHP_URL_HOST )) {
            
            // is this an IP? 
            if (preg_match ( '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $host )) {
                return $host;
            }
            
            // sanitize the hostname 
            $host = strtolower ( $host );
            
            // explode on the decimals 
            $parts = explode ( '.', $host );
            
            // is there just one part? (`localhost`, etc) 
            if (! isset ( $parts [1] )) {
                return $parts [0];
            }
            
            // grab the TLD 
            $tld = array_pop ( $parts );
            
            // grab the hostname 
            $host = array_pop ( $parts ) . '.' . $tld;
            
            // have we collected a double TLD? 
            if (! empty ( $parts ) && in_array ( $host, $doubleTlds )) {
                $host = array_pop ( $parts ) . '.' . $host;
            }
            
            // send it on it's way 
            return $host;
        
        }
        
        // at this point, nah 
        return FALSE;
    
    }

} // End url