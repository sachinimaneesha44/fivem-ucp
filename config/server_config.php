<?php
class ServerConfig {
    // FiveM Server Configuration
    const FIVEM_SERVER_IP = '127.0.0.1';  // Change to your server IP
    const FIVEM_SERVER_PORT = 30120;      // Change to your server port
    const MAX_PLAYERS = 64;
    
    // Server API endpoints
    const API_INFO_ENDPOINT = '/info.json';
    const API_DYNAMIC_ENDPOINT = '/dynamic.json';
    const API_PLAYERS_ENDPOINT = '/players.json';
    
    // Reboot schedule
    const DAILY_REBOOT_TIME = '06:00';
    const SERVER_TIMEZONE = 'America/New_York';
    
    // Discord Integration
    const DISCORD_WEBHOOK_URL = ''; // Add your Discord webhook URL here
    const DISCORD_BOT_TOKEN = ''; // Optional: For advanced Discord integration
    
    // Server Monitoring
    const ENABLE_REAL_TIME_MONITORING = true;
    const MONITORING_INTERVAL = 30; // seconds
    
    // Map Configuration
    const GTA_MAP_IMAGE_URL = 'https://i.imgur.com/KNIH6Ej.png';
    const ENABLE_LOCATION_TRACKING = true;
    
    // Performance Thresholds
    const CPU_WARNING_THRESHOLD = 80;
    const MEMORY_WARNING_THRESHOLD = 85;
    const DISK_WARNING_THRESHOLD = 90;
    
    public static function getFiveMServerStatus() {
        $api_base = 'http://' . self::FIVEM_SERVER_IP . ':' . self::FIVEM_SERVER_PORT;
        
        try {
            // Fetch server info
            $info_url = $api_base . self::API_INFO_ENDPOINT;
            $dynamic_url = $api_base . self::API_DYNAMIC_ENDPOINT;
            
            $info_data = @file_get_contents($info_url, false, stream_context_create([
                'http' => ['timeout' => 5]
            ]));
            
            $dynamic_data = @file_get_contents($dynamic_url, false, stream_context_create([
                'http' => ['timeout' => 5]
            ]));
            
            if ($info_data && $dynamic_data) {
                $info = json_decode($info_data, true);
                $dynamic = json_decode($dynamic_data, true);
                
                return [
                    'online' => true,
                    'info' => $info,
                    'dynamic' => $dynamic,
                    'api_base' => $api_base
                ];
            }
        } catch (Exception $e) {
            // Server unreachable
        }
        
        // Try basic connection test as fallback
        $connection = @fsockopen(self::FIVEM_SERVER_IP, self::FIVEM_SERVER_PORT, $errno, $errstr, 3);
        $basic_online = (bool)$connection;
        if ($connection) fclose($connection);
        
        return [
            'online' => $basic_online,
            'info' => null,
            'dynamic' => null,
            'api_base' => 'http://' . self::FIVEM_SERVER_IP . ':' . self::FIVEM_SERVER_PORT,
            'error' => $basic_online ? 'API endpoints unavailable' : $errstr
        ];
    }
    
    public static function getServerInfo() {
        // You can implement FiveM server info API call here
        // This would typically call your FiveM server's info endpoint
        return [
            'name' => 'Your FiveM Server',
            'description' => 'QBCore Roleplay Server',
            'version' => 'QBCore Framework',
            'website' => 'https://yourserver.com',
            'discord' => 'https://discord.gg/yourserver'
        ];
    }
    
    public static function getResourceList() {
        // You can implement this to get actual resource list from your server
        return [
            'qb-core', 'qb-multicharacter', 'qb-spawn', 'qb-apartments',
            'qb-garages', 'qb-vehicleshop', 'qb-banking', 'qb-phone',
            'qb-inventory', 'qb-weapons', 'qb-drugs', 'qb-jobs'
        ];
    }
}
?>