<?php

function processData($data) {
    // Validazione dei dati
    if (!is_array($data)) {
        return ['error' => 'Invalid data format'];
    }

    // Inizializza risultati
    $results = [
        'cpu_usage' => null,
        'memory_usage' => null,
        'disk_usage' => null,
        'network_activity' => null,
        'anomalies' => []
    ];

    // Funzioni helper
    function sanitizeAndValidate($value, $type) {
        switch ($type) {
            case 'float':
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'int':
                return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            default:
                return null;
        }
    }

    function detectAnomalies($metric, $value, $thresholds) {
        $anomalies = [];
        if ($value > $thresholds['high']) {
            $anomalies[] = "High $metric detected: $value";
        } elseif ($value < $thresholds['low']) {
            $anomalies[] = "Low $metric detected: $value";
        }
        return $anomalies;
    }

    // Elaborazione CPU Usage
    if (isset($data['cpu_usage'])) {
        $cpuUsage = sanitizeAndValidate($data['cpu_usage'], 'float');
        $results['cpu_usage'] = $cpuUsage;
        
        // Soglie dinamiche (possono essere adattate o apprese da dati storici)
        $cpuThresholds = ['high' => 90, 'low' => 5];
        $results['anomalies'] = array_merge($results['anomalies'], detectAnomalies('CPU usage', $cpuUsage, $cpuThresholds));
    }

    // Elaborazione Memory Usage
    if (isset($data['memory_usage'])) {
        $memoryUsage = sanitizeAndValidate($data['memory_usage'], 'int');
        $results['memory_usage'] = $memoryUsage;
        
        // Soglie dinamiche
        $memoryThresholds = ['high' => 8000, 'low' => 500]; // In MB
        $results['anomalies'] = array_merge($results['anomalies'], detectAnomalies('memory usage', $memoryUsage, $memoryThresholds));
    }

    // Elaborazione Disk Usage
    if (isset($data['disk_usage'])) {
        $diskUsage = sanitizeAndValidate($data['disk_usage'], 'float');
        $results['disk_usage'] = $diskUsage;

        // Soglie dinamiche
        $diskThresholds = ['high' => 90, 'low' => 10]; // Percentuale di utilizzo
        $results['anomalies'] = array_merge($results['anomalies'], detectAnomalies('disk usage', $diskUsage, $diskThresholds));
    }

    // Elaborazione Network Activity
    if (isset($data['network_activity'])) {
        $networkActivity = sanitizeAndValidate($data['network_activity'], 'float');
        $results['network_activity'] = $networkActivity;

        // Soglie dinamiche
        $networkThresholds = ['high' => 1000, 'low' => 0]; // In Mbps
        $results['anomalies'] = array_merge($results['anomalies'], detectAnomalies('network activity', $networkActivity, $networkThresholds));
    }

    // Aggiungere ulteriori elaborazioni e analisi dei dati qui

    return $results;
}

?>

