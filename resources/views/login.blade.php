<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Login</title>
    <link rel="stylesheet" href="{{ url('CSS/login.css') }}">
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


</style>

<!-- Include the QR code library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<body>
    
    <div class="container">
        <div class="left-panel">
            <img src="https://qrtor.net/qrbg.png" alt="">
            <!-- Button to trigger modal -->
            <button class="scanbtn" onclick="openModal()">Scan Now</button>
        </div>

        <div class="right-panel">
            <h2 class="title">LOGIN</h2>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <label for="username">Username</label>
                <input type="email" id="username" placeholder="Enter your username" name="email">
                
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter your password" name="password">
                
                <button type="submit" class="signin-btn">Sign In</button>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </form>
        </div>
    </div>

    <!-- QR Scanner Modal -->
    <div id="qrModal">
        <div id="qrModalContent">
            <!-- Close Button with just "X" text -->
            <span class="close-btn" onclick="closeModal()">X</span>
            <!-- Left section for QR code result -->
            <div id="qrResult">
                <h3>Scanned QR Code:</h3>
                <div id="result"></div>
            </div>
            <!-- Right section for QR code scanner -->
            <div id="qr-reader"></div>
        </div>
    </div>

    <script>
        // Open the QR Scanner modal
        function openModal() {
            document.getElementById('qrModal').style.display = 'flex';
            startScanner();
        }

        // Close the QR Scanner modal
        function closeModal() {
            document.getElementById('qrModal').style.display = 'none';
            stopScanner();  // Stop the scanner when the modal is closed
        }

        let html5QrCode;

        function startScanner() {
            // Create a new QR code scanner
            html5QrCode = new Html5Qrcode("qr-reader");

            // Start the scanner
            html5QrCode.start(
                { facingMode: "environment" },  // Use rear camera
                {
                    fps: 10,    // Frames per second
                    qrbox: 250  // QR box size (optional)
                },
                // Success callback - when a QR code is scanned
                (qrCodeMessage) => {
                    console.log("QR Code Message:", qrCodeMessage);
                    document.getElementById("result").innerText = "Scanned QR Code: " + qrCodeMessage;
                },
                // Error callback - if any issue occurs
                (errorMessage) => {
                    console.log("QR Error:", errorMessage);
                }
            ).catch((err) => {
                console.error("Failed to start the scanner", err);
            });
        }

        // Stop the scanner when modal is closed
        function stopScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then((result) => {
                    console.log("Scanner stopped:", result);
                }).catch((err) => {
                    console.error("Error stopping scanner:", err);
                });
            }
        }
    </script>

</body>
</html>
