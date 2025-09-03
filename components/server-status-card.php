<?php
// Server Status Card Component
// This component displays real-time FiveM server information
?>

<div id="server-status-card" class="relative overflow-hidden rounded-2xl border shadow-xl transition-all duration-300 theme-transition" 
     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
    
    <!-- Loading State -->
    <div id="loading-overlay" class="absolute inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-10 transition-opacity duration-300">
        <div class="text-center">
            <div class="w-8 h-8 border-4 border-fivem-primary border-t-transparent rounded-full animate-spin mx-auto mb-2"></div>
            <p class="text-white text-sm">Loading server status...</p>
        </div>
    </div>
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0 bg-gradient-to-br from-fivem-primary via-transparent to-blue-500"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(243, 156, 18, 0.1) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);"></div>
    </div>
    
    <div class="relative p-6">
        <!-- Header with Status Indicator -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div id="server-logo" class="w-12 h-12 bg-gradient-to-r from-fivem-primary to-yellow-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                    <i class="fas fa-server text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="server-name">
                        FiveM Server
                    </h2>
                    <p class="text-sm theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Server Status Dashboard</p>
                </div>
            </div>
            
            <!-- Status Indicator -->
            <div class="flex items-center" id="status-indicator">
                <div class="w-3 h-3 bg-gray-400 rounded-full mr-2"></div>
                <span class="text-sm font-medium text-gray-400">Checking...</span>
            </div>
        </div>
        
        <!-- Server Info Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <!-- Players -->
            <div class="text-center p-4 rounded-xl theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                    <i class="fas fa-users text-white"></i>
                </div>
                <p class="text-2xl font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="player-count">0/64</p>
                <p class="text-xs theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Players Online</p>
                <div class="mt-2">
                    <div class="w-full h-1.5 rounded-full theme-transition" :class="darkMode ? 'bg-gray-600' : 'bg-gray-300'">
                        <div id="player-bar" class="bg-gradient-to-r from-blue-500 to-blue-600 h-1.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>
            </div>
            
            <!-- Uptime -->
            <div class="text-center p-4 rounded-xl theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <p class="text-lg font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="uptime">00:00:00</p>
                <p class="text-xs theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Uptime</p>
            </div>
            
            <!-- Game Type -->
            <div class="text-center p-4 rounded-xl theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                    <i class="fas fa-gamepad text-white"></i>
                </div>
                <p class="text-sm font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="game-type">Roleplay</p>
                <p class="text-xs theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Game Mode</p>
            </div>
            
            <!-- Next Reboot -->
            <div class="text-center p-4 rounded-xl theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mx-auto mb-2 shadow-md">
                    <i class="fas fa-power-off text-white"></i>
                </div>
                <p class="text-lg font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="next-reboot">06:00</p>
                <p class="text-xs theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Next Reboot</p>
            </div>
        </div>
        
        <!-- Server Details -->
        <div class="space-y-4">
            <!-- Map and Performance -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-lg p-4 theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-map text-fivem-primary mr-2"></i>
                            <span class="text-sm font-medium theme-transition" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Map</span>
                        </div>
                        <span class="text-sm font-bold theme-transition" :class="darkMode ? 'text-white' : 'text-gray-900'" id="map-name">Los Santos</span>
                    </div>
                </div>
                
                <div class="rounded-lg p-4 theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-tachometer-alt text-green-500 mr-2"></i>
                            <span class="text-sm font-medium theme-transition" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Performance</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs theme-transition" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">CPU:</span>
                            <span class="text-sm font-bold text-green-500" id="cpu-usage">0%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tags -->
            <div class="rounded-lg p-4 theme-transition" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                <div class="flex items-center mb-2">
                    <i class="fas fa-tags text-yellow-500 mr-2"></i>
                    <span class="text-sm font-medium theme-transition" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Server Tags</span>
                </div>
                <div id="server-tags" class="flex flex-wrap gap-1">
                    <span class="px-2 py-1 bg-gray-600 text-gray-300 rounded-full text-xs">Loading...</span>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex space-x-2">
                <button onclick="refreshServerStatus()" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-2 px-4 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-md">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
                <button onclick="copyServerInfo()" 
                        class="flex-1 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white py-2 px-4 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-md">
                    <i class="fas fa-copy mr-2"></i>Copy Info
                </button>
            </div>
        </div>
        
        <!-- Last Updated -->
        <div class="mt-4 text-center">
            <p class="text-xs theme-transition" :class="darkMode ? 'text-gray-500' : 'text-gray-500'">
                Last updated: <span id="last-updated">Never</span>
            </p>
        </div>
    </div>
</div>

<script>
class FiveMServerStatus {
    constructor() {
        this.updateInterval = 30000; // 30 seconds
        this.isActive = true;
        this.lastUpdateTime = null;
        this.retryCount = 0;
        this.maxRetries = 3;
        
        this.init();
    }
    
