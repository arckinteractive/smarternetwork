<?php
// example parent level form
// would define the different options at this level, but we are terminating here so there is nothing else
$parent = array(

);
$brand = array('Stacy Adams','Rockport','Florsheim','Nunn Bush');
$price = array(90,100,110,120,130,140,150,160);

$guid = $vars['guid'];
$entity = get_entity($guid);
if (elgg_instanceof($entity, 'object','market')) {
  // must always supply $guid $h (current hierarchy) and current $level (in this case parent)
  echo elgg_view('input/hidden', array('name'=>'guid','value'=>$guid));
  echo elgg_view('input/hidden', array('name'=>'h','value'=>$vars['h']));
  echo elgg_view('input/hidden', array('name'=>'level','value'=>'parent'));
  $items = array();

  // fields for this level
  // notice that the field names are wrapped by item (eg. item[size])
  // to make it easier for the edit_more action to process them

  // brand
  $label = elgg_echo('market:edit_more:shoes:running:brand:label');
  $field = elgg_view('input/dropdown',array('name'=>'item[brand]','value'=>$entity->brand,'options' => $brand));
  $items[] = array('label'=>$label,'field' => $field);

  // size
  $label = elgg_echo('market:edit_more:shoes:running:price:label');
  $field = elgg_view('input/dropdown',array('name'=>'item[price]','value'=>$entity->price,'options' => $price));
  $items[] = array('label'=>$label,'field' => $field);

  // now that we have defined the fields, we can spit them out in a loop

  foreach ($items as $item) {
    echo '<p><label>'.$item['label'] . ' ' . $item['field'] . '</label></p>';
  }

  // TODO: we might consider having more than one button here - cancel, save, save and add more
  echo '<div class="elgg-foot">'.elgg_view('input/submit',array('value'=>elgg_echo('submit'))).'</div>';

} else {
  echo elgg_echo('market:edit_more:invalid_guid');
}

