<?php namespace App\Http\Controllers;

use App\Clients;
use App\Linguists;
use App\Project;
use App\ProjectLinguist;
use App\TypeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProjectController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('project.index')
            ->with('menu','project');
    }

    public function add(){

        $typerate = TypeRate::all();

        return view('project.add')
            ->with('menu','project')
            ->with('typerate',$typerate);
    }

    public function edit($id=0){

        $project = Project::find($id);
        $typerate = TypeRate::all();

        $client_name = "";
        if($project->clientsFK > 0){
            $client = Clients::find($project->clientsFK);
            $client_name = $client->name;
        }


        return view('project.edit')
            ->with('menu', 'project')
            ->with('project', $project)
            ->with('typerate',$typerate)
            ->with('client_name', $client_name);
    }

    public function store(){
        $project = new Project();
        $project->name = Input::get('name');
        $project->status = Input::get('status');
        $project->type_rateFK = Input::get('type_rate');
        $project->unit_total = Input::get('unit_total');
        $project->clientsFK = Input::get('client');
        $project->total_price = Input::get('total_price');
        $project->start_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('start_date'))));
        $project->end_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('end_date'))));
        $project->dead_line = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('dead_line'))));
        $project->save();
        return redirect()
            ->route('project.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $project = Project::find(Input::get('id'));
        $project->name = Input::get('name');
        $project->status = Input::get('status');
        $project->type_rateFK = Input::get('type_rate');
        $project->unit_total = Input::get('unit_total');
        $project->clientsFK = Input::get('client');
        $project->total_price = Input::get('total_price');
        $project->start_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('start_date'))));
        $project->end_date = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('end_date'))));
        $project->dead_line = date("Y-m-d H:i:s",strtotime(str_replace("/","-",Input::get('dead_line'))));
        $project->save();

        if(Input::get('invoice_date') || Input::get('expected_date') || Input::get('received_date')){

        }

        return redirect()
            ->route('project.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function delete($id=0){
        $project = Project::find($id);
        $project->delete();
        return redirect()
            ->route('project.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $project = Project::where('id','>',0);

        $countAll = $project->count();

        $project->skip(Input::get('start'))->take(Input::get('length'));

        $projects = $project->get()->toArray();

        $projects = $this->reFormatArray($projects);

        $array = array(
            'data' => $projects,
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
            if($array[$i]['dead_line'] != ''){
                $array[$i]['dead_line'] = date("d/m/Y",strtotime($array[$i]['dead_line']));
            }
            if($array[$i]['start_date'] != ''){
                $array[$i]['start_date'] = date("d/m/Y",strtotime($array[$i]['start_date']));
            }
            if($array[$i]['end_date'] != ''){
                $array[$i]['end_date'] = date("d/m/Y",strtotime($array[$i]['end_date']));
            }
            $array[$i]['actions'] = '<a href="'.route('project.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('project.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

    public function lgajax(){
        $result = ProjectLinguist::where('projectsFK','=',Input::get('project_id'));

        $countAll = $result->count();

        $result->take(10);

        $results = $result->get()->toArray();

        $results = $this->reFormatArray2($results);

        $array = array(
            'data' => $results,
            'draw' => Input::get('draw'),
            'recordsFiltered' => $countAll,
            'recordsTotal' => $countAll
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }


    public function reFormatArray2($array = array()){

        for($i=0;$i<count($array);$i++){

            if($array[$i]['linguistFK'] > 0){
                $lg = Linguists::find($array[$i]['linguistFK']);
                $array[$i]['linguist'] = $lg->name;
            }else{
                $array[$i]['linguist'] = "";
            }

            if($array[$i]['price'] != ''){
                $array[$i]['price'] = $array[$i]['price'].' '.$array[$i]['currency'];
            }

            if($array[$i]['late'] > 0){
                $array[$i]['late'] = 'Yes';
            }else{
                $array[$i]['late'] = 'No';
            }

            $array[$i]['actions'] = '<a href="javascript:;" onClick="editForm('.$array[$i]['id'].');" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="javascript:;" onClick="deleteForm('.$array[$i]['id'].');" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }


    function getProjectLg(){

        $result = ProjectLinguist::find(Input::get('id'));

        if($result->linguistFK > 0){
            $project_lg = Linguists::leftJoin('linguist_level','linguist_level.id','=','linguist.linguist_levelFK')
                            ->where('linguist.id','=',$result->linguistFK)
                            ->select('linguist.name','linguist_level.rate_word','linguist_level.rate_hourly')
                            ->get();
            $linguist_name = $project_lg[0]->name;
            $rate_word = $project_lg[0]->rate_word;
            $rate_hourly = $project_lg[0]->rate_hourly;
        }else{
            $linguist_name = "";
            $rate_word = 0;
            $rate_hourly = 0;
        }

        $array = array(
            'status' => $result->status,
            'linguist' => $result->linguistFK,
            'linguist_name' => $linguist_name,
            'rate_word' => $rate_word,
            'rate_hourly' => $rate_hourly,
            'wc' => $result->wc,
            'hourly' => $result->hourly,
            'price' => $result->price,
            'late' => $result->late,
            'note' => $result->note,
            'currency' => $result->currency
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

    function deleteProjectLg(){
        $result = ProjectLinguist::find(Input::get('id'));
        $result->delete();

        $array = array(
            'success' => 1
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }


    public function saveajax(){
        if(Input::get('id') && Input::get('id')  > 0){
            $result = ProjectLinguist::find(Input::get('id'));
        }else{
            $result = new ProjectLinguist();
        }
        $result->projectsFK = Input::get('project_id');
        $result->linguistFK = Input::get('lg_id');
        $result->status = Input::get('status');
        $result->wc = Input::get('wc');
        $result->hourly = Input::get('hourly');
        $result->price = Input::get('price');
        $result->currency = Input::get('currency');
        $result->late = Input::get('late');
        $result->note = Input::get('note');
        $result->save();

        $array = array(
            'success' => 1
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

}
