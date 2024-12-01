<?php

require_once '../models/menuModel.php';

function getMenuData() {
    // Get menu data from the model
    $menuItems = getMenuItems();
    
    // Pass data to view (JSON response for API)
    header('Content-Type: application/json');
    echo json_encode($menuItems);
}
