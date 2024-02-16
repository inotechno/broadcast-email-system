<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SubscriberImport implements ToCollection
{
    protected static $importedData = [];

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $col) {
            // Sesuaikan dengan struktur file Excel Anda
            $data = [
                'email' => $col[0] ?? null,
                'name' => $col[1] ?? null,
                'phone_number' => $col[2] ?? null,
            ];

            static::$importedData[] = $data;
        }
    }

    /**
     * Mendapatkan data yang diimpor.
     *
     * @return array
     */
    public static function getImportedData()
    {
        return static::$importedData;
    }
}