    init() {
        this.fetchServerStatus();
        this.startAutoRefresh();
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopAutoRefresh();
            } else {
                this.startAutoRefresh();
                this.fetchServerStatus(); // Immediate update when page becomes visible
            }
        });
        
        // Handle network status changes
        window.addEventListener('online', () => {
            this.retryCount = 0;
            this.fetchServerStatus();
        });
        
        window.addEventListener('offline', () => {
            this.showOfflineStatus();
        });
    }
    
    async fetchServerStatus() {
        try {
            this.showLoading(true);
            
            const response = await fetch('api/fivem_status.php', {
                method: 'GET',
                headers: {
                    'Cache-Control': 'no-cache'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            this.updateUI(data);
            this.retryCount = 0; // Reset retry count on success
            
        } catch (error) {
            console.error('Failed to fetch server status:', error);
            this.handleError(error);
        } finally {
            this.showLoading(false);
        }
    }
    
    updateUI(data) {
        const isOnline = data.online;
        
        // Update status indicator
        this.updateStatusIndicator(isOnline);
        
        // Update server info
        this.updateServerInfo(data.server);
        
        // Update player count
        this.updatePlayerCount(data.players);
        
        // Update uptime
        this.updateUptime(data.uptime);
        
        // Update next reboot
        this.updateNextReboot(data.next_reboot);
        
        // Update performance
        this.updatePerformance(data.performance);
        
        // Update last updated time
        this.updateLastUpdated();
        
        // Update card appearance based on status
        this.updateCardAppearance(isOnline);
    }
    
    updateStatusIndicator(isOnline) {
        const indicator = document.getElementById('status-indicator');
        if (!indicator) return;
        
        if (isOnline) {
            indicator.innerHTML = `
                <div class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                <span class="text-sm font-medium text-green-500">Online</span>
            `;
        } else {
            indicator.innerHTML = `
                <div class="w-3 h-3 bg-red-400 rounded-full mr-2"></div>
                <span class="text-sm font-medium text-red-500">Offline</span>
            `;
        }
    }
    
    updateServerInfo(server) {
        // Update server name
        const nameEl = document.getElementById('server-name');
        if (nameEl) {
            nameEl.textContent = server.name || 'FiveM Server';
        }
        
        // Update server logo
        const logoEl = document.getElementById('server-logo');
        if (logoEl && server.logo) {
            logoEl.innerHTML = `<img src="data:image/png;base64,${server.logo}" alt="Server Logo" class="w-full h-full object-contain rounded-xl">`;
        }
        
        // Update game type
        const gameTypeEl = document.getElementById('game-type');
        if (gameTypeEl) {
            gameTypeEl.textContent = server.game_type || 'Roleplay';
        }
        
        // Update map name
        const mapNameEl = document.getElementById('map-name');
        if (mapNameEl) {
            mapNameEl.textContent = server.map_name || 'Los Santos';
        }
        
        // Update tags
        this.updateTags(server.tags || []);
    }
    
    updatePlayerCount(players) {
        const countEl = document.getElementById('player-count');
        const barEl = document.getElementById('player-bar');
        
        if (countEl) {
            countEl.textContent = `${players.current}/${players.max}`;
        }
        
        if (barEl) {
            const percentage = players.max > 0 ? (players.current / players.max) * 100 : 0;
            barEl.style.width = `${percentage}%`;
            
            // Change color based on capacity
            if (percentage > 90) {
                barEl.className = 'bg-gradient-to-r from-red-500 to-red-600 h-1.5 rounded-full transition-all duration-500';
            } else if (percentage > 70) {
                barEl.className = 'bg-gradient-to-r from-yellow-500 to-yellow-600 h-1.5 rounded-full transition-all duration-500';
            } else {
                barEl.className = 'bg-gradient-to-r from-blue-500 to-blue-600 h-1.5 rounded-full transition-all duration-500';
            }
        }
    }
    
    updateUptime(uptime) {
        const uptimeEl = document.getElementById('uptime');
        if (uptimeEl) {
            uptimeEl.textContent = uptime.formatted || '00:00:00';
        }
    }
    
    updateNextReboot(rebootTime) {
        const rebootEl = document.getElementById('next-reboot');
        if (rebootEl) {
            rebootEl.textContent = rebootTime || '06:00';
        }
    }
    
    updatePerformance(performance) {
        const cpuEl = document.getElementById('cpu-usage');
        if (cpuEl) {
            cpuEl.textContent = `${performance.cpu}%`;
        }
    }
    
    updateTags(tags) {
        const tagsEl = document.getElementById('server-tags');
        if (!tagsEl) return;
        
        if (tags.length === 0) {
            tagsEl.innerHTML = '<span class="px-2 py-1 bg-gray-600 text-gray-300 rounded-full text-xs">No tags</span>';
            return;
        }
        
        const tagColors = [
            'bg-blue-500', 'bg-green-500', 'bg-purple-500', 
            'bg-pink-500', 'bg-indigo-500', 'bg-teal-500'
        ];
        
        tagsEl.innerHTML = tags.map((tag, index) => {
            const color = tagColors[index % tagColors.length];
            return `<span class="px-2 py-1 ${color} text-white rounded-full text-xs font-medium">${this.escapeHtml(tag.trim())}</span>`;
        }).join('');
    }
    
    updateLastUpdated() {
        const lastUpdatedEl = document.getElementById('last-updated');
        if (lastUpdatedEl) {
            this.lastUpdateTime = new Date();
            lastUpdatedEl.textContent = this.lastUpdateTime.toLocaleTimeString();
        }
    }
    
    updateCardAppearance(isOnline) {
        const card = document.getElementById('server-status-card');
        if (!card) return;
        
        // Remove existing status classes
        card.classList.remove('ring-2', 'ring-green-400', 'ring-red-400', 'ring-opacity-50');
        
        if (isOnline) {
            card.classList.add('ring-2', 'ring-green-400', 'ring-opacity-50');
        } else {
            card.classList.add('ring-2', 'ring-red-400', 'ring-opacity-50');
        }
    }
    
    handleError(error) {
        this.retryCount++;
        
        if (this.retryCount <= this.maxRetries) {
            console.log(`Retrying server status fetch (${this.retryCount}/${this.maxRetries})...`);
            setTimeout(() => this.fetchServerStatus(), 5000); // Retry after 5 seconds
            return;
        }
        
        // Show offline status after max retries
        this.showOfflineStatus();
        
        // Show error notification
        if (window.showNotification) {
            window.showNotification(
                'Server Status Error', 
                'Failed to fetch server status. The server may be offline.', 
                'error'
            );
        }
    }
    
    showOfflineStatus() {
        this.updateUI({
            online: false,
            server: {
                name: 'FiveM Server',
                logo: null,
                game_type: 'Unknown',
                map_name: 'Unknown',
                tags: [],
                version: 'Unknown'
            },
            players: { current: 0, max: 64 },
            uptime: { formatted: '00:00:00' },
            next_reboot: '06:00',
            performance: { cpu: 0, memory: 0, ping: 999 }
        });
    }
    
    showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.style.opacity = show ? '1' : '0';
            overlay.style.pointerEvents = show ? 'auto' : 'none';
        }
    }
    
    startAutoRefresh() {
        if (this.refreshInterval) return;
        
        this.refreshInterval = setInterval(() => {
            if (!document.hidden && this.isActive) {
                this.fetchServerStatus();
            }
        }, this.updateInterval);
    }
    
    stopAutoRefresh() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
            this.refreshInterval = null;
        }
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    destroy() {
        this.isActive = false;
        this.stopAutoRefresh();
    }
}

