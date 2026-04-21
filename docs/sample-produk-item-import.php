<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Produk Item Import');

$rows = [
    ['produk_id', 'nama_produk', 'kode_barang', 'status', 'kondisi'],
    [4, 'meja gaming', 'MG-TEST-001', 'tersedia', 'baik'],
    [4, 'meja gaming', 'MG-TEST-002', 'tersedia', 'baik'],
    [4, 'meja gaming', 'MG-TEST-003', 'rusak', 'rusak ringan'],
];

foreach ($rows as $rowIndex => $row) {
    $columnIndex = 1;
    foreach ($row as $value) {
        $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex + 1, $value);
        $columnIndex++;
    }
}

foreach (range('A', 'E') as $column) {
    $sheet->getColumnDimension($column)->setAutoSize(true);
}

$outputPath = __DIR__ . '/sample-produk-item-import.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($outputPath);

echo $outputPath . PHP_EOL;
