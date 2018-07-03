<?php
$dir = __DIR__ . '/zipcode';

$zipcode = $_GET['zipcode'];
//$array_data = array('zipcode' => $zipcode);
//header('Content-type: application/javascript; charset=utf-8');
//echo json_encode($data);
//exit;

// Ajax以外からのアクセスを遮断
//$request = (string)filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH');
//if(strtolower($request) !== 'xmlhttprequest') exit;
 
//$json = file_get_contents('php://input');

//$data = json_decode($json, true);
//file_put_contents('test.log', print_r($data, true));
//$zipcode = !empty($data) ? $data : '';
//$zipcode = mb_convert_kana($zipcode, 'a', 'utf-8');
//$zipcode = preg_replace('/[\sー-]/', '', $zipcode);
 
//$zipcode  = (string)filter_input(INPUT_GET, 'callback');
//$callback  = htmlspecialchars(strip_tags($callback));
 
$result = array();

// Search
$file = $dir . DIRECTORY_SEPARATOR . substr($zipcode, 0, 1) . '.csv';
if(file_exists($file)) {
    $spl = new SplFileObject($file);
    while (!$spl->eof()) {
        $columns = $spl->fgetcsv();
        if(isset($columns[0]) && $columns[0] == $zipcode){
            // TODO: $result = array($columns[1], $columns[2], $columns[3]);
            $result = array('prefecture' => $columns[1], 'city' => $columns[2], 'address_line' => $columns[3]);
            break;
        }
    }
}

header('Content-type: application/javascript; charset=utf-8');
echo json_encode($result);
