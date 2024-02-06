<?php

namespace App\Exports;

use App\Models\Fecen9;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\WithProperties;
class Fecen9Export implements FromView
{

    public $fc9_id;
    public $type;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($type,$fc9_id=null)
    {
        $this->fc9_id=$fc9_id;
        $this->type=$type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return Fecen9::all();
//    }
    public function view(): View
    {
        $data['fc9']     = (new Fecen9())->getFece9($this->fc9_id);
        $data['items'] = (new Fecen9())->getFc9Details($this->fc9_id);
        return view('fc9.show-excel',$data);
    }
}
