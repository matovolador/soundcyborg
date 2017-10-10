<?php
include("../_config.php");
session_start();
if ($_SESSION['admin'] == true){
	$currentDate = new DateTime("now");
	$posts = new Posts();
	$array=$posts->getSortedPosts();
	$flag = false;
	$i = sizeof($array)-1;
	while(!$flag){
		if (days_diff($currentDate,new DateTime($array[$i]['day']))>60){
			$posts->deletePost($array[$i]['id']);
			$i-=1;
			if ($i<0) $flag = true;
		}else{
			$flag = true;
		}
		
	}
	echo sizeof($array) - $i - 1;

}


function days_diff($d1, $d2) {
    $x1 = days($d1);
    $x2 = days($d2);
    if ($x1 && $x2) {
        return abs($x1 - $x2);
    }
}

function days($x) {
    if (get_class($x) != 'DateTime') {
        return false;
    }
    
    $y = $x->format('Y') - 1;
    $days = $y * 365;
    $z = (int)($y / 4);
    $days += $z;
    $z = (int)($y / 100);
    $days -= $z;
    $z = (int)($y / 400);
    $days += $z;
    $days += $x->format('z');

    return $days;
}