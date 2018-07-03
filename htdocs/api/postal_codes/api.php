<?php
$dir = __DIR__ . '/zipcode';
$zipcode = $_GET['zipcode'];

// GET Parameter Check
if (!preg_match("/^\d{7}$/", $zipcode)) {
    header('Content-type: application/javascript; charset=utf-8');
    http_response_code(400);
    array('error' => 'postal_code is Invalid');
    exit;
}

// Address Search
$result = array();
$file = $dir . DIRECTORY_SEPARATOR . substr($zipcode, 0, 1) . '.csv';
if(file_exists($file)) {
    $spl = new SplFileObject($file);
    while (!$spl->eof()) {
        $columns = $spl->fgetcsv();
        if(isset($columns[0]) && $columns[0] == $zipcode){
            $result = array('prefecture' => $columns[1], 'city' => $columns[2], 'address_line' => $columns[3]);
            break;
        }
    }
}

// Response
header('Content-type: application/javascript; charset=utf-8');
echo json_encode($result);
