<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class GeneralSample implements
    Responsable,
    WithHeadings,
    ShouldQueue,
    WithStyles,
    FromArray,
    WithCustomStartCell
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $length;
    protected $type;
    protected $company;
    protected $header;
    protected $data;
    protected $column_size;
    protected $title;
    protected $alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'Y', 'Z'];
    function __construct(array $data, int $length, $type, $header, $column_size, $title=null)
    {
        $this->header = $header;
        $this->data = $data;
        $this->column_size = $column_size;
        $this->length = $length;
        $this->type = $type;
        $this->title = $title;


    }

    use Exportable;

    private $fileName = 'Shop.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/xlsx',
    ];
    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->header;
    }

    public function styles(Worksheet $spreadsheet)
    {
        $date = miladiToHijriOrJalali(Carbon::now()->format('Y-m-d'));

        $maxLength = $this->length + 6;
        $type = $this->type;
        $lastColumn = count($this->header) - 1;

        // Column Headers Style

        $spreadsheet->getStyle('A1')->getFont()->setBold(true);
        $spreadsheet->getStyle('A1')->getFont()->setSize(16);
        $spreadsheet->getStyle('A3')->getFont()->setSize(12);
        $spreadsheet->getStyle('A1')->getFont()->setBold(true);
        $spreadsheet->getStyle('A3')->getFont()->setBold(true);
        $spreadsheet->getStyle('A6:' . $this->alphabet[$lastColumn] . '6')->getFont()->setBold(true);
        $spreadsheet->getStyle('A6:' . $this->alphabet[$lastColumn] . '6')->getFont()->getColor()->setRGB('ffffff');
        $spreadsheet->getStyle('A6:' . $this->alphabet[$lastColumn] . '6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet->getStyle('A6:' . $this->alphabet[$lastColumn] . '6')->getFill()->getStartColor()->setRGB('0277bd');
        $spreadsheet->getStyle('A1:' . $this->alphabet[$lastColumn] . '' . $maxLength)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getStyle('A2:' . $this->alphabet[$lastColumn] . '' . $maxLength)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getStyle('A1:' . $this->alphabet[$lastColumn] . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getStyle('A2:' . $this->alphabet[$lastColumn] . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getStyle('6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getStyle('6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getRowDimension('6')->setRowHeight(30);
        for ($x = 0; $x <= $lastColumn; $x++) {
            $spreadsheet->getColumnDimension($this->alphabet[$x])->setWidth($this->column_size[$x]);
        }

        $spreadsheet->getStyle('A1:' . $this->alphabet[$lastColumn] . '5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet->getStyle('A2:' . $this->alphabet[$lastColumn] . '5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet->mergeCells('A1:' . $this->alphabet[$lastColumn] . '1');
        $spreadsheet->mergeCells('A2:' . $this->alphabet[$lastColumn] . '2');
        $spreadsheet->mergeCells('A3:' . $this->alphabet[$lastColumn] . '4');
        $spreadsheet->mergeCells('A5:' . $this->alphabet[$lastColumn] . '5');
        // --------------------------------------------------------->>

        // Number Column
        $spreadsheet->getStyle('A6:' . 'A' . $maxLength)->getFont()->getColor()->setRGB('ffffff');
        $spreadsheet->getStyle('A6:' . 'A' . $maxLength)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet->getStyle('A7:' . 'A' . $maxLength)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getStyle('A6:' . 'A' . $maxLength)->getFill()->getStartColor()->setRGB('0277bd');
        // --------------------------------------------------------->>


        // Title || Company || Name
        $spreadsheet->getCell('A1')->setValue(__('general_words.ministry_of_finance'));
        $spreadsheet->getStyle('A1')->getAlignment()->setWrapText(true);
        $spreadsheet->getCell('A2')->setValue(__('general_words.archive_directorate'));
        $spreadsheet->getStyle('A2')->getAlignment()->setWrapText(true);
        $spreadsheet->getCell('A3')->setValue($this->title);
        $spreadsheet->getStyle('A3')->getAlignment()->setWrapText(true);
        // --------------------------------------------------------->>


        // Date Of Export
        $spreadsheet->getStyle('A5')->getFont()->setSize(13);
        $spreadsheet->getStyle('A5')->getFont()->setBold(true);
        $spreadsheet->getCell('A5')->setValue($type . __('general_words.exported_date') . $date);
        $spreadsheet->getStyle('A5:' . $this->alphabet[$lastColumn] . '5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getStyle('A5:' . $this->alphabet[$lastColumn] . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // --------------------------------------------------------->>


        // Body Cells alignment
        $spreadsheet->getStyle('B7:' . '' . $this->alphabet[$lastColumn] . '' . $maxLength)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // --------------------------------------------------------->>
        \App::setLocale('prs');
        if(\App::isLocale('prs') || \App::isLocale('pa')){
            $spreadsheet->setRightToLeft(true);
        }
        else
        {
            $spreadsheet->setRightToLeft(false);
        }

        // All Cells Borders Inside And Outline
        $styleArray = [
            'borders' => [
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $spreadsheet->getStyle('A6:' . '' . $this->alphabet[$lastColumn] . '' . $maxLength)->applyFromArray($styleArray);
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $spreadsheet->getStyle('A6:' . '' . $this->alphabet[$lastColumn] . '' . $maxLength)->applyFromArray($styleArray);
        $styleArray = [
            'borders' => [
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'ffffff'],
                ],
            ],
        ];
        $spreadsheet->getStyle('A1:' . $this->alphabet[$lastColumn] . '6')->applyFromArray($styleArray);
        for ($x = 1; $x < $maxLength + 1; $x++) {
            if ($x != 6) {

                $spreadsheet->getRowDimension("$x")->setRowHeight(20);
            }
        }
        // --------------------------------------------------------->>

        // General Settings
        $spreadsheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $spreadsheet->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getPageSetup()->setFitToHeight(0);
        $spreadsheet->getPageSetup()->setFitToPage(FALSE);
        $spreadsheet->getPageSetup()->setScale(80);
        // --------------------------------------------------------->>


    }

    public function startCell(): string
    {
        return 'A6';
    }
}
