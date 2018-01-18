<?php namespace App\Http\Controllers;

use App\Currency;
use App\TypeRate;
use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CurrencyController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('currency.index')
            ->with('menu','currency');
    }

    public function add(){
        return view('currency.add')
            ->with('menu','currency');
    }

    public function edit($id=0){

        $currency = Currency::find($id);

        return view('currency.edit')
            ->with('menu', 'currency')
            ->with('currency', $currency);
    }

    public function store(){
        $currency = new Currency();
        $currency->name = Input::get('name');
        $currency->rate = Input::get('rate');
        $currency->symbol = Input::get('symbol');
        $currency->position = Input::get('position');
        $currency->save();
        return redirect()
            ->route('currency.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $currency = Currency::find(Input::get('id'));
        $currency->name = Input::get('name');
        $currency->rate = Input::get('rate');
        $currency->symbol = Input::get('symbol');
        $currency->position = Input::get('position');
        $currency->save();
        return redirect()
            ->route('currency.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function delete($id=0){
        $currency = Currency::find($id);
        $currency->delete();
        return redirect()
            ->route('currency.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $currency = Currency::where('id','>',0);

        $countAll = $currency->count();

        $currency->skip(Input::get('start'))->take(Input::get('length'));

        $currency_array = $currency->get()->toArray();

        $currency_array = $this->reFormatArray($currency_array);

        $array = array(
            'data' => $currency_array,
            'draw' => Input::get('draw'),
            'recordsFiltered' => $countAll,
            'recordsTotal' => $countAll
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

    public function reFormatArray($array = array()){

        for($i=0;$i<count($array);$i++){
            if($array[$i]['name'] == ''){
                $array[$i]['name'] = '-';
            }
            if($array[$i]['rate'] != ''){
                if($array[$i]['position'] == 0){
                    $array[$i]['rate'] = $array[$i]['symbol'].$array[$i]['rate'];
                }else{
                    $array[$i]['rate'] = $array[$i]['rate'].' '.$array[$i]['symbol'];
                }
            }
            $array[$i]['actions'] = '<a href="'.route('currency.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('currency.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

}
