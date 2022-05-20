<?php

namespace App\Service;

use App\Entity\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\BaseWriter;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class XlsExporter
{
    public function exportFriendsKilometrages(User $user): BaseWriter
    {
        $excel = new Spreadsheet();

        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();

        foreach ($user->getFriends() as $key => $friend) {
            $sheetKey = $key + 1;
            $sheet->getCell('A'.$sheetKey)->setValue($friend->getUserName());
            $sheet->getCell('B'.$sheetKey)->setValue($friend->getKilometrage());
        }

        return new Xls($excel);
    }
}