// XML İşlem Durumu Bildirim Sistemi
class XMLNotificationChecker {
    constructor() {
        this.checkInterval = null;
        this.notificationElement = null;
        this.isChecking = false;
        this.init();
    }

    init() {
        // Sayfa yüklendiğinde kontrol et
        this.checkStatus();
        
        // Her 30 saniyede bir kontrol et
        this.checkInterval = setInterval(() => {
            this.checkStatus();
        }, 30000);
        
        // Sayfa kapatılırken interval'ı temizle
        window.addEventListener('beforeunload', () => {
            if (this.checkInterval) {
                clearInterval(this.checkInterval);
            }
        });
    }

    checkStatus() {
        if (this.isChecking) return;
        
        this.isChecking = true;
        
        fetch('/boss/xml_process_backend.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'check_status=1'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.is_processing) {
                this.showNotification(data.data);
            } else {
                this.hideNotification();
            }
        })
        .catch(error => {
            console.error('XML status kontrolü hatası:', error);
        })
        .finally(() => {
            this.isChecking = false;
        });
    }

    showNotification(data) {
        if (!this.notificationElement) {
            this.createNotificationElement();
        }

        const progressParts = data.progress.split('|');
        const progressValue = progressParts[0];
        const progressMessage = progressParts[1] || 'İşleniyor...';
        
        let statusText = '';
        let timeEstimate = '';
        
        if (progressValue === 'done') {
            statusText = '✅ XML yükleme tamamlandı!';
            timeEstimate = '';
            // 5 saniye sonra bildirimi gizle
            setTimeout(() => {
                this.hideNotification();
            }, 5000);
        } else if (progressValue === 'error') {
            statusText = '❌ XML yükleme hatası!';
            timeEstimate = 'Lütfen kontrol edin.';
        } else if (progressValue > 0) {
            const percent = Math.min((progressValue / 10000) * 100, 100);
            statusText = `🔄 XML yükleniyor... (${percent.toFixed(1)}%)`;
            
            // Tahmini kalan süre hesaplama (basit)
            if (percent > 5) {
                const estimatedMinutes = Math.ceil((15 * (100 - percent)) / 100);
                timeEstimate = `Tahminen ${estimatedMinutes} dakika kaldı`;
            } else {
                timeEstimate = 'Tahminen 10-15 dakika sürecek';
            }
        } else {
            statusText = '🔄 XML yükleme başlatılıyor...';
            timeEstimate = 'Tahminen 10-15 dakika sürecek';
        }

        this.notificationElement.querySelector('.xml-notification-text').textContent = statusText;
        this.notificationElement.querySelector('.xml-notification-time').textContent = timeEstimate;
        this.notificationElement.style.display = 'block';
        
        // Animasyon için kısa gecikme
        setTimeout(() => {
            this.notificationElement.classList.add('show');
        }, 100);
    }

    hideNotification() {
        if (this.notificationElement) {
            this.notificationElement.classList.remove('show');
            setTimeout(() => {
                this.notificationElement.style.display = 'none';
            }, 300);
        }
    }

    createNotificationElement() {
        // Notification element'ini oluştur
        this.notificationElement = document.createElement('div');
        this.notificationElement.className = 'xml-notification';
        this.notificationElement.innerHTML = `
            <div class="xml-notification-content">
                <div class="xml-notification-text">XML işlemi kontrol ediliyor...</div>
                <div class="xml-notification-time"></div>
                <button class="xml-notification-btn" onclick="xmlNotificationChecker.showProgress()">
                    Detayları Gör
                </button>
                <button class="xml-notification-close" onclick="xmlNotificationChecker.hideNotification()">
                    ×
                </button>
            </div>
        `;

        // CSS stillerini ekle
        if (!document.querySelector('#xml-notification-styles')) {
            const style = document.createElement('style');
            style.id = 'xml-notification-styles';
            style.textContent = `
                .xml-notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: #fff;
                    border-left: 4px solid #007bff;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    padding: 15px 20px;
                    max-width: 350px;
                    z-index: 9999;
                    transform: translateX(100%);
                    opacity: 0;
                    transition: all 0.3s ease;
                    display: none;
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                }
                
                .xml-notification.show {
                    transform: translateX(0);
                    opacity: 1;
                }
                
                .xml-notification-content {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }
                
                .xml-notification-text {
                    font-weight: 600;
                    color: #333;
                    font-size: 14px;
                }
                
                .xml-notification-time {
                    color: #666;
                    font-size: 12px;
                }
                
                .xml-notification-btn {
                    background: #007bff;
                    color: white;
                    border: none;
                    padding: 6px 12px;
                    border-radius: 4px;
                    font-size: 12px;
                    cursor: pointer;
                    align-self: flex-start;
                    transition: background 0.2s ease;
                }
                
                .xml-notification-btn:hover {
                    background: #0056b3;
                }
                
                .xml-notification-close {
                    position: absolute;
                    top: 8px;
                    right: 8px;
                    background: none;
                    border: none;
                    font-size: 18px;
                    color: #999;
                    cursor: pointer;
                    width: 24px;
                    height: 24px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    transition: all 0.2s ease;
                }
                
                .xml-notification-close:hover {
                    background: #f5f5f5;
                    color: #333;
                }
                
                @media (max-width: 768px) {
                    .xml-notification {
                        right: 10px;
                        left: 10px;
                        max-width: none;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Body'ye ekle
        document.body.appendChild(this.notificationElement);
    }

    showProgress() {
        // Progress window'unu aç
        window.open('pages/xml_progress_show.php', '_blank', 'width=500,height=400,scrollbars=no,resizable=no');
    }

    destroy() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
        }
        if (this.notificationElement) {
            this.notificationElement.remove();
        }
    }
}

// Global instance oluştur
let xmlNotificationChecker;

// DOM hazır olduğunda başlat
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        xmlNotificationChecker = new XMLNotificationChecker();
    });
} else {
    xmlNotificationChecker = new XMLNotificationChecker();
}
