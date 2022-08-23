<?php

namespace App\Imports;

use App\Models\Counteragent;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CounteragentsImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        $collect = new Collection();
        foreach ($rows as $row)
        {
                $data['id_1c'] = $row[1];
                $data['name'] = $row[2];
                $data['bin'] = (int)$row[3];
                $data['price_type_id'] =  $this->getPaymentType($row);
                $data['price_type'] =  $row[7];
                $data['payment_type_id'] = $this->getPaymentType($row);
                $data['payment_type'] = $row[4];
                $collect->add($data);

        }
        return  $collect;
    }

    private function getPriceType($row)
    {
        switch ((string)$row[4]){
            case "Розничная ВС Алматы":
                return 1;
            case "Розничная ВС +":
                return 2;
            case "Розничная А №2":
                return 3;
            case "Цены HoReCa":
                return 4;
            case "Цены для оптовки":
                return 5;

        }
    }

    private function getPaymentType($row)
    {
        switch ($row[7]){
            case "Наличный расчет":
                return 1;
            case "Безналичный расчет":
                return  2;
            default:
                throw $row;
        }
    }
    public function startRow(): int
    {
        return 2;
    }


}
