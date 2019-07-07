<?php 

$result1 = $_POST['a1'];
$result2 = $_POST['a2'];
$result3 = $_POST['a3'];

$outcome1 = $_POST['r1'];
$outcome2 = $_POST['r2'];

$total = $result1 + $result2 + $result3; 
if ($total > 1) {
    print $outcome1; 
} else {
    print $outcome2;
}