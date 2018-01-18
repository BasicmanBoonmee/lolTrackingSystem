<?php namespace App\Http\Controllers;

use App\Clients;
use App\Linguistlevel;
use App\Linguists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class LinguistsController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('linguist.index')
            ->with('menu','linguist');
    }

    public function addLinguist(){

	    $linguistlevel = Linguistlevel::all();

        return view('linguist.add')
            ->with('menu','linguist')
            ->with('linguistlevel', $linguistlevel);
    }

    public function editLinguist($id=0){

        $linguist = Linguists::find($id);

        $linguistlevel = Linguistlevel::all();

        return view('linguist.edit')
            ->with('menu', 'linguists')
            ->with('linguist', $linguist)
            ->with('linguistlevel', $linguistlevel);
    }

    public function store(){
        $linguist = new Linguists();
        $linguist->name = Input::get('name');
        $linguist->guaranteed_income = Input::get('guaranteed_income');
        $linguist->daily_capacity = Input::get('daily_capacity');
        $linguist->note = Input::get('note');
        $linguist->linguist_levelFK = Input::get('linguist_levelFK');
        $linguist->save();
        return redirect()
            ->route('linguist.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $linguist = Linguists::find(Input::get('id'));
        $linguist->name = Input::get('name');
        $linguist->guaranteed_income = Input::get('guaranteed_income');
        $linguist->daily_capacity = Input::get('daily_capacity');
        $linguist->note = Input::get('note');
        $linguist->linguist_levelFK = Input::get('linguist_levelFK');
        $linguist->save();
        return redirect()
            ->route('linguist.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function delete($id=0){
        $linguist = Linguists::find($id);
        $linguist->delete();
        return redirect()
            ->route('linguist.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $linguist = Linguists::where('id','>',0);

        $countAll = $linguist->count();

        $linguist->skip(Input::get('start'))->take(Input::get('length'));

        $linguists = $linguist->get()->toArray();

        $linguists = $this->reFormatArray($linguists);

        $array = array(
            'data' => $linguists,
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
            if($array[$i]['guaranteed_income'] == ''){
                $array[$i]['guaranteed_income'] = '-';
            }
            if($array[$i]['daily_capacity'] == ''){
                $array[$i]['daily_capacity'] = '-';
            }
            if($array[$i]['note'] == ''){
                $array[$i]['note'] = '-';
            }

            if($array[$i]['linguist_levelFK'] != ''){
                $linguistlevel = Linguistlevel::find($array[$i]['linguist_levelFK']);
                $array[$i]['linguist_levelFK'] = $linguistlevel->name;
            }

            $array[$i]['actions'] = '<a href="'.route('linguist.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('linguist.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

    function search(){

        $result = Linguists::leftJoin('linguist_level','linguist_level.id','=','linguist.linguist_levelFK')
            ->where("linguist.name","like","%".Input::get('q.term')."%")
            ->select('linguist.id','linguist.name','linguist_level.rate_word','linguist_level.rate_hourly')
            ->take(15);

        if($result->count() > 0){
            $results = $result->get();
            $array = array();
            foreach ($results as $value){
                $data = array();
                $data['id'] = $value->id;
                $data['text'] = $value->name;
                $data['rate_word'] = $value->rate_word;
                $data['rate_hourly'] = $value->rate_hourly;
                array_push($array, $data);
            }

        }else{
            $array = array();
        }

        return response()->json([
            "items" => $array
        ]);
    }

    public function ratelevel(){
        $results = Linguistlevel::find(Input::get('linguist_level_id'));

        $array = array(
            'success' => 1,
            'results' => $results
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

}
