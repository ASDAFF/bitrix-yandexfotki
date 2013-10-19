<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"PARAMETERS" => array(
		"AUTHOR" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "AUTHOR",
			"TYPE" => "STRING",
			"VALUES" => "",
			"DEFAULT" => ""
		),
		"SIZE" => Array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "SIZE",
			"TYPE" => "DROPDOWN",
			"VALUES" => "",
			"DEFAULT" => ""
		),
		"DISPLAY_ORIGINAL" => array(
			"PARENT" => "VISUAL",
			"NAME" => "DISPLAY_ORIGINAL",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
			"PARENT" => "VISUAL"
		),
		"AJAX_MODE" => array(),
		"CACHE_TIME"  =>  Array("DEFAULT"=>3600),
	),
);
?>
