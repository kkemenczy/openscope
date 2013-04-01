<?php
$lines = file('data/glosar.txt');
$first_term="";
$array_others = array();
foreach ($lines as $line_num => $line) {
	$splitted = split("\t",$line);
	$splitted_words = split(" ",$splitted['0']);
	$contains=False;
	
	foreach($splitted_words as $word){
		if (strpos(strtolower($word),strtolower($_GET['term'])) === 0) {

                        $contains=True;
        	}
	}
	if($contains) {
		$array_others[] = $splitted['0'] . " = " . $splitted['1'];
		$contains=False;
	}
}

//Sorting start
natcasesort($array_others);
$array_sorted=array();
foreach($array_others as $v) {
	$array_sorted[]=$v;
}
//Sorting end
$arr = array($_GET['term'],$array_sorted);

echo json_encode($arr);
?>

