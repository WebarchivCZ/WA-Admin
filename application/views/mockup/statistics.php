<?
$months = date::months();
$years = date::years(2005, date('Y'));
$curators = ORM::factory('curator')->select_list('id', 'firstname');

$prefix = '';
if ($this->input->post('send_all') == true) {
	$prefix = 'all_';
}
$selected_month = $this->input->post($prefix . 'stat_month', date('n'));
$selected_year = $this->input->post($prefix . 'stat_year', date('Y'));
$selected_curator = $this->input->post('stat_curator', $this->user->id);

$res_stats = array ('suggested', 'addressed', 'contracted', 'catalogued', 'rated');
?>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Statistiky kurátora</a></li>
	<li><a href="#tabs-2">Celkové statistiky</a></li>
</ul>
<?=form::open(null, array ('method' => 'post', 'name' => 'stat_curator'));?>
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
		<td>' . Kohana::lang('stats.' . $stat) . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator, $selected_year, $selected_month)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator, $selected_year)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, $selected_curator)->count() . '</td>
</tr>';
}
echo table::footer();
?>
<button type="submit" name="send_curator" value='true'>Aktualizovat</button>
</div>
<?=form::close();?>
<?=form::open('/home#tabs-2', array ('method' => 'post', 'name' => 'stat_all'));?>
<div id="tabs-2">
<?=table::header();?>
<tr>
	<th class='first'>Statistika</th>
	<th>Měsíc <?=form::dropdown('all_stat_month', $months, $selected_month)?></th>
	<th>Rok <?=form::dropdown('all_stat_year', $years, $selected_year)?></th>
	<th class='last'>Celkem</th>
</tr>
<?php
$res_stats = array ('resources', 'rated', 'suggested', 'suggested_issn', 'suggested_visitor', 'suggested_publisher', 'contracted');
foreach($res_stats as $stat) {
    echo '<tr>
		<td>' . Kohana::lang('stats.' . $stat) . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, null, $selected_year, $selected_month)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat, null, $selected_year)->count() . '</td>
		<td>' . Statistic_Model::get_resource_statistic($stat)->count() . '</td>
</tr>';
} ?>

<tr>
		<td>Smlouvy</td>
		<td><?= Statistic_Model::get_contracts($selected_year, $selected_month)->count() ?></td>
		<td><?= Statistic_Model::get_contracts($selected_year)->count() ?></td>
		<td><?= Statistic_Model::get_contracts()->count() ?></td>
</tr>

<?=table::footer();?>
<button type="submit" name="send_all" value='true'>Aktualizovat</button>
</div>
<?=form::close();?>
</div>