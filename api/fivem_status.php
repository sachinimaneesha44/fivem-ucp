<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../config/auth.php';

$database = new Database();
$db = $database->getConnection();
$auth = new Auth($db);

if (!$auth->isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// FiveM Server Configuration
$FIVEM_SERVER_IP = '127.0.0.1'; // Change to your server IP
$FIVEM_SERVER_PORT = '30120';   // Change to your server port
$SERVER_API_BASE = "http://{$FIVEM_SERVER_IP}:{$FIVEM_SERVER_PORT}";

// Custom server settings
$NEXT_REBOOT_TIME = '06:00'; // 6:00 AM daily reboot
$SERVER_TIMEZONE = 'America/New_York'; // Change to your timezone

function fetchFiveMData($url, $timeout = 5) {
    $context = stream_context_create([
        'http' => [
            'timeout' => $timeout,
            'method' => 'GET',
            'header' => 'User-Agent: FiveM-UCP/1.0'
        ]
    ]);
    
    $data = @file_get_contents($url, false, $context);
    return $data ? json_decode($data, true) : null;
}

function calculateUptime($seconds) {
    if (!is_numeric($seconds) || $seconds < 0) {
        return '00:00:00';
    }
    
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;
    
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

function getNextRebootTime($reboot_time, $timezone) {
    try {
        $tz = new DateTimeZone($timezone);
        $now = new DateTime('now', $tz);
        $reboot = new DateTime($reboot_time, $tz);
        
        // If reboot time has passed today, set it for tomorrow
        if ($reboot <= $now) {
            $reboot->add(new DateInterval('P1D'));
        }
        
        return $reboot->format('H:i');
    } catch (Exception $e) {
        return $reboot_time;
    }
}

try {
    // Fetch server info and dynamic data
    $info_data = fetchFiveMData("{$SERVER_API_BASE}/info.json");
    $dynamic_data = fetchFiveMData("{$SERVER_API_BASE}/dynamic.json");
    $players_data = fetchFiveMData("{$SERVER_API_BASE}/players.json");
    
    if (!$info_data || !$dynamic_data) {
        throw new Exception('Failed to fetch server data');
    }
    
    // Process server data
    $server_status = [
        'online' => true,
        'server' => [
            'name' => $info_data['vars']['sv_hostname'] ?? 'FiveM Server',
            'logo' => $info_data['icon'] ?? null,
            'game_type' => $info_data['vars']['gametype'] ?? 'Roleplay',
            'map_name' => $info_data['vars']['mapname'] ?? 'Los Santos',
            'tags' => isset($info_data['vars']['tags']) ? explode(',', $info_data['vars']['tags']) : [],
            'version' => $info_data['server'] ?? 'Unknown'
        ],
        'players' => [
            'current' => count($players_data ?? []),
            'max' => (int)($info_data['vars']['sv_maxClients'] ?? 64)
        ],
        'uptime' => [
            'seconds' => $dynamic_data['uptime'] ?? 0,
            'formatted' => calculateUptime($dynamic_data['uptime'] ?? 0)
        ],
        'next_reboot' => getNextRebootTime($NEXT_REBOOT_TIME, $SERVER_TIMEZONE),
        'performance' => [
            'cpu' => rand(25, 75), // You can implement real CPU monitoring
            'memory' => rand(40, 85),
            'ping' => rand(15, 50)
        ],
        'timestamp' => time()
    ];
    
    echo json_encode($server_status);
    
} catch (Exception $e) {
    // Server is offline or unreachable
    echo json_encode([
        'online' => false,
        'error' => $e->getMessage(),
        'server' => [
            'name' => 'FiveM Server',
            'logo' => null,
            'game_type' => 'Unknown',
            'map_name' => 'Unknown',
            'tags' => [],
            'version' => 'Unknown'
        ],
        'players' => [
            'current' => 0,
            'max' => 64
        ],
        'uptime' => [
            'seconds' => 0,
            'formatted' => '00:00:00'
        ],
        'next_reboot' => getNextRebootTime($NEXT_REBOOT_TIME, $SERVER_TIMEZONE),
        'performance' => [
            'cpu' => 0,
            'memory' => 0,
            'ping' => 999
        ],
        'timestamp' => time()
    ]);
}
?>