<?php
session_start();
require 'connect-pdo.php'; // โหลดไฟล์เชื่อมต่อฐานข้อมูล


// ตรวจสอบว่ามีข้อมูล QR Code หรือไม่
if (!isset($_SESSION['qrcode_image']) || !isset($_SESSION['expiry_date'])) {
    die("ไม่มีข้อมูล QR Code กรุณากลับไปสร้างใหม่");
}

$qrcodeImage = $_SESSION['qrcode_image'];
$expiryDate = $_SESSION['expiry_date'];
$applicationId = $_SESSION['ApplicantID'];


// แปลงเวลาให้เป็น timestamp สำหรับ JavaScript
$expiryTimestamp = strtotime($expiryDate);

echo date('Y-m-d H:i:s') . "<br>";
echo $_SESSION['paymentData'];

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code ชำระเงิน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        img {
            width: 100%;
            max-width: 300px;
        }

        .expiry {
            font-size: 18px;
            color: red;
            margin-top: 10px;
        }

        .timer {
            font-size: 20px;
            font-weight: bold;
            color: red;
        }

        .new-payment {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
        }

        .new-payment:hover {
            background-color: #0056b3;
        }
    </style>


    <script>
        // ตั้งค่าเวลาหมดอายุจาก PHP
        let expiryTimestamp = <?php echo $expiryTimestamp * 1000; ?>; // แปลงเป็น milliseconds

        function updateCountdown() {
            let now = new Date().getTime();
            let timeLeft = expiryTimestamp - now;

            if (timeLeft <= 0) {
                document.getElementById("countdown").innerHTML = "QR Code หมดอายุแล้ว!";
                document.getElementById("countdown").style.color = "gray";
                return;
            }

            let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById("countdown").innerHTML =
                (days > 0 ? days + " วัน " : "") +
                (hours > 0 ? hours + " ชั่วโมง " : "") +
                minutes + " นาที " + seconds + " วินาที";
        }

        setInterval(updateCountdown, 1000);
        window.onload = updateCountdown;
    </script>


</head>

<body>

    <div class="container">
        <h2>QR Code สำหรับการชำระเงิน</h2>
        <p>หมายเลขคำขอ: <strong><?php echo htmlspecialchars($applicationId); ?></strong></p>
        <!-- <img src="<?php echo htmlspecialchars($qrcodeImage); ?>" alt="QR Code">
 -->



        <img id="qrImage" src="<?php echo htmlspecialchars($qrcodeImage); ?>" alt="QR Code">
        <br>
        <button onclick="enablePip()">🔳 เปิด QR แบบ Picture-in-Picture</button>

        <canvas id="qrCanvas" width="300" height="300" style="display:none;"></canvas>
        <video id="qrVideo" autoplay muted style="display:none;"></video>









        <p class="expiry">QR Code นี้จะหมดอายุใน:</p>
        <p id="countdown" class="timer"></p>

        <p>กรุณาชำระเงินก่อนหมดอายุ มิฉะนั้น QR Code นี้จะใช้ไม่ได้</p>

        <a href="insertdata-payment-test.php" class="new-payment">สร้าง QR Code การชำระเงินใหม่</a>
    </div>











    <script>
        function enablePip() {
            const img = document.getElementById("qrImage");
            const canvas = document.getElementById("qrCanvas");
            const ctx = canvas.getContext("2d");
            const video = document.getElementById("qrVideo");

            // ใช้ภาพใหม่เพื่อหลีกเลี่ยง CORS
            const qr = new Image();
            qr.crossOrigin = "anonymous"; // สำคัญมากถ้า QR อยู่บนเว็บอื่น
            qr.src = img.src;

            // โหลดภาพเสร็จแล้วค่อยวาด
            qr.onload = () => {
                // วาดลง canvas
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(qr, 0, 0, canvas.width, canvas.height);

                // stream canvas เข้า video
                const stream = canvas.captureStream(30);
                video.srcObject = stream;

                video.onloadedmetadata = async () => {
                    try {
                        await video.play();
                        await video.requestPictureInPicture();
                    } catch (err) {
                        console.error("เปิด PiP ไม่ได้:", err);
                        alert("เปิด Picture-in-Picture ไม่ได้: " + err.message);
                    }
                };
            };

            // หากโหลดภาพไม่สำเร็จ
            qr.onerror = () => {
                alert("โหลดภาพ QR ไม่สำเร็จ");
            };
        }
    </script>



</body>

</html>