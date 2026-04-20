<?php

$index = 'welcome.html';

if (file_exists($index)) {
    include $index;
} else {
    echo "El archivo no existe.";
}

?>

