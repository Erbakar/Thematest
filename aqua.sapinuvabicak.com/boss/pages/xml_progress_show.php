<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML İşleme Durumu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .progress {
            width: 100%;
            height: 20px;
            background-color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-bar {
            height: 100%;
            background-color: #4CAF50;
            width: 0%;
            transition: width 0.3s ease;
        }
        .status {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>XML İşleme Durumu</h2>
        <div class="status" id="status">İşlem başlatılıyor...</div>
        <div class="progress">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        <div id="details"></div>
        <div style="text-align: center; margin-top: 20px;">
            <div class="loading" id="loading"></div>
        </div>
    </div>

    <script>
        // Progress güncelleme fonksiyonu
        function updateProgress(percent, message, details) {
            document.getElementById('progressBar').style.width = percent + '%';
            document.getElementById('status').textContent = message;
            
            if (details) {
                document.getElementById('details').innerHTML = '<p>' + details + '</p>';
            }
            
            if (percent >= 100) {
                document.getElementById('loading').style.display = 'none';
                setTimeout(function() {
                    window.close();
                }, 3000);
            }
        }

        // Simüle edilmiş progress (gerçek uygulamada AJAX ile güncellenir)
        let progress = 0;
        const interval = setInterval(function() {
            progress += Math.random() * 10;
            if (progress > 100) progress = 100;
            
            let message = '';
            let details = '';
            
            if (progress < 30) {
                message = 'XML dosyası indiriliyor...';
                details = 'XML kaynağından veri çekiliyor';
            } else if (progress < 60) {
                message = 'XML verisi işleniyor...';
                details = 'Ürün bilgileri parse ediliyor';
            } else if (progress < 90) {
                message = 'Veritabanına kaydediliyor...';
                details = 'Ürünler veritabanına ekleniyor';
            } else {
                message = 'İşlem tamamlandı!';
                details = 'XML işleme başarıyla tamamlandı';
            }
            
            updateProgress(progress, message, details);
            
            if (progress >= 100) {
                clearInterval(interval);
            }
        }, 1000);
    </script>
</body>
</html>
