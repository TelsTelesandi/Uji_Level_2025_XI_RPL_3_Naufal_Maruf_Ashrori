<?php

namespace App\Imports;

use App\Models\Ruangan;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RuanganImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $failed_rows = [];
    protected $rows_count = 0;
    protected $created_updatedt_rows = 0;

    public function getFailedRows()
    {
        return $this->failed_rows;
    }
    public function getRowsCount()
    {
        return $this->rows_count;
    }
    public function getCreatedOrUpdatedRowsCount()
    {
        return $this->created_updatedt_rows;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            try {
                $this->rows_count += 1;


                if (
                    empty($row["nama_ruangan"]) ||
                    empty($row["lokasi"]) ||
                    empty($row["kapasitas"])
                ) {
                    continue;
                }

                $errors = [];

                if($row['kapasitas'] <= 0) {
                    $errors[] = "Kapasitas tidak boleh kurang dari 0";
                }

                if (count($errors) > 0) {
                    $this->failed_rows[] = [
                        "row" => $row,
                        "errors" => $errors
                    ];

                    continue;
                }

                Ruangan::updateOrCreate(
                    ["nama_ruangan" => $row['nama_ruangan'], 'lokasi' => $row['lokasi']],
                    [
                        "nama_ruangan" => $row["nama_ruangan"],
                        "lokasi" => $row["lokasi"],
                        "kapasitas" => $row["kapasitas"],
                    ]
                );

                $this->created_updatedt_rows++;
            } catch (Exception $e) {
                return dd($e);
            }
        }
    }
}
