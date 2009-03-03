<?php defined('SYSPATH') or die('No direct script access.');

/*=====================================================================================

Sample Config file

=====================================================================================*/

$states = array('_blank_'=>'',
			'AK'=>'AK', 'AL'=>'AL', 'AR'=>'AR', 'AZ'=>'AZ', 'CA'=>'CA', 'CO'=>'CO',
			'CT'=>'CT', 'DC'=>'DC', 'DE'=>'DE', 'FL'=>'FL', 'GA'=>'GA', 'HI'=>'HI',
			'IA'=>'IA', 'ID'=>'ID', 'IL'=>'IL', 'IN'=>'IN', 'KS'=>'KS', 'KY'=>'KY',
			'LA'=>'LA', 'MA'=>'MA', 'MD'=>'MD', 'ME'=>'ME', 'MI'=>'MI', 'MN'=>'MN',
			'MO'=>'MO', 'MS'=>'MS', 'MT'=>'MT', 'NC'=>'NC', 'ND'=>'ND', 'NE'=>'NE',
			'NH'=>'NH', 'NJ'=>'NJ', 'NM'=>'NM', 'NV'=>'NV', 'NY'=>'NY', 'OH'=>'OH',
			'OK'=>'OK', 'OR'=>'OR', 'PA'=>'PA', 'RI'=>'RI', 'SC'=>'SC', 'SD'=>'SD',
			'TN'=>'TN', 'TX'=>'TX', 'UT'=>'UT', 'VA'=>'VA', 'VT'=>'VT', 'WA'=>'WA',
			'WI'=>'WI', 'WV'=>'WV', 'WY'=>'WY');

/*=====================================================================================*/

$config['defaults']['submit']	= array('class'=>'submit');
$config['defaults']['textarea']	= array('rows'=>8, 'style'=>'width: 300px');
$config['defaults']['file']		= array('class'=>'file', 'style'=>'border:none');
$config['defaults']['email']	= array('rule'=>array('email'));
$config['defaults']['phone']	= array('rule'=>'phone');
$config['defaults']['fax']		= array('required'=>FALSE, 'rule'=>'phone');
$config['defaults']['zip']		= array('rule'=>'numeric', 'size'=>5, 'maxlength'=>5);
$config['defaults']['submit']	= array('type'=>'submit', 'class'=>'submit');
$config['defaults']['state']	= array('type'=>'select', 'values'=>$states);

$config['label_filters'][] = 'ucwords';

$config['pre_filters']['username'][] = 'trim';
$config['pre_filters']['email'][] = 'strtolower';
$config['pre_filters']['ten'][] = 'trim';

$config['auto_rules']['ten'][] = array('length[10]', 'This is not an element, yo');

$config['globals']['class'] = 'input';

// end formo config