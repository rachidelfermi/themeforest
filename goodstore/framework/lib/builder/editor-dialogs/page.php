<?php

 
 $of_options = array();


/* ==== CONTENT ==== */
$of_options[] = array(
    "name" => "Content",
    "type" => "sectionstart");

$of_options[] = array(
    'id' => 'id',
    'type' => 'text',
    'name' => 'Page ID',
    'desc' => 'Enter ID of the page to be displayed in this element.',
    'std' => ''
);

$of_options[] = array(
    "type" => "sectionend");


/* ==== DESIGN ==== */
$of_options[] = array(
    "name" => "Design",
    "type" => "sectionstart");

$of_options[] = array(
    'id' => 'fullwidth',
    'type' => 'toggle',
    'name' => 'Full Width',
    'desc' => 'Decide whether or not to set this element to full width.',
    'std' => '0',
    "builder" => 'true',
    "options" => array("1" => "On", "0" => "Off")
);

$of_options[] = array(
    "name" => "Background",
    "desc" => "Choose a background image.",
    "id" => "image",
    "type" => "simple_media_picker",
    'std' => ''
);

$of_options[] = array(
    'id' => 'class',
    'type' => 'text',
    'name' => 'Custom Class',
    'desc' => 'Insert your custom class for this element.',
    'std' => ''
);

$of_options[] = array(
    "type" => "sectionend");
 




/* ==== BAR ==== */
$of_options[] = array(
    "name" => "Bar",
    "type" => "sectionstart");

 
$of_options[] = array(
    'id' => 'bar_type',
    'type' => 'toggle',
    'name' => 'Bar Type',
    'desc' => 'Select this element&acute;s header type.',
    'std' => 'big',
    "builder" => 'true',
    "options" => array("off"=>"Off", "space" => "Off without space",  "line" => "Line", "box" => "Box", "big" => "Big title")
);

$of_options[] = array(
    "type" => "sectionend");

 
 /* Settings */
 global $jaw_builder_options;
$jaw_builder_options['page'] = $of_options;