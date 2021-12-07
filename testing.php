<?php
$testing = '[{"word_arabic":"testing","word_english":"english testing","word_meaning":"meaning testing"},{"word_arabic":"Second testing","word_english":"English Second testing","word_meaning":"meaning Second testing"}]';

$testing = json_decode($testing);

$json_array = array();
foreach ($testing as $key => $value) {
	$json_array[$value->word_arabic] = $value;
}
echo "<pre>";
print_r($json_array);
echo "</pre>";
?>