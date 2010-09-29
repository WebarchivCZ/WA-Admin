<?
$months = date::months();
$years = date::years(2000, date('Y'));
$curators = ORM::factory('curator')->select_list('id', 'firstname');

$selected_month = $this->input->post('stat_month', date('n'));
$selected_year = $this->input->post('stat_year', date('Y'));
$selected_curator = $this->input->post('stat_curator', $this->user->id);

$res_stats = array ('suggested', 'addressed', 'contracted', 'catalogued');
?>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Statistiky kurátora</a></li>
	<li><a href="#tabs-2">Celkové statistiky</a></li>
</ul>
<?=form::open(null, array('method'=>'post')); ?>
<div id="tabs-1">
<?=table::header();?>
<tr>
	<th class='first'>Kurátor: <?=form::dropdown('stat_curator', $curators, $selected_curator)?></th>
	<th>Měsíc <?=form::dropdown('stat_month', $months, $selected_month)?></th>
	<th>Rok <?=form::dropdown('stat_year', $years, $selected_year)?></th>
	<th class='last'>Celkem</th>
</tr>
<?php
foreach($res_stats as $stat) {
    echo '<tr>
		<td>'.Kohana::lang('stats.'.$stat).'</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator, $selected_year, $selected_month)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator, $selected_year)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator)->count() . '</td>
</tr>';
}
echo table::footer();?>
<button type="submit">Aktualizovat</button>
</div>
<?=form::close(); ?>
<div id="tabs-2">
Na tomto se pilně pracuje...
<?=table::header();?>
<tr>
	<th class='first'>&nbsp;</th>
	<th>měsíc</th>
	<th>rok</th>
	<th class='last'>celkem</th>
</tr>
<tr>
	<td>zdroje</td>
	<td>15</td>
	<td>140</td>
	<td>640</td>
</tr>
<tr>
	<td>smlouvy</td>
	<td>15</td>
	<td>140</td>
	<td>640</td>
</tr>
<tr>
	<td>vydavatele</td>
	<td>15</td>
	<td>140</td>
	<td>640</td>
</tr>
<?=table::footer();?>
</div>
</div>