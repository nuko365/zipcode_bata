<?php
$dir = __DIR__ . '/data';
$result = array();

// GET Parameter Check
if (!isset($_GET['code'])) {
    http_response_code(400);
    $result = array('error' => 'Get Parameter is Invalid');
} elseif(!preg_match("/^\d{7}$/", $_GET['code'])) {
    http_response_code(400);
    $result = array('error' => 'Postal Code is Invalid');
} else {
    // Address Search
    $code = $_GET['code'];
    $file = $dir . DIRECTORY_SEPARATOR . substr($code, 0, 1) . '.csv';
    if(file_exists($file)) {
        $spl = new SplFileObject($file);
        while (!$spl->eof()) {
            $columns = $spl->fgetcsv();
            if(isset($columns[0]) && $columns[0] === $code){
                $result = array('prefecture' => $columns[1], 'city' => $columns[2], 'address_line' => $columns[3]);
                break;
            }
        }
    }
}

// Response
header('Content-type: application/javascript; charset=utf-8');
echo json_encode($result);
