
<?php
require 'vendor/autoload.php';
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Example bill payment details
$billerID = "|099400018814500"; // Replace with the actual biller ID
$referenceNumber1 = "220101010"; // Replace with the customer's reference number
$referenceNumber2 = "100133"; // Replace with the ORDER ID reference number
$amount = 9999900;              // Payment amount in THB

// Create the bill payment data string
$paymentData = sprintf(
	"%s\n%s\n%s\n%s",
	$billerID,
	$referenceNumber1,
	$referenceNumber2,
	$amount
);

echo $paymentData;

// Options for QR Code
$options = new QROptions([
	'eccLevel' => QRCode::ECC_L,
	'outputType' => QRCode::OUTPUT_IMAGE_PNG,
	'imageBase64' => false,
]);

// Generate the QR code
$qrcode = (new QRCode($options))->render($paymentData);

// Save the QR code as an image
$fileName = "bbl_billpay_qrcode.png";
file_put_contents($fileName, $qrcode);

// echo "QR Code for bill payment generated as $fileName\n";

?>
<img src="bbl_billpay_qrcode.png">





<?php
echo "<br>";
$fh = fopen('bank_transaction.txt','r');
while ($line = fgets($fh)) {
	$line_arr = explode(" " , iconv('TIS-620', 'UTF-8', $line));
	foreach ($line_arr as $key => $value) {
		if ($value!="") {
			echo "$value<br>";
		}
	}
}
fclose($fh);
?>