<?php

namespace App\Http\Controllers;

use App\Models\Fecen1;
use App\Models\Fecen9;
use App\Models\Fecen8;
use App\Models\Fecen4;
use App\Models\Fecen5;
use App\Models\CardToCard;
use App\Models\CardToCardDetails;
use App\Models\Fecen5ItemDetail;
use App\Models\Fecen9ItemDetail;
use App\Models\Item;
use App\Models\Meem7;
use App\Models\Moblin;
use App\Models\Repairing;
use App\Models\Sejel;
use App\Models\UnitOfMeasure;
use App\Models\ItemStatus;
use Illuminate\Http\Request;
use PDF;
class PrintController extends Controller
{
    protected $fecen9;
    protected $fece9_details;
    protected $item;
    public function __construct(Fecen9 $fecen9,Fecen9ItemDetail $fece9_details,Item $item)
    {
        $this->fecen9          = $fecen9;
        $this->item           = $item;
        $this->fece9_details  = $fece9_details;
    }
    public  function print($type,$form_id)
    {
        if($type =='fc9')
        {

            $data['fc9']    = $this->fecen9->getFece9($form_id);
            $data['items']  = $this->fecen9->getFc9Details($form_id); 
            return view('fc9.print',$data); 
        }

        if($type =='fc4')
        {
            $data['fc4']    = (new Fecen4())->getFece4($form_id);
            $data['items']  = (new Fecen4())->getFc4Details($form_id);
            return view('fc4.print',$data);
            // $pdf = PDF::loadView('fc4.print',$data);
            // return $pdf->stream($data['fc4']->fecen4_number.'pdf');
        }
        if($type =='fc8')
        {
            $data['fc8']    = (new Fecen8())->getFece8($form_id);
            $data['items']  = (new Fecen8())->getfc8Details($form_id);
            return view('fc8.print',$data);
            // $pdf = PDF::loadView('fc8.print',$data);
            // return $pdf->stream($data['fc8']->fecen8_number.'pdf');
        }
        // dd($type);
        if($type =='card_to_card')
        {
            $data['card_to_cards']    = (new CardToCard())->showCardToCard($form_id);
            // dd($data['card_to_cards']);
            $data['items']  = (new CardToCard())->getItem($form_id);
            // dd($data);
            return view('card_to_cards.print',$data);

            // $pdf = PDF::loadView('card_to_cards.print',$data);
            // return $pdf->stream($data['card_to_cards']->id.'pdf');
        }
        if($type =='fc1')
        {
            $data['fecen1']    = (new Fecen1())->getFecen1($form_id);
            $data['items']  = (new Fecen1())->getFc1Details($form_id);
            $data['comittee_members']  = (new Fecen1())->getFecen1CommitteeMembers($form_id);
            // dd($data['comittee_members']);
            return view('fc1.print',$data);
            // $pdf = PDF::loadView('fc1.print',$data);
            // return $pdf->stream($data['fecen1']->fecen1_number.'.pdf');
        }
        if($type =='fc5')
        {
            $data['fecen5']    = (new Fecen5)->getFecen5($form_id);
            $data['items']  = (new Fecen5)->getFc5Details($form_id);
            return view('fc5.print', $data);
            // $pdf = \PDF::loadView('fc5.print', $data);
            // return $pdf->stream($data['fecen5']->fecen5_number.'.pdf');
        }

        if($type =='m7')
        {
            $data['m7']    =  (new Meem7())->getMeem7($form_id);
            $data['items']  =  (new Meem7())->getM7Details($form_id);
            return view('m7.print',$data);
            // $pdf = PDF::loadView('m7.print',$data);
            // return $pdf->stream($data['m7']->meem7_number.'.pdf');
        }

        if($type =='sejel')
        {
            // $data['m7']    =  (new Meem7())->getMeem7($form_id);
            // $data['items']  =  (new Meem7())->getM7Details($form_id);
            $data['sejel']         = (new Sejel())->getSejelData($form_id);
            $data['vehicle_part']    = $data['sejel']->vehicle_part;
            return view('sejel.print',$data);
            // $pdf = PDF::loadView('m7.print',$data);
            // return $pdf->stream($data['m7']->meem7_number.'.pdf');
        }
        if($type =='moblin')
        {
            $data['moblin']       = (new Moblin())->find($form_id);
            $data['sejel']        = (new Sejel())->getSejelData($data['moblin']->sejel_id);
            $data['items']        = collect(json_decode($data['moblin']->details));
            $item = $data['items']->map(function ($item) {
                $itemArr = [
                    'item_name'        => $item->item_name,
                    'measure'          => $item->measure,
                    'quantity'         => $item->quantity
                ];
                return $itemArr;
            });
            $data['items'] = $item;
            return view('sejel.moblin.print',$data);
        }
        if($type =='repairing')
        {
            $data['repairing']       = (new Repairing())->find($form_id);
            $data['sejel']        = (new Sejel())->getSejelData($data['repairing']->sejel_id);
            $data['items']        = collect(json_decode($data['repairing']->item_details));
            $item = $data['items']->map(function ($item) {
                $findItem         = Item::find($item->item_id);
                $itemStatus      = (new ItemStatus())->where('id',$findItem->item_status_id)
                    ->selectRaw('name_'.lang().' as status')->first();
                $itemArr = [
                    'item_name'        => $item->item_name,
                    'specification'          => $item->specification,
                    'quantity'         => $item->quantity,
                    'item_status'         => $item->item_status,
                    'measure'         => $item->measure,
                    'purchase_type'         => $item->purchase_type
                ];
                return $itemArr;
            });
            $data['items'] = $item;
            return view('sejel.repairing.print',$data);
        }
    }
}
