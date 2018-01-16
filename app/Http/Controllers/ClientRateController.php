<?php namespace App\Http\Controllers;

use App\TypeRate;
use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ClientRateController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('clientrate.index')
            ->with('menu','clientrate');
    }

    public function add(){
        return view('clientrate.add')
            ->with('menu','clientrate');
    }

    public function edit($id=0){

        $clientrate = TypeRate::find($id);

        return view('clientrate.edit')
            ->with('menu', 'clientrate')
            ->with('clientrate', $clientrate);
    }

    public function store(){
        $clientrate = new TypeRate();
        $clientrate->name = Input::get('name');
        $clientrate->save();
        return redirect()
            ->route('clientrate.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $clientrate = TypeRate::find(Input::get('id'));
        $clientrate->name = Input::get('name');
        $clientrate->save();
        return redirect()
            ->route('clientrate.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function delete($id=0){
        $clientrate = TypeRate::find($id);
        $clientrate->delete();
        return redirect()
            ->route('clientrate.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $clientrate = TypeRate::where('id','>',0);

        $countAll = $clientrate->count();

        $clientrate->skip(Input::get('start'))->take(Input::get('length'));

        $clientrates = $clientrate->get()->toArray();

        $clientrates = $this->reFormatArray($clientrates);

        $array = array(
            'data' => $clientrates,
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
            $array[$i]['actions'] = '<a href="'.route('clientrate.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('clientrate.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

}
