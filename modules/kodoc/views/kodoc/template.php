<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title><?php echo empty($title) ? '' : $title.' &ndash; ' ?> Kohana API Documentation</title>

<?php

echo html::script(array
(
	'kodoc/media/js/jquery-ui',
	'kodoc/media/js/jquery-min',
	//'kodoc/media/js/plugins',
	//'kodoc/media/js/effects'
), TRUE)

?>

<script>
  $(document).ready(function(){
    $("#menu-accordion").accordion({
   header: "a.group-head",
autoHeight: false ,
navigation: true, 
});
  });
  </script>

<style type="text/css">

* { padding:0; margin:0; border:0; }

body { background: #f7fbf1; color: #111; font-size: 82%; font-family: Arial, Verdana, sans-serif; }

h2, h3, h4, h5 { padding: 0.2em 0 0.5em; }
p { padding: 0.5em 0; }
hr { margin: 1em 0; border-bottom: solid 2px #ccc; }

ul { margin-left: 1.5em; }

dt { float: left; clear: left; display: block; width: 12em; font-weight: bold; }
dt tt { display: inline-block; display: -moz-inline-box; width: 5em;}
dd { display: block; padding-left: 1em; }

code { white-space: pre; display: none; }

#container { position: relative; margin: 0 16em 2em 1em; border: solid 0 #e7f5d7; border-width: 0 0.2em 0.3em 0.2em; }
#header{
width:100%;
height:3.5em;
background-color:#63a80d;

}
#header h1{ font-size: 2em;color:Black;}
#menu {   position: absolute;   left: 0.3em;  padding: 0;  width: 16em}
* html body #menu { position: absolute; } /* Add this style for IE6 */
#menu ul { margin: 0 0.2em; list-style: none; color: #b43f11; }
#menu li.first { padding-top: 0.2em; }
#menu li ul { padding: 0.1em 0; margin-right: 0; color: #444; }
#menu li ul a { padding-left: 0.4em; color: #333; }
#menu li ul a:hover { font-weight: bold; color: #2f4f14; }
#menu li ul li:before { content: "«"; }
#menu ul.expanded li { padding-left: 0.6em; }
#menu li span { text-shadow: 1px 1px 1px #333; font-size: 1.3em; cursor: pointer; }
#header h4{
font-size:0.8em;
}
a.group-head,a.group-head:visited{color:#b43f11;}
.methods-overview li a{
color:#b43f11;
}
* html body #menu li span { text-shadow: 0 0 0 transparent; } /* Remove the text shadow in IE6 */

#content {   margin-left: 16em;
  padding: 0;
  margin-right: 1em;}

#stats { clear: both; padding: 1em 0; text-align: center; font-size: 0.8em; }
</style>

</head>
<body>
<div id="container">

<?php echo $menu ?>

<!-- Dynamically generated content -->
<div id="content">
<?php echo $content ?>
</div>
<!-- End of dynamic content -->

<div id="stats"><?php echo Kohana::lang('core.stats_footer') ?></div>

</div>
</body>
</html>