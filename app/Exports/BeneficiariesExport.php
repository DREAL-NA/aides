<?php

namespace App\Exports;

use App\Beneficiary;

class BeneficiariesExport extends GlobalExport implements GlobalExportInterface
{
    use Exportable;

    protected $columns = [
        'name_complete' => 'Nom',
        'description' => 'Description',
        'created_at' => 'Date de création',
        'updated_at' => 'Date de mise à jour',
    ];

    protected $filename = 'beneficiaires';

    public function collection()
    {
        return Beneficiary::all()
            ->map(function ($item) {
                return $item->only(array_keys($this->columns));
            })
            ->sortBy('name_complete');
    }
}