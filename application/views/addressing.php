<div class="top-bar">
	<h1>Oslovení vydavatelů</h1>
</div>
<br />
<div class="select-bar">
	<form action="<?= url::base().url::current() ?>/search/">
		<label> <input type="text" name="search_string" /> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
	</form>
</div>
<div class="table">
<?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
<?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">Název</th>
		<th>URL</th>
		<th>Doplnit údaje</th>
		<th>1. oslovení</th>
		<th>2. oslovení</th>
		<th>3. oslovení</th>
		<th class="last">Stav</th>
	</tr>
	<?php

	foreach($resources as $resource) { 
		$correspondence = ORM::factory('correspondence')->where('resource_id', $resource->id)->find_all(); 
		//$this->debug($correspondence);
		?>
	
		<tr>
		<td class="first"><?=$resource->title ?></td>
		<td><a href="<?=$resource->url ?>"><?=$resource->url ?></a></td>
		<td class="center">
			<?=icon::img('pencil')?>
		</td>
		<td class="center">
		<?php if($correspondence) {} ?>
			<?=icon::img('tick')?>
		</td>
		<td class="center">
			<?=icon::img('email_open')?>
		</td>
		<td class="center">
			<?=icon::img('email')?>
		</td>
		<td class="center">
			V jednání
		</td>
	</tr>	
	<? } ?>
</table>
<p class="center">
<button>Zobrazit všechny neoslovené zdroje</button>
</p>
</div>