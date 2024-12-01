<?php

function getMenuItems() {
    $jsonData = file_get_contents('./databases/menu.json');
    return json_decode($jsonData, true);
}
