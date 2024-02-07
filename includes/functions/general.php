<?php
function clean_vars($array = array())
{
	$result = array();
	foreach ($array as $key => $value) {
		$result[$key] = str_replace("'", "\'", $value);
	}
	return $result;
}
function clean_vars_erase($array = array())
{
	$result = array();
	foreach ($array as $key => $value) {
		$result[$key] = str_replace("\'", "\u2019", $value);
	}
	return $result;
}
function get_id_noc($code)
{
	$result = '0';
	$noc_query = tep_db_query("select id_noc as result from `noc` where code_noc='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}
function get_id_teer($code)
{
	$result = '0';
	$noc_query = tep_db_query("select id_teer as result from `teer` where name_teer='TEER " . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}
function get_id_teer_name($name)
{
	$result = '0';
	$noc_query = tep_db_query("select id_teer as result from `teer` where name_teer='$name'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}
function get_name_teer($code)
{
	$result = '0';
	$noc_query = tep_db_query("select name_teer as result from `teer` where id_teer='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}
function get_name_teer_code($code)
{
	$result = '0';
	$noc_query = tep_db_query("select name_teer as result from `noc_teer` where code_noc='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	//echo 'ppp='.$result;
//		  if($result==0){
//			  $result='TEER 0';
//		  }
	return $result;
}
function get_types_teer($code)
{
	$noc_query = tep_db_query("select types_teer as result from `teer` where id_teer='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}

function get_exmaples_teer($code)
{
	$noc_query = tep_db_query("select examples_teer as result from `teer` where id_teer='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}

function get_parent_array($code)
{
	$level = get_level_noc($code);
	//echo 'level'.$level; 
	$resultado = array();
	for ($i = 1; $i <= $level; $i++) {
		$code_minor = substr($code, 0, $i);
		$title = get_title_noc($code_minor);
		$definition = get_definition_noc($code_minor);
		if (!empty($title) && !empty($definition)) {
			$resultado[$title] = $definition;
		}

	}
	//	print_r($resultado);
	return $resultado;
}
function mk_html_array($array_html)
{
	$result = '';
	$result .= '<table class="table_noc">';
	foreach ($array_html as $key => $value) {
		$result .= '<tr>';
		$result .= '<th>' . $key . '</th>';
		$result .= '<td>' . $value . '</td>';
		$result .= '</tr>';
	}
	$result .= '</table>';
	return $result;
}
function mk_list_array($array_html)
{
	$result = '<ul class="list_noc">';

	foreach ($array_html as $key => $value) {
		$result .= '<li>' . $value . '</li>';
	}
	$result .= '</ul>';
	return $result;
}
function get_definition_noc($code)
{
	$result = '';
	$noc_query = tep_db_query("select definition_noc as result from `noc` where code_noc='" . $code . "' ");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}

function get_level_noc($code)
{
	$result = '';

	$noc_query = tep_db_query("select level_noc as result from `noc` where code_noc='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}

function get_title_noc($code)
{
	$result = '';

	$noc_query = tep_db_query("select title_noc as result from `noc` where code_noc='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result = $noc['result'];
	}
	return $result;
}

function get_titles_array_class($code)
{
	$result = array();

	$noc_query = tep_db_query("select distinct title_class as result from `class` where code_class='" . $code . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result[] = $noc['result'];
	}
	return $result;
}
function get_definitions_array_class($code, $title)
{
	$result = array();

	$noc_query = tep_db_query("select definition_class as result from `class` where code_class='" . $code . "' and title_class='" . $title . "'");
	while ($noc = tep_db_fetch_array($noc_query)) {
		$result[] = $noc['result'];
	}
	return $result;
}
function add_opertators($q)
{
	$opr1 = '+';
	$opr = '*';
	$result = array();
	$q_array = explode(' ', $q);
	foreach ($q_array as $key => $value) {
		$result[] = $opr1 . $value . $opr;
	}
	return implode(' ', $result);
}
function get_teer_number($teer_name)
{
	$teer_array = explode(' ', $teer_name);
	return implode('', array_slice($teer_array, 1, 1)); //ppppppppaaaaaa
}
function highlight_text($search, $text)
{

	$array_search = explode(" ", $search);
	foreach ($array_search as $key => $value) {
		$text = str_ireplace("$value", "<mark>$value</mark>", $text);
	}
	return $text;
}
function api_teer($q)
{

	$limit = "LIMIT 1";
	$relevancy = array();
	$result = array();

	$query = "SELECT count(MATCH (hierarchy_class) AGAINST ('" . add_opertators($q) . "' IN BOOLEAN MODE )) as Score1, code_class, hierarchy_class from class WHERE MATCH (hierarchy_class, definition_class) AGAINST ('" . add_opertators($q) . "' IN BOOLEAN MODE) AND `title_class` NOT LIKE '%Exclusion%' GROUP BY code_class HAVING (Score1)>0  ORDER BY (Score1) DESC";

	//	echo $query;
	$teer_query = tep_db_query($query);
	while ($teer = tep_db_fetch_array($teer_query)) {
		$relevancy[] = $teer['Score1'];
	}
	$total = mysqli_num_rows($teer_query) - 1;
	if ($total < 0) {
		$total = 0;
	}

	$teer_query = tep_db_query($query . ' ' . $limit);

	//$teer_query = tep_db_query( "select distinct code_class, hierarchy_class from `class` where (`definition_class` LIKE '%$q%' OR `hierarchy_class` LIKE '%$q%') $extra_where order by code_class " );
	while ($teer = tep_db_fetch_array($teer_query)) {

		$code = $teer['code_class'];
		$teer_name = get_name_teer_code($code);
		$hierarchy = $teer['hierarchy_class'];
		$result['TeerNo'] = get_teer_number($teer_name);
		$result['TeerName'] = $teer_name;
		$result['TeerUrl'] = URL_TEER . '?id_teer=' . get_id_teer_name($teer_name);
		$result['NocNo'] = $code;
		$result['NocName'] = $hierarchy;
		$result['NocUrl'] = URL_NOC . '?code_noc=' . $code;
		$result['Revelancy'] = round((($teer['Score1'] / $relevancy[0]) * 100), 2) . '%';
		$result['OthersRelev'] = get_other_values($teer['Score1'], $relevancy);
		$result['NumOthers'] = $total;
		$result['UrlSeach'] = URL_SEARCH . '?c=-&q=' . urldecode($q);
		$result['DateSearch'] = date('d-m-Y h:i:s');
		$result['broad_category'] = substr($code, 0, 1);
		$result['major_group'] = substr($code, 0, 2);
		$result['sub_major_group'] = substr($code, 0, 3);
		$result['minor_group'] = substr($code, 0, 4);
		$result['unit_group'] = $code;


	}
	return $result;

}


function get_other_values($value, $array_values)
{
	//$values = array(1, 2, 3, 2, 4, 1, 5, 4, 6); 

	// Use the array_count_values() function to count the occurrences of each value 
	$counted_values = array_count_values($array_values);

	// Loop through the counted values array and output the duplicates 
	$i = 0;
	$result = 0;
	foreach ($counted_values as $value => $count) {
		if ($i == 0) {
			$result = $count - 1;
			if ($result < 0) {
				$result = 0;
			}
			return $result;
			break;
		}
		$i++;
	}
}

function get_age($birthDate)
{
	$age = 0;

	$birthDate = explode("-", $birthDate);
	//    print_r($birthDate);
	$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
		? ((date("Y") - $birthDate[0]) - 1)
		: (date("Y") - $birthDate[0]));
	return $age;
}

// FUNCTIONS REPORT

//FUNCTIONS
function sum_array($sum_array)
{
	$sum_string = 0;

	foreach ($sum_array as $key => $value) {
		$sum_string += $value;
	}

	return $sum_string;

}
function check_language_ability_greater($test, $than, $sp = false)
{
	$i = 0;
	$result = false;
	$abilityArray = $GLOBALS['abilityArray'];
	$language = $GLOBALS['language'];
	if ($sp == true) {
		$language = $GLOBALS['Language_SP'];
	}
	foreach ($abilityArray as $key => $value) {
		if ($language[$test][$value] >= $than) {
			$i++;
		}
	}
	if ($i == 4) {
		$result = true;
	}
	return $result;
}

function check_language_ability_between($test, $low, $high) // check if all abilities are in >=$low and < $high
{
	$i = 0;
	$result = false;
	$abilityArray = $GLOBALS['abilityArray'];
	$language = $GLOBALS['language'];
	foreach ($abilityArray as $key => $value) {
		if (($language[$test][$value] >= $low) && ($language[$test][$value] < $high)) {
			$i++;
		}
	}
	if ($i == 4) {
		$result = true;
	}
	return $result;
}

function check_language_ability_between_at_least($test, $low, $high, $at_least = '1') // check if all abilities are in >=$low and $at_least abilities < $high
{
	$i = 0;
	$p = 0;
	$result = false;
	$abilityArray = $GLOBALS['abilityArray'];
	$language = $GLOBALS['language'];
	foreach ($abilityArray as $key => $value) {
		if (($language[$test][$value] >= $low)) {
			$i++;
		}
		if (($language[$test][$value] < $high)) {
			$p++;
		}
	}
	if (($i == 4) && ($p > $at_least)) {
		$result = true;
	}
	return $result;
}

function calculate_NCLC7_CLB4($final_languages)
{

	$result = 0;
	$GLOBALS['scores']['NCLC7_CLB4'] = 0;
	$FR = false;
	$EN = true;
	if (isset($final_languages['TEF'])) {
		$FR = check_language_ability_greater('TEF', 7);
	}
	if (isset($final_languages['TCF'])) {
		$FR = check_language_ability_greater('TCF', 7);
	}
	if (isset($final_languages['IELTS'])) {
		if ($final_languages['IELTS'] > 4) {
			$EN = false;
		}
	}
	if (isset($final_languages['CELPIP'])) {
		if ($final_languages['CELPIP'] > 4) {
			$EN = false;

		}
	}
	if ($FR === true && $EN === true) {
		$result = calculate_score('NCLC7_CLB4', 'ExtraLanguage');
		$GLOBALS['scores']['NCLC7_CLB4'] = $result;
	}
	return $result;
}
function calculate_NCLC7_CLB5($final_languages)
{

	$result = 0;
	$GLOBALS['scores']['NCLC7_CLB5'] = 0;
	$FR = false;
	$EN = false;
	if (isset($final_languages['TEF'])) {
		$FR = check_language_ability_greater('TEF', 7);
	}
	if (isset($final_languages['TCF'])) {
		$FR = check_language_ability_greater('TCF', 7);
	}
	if (isset($final_languages['IELTS'])) {
		$EN = check_language_ability_greater('IELTS', 7);

	}
	if (isset($final_languages['CELPIP'])) {
		$EN = check_language_ability_greater('CELPIP', 7);

	}
	if ($FR === true && $EN === true) {
		$result = calculate_score('NCLC7_CLB5', 'ExtraLanguage');
		$GLOBALS['scores']['NCLC7_CLB5'] = $result;
	}
	return $result;
}

function calculate_language_score_SP($language)
{
	$GLOBALS['scores']['Language_SP'] = 0;
	$abilityArray = $GLOBALS['abilityArray'];
	// $language = $GLOBALS['Language_SP'];
	$i = 1;
	$score_temp = array();
	foreach ($language as $key => $value) {
		// echo 'valor'.$i.'='. $value;

		//  $score_temp[$key]=array();

		foreach ($abilityArray as $key2 => $value2) {
			$score_temp[$key][] = calculate_score($language[$key][$value2], 'Language_SP');
			//   $score_temp[$key] =  'language_'.$i;   


		}
		$i++;
		// $GLOBALS['scores']['language_'.$i]
	}
	$a = 1;
	foreach ($score_temp as $key => $value) {
		//  $score_temp2=array();
		foreach ($value as $key2 => $value2) {
			$score_temp2[$key] = sum_array($value);
		}
		if ($a == 1) {
			$GLOBALS['scores']['Language_SP'] = $score_temp2[$key];
		} else if ($a == 2) {
			//   $GLOBALS['scores']['language_2'] = $score_temp2[$key];
		}
		$a++;
	}
	//$score_temp["]=$score_temp["];
	// print_r($score_temp);
	//print_r($score_temp2);
}
function calculate_language_score($final_languages)
{
	$GLOBALS['scores']['language_1'] = 0;
	$GLOBALS['scores']['language_2'] = 0;
	$abilityArray = $GLOBALS['abilityArray'];
	$language = $GLOBALS['language'];
	$i = 1;
	$score_temp = array();
	foreach ($final_languages as $key => $value) {
		// echo 'valor'.$i.'='. $value;

		//  $score_temp[$key]=array();

		foreach ($abilityArray as $key2 => $value2) {
			// echo 'language['.$key.']['.$value2.']-'.$language[$key][$value2].'; ';
			$score_temp[$key][] = calculate_score($language[$key][$value2], 'language_' . $i);
			//   $score_temp[$key] =  'language_'.$i;   
		}
		$i++;
		// $GLOBALS['scores']['language_'.$i]
	}
	$a = 1;
	foreach ($score_temp as $key => $value) {
		//  $score_temp2=array();
		foreach ($value as $key2 => $value2) {
			$score_temp2[$key] = sum_array($value);
		}
		if ($a == 1) {
			$GLOBALS['scores']['language_1'] = $score_temp2[$key];
		} else if ($a == 2) {
			$GLOBALS['scores']['language_2'] = $score_temp2[$key];
		}
		$a++;
	}
	//$score_temp["]=$score_temp["];
//print_r($score_temp2);
//print_r($score_temp2);
}
function calculate_language_score_FSW($final_languages)
{
	$GLOBALS['FSW']['language_1'] = 0;
	$GLOBALS['FSW']['language_2'] = 0;
	$abilityArray = $GLOBALS['abilityArray'];
	$language = $GLOBALS['language'];
	$i = 1;
	$score_temp = array();
	foreach ($final_languages as $key => $value) {
		// echo 'valor'.$i.'='. $value;

		//  $score_temp[$key]=array();

		foreach ($abilityArray as $key2 => $value2) {
			// echo 'language['.$key.']['.$value2.']-'.$language[$key][$value2].'; ';
			$score_temp[$key][] = calculate_score_FSW($language[$key][$value2], 'language_' . $i, 'language');
			//   $score_temp[$key] =  'language_'.$i;   
		}
		$i++;
		// $GLOBALS['scores']['language_'.$i]
	}
	$a = 1;
	foreach ($score_temp as $key => $value) {
		//  $score_temp2=array();
		foreach ($value as $key2 => $value2) {
			$score_temp2[$key] = sum_array($value);
		}
		if ($a == 1) {
			calculate_FSW('language_1', $score_temp2[$key], 'language');
		} else if ($a == 2) {
			calculate_FSW('language_2', $score_temp2[$key], 'language');
		}
		$a++;
	}
	//$score_temp["]=$score_temp["];
//print_r($score_temp2);
//print_r($score_temp2);
}

function get_lang_CLB($type, $ability, $option)
{
	$result = 0;
	$LANG_table = $GLOBALS['LANG_table'];
	if (isset($LANG_table[$type . $ability][$option])) {
		$result = $LANG_table[$type . $ability][$option];
	}
	return $result;
}

function get_best_language($language, $type = 'EN')
{
	$language_arr = $language;
	$new_arr = array();
	$result = "";
	foreach ($language_arr as $key => $value) {
		$new_arr[$key] = $value['avg'];
	}
	if ($type == 'EN') {
		unset($new_arr['TCF']);
		unset($new_arr['TEF']);
		arsort($new_arr);
		$result = array_slice($new_arr, 0, 1);

	}
	if ($type == 'FR') {
		unset($new_arr['IELTS']);
		unset($new_arr['CELPIP']);
		arsort($new_arr);
		$result = array_slice($new_arr, 0, 1);

	}

	return $result;
	//print_r($new_arr);
}

function get_languages($language)
{
	$language_arr = $language;
	$new_arr = array_merge(get_best_language($language, 'EN'), get_best_language($language, 'FR'));
	$result = "";
	arsort($new_arr);
	//print_r($new_arr);
	return $new_arr;
}

function calculate_langage_avg($lang_arr)
{
	$avg = 0;
	$sum = 0;
	$lenght = count($lang_arr);
	foreach ($lang_arr as $key => $value) {
		$sum = $sum + $value;
	}
	if ($lenght > 0) {
		$avg = $sum / $lenght;
	}
	return $avg;
}

function construct_language()
{
	$LangTestType = $GLOBALS['LangTestType'];
	$vars = $GLOBALS['vars'];
	$abilityArray = $GLOBALS['abilityArray'];
	$langArray = explode(',', str_replace(" ", "", $LangTestType));
	$language = array();
	foreach ($langArray as $key => $value) {
		foreach ($abilityArray as $key2 => $value2) {
			$language[$value][$value2] = get_lang_CLB($value, $value2, $vars[$value . $value2]);
		}
		$language[$value]['avg'] = calculate_langage_avg($language[$value]);
	}
	// print_r(get_best_language($language,'al'));
// print_r(get_best_language($language,'EN'));
// print_r( get_best_language($language,'FR'));

	$GLOBALS['language'] = $language;
	$GLOBALS['final_languages'] = get_languages($language);


	return $language;


	//print_r($language);


}

function construct_Language_SP()
{
	$LangTestType = $GLOBALS['LangTestType_SP'];
	$vars = $GLOBALS['vars'];
	$abilityArray = $GLOBALS['abilityArray'];
	$langArray = explode(',', str_replace(" ", "", $LangTestType));
	$language = array();
	foreach ($langArray as $key => $value) {
		foreach ($abilityArray as $key2 => $value2) {
			$language[$value][$value2] = get_lang_CLB($value, $value2, $vars[$value . $value2 . '_SP']);
		}
		$language[$value]['avg'] = calculate_langage_avg($language[$value]);
	}
	// print_r(get_best_language($language,'al'));
// print_r(get_best_language($language,'EN'));
// print_r( get_best_language($language,'FR'));

	$GLOBALS['Language_SP'] = $language;
	//  $GLOBALS['final_languages'] = get_languages($language);

	return $language;

}

function get_m_status($SingleOrMarried)
{
	$result = 'single';
	$Spouse = $GLOBALS['Spouse'];

	if ($SingleOrMarried == 1 && $Spouse == 'yes') {
		$result = 'married';
	}
	return $result;
}

function calculate_RelativeCan()
{


	$RelativeCan = isset($GLOBALS['RelativeCan']) ? strtolower($GLOBALS['RelativeCan']) : "";
	$RelativeCan_SP = isset($GLOBALS['RelativeCan_SP']) ? strtolower($GLOBALS['RelativeCan_SP']) : "";
	$result = 0;
	$GLOBALS['scores']['RelativeCan']=0;

	if (check_relatives($RelativeCan, 'sibling') || check_relatives($RelativeCan_SP, 'sibling')) {
		$GLOBALS['scores']['RelativeCan'] = calculate_score('yes', 'RelativeCan');

	}

	// add calculation FSW_Score['Relative'];
	return $result;
}


function calculate_score($option, $type)
{
	$SingleOrMarried = $GLOBALS['SingleOrMarried'];
	$CRS_table = $GLOBALS['CRS_table'];

	$result = 0;

	if (isset($CRS_table[$type][$option][get_m_status($SingleOrMarried)])) {

		$result = $CRS_table[$type][$option][get_m_status($SingleOrMarried)];
	}
	return $result;
}
function calculate_score_FSW($option, $type, $max = "")
{
	$SingleOrMarried = $GLOBALS['SingleOrMarried'];
	$FWS_table = $GLOBALS['FSW_table'];

	$result = 0;

	if (isset($FWS_table[$type][$option][get_m_status($SingleOrMarried)])) {

		$result = $FWS_table[$type][$option][get_m_status($SingleOrMarried)];
	}

	return $result;
}

function calculate_JobOffer()
{
	$JobOffer = isset($GLOBALS['JobOffer']) ? $GLOBALS['JobOffer'] : "";
	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";

	$TeerName = isset($api_teer['TeerName']) ? $api_teer['TeerName'] : "";
	$major_group = isset($api_teer['major_group']) ? $api_teer['major_group'] : "";
	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";

	$result = 0;
	$GLOBALS['scores']['AE_TEER0_MG00'] = 0;
	$GLOBALS['scores']['AE_TEER123_TEER0'] = 0;
	if (($JobOffer == 'yes')) {

		if (($TeerNo == 0) && ($major_group == '00')) {
			$GLOBALS['scores']['AE_TEER0_MG00'] = calculate_score('AE_TEER0_MG00', 'JobOffer');
		}

		if (($TeerNo == 1) || ($TeerNo == 2) || ($TeerNo == 3)) {
			$GLOBALS['scores']['AE_TEER123_TEER0'] = calculate_score('AE_TEER123_TEER0', 'JobOffer');
		}

		if (($TeerNo == 0) && ($major_group != '00')) {
			$GLOBALS['scores']['AE_TEER123_TEER0'] = calculate_score('AE_TEER123_TEER0', 'JobOffer');
		}

	}
	return $result;

}
function calculate_JobOffer_FSW()
{
	$JobOffer = isset($GLOBALS['JobOffer']) ? $GLOBALS['JobOffer'] : "";
	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";



	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";

	$result = 0;
	$GLOBALS['FSW']['AE_TEER0123'] = 0;


	if (($JobOffer == 'yes')) {


		if (($TeerNo == 0) || ($TeerNo == 1) || ($TeerNo == 2) || ($TeerNo == 3)) {
			$result = calculate_score_FSW('AE_TEER0123', 'JobOffer', 'JobOffer');
			$GLOBALS['FSW']['AE_TEER0123'] = $result;
			$GLOBALS['FSW_temp']['Adaptability']['JobOffer'] = calculate_score_FSW('JobOffer', 'Adaptability', 'Adaptability');
			;
			// echo 'JOBOFFER:'.$JobOffer.' - TEERNO:'.$TeerNo.' - SCORE:'. $result;
		}



	}


	return $result;


}
function calculate_ExperienceCan_FSW($sp = false)
{
	$result = 0;
	if ($sp == false) {
		$ExperienceCan = isset($GLOBALS['ExperienceCan']) ? $GLOBALS['ExperienceCan'] : "";
		$group = isset($GLOBALS['ExperienceCan']) ? $GLOBALS['CRS_table']['ExperienceCan'][$ExperienceCan]['group'] : "0";
		$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";



		$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";


		$GLOBALS['FSW_temp']['Adaptability']['1EXPCAN'] = 0;


		if (($group > 0)) {


			if (($TeerNo == 0) || ($TeerNo == 1) || ($TeerNo == 2) || ($TeerNo == 3)) {
				$result = calculate_score_FSW('1EXPCAN', 'Adaptability', 'Adaptability');
				$GLOBALS['FSW_temp']['Adaptability']['1EXPCAN'] = $result;
				// echo 'JOBOFFER:'.$JobOffer.' - TEERNO:'.$TeerNo.' - SCORE:'. $result;
			}



		}
	} else {
		$ExperienceCan = isset($GLOBALS['ExperienceCan_SP']) ? $GLOBALS['ExperienceCan_SP'] : "";
		$group = isset($GLOBALS['ExperienceCan_SP']) ? $GLOBALS['CRS_table']['ExperienceCan_SP'][$ExperienceCan]['group'] : "0";
		if (($group > 0)) {
			$result = calculate_score_FSW('1EXPCAN_SP', 'Adaptability', 'Adaptability');
			$GLOBALS['FSW_temp']['Adaptability']['1EXPCAN_SP'] = $result;
		}
	}

	return $result;


}
function check_relatives($relativevar, $type = 'all')
{

	$result = false;
	if ($type == 'all') {
		if (str_contains($relativevar, 'sibling')) {
			$result = true;
		} elseif (str_contains($relativevar, 'parent')) {
			$result = true;
		} elseif (str_contains($relativevar, 'grandparent')) {
			$result = true;
		} elseif (str_contains($relativevar, 'child')) {
			$result = true;
		} elseif (str_contains($relativevar, 'grandchild')) {
			$result = true;
		} elseif (str_contains($relativevar, 'aunt')) {
			$result = true;
		} elseif (str_contains($relativevar, 'uncle')) {
			$result = true;
		} elseif (str_contains($relativevar, 'niece')) {
			$result = true;
		} elseif (str_contains($relativevar, 'nephew')) {
			$result = true;
		}

	} else {
		if (str_contains($relativevar, $type)) {
			$result = true;
		}
	}
	return $result;
}

function calculate_nomination()
{
	$result = 0;
	$Nomination = $GLOBALS['Nomination'];
	$ProvincialNom = $GLOBALS['ProvincialNom'];
	if (($Nomination == 'yes') && (!empty($ProvincialNom))) {
		$result = calculate_score('NOM', 'ProvincialNomination');
	}
	return $result;
}
function calculate_Education_ExperienceCan_score()
{
	$result = 0;
	$Education = $GLOBALS['Education'];
	$ExperienceCan = $GLOBALS['ExperienceCan'];
	$CRS_table = $GLOBALS['CRS_table'];
	//echo $CRS_table['Education'][$Education]['group'] . "PSD_" . $CRS_table['ExperienceCan'][$ExperienceCan]['group'] . 'EXPCAN';
	if (isset($CRS_table['Education'][$Education]['group']) && isset($CRS_table['ExperienceCan'][$ExperienceCan]['group'])) {
		$result = calculate_score($CRS_table['Education'][$Education]['group'] . "PSD_" . $CRS_table['ExperienceCan'][$ExperienceCan]['group'] . 'EXPCAN', 'Education_ExperienceCan');
	}
	return $result;
}
function calculate_Experience_ExperienceCan_score()
{
	$result = 0;
	$Experience = $GLOBALS['Experience'];
	$ExperienceCan = $GLOBALS['ExperienceCan'];
	$CRS_table = $GLOBALS['CRS_table'];
	//   echo $CRS_table['Experience'][$Experience]['group'] . "EXP_" . $CRS_table['ExperienceCan'][$ExperienceCan]['group'] . 'EXPCAN';
	if (isset($CRS_table['Experience'][$Experience]['group']) && isset($CRS_table['ExperienceCan'][$ExperienceCan]['group'])) {
		$result = calculate_score($CRS_table['Experience'][$Experience]['group'] . "EXP_" . $CRS_table['ExperienceCan'][$ExperienceCan]['group'] . 'EXPCAN', 'Experience_ExperienceCan');
	}
	//  echo '3EXP_2EXPCAN=' . $result;
	return $result;
}
function calculate_Education_Language_score()
{
	$result = 0;
	$CLB = "";
	$Education = $GLOBALS['Education'];
	$CRS_table = $GLOBALS['CRS_table'];
	$final_languages = $GLOBALS['final_languages'];
	$final_languages = array_slice($final_languages, 0, 1);
	foreach ($final_languages as $language => $avg) {
		if (check_language_ability_between_at_least($language, 7, 9) === true) {
			$CLB = 'CLB7_8';
		}
		if (check_language_ability_greater($language, 9) === true) {
			$CLB = 'CLB9';
		}
	}

	if (isset($CRS_table['Education'][$Education]['group'])) {
		$result = calculate_score($CRS_table['Education'][$Education]['group'] . "PSD_" . $CLB, 'Education_Language');
	}
	return $result;
}
function calculate_Qualification_Language_score()
{
	$result = 0;
	$QualificationCan = $GLOBALS['QualificationCan'];
	$CRS_table = $GLOBALS['CRS_table'];
	$final_languages = $GLOBALS['final_languages'];
	$final_languages = array_slice($final_languages, 0, 1);
	foreach ($final_languages as $language => $avg) {
		if (check_language_ability_between_at_least($language, 5, 7) === true) {
			$CLB = 'CLB5_7';
		}
		if (check_language_ability_greater($language, 7) === true) {
			$CLB = 'CLB7';
		}
	}

	if ($QualificationCan == 'yes') {
		$result = calculate_score("QUA_" . $CLB, 'Qualification_Language');
	}
	return $result;
}
function print_var($field)
{
	$result = "";
	if (isset($GLOBALS[$field])) {
		$result = $GLOBALS[$field];
	}
	return $result;
}
function calculate_Experience_Language_score()
{
	$result = 0;
	$Experience = $GLOBALS['Experience'];
	$CRS_table = $GLOBALS['CRS_table'];
	$final_languages = $GLOBALS['final_languages'];
	$final_languages = array_slice($final_languages, 0, 1);
	$CLB = "";
	foreach ($final_languages as $language => $avg) {
		if (check_language_ability_between_at_least($language, 7, 9) === true) {
			$CLB = 'CLB7_8';
		}
		if (check_language_ability_greater($language, 9) === true) {
			$CLB = 'CLB9';
		}
	}
	//echo 'prueba=';
	if (isset($CRS_table['Experience'][$Experience]['group'])) {
		$result = calculate_score($CRS_table['Experience'][$Experience]['group'] . "EXP_" . $CLB, 'Experience_Language');
	}
	return $result;
}
function calculate_CRS($option, $var, $max)
{
	$result = $var;
	$new_val = 0;
	if (isset($GLOBALS['CRS'][$option])) {
		$new_val = $GLOBALS['CRS'][$option];
	}
	$GLOBALS['CRS'][$option] = $new_val + $var;
	// $max=calculate_score('Max', $option);
	if ($GLOBALS['CRS'][$option] > $max) {
		$GLOBALS['CRS'][$option] = $max;
		$result = $max;
	}
	return $result;
}
function calculate_FSW($option, $var, $max)
{
	$SingleOrMarried = $GLOBALS['SingleOrMarried'];
	$result = $var;
	$new_val = 0;
	$max_val = $GLOBALS['FSW_table'][$option]['Max'][get_m_status($SingleOrMarried)];
	if (isset($GLOBALS['FSW'][$option])) {
		$new_val = $GLOBALS['FSW'][$option];
	}
	$GLOBALS['FSW'][$option] = $new_val + $var;
	// $max=calculate_score('Max', $option);
	if ($GLOBALS['FSW'][$option] > $max_val) {
		$GLOBALS['FSW'][$option] = $max_val;
		$result = $max_val;
	}
	return $result;
}

function calculate_RelativeCan_FSW()
{


	$RelativeCan = isset($GLOBALS['RelativeCan']) ? strtolower($GLOBALS['RelativeCan']) : "";
	$RelativeCan_SP = isset($GLOBALS['RelativeCan_SP']) ? strtolower($GLOBALS['RelativeCan_SP']) : "";
	$result = 0;


	if (check_relatives($RelativeCan) || check_relatives($RelativeCan_SP)) {
		$GLOBALS['FSW_temp']['Adaptability']['RelativeCan'] = calculate_score_FSW('RelativeCan', 'Adaptability', 'Adaptability');
	}


	// add calculation FSW_Score['Relative'];
	return $result;
}
function calculate_language_SP_CLB4($language)
{
	$result = 0;
	foreach ($language as $key => $value) {
		if (check_language_ability_greater($key, 4, true) === true) {
			$result = calculate_score_FSW('CLB4_SP', 'Adaptability', 'Adaptability');
		}
	}
	$GLOBALS['FSW_temp']['Adaptability']['CLB4_SP'] = $result;
	return $result;
}

function calculate_experience_FSW()
{
	$result = 0;
	$Experience = $GLOBALS['Experience'];
	$ExperienceCan = $GLOBALS['ExperienceCan'];
	$score_Experience = calculate_score_FSW($Experience, 'Experience', 'Experience');
	$score_ExperienceCan = calculate_score_FSW($ExperienceCan, 'Experience', 'Experience');

	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";

	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";




	if (($TeerNo == 0) || ($TeerNo == 1) || ($TeerNo == 2) || ($TeerNo == 3)) {
		$GLOBALS['FSW']['Experience'] = max($score_Experience, $score_ExperienceCan);
		// echo 'JOBOFFER:'.$JobOffer.' - TEERNO:'.$TeerNo.' - SCORE:'. $result;
	}

}
function calculate_experience_CEC()
{
	$result = false;

	$ExperienceCan = $GLOBALS['ExperienceCan'];
	$group = $GLOBALS['CRS_table']['Experience'][$ExperienceCan]['group'];
	// $score_ExperienceCan = calculate_score_FSW($ExperienceCan, 'Experience', 'Experience');

	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";

	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";


	if ($group > 0) {

		if (($TeerNo == 0) || ($TeerNo == 1) || ($TeerNo == 2) || ($TeerNo == 3)) {
			$result = true;
			
			// echo 'JOBOFFER:'.$JobOffer.' - TEERNO:'.$TeerNo.' - SCORE:'. $result;
		}
	}

	$GLOBALS['CEC']['Experience'] = $result;
	//var_dump(get_defined_vars());
	return $result;
}
function calculate_experience_FST()
{
	$result = false;

	$ExperienceCan = $GLOBALS['ExperienceCan'];
	$group = $GLOBALS['CRS_table']['Experience'][$ExperienceCan]['group'];
	// $score_ExperienceCan = calculate_score_FSW($ExperienceCan, 'Experience', 'Experience');

	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";

	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";
	$major_group = isset($api_teer['major_group']) ? $api_teer['major_group'] : "";
	$sub_major_group = isset($api_teer['sub_major_group']) ? $api_teer['sub_major_group'] : "";
	$minor_group = isset($api_teer['minor_group']) ? $api_teer['minor_group'] : "";
	$unit_group = isset($api_teer['unit_group']) ? $api_teer['unit_group'] : "";

$MGS_allowed=array(72, 73, 82, 83, 92, 93);
$SMG_excluded=array(932, 726);
$MinorGroup_allowed=array(6320);
$UnitGroup_allowed=array(62200);



	if ($group > 1) {

		if (in_array($major_group,$MGS_allowed)) {
			$result = true;
			
			// echo 'JOBOFFER:'.$JobOffer.' - TEERNO:'.$TeerNo.' - SCORE:'. $result;
		}
		if(in_array($sub_major_group,$SMG_excluded)){
			$result = false;
		}
		if(in_array($minor_group,$MinorGroup_allowed)){
		$result=true;
		}
		if(in_array($unit_group,$UnitGroup_allowed)){
		$result=true;
		}

		
	}
	$GLOBALS['FST']['Experience'] = $result;
	return $result;
}
function calculate_JobOffer_FST(){
	$result=false;
	$JobOffer = isset($GLOBALS['JobOffer'])?$GLOBALS['JobOffer']:"";
	$LMIA = isset($GLOBALS['LMIA'])?$GLOBALS['LMIA']:"";
	$QualificationCan = $GLOBALS['QualificationCan'];
	
	if($JobOffer=='yes'){
		if(($LMIA=="I have a LMIA for this job") || ($LMIA=="This job is LMIA exempt")){
			$result=true;
		}
	}elseif($QualificationCan=='yes') {
		$result=true;
	}
	$GLOBALS['FST']['JobOffer'] = $result;
	//var_dump(get_defined_vars());
	return $result;
}
function calculate_language_CEC()
{
	$result = false;
	$final_languages = $GLOBALS['final_languages'];

	$api_teer = isset($GLOBALS['api_teer']) ? $GLOBALS['api_teer'] : "";

	$TeerNo = isset($api_teer['TeerNo']) ? $api_teer['TeerNo'] : "";
	$max_lang = 0;


	if (($TeerNo == 0) || ($TeerNo == 1)) {
		$max_lang = 7;
	}
	if (($TeerNo == 2) || ($TeerNo == 3)) {
		$max_lang = 5;
	}

	foreach ($final_languages as $language => $avg) {


		if (check_language_ability_greater($language, $max_lang) === true) {
			$result = true;
			
		}
	}
	$GLOBALS['CEC']['Language'] = $result;
	return $result;
}

function calculate_2EDUCAN($sp = false)
{

	$EducationCan = "";
	$varAdaptability = "";
	if ($sp == false) {
		if (isset($GLOBALS['EducationCan'])) {
			$EducationCan = $GLOBALS['EducationCan'];
			$varAdaptability = '2EDUCAN';
		}
	}
	if ($sp == true) {
		if (isset($GLOBALS['EducationCan_SP'])) {
			$EducationCan = $GLOBALS['EducationCan_SP'];
			$varAdaptability = '2EDUCAN_SP';
		}
	}
	$result = 0;
	$result = calculate_score_FSW($EducationCan, 'EducationCan', 'EducationCan');
	if ($varAdaptability != "") {
		$GLOBALS['FSW_temp']['Adaptability'][$varAdaptability] = $result;
	}
	// echo 'prueba=' . $result;
	return $result;
}

function calculate_adaptability()
{
	$adaptability = array();
	if (isset($GLOBALS['FSW_temp']['Adaptability'])) {
		$adaptability = $GLOBALS['FSW_temp']['Adaptability'];
	}
	$sum = 0;
	foreach ($adaptability as $key => $value) {
		$sum += $value;
	}
	calculate_FSW('Adaptability', $sum, 'Adaptability');
	// echo 'total adaptability='.$sum;
	//print_r($adaptability);

}

function calculate_total_FSW()
{
	$total = 0;
	$FSW = (isset($GLOBALS['FSW']) ? $GLOBALS['FSW'] : array());

	$sum = 0;
	$language = 0;
	foreach ($FSW as $key => $value) {
		$sum += $value;
		if (str_contains($key, 'language')) {
			$language += $value;
		}
	}
	$GLOBALS['FSW']['Total'] = $sum;
	$GLOBALS['FSW']['Language'] = $language;

	return $sum;
}
function print_var_FSW($var, $scope = 'full')
{
	if ($scope == 'full') {
		$result = isset($GLOBALS['FSW'][$var]) ? $GLOBALS['FSW'][$var] : "N/A";
	} else {
		$result = isset($GLOBALS['FSW_temp'][$scope][$var]) ? $GLOBALS['FSW_temp'][$scope][$var] : "N/A";
	}
	return $result;
}
function qualify_FSW($total)
{
	$result = "";
	$img = '<i class="fa-solid fa-circle-xmark fa-xl"></i>';
	$msg = "DOESN'T QUALIFY";
	$style = 'red FSW_Q';
	$MAX_FSW_QUALIFICATION = $GLOBALS['MAX_FSW_QUALIFICATION'];

	if ($total > $MAX_FSW_QUALIFICATION) { //check if Database
		$style = "green FSW_Q";
		$img = '<i class="fa-solid fa-circle-check fa-xl green"></i>';
		$msg = 'QUALIFIES';
	}
	$result = '<span class="' . $style . '">' . $img .' '. $msg . '</span>';

	return $result;
}
function calculate_elegibility_CEC(){
	$check=0;
	$result = false;
	$elegibity=$GLOBALS['CEC'];
	//print_r($elegibity);
	$size=count($elegibity);
	foreach ($elegibity as $k => $v) {
		if($v===true){
			$check++;
		}
}

if($check==$size){
	$result = true;
}
return $result;
}
function calculate_elegibility_FST(){
	$check=0;
	$result = false;
	$elegibity=$GLOBALS['FST'];
	//print_r($elegibity);
	$size=count($elegibity);
	foreach ($elegibity as $k => $v) {
		if($v===true){
			$check++;
		}
}
//echo $check.'-'.$size;
if($check==$size){
	$result = true;
}
//var_dump(get_defined_vars());
return $result;
}
function api_teer_formaloo($q)
{

	$limit = "LIMIT 1";
	$result = array();

	$query = "SELECT ocupation, id_teer, name_teer,  full_noc, broad_category, major_group, sub_major_group, minor_group, unit_group, title, hierarchy from teer_formaloo WHERE ocupation LIKE '%".$q."%' ORDER BY ocupation DESC ".$limit;

	$teer_query = tep_db_query($query);

	while ($teer = tep_db_fetch_array($teer_query)) {
	
		$result['TeerNo'] = $teer['id_teer'];
		$result['TeerName'] = $teer['name_teer'];
		$result['TeerUrl'] = URL_TEER . '?id_teer=' . $teer['name_teer'];
		$result['NocNo'] = $teer['full_noc'];
		$result['NocName'] = $teer['hierarchy'];
		$result['NocUrl'] = URL_NOC . '?code_noc=' . $teer['full_noc'];
		$result['Revelancy'] = '100%';
		$result['OthersRelev'] = '';
		$result['NumOthers'] = '1';
		$result['UrlSeach'] = URL_SEARCH . '?c=-&q=' . urldecode($q);
		$result['DateSearch'] = date('d-m-Y h:i:s');
		$result['broad_category'] = $teer['broad_category'];
		$result['major_group'] = $teer['major_group'];
		$result['sub_major_group'] = $teer['sub_major_group'];
		$result['minor_group'] = $teer['minor_group'];
		$result['unit_group'] = $teer['unit_group'];


	}
	return $result;

}
///////////////////////////////////
function get_active($url){
$result='';
//echo basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	if(basename($_SERVER['PHP_SELF'])==$url){
	$result='active';
}
if($url=='map.php'&&basename($_SERVER['PHP_SELF'])=='map-building.php'){
	$result='active';
}

return $result;
}