<?php namespace App\Http\Controllers;

use App\Clients;
use App\Currency;
use App\Linguistlevel;
use App\Linguists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LinguistlevelController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('linguistlevel.index')
            ->with('menu','linguistlevel');
    }

    public function add(){

	    $currency = Currency::all();

        return view('linguistlevel.add')
            ->with('menu','linguistlevel')
            ->with('currency',$currency);
    }

    public function edit($id=0){

        $linguistlevel = Linguistlevel::find($id);
        $currency = Currency::all();

        return view('linguistlevel.edit')
            ->with('menu', 'linguistlevel')
            ->with('linguistlevel', $linguistlevel)
            ->with('currency',$currency);
    }

    public function store(){
        $linguistlevel = new Linguistlevel();
        $linguistlevel->name = Input::get('name');
        $linguistlevel->rate_word = Input::get('rate_word');
        $linguistlevel->rate_hourly = Input::get('rate_hourly');
        $linguistlevel->currency = Input::get('currency');
        $linguistlevel->save();
        return redirect()
            ->route('linguistlevel.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $linguistlevel = Linguistlevel::find(Input::get('id'));
        $linguistlevel->name = Input::get('name');
        $linguistlevel->rate_word = Input::get('rate_word');
        $linguistlevel->rate_hourly = Input::get('rate_hourly');
        $linguistlevel->currency = Input::get('currency');
        $linguistlevel->save();
        return redirect()
            ->route('linguistlevel.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function delete($id=0){
        $linguistlevel = Linguistlevel::find($id);
        $linguistlevel->delete();
        return redirect()
            ->route('linguistlevel.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $linguistlevel = Linguistlevel::where('id','>',0);

        $countAll = $linguistlevel->count();

        $linguistlevel->skip(Input::get('start'))->take(Input::get('length'));

        $linguistlevels = $linguistlevel->get()->toArray();

        $linguistlevels = $this->reFormatArray($linguistlevels);

        $array = array(
            'data' => $linguistlevels,
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

            if($array[$i]['rate_word'] != ''){
                if($array[$i]['currency'] > 0){
                    $currency = Currency::find($array[$i]['currency']);
                    if($currency->position == 0){
                        $array[$i]['rate_word'] = $currency->symbol.$array[$i]['rate_word'];
                    }else{
                        $array[$i]['rate_word'] = $array[$i]['rate_word'].' '.$currency->symbol;
                    }
                }
            }

            if($array[$i]['rate_hourly'] != ''){
                if($array[$i]['currency'] > 0) {
                    $currency = Currency::find($array[$i]['currency']);
                    if ($currency->position == 0) {
                        $array[$i]['rate_hourly'] = $currency->symbol . $array[$i]['rate_hourly'];
                    } else {
                        $array[$i]['rate_hourly'] = $array[$i]['rate_hourly'] . ' ' . $currency->symbol;
                    }
                }
            }

            $array[$i]['actions'] = '<a href="'.route('linguistlevel.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('linguistlevel.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

}
