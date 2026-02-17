<?php

namespace App\Services\Product;

use App\Contracts\Product\ProductImportExportInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductImportExportService implements ProductImportExportInterface
{
    public function export(string $format = 'csv')
    {
        $products = Product::with(['category', 'seller'])->get();
        
        if ($format === 'csv') {
            return $this->exportToCsv($products);
        }
        
        throw new \InvalidArgumentException("Format {$format} not supported");
    }

    public function import(string $filePath)
    {
        $file = Storage::get($filePath);
        $rows = array_map('str_getcsv', explode("\n", $file));
        
        $imported = 0;
        foreach ($rows as $row) {
            if (count($row) >= 4) {
                Product::create([
                    'name' => $row[0],
                    'description' => $row[1],
                    'price' => $row[2],
                    'category_id' => $row[3],
                ]);
                $imported++;
            }
        }
        
        return $imported;
    }

    private function exportToCsv($products)
    {
        $csv = "Name,Description,Price,Category\n";
        
        foreach ($products as $product) {
            $csv .= "\"{$product->name}\",\"{$product->description}\",{$product->price},\"{$product->category->name}\"\n";
        }
        
        return $csv;
    }
}
