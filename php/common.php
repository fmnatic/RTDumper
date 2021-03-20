<?php
date_default_timezone_set("UTC");
include "config.php";

function startswith( $haystack, $needle ) {
     $length = strlen( $needle );
     return substr( $haystack, 0, $length ) === $needle;
}

function endswith($string, $test) {
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}

function endswith_i($string, $test) {
	$string=strtolower($string);
	$test=strtolower($test);
    $strlen = strlen($string);
    $testlen = strlen($test);
    if ($testlen > $strlen) return false;
    return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}


$data_collect=array();

$stat_min=array();
$stat_max=array();
$stat_avg=array();
$stat_stddev_lt=array();
$stat_stddev_gt=array();

// Function to calculate square of value - mean
function sd_square($x, $mean) { return pow($x - $mean,2); }

// Function to calculate standard deviation (uses sd_square)   
function sd($array,$mean) {
   
	// square root of sum of squares devided by N-1
	return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array),$mean) ) ) / (count($array)-1) );
}

//don't reorder - used by aitag and dump
$csv_header=array("#MECH Id","Tons","Engine Rating",//x,1,2
	"Max Walk base (hex)","Max Walk activated (hex)","Max Run base (hex)","Max Run activated (hex)",//3,4,5,6
	"Max Jump base (hex)","Max Jump activated (hex)",//7,8
	"Heat Sinking base","Heat Sinking activated","Auto Activation Heat","Alpha Strike Heat","Jump Heat base","Jump Heat activated",//9,10,11,12,13,14
    "Max Ammo Explosion damage","Max Volatile Ammo Explosion damage",//15,16
    "AMS Single Heat","AMS Multi Heat",//17,18
    "Heat Damage Injury","Heat Efficency",//19,20
    "Charge Attacker Damage","Charge Target Damage","Charge Attacker Instability","Charge Target Instability",//21,22,23,24
	"DFA Attacker Damage","DFA Target Damage","DFA Attacker Instability","DFA Target Instability",//25,26,27,28
	"Kick Damage","Kick Instability",//29,30
	"Physical Weapon Damage","Physical Weapon Instability",//31,32
	"Punch Damage","Punch Instability",//33,34
    "Armor","Leg Armor","Structure","Leg Structure",//35,36,37,38
    "Repair Armor","Repair Leg Armor","Repair Structure","Repair Leg Structure",//39,40,41,42
    "DFA Self Damage Efficency","DFA Damage Efficency",//43,44
	"Equipment",
	"path");

//these are processed to find mean/std dev
$csv_min_stat=1;
$csv_max_stat=44;

//Heat Efficency is just spare heat dissipation after alpha strike expressed as % of dissipation capacity
//DFA Self Damage Efficency is how many a DFAs a mech can perform before both its legs break
//DFA Damage Efficency is DFA damage per mech tonnage
$stats_ignore_zeros=array(
    43,44// "DFA Self Damage Efficency","DFA Damage Efficency", most mechs don't have Jump Jets, so data is highly skewed
);

$ai_tags=array("ai_heat","ai_dfa");

$ai_tags_calc=array(
//ai_heat={R Max Ammo Explosion damage}  {R Max Volatile Ammo Explosion damage}  {R "AMS Single Heat"}  {R "AMS Multi Heat" }  {R Heat Damage Injury}  {R Heat Efficency } {R Auto Activation Heat}
    array(15,16,17,18,19,20,11),
//ai_dfa={R DFA Self Damage Efficency}  {R DFA Damage Efficency}
    array(43,44),
);

$ai_tags_weights=array(
    array(2.5,2.5,1,1,0.5,4,2.5),//ai_heat
    array(1,1),//ai_dfa
);

//false means larger values better -> i.e.  on higher values i want ai_tag high
//true means smaller values better ->on lower values i want ai_tag high 
$ai_tags_reverserating=array(
//ai_heat={R Max Ammo Explosion damage}  {R Max Volatile Ammo Explosion damage}  {R "AMS Single Heat"}  {R "AMS Multi Heat" }  {R Heat Damage Injury}  {R Heat Efficency } {R Auto Activation Heat}
    array(true,true,true,true,true,true,false),//ai_heat
//ai_dfa={R DFA Self Damage Efficency}  {R DFA Damage Efficency}
    array(false,false),//ai_dfa
);

//ignore ratings of 0 , for cases where there are a large number of them throwing the stat off.
$ai_tags_ignore_zeros=array(
    "ai_dfa"//most mechs don't have Jump Jets, so data is highly skewed
);

//The tags are generated from a rating number [0-1] where <=0.2 is low  >=0.8 is high, else normal
//skew allows the ratings to be adjusted up/down. [0-1]+skew , before tagging
$ai_tags_skew=array( 
  0,//ai_heat
 -0.25,//ai_dfa
);


 
?>