<?php namespace App\Http\Controllers;

use App\ClientRate;
use App\Clients;
use App\TypeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ClientController extends Controller {

	public function __construct()
	{
	}

	public function index(){
	    return view('client.index')
            ->with('menu','client');
    }

    public function addClient(){
        return view('client.add')
            ->with('menu','client');
    }

    public function editClient($id=0){

        $client = Clients::find($id);
        $typerate = TypeRate::all();

        return view('client.edit')
            ->with('menu', 'client')
            ->with('client', $client)
            ->with('typerate', $typerate);
    }

    public function store(){
        $clients = new Clients();
        $clients->name = Input::get('name');
        $clients->email = Input::get('email');
        $clients->phone = Input::get('phone');
        $clients->code = Input::get('code');
        $clients->payment_term = Input::get('payment_term');
        $clients->save();
        return redirect()
            ->route('client.index')
            ->with('alert_color','green')
            ->with('alert','Created');
    }


    public function update(){
        $clients = Clients::find(Input::get('id'));
        $clients->name = Input::get('name');
        $clients->email = Input::get('email');
        $clients->phone = Input::get('phone');
        $clients->code = Input::get('code');
        $clients->payment_term = Input::get('payment_term');
        $clients->save();
        return redirect()
            ->route('client.index')
            ->with('alert_color','green')
            ->with('alert','Updated');
    }

    public function saveajax(){
        if(Input::get('id') && Input::get('id')  > 0){
            $clients = ClientRate::find(Input::get('id'));
        }else{
            $clients = new ClientRate();
        }
        $clients->clientsFK = Input::get('client_id');
        $clients->type_rateFK = Input::get('type_rate_id');
        $clients->price = Input::get('price');
        $clients->currency = Input::get('currency');
        $clients->save();

        $array = array(
            'success' => 1
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

    public function delete($id=0){
        $clients = Clients::find($id);
        $clients->delete();
        return redirect()
            ->route('client.index')
            ->with('alert_color','red')
            ->with('alert','Deleted');
    }

    public function ajax(){
        $client = Clients::where('id','>',0);

        $countAll = $client->count();

        $client->skip(Input::get('start'))->take(Input::get('length'));

        $clients = $client->get()->toArray();

        $clients = $this->reFormatArray($clients);

        $array = array(
            'data' => $clients,
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
            if($array[$i]['email'] == ''){
                $array[$i]['email'] = '-';
            }
            if($array[$i]['phone'] == ''){
                $array[$i]['phone'] = '-';
            }
            if($array[$i]['code'] == ''){
                $array[$i]['code'] = '-';
            }
            $array[$i]['actions'] = '<a href="'.route('client.edit', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="'.route('client.delete', ['id' => $array[$i]['id']]).'" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

    public function rateajax(){
        $clientrate = ClientRate::where('clientsFK','=',Input::get('client_id'));

        $countAll = $clientrate->count();

        $clientrate->take(10);

        $clientrates = $clientrate->get()->toArray();

        $clientrates = $this->reFormatArray2($clientrates);

        $array = array(
            'data' => $clientrates,
            'draw' => Input::get('draw'),
            'recordsFiltered' => $countAll,
            'recordsTotal' => $countAll
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

    public function reFormatArray2($array = array()){

        for($i=0;$i<count($array);$i++){

            if($array[$i]['type_rateFK'] > 0){
                $typeRate = TypeRate::find($array[$i]['type_rateFK']);
                $array[$i]['rate'] = $typeRate->name;
            }else{
                $array[$i]['rate'] = "";
            }

            if($array[$i]['price'] != ''){
                $array[$i]['price'] = $array[$i]['price'].' '.$array[$i]['currency'];
            }
            $array[$i]['actions'] = '<a href="javascript:;" onClick="editRate('.$array[$i]['id'].');" class="waves-effect waves-light btn blue" style="padding: 0 1rem;margin-right: 15px;">
                                            <i class="material-icons" style="margin-left: 0px;">build</i>
                                     </a>
                                    <a href="javascript:;" onClick="deleteRate('.$array[$i]['id'].');" class="waves-effect waves-light btn red" style="padding: 0 1rem;">
                                            <i class="material-icons" style="margin-left: 0px;">delete</i>
                                     </a>';
        }

        return $array;
    }

    function getRate(){

        $clientrate = ClientRate::find(Input::get('id'));

        $array = array(
            'rate' => $clientrate->type_rateFK,
            'price' => $clientrate->price,
            'currency' => $clientrate->currency
        );

        return response()->jsonp(\Request::query('callback'), $array);
    }

    function deleteRate(){
        $clientrate = ClientRate::find(Input::get('id'));
        $clientrate->delete();

        $array = array(
            'success' => 1
        );

        return response()->jsonp(\Request::query('callback'), $array);

    }

    function search(){

        $client = Clients::leftJoin('client_rate','clients.id','=','client_rate.clientsFK')
                        ->where("clients.name","like","%".Input::get('q.term')."%")
                        ->where('client_rate.type_rateFK','=',Input::get('rate_type'))
                        ->select('clients.id','clients.name','client_rate.price')
                        ->take(15);

        if($client->count() > 0){
            $clients = $client->get();
            $array = array();
            foreach ($clients as $value){
                $data = array();
                $data['id'] = $value->id;
                $data['text'] = $value->name;
                $data['rate_price'] = $value->price;
                array_push($array, $data);
            }

        }else{
            $array = array();
        }

        return response()->json([
            "items" => $array
        ]);
    }

}
