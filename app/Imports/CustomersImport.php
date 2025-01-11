<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'branch_id'  => $row['branch_id'],
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'email'      => $row['email'],
            'phone'      => $row['phone'],
            'gender'     => $row['gender'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000; 
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
