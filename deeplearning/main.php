<?php
include 'waf_lib.php';

$output = shell_exec("python3 /var/www/html/deeplearning/python.py");
print_r($output);

print("This is main");

print("Predicting whether the following query is malicious or benign");
print("https://www.hofstra.edu");


?>

