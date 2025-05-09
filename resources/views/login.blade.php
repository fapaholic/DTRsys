<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Login</title>

    <!-- Link to your custom CSS -->
    <link rel="stylesheet" href="{{ url('CSS/login.css') }}">

    <!-- CSRF Token for secure POST requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-image: url("{{ asset('img/background.jpg') }}");
        background-size: cover;
        background-position: center;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        position: relative;
        background: white;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 700px;
        text-align: center;
    }

    .modal-content h3 {
        margin-bottom: 20px;
    }

    .modal-content .scanbtn {
        margin: 10px;
    }

    #qr-reader {
        margin-top: 20px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 28px;
        font-weight: bold;
        color: #555;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
    }

    .close-btn:hover {
        color: #e74c3c;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

<body>
    <div class="container">
        <div class="left-panel">
            <img src="https://qrtor.net/qrbg.png" alt="Company Logo">
            <button class="scanbtn" onclick="openModeModal()">Scan Now</button>
        </div>

        <div class="right-panel">
            <h2 class="title">LOGIN</h2>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <label for="username">Username</label>
                <input type="email" id="username" name="email" placeholder="Enter your username">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
                <button type="submit" class="signin-btn">Sign In</button>
            </form>
        </div>
    </div>

    <!-- Modal 1 -->
    <div id="modeModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModeModal()">&times;</span>
            <h3>Select Attendance Mode</h3>
            <button class="scanbtn" onclick="chooseMode('in')">Time In</button>
            <button class="scanbtn" onclick="chooseMode('out')">Time Out</button>
        </div>
    </div>

    <!-- Modal 2 -->
    <div id="qrModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeQrModal()">&times;</span>
            <h3 id="scanTitle">Scanning...</h3>
            <div id="qr-reader" style="width: 100%"></div>
        </div>
    </div>

    <script>
        let selectedMode = '';
        let html5QrCode;

        function openModeModal() {
            document.getElementById('modeModal').style.display = 'flex';
        }

        function closeModeModal() {
            document.getElementById('modeModal').style.display = 'none';
        }

        function chooseMode(mode) {
            selectedMode = mode;
            closeModeModal();
            openQrModal();
        }

        function openQrModal() {
            document.getElementById('qrModal').style.display = 'flex';
            document.getElementById('scanTitle').innerText =
                selectedMode === 'in' ? 'Time In - Scan your QR Code' : 'Time Out - Scan your QR Code';
            startScanner();
        }

        function closeQrModal() {
            stopScanner(); // Stops the QR scanner and the camera
            document.getElementById('qrModal').style.display = 'none';
            selectedMode = '';
        }

        function startScanner() {
            html5QrCode = new Html5Qrcode("qr-reader");

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 450
                },
                (qrCodeMessage) => {
                    const scanText = qrCodeMessage.trim();
                    html5QrCode.stop().then(() => {
                        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        fetch('/attendance/record', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrf
                                },
                                body: JSON.stringify({
                                    qr: scanText,
                                    mode: selectedMode
                                })
                            })
                            .then(async res => {
                                const contentType = res.headers.get("content-type");
                                if (contentType && contentType.includes("application/json")) {
                                    const data = await res.json();
                                    alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
                                } else {
                                    const html = await res.text();
                                    console.error("Non-JSON response:\n", html);
                                    alert("❌ Unexpected server response. Check console.");
                                }
                                closeQrModal(); // Hide scanner modal after scan
                                openModeModal(); // Return to mode modal for next scan
                            })
                            .catch(err => {
                                console.error("Fetch error:", err);
                                alert("❌ Could not record attendance.");
                                closeQrModal();
                                openModeModal();
                            });
                    }).catch(console.error);
                },
                (errorMessage) => {
                    console.log("QR Error:", errorMessage);
                }
            ).catch((err) => {
                console.error("Failed to start scanner:", err);
            });
        }

        function stopScanner() {
            if (html5QrCode && html5QrCode._isScanning) {
                // Stop the QR code scanner
                html5QrCode.stop().then(() => {
                    // Clear the QR code scanner
                    html5QrCode.clear();

                    // Manually stop media tracks (cameras)
                    if (html5QrCode._mediaStream) {
                        let tracks = html5QrCode._mediaStream.getTracks();
                        tracks.forEach(track => track.stop());
                    }
                }).catch((error) => {
                    console.error("Error stopping QR scanner:", error);
                });
            }
        }
    </script>

    <script>
    const isAuthorizedDevice = localStorage.getItem('deviceAuth') === 'WORKPLACE-ONLY';

     window.addEventListener('DOMContentLoaded', () => {
         const scanButton = document.querySelector('.left-panel .scanbtn');
         if (scanButton && !isAuthorizedDevice) {
             scanButton.style.display = 'none';
         }
     });
</script>

</body>

</html>