// Global functions for button actions
function refreshServerStatus() {
    if (window.fivemStatus) {
        window.fivemStatus.retryCount = 0; // Reset retry count
        window.fivemStatus.fetchServerStatus();
        
        if (window.showNotification) {
            window.showNotification('Server Status', 'Refreshing server information...', 'info');
        }
    }
}

function copyServerInfo() {
    const serverName = document.getElementById('server-name')?.textContent || 'FiveM Server';
    const playerCount = document.getElementById('player-count')?.textContent || '0/64';
    const uptime = document.getElementById('uptime')?.textContent || '00:00:00';
    const gameType = document.getElementById('game-type')?.textContent || 'Roleplay';
    
    const serverInfo = `🎮 ${serverName}
👥 Players: ${playerCount}
⏱️ Uptime: ${uptime}
🎯 Mode: ${gameType}
🕐 Updated: ${new Date().toLocaleTimeString()}`;
    
    navigator.clipboard.writeText(serverInfo).then(() => {
        if (window.showNotification) {
            window.showNotification('Server Info', 'Server information copied to clipboard!', 'success');
        }
    }).catch(() => {
        if (window.showNotification) {
            window.showNotification('Copy Failed', 'Failed to copy server information', 'error');
        }
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.fivemStatus = new FiveMServerStatus();
});

// Cleanup on page unload
window.addEventListener('beforeunload', () => {
    if (window.fivemStatus) {
        window.fivemStatus.destroy();
    }
});
</script>

<style>
/* Enhanced animations for server status card */
@keyframes pulse-ring {
    0% {
        transform: scale(0.8);
        opacity: 1;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

.animate-pulse-ring::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: currentColor;
    transform: translate(-50%, -50%);
    animation: pulse-ring 2s infinite;
}

/* Smooth transitions for all elements */
#server-status-card * {
    transition: all 0.3s ease;
}

/* Loading overlay improvements */
#loading-overlay {
    backdrop-filter: blur(4px);
}

/* Enhanced hover effects for action buttons */
#server-status-card button:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Tag animation */
#server-tags span {
    animation: fadeInScale 0.3s ease-out;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Progress bar animations */
#player-bar {
    transition: width 1s ease-out, background 0.5s ease;
}

/* Status indicator glow effect */
.status-online {
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
}

.status-offline {
    box-shadow: 0 0 20px rgba(239, 68, 68, 0.3);
}
</style>