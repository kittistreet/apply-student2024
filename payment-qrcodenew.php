<?php
require 'vendor/autoload.php'; // ใช้ไลบรารี qrcode เช่น endroid/qr-code
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

function generatePaymentQR($data) {
    // กำหนดค่าเริ่มต้น
    $qrString = "|" . $data['tax_id'] . $data['suffix'] . "\r";
    $qrString .= $data['reference_no1'] . "\r";
    $qrString .= $data['reference_no2'] . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['total_amount']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= "2\r"; // Transaction Type
    $qrString .= $data['due_date'] . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['quantity']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['sales_amount']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['vat_rate']), 4, '0', STR_PAD_LEFT) . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['vat_amount']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= $data['seller_vat_branch_id'] . "\r";
    $qrString .= $data['buyer_tax_id'] . "\r";
    $qrString .= $data['buyer_vat_branch_id'] . "\r";
    $qrString .= $data['buyer_name'] . "\r";
    $qrString .= $data['reference_no3'] . "\r";
    $qrString .= $data['proxy_id'] . "\r";
    $qrString .= $data['proxy_type'] . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['net_amount']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= $data['type_of_income'] . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['withholding_tax_rate']), 4, '0', STR_PAD_LEFT) . "\r";
    $qrString .= str_pad(str_replace('.', '', $data['withholding_tax_amount']), 10, '0', STR_PAD_LEFT) . "\r";
    $qrString .= $data['withholding_tax_conditions'];
    
    // สร้าง QR Code
    $qrCode = new QrCode($qrString);
    $qrCode->setSize(300);
    
    // บันทึกไฟล์ QR Code
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    header('Content-Type: '.$result->getMimeType());
    echo $result->getString();
}

// ตัวอย่างข้อมูล
$data = [
    'tax_id' => '1234567890123',
    'suffix' => '00',
    'reference_no1' => '12345678901234567890',
    'reference_no2' => '09876543210987654321',
    'total_amount' => '1000.00',
    'due_date' => '01012025',
    'quantity' => '10',
    'sales_amount' => '900.00',
    'vat_rate' => '07.00',
    'vat_amount' => '70.00',
    'seller_vat_branch_id' => '00001',
    'buyer_tax_id' => '9876543210987',
    'buyer_vat_branch_id' => '00002',
    'buyer_name' => 'John Doe',
    'reference_no3' => 'REF20250001',
    'proxy_id' => '0039999999999',
    'proxy_type' => 'BANKACCOUNT',
    'net_amount' => '930.00',
    'type_of_income' => '001',
    'withholding_tax_rate' => '03.00',
    'withholding_tax_amount' => '30.00',
    'withholding_tax_conditions' => 'B'
];

generatePaymentQR($data);