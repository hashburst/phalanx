<?php

// Esempio di utilizzo
$data = [
    'cpu_usage' => '95.6',
    'memory_usage' => '450',
    'disk_usage' => '92.5',
    'network_activity' => '1050'
];

$result = processData($data);
print_r($result);

?>