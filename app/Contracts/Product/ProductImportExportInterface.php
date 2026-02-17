<?php

namespace App\Contracts\Product;

interface ProductImportExportInterface
{
    public function export(string $format = 'csv');
    public function import(string $filePath);
}
