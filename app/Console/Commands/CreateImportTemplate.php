<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateImportTemplate extends Command
{
    protected $signature = 'template:create';
    protected $description = 'Create product import template';

    public function handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'name');
        $sheet->setCellValue('B1', 'description');
        $sheet->setCellValue('C1', 'price');
        $sheet->setCellValue('D1', 'category_id');
        
        // Set sample data
        $sheet->setCellValue('A2', 'Sample Item');
        $sheet->setCellValue('B2', 'Sample description');
        $sheet->setCellValue('C2', 19.99);
        $sheet->setCellValue('D2', 1);

        $writer = new Xlsx($spreadsheet);
        $writer->save('c:\Users\allan\OneDrive\Documents\Laravel\public\sample\product_import_sample.xlsx');
        
        $this->info('Template created successfully!');
    }
}