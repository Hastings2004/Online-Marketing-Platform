<?php

header('Content-Type: text/xml');

echo '<response>';
$search = $_GET['search'];
$data = array('hes', 'shad', 'jack', 'elln', 'bester');

if(in_array($search, $data)) {
    echo'hi '.$search;
}
else if($search === ""){
    echo "enter something";
}
else{
    echo "not found";
}
echo '</response>';