<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefundRequest;
use App\Refund;
use App\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    public function __construct(Refund $refund, Person $person)
    {
        $this->person = $person;
        $this->refund = $refund;
    }

    public function index(){
        $refunds = $this->person->with('refund')->paginate(10);

        return response()->json($refunds, 200);
    }

    public function show($id){

        // $refund = $this->person->with('refund')->findOrFail($id);
        // if(!$refund->refund){
        //     return ['msg' => 'Esta pessoa não possui reembolso', 401];             
        // }
        try {

    		$refund = $this->refund->with('photos')->findOrFail($id);

    		return response()->json([
    			'data' => [
    				'data' => $refund
    			]
    		], 200);

    	} catch (Exception $e) {
    		$message = new ApiMessages($e->getMessage());
    		response()->json($message->getMessage(), 401);
    	}
    }

    public function store(Request $request){
        $data = $request->all();
        $refunds = $data['refunds'][0];

        // Converte Parametro em Objeto
        $convert_date_refund =  Carbon::parse($refunds['date']);
        $convert_createdAt =  Carbon::parse($data['createdAt']);
        
        // Converte para o Padrão datetime
        $refunds['date'] = $convert_date_refund->year . '-' . $convert_date_refund->month . '-' . $convert_date_refund->day 
        .' ' . $convert_date_refund->hour . ':' . $convert_date_refund->minute . ':' . $convert_date_refund->second; 

        $data['createdAt'] = $convert_createdAt->year . '-' . $convert_createdAt->month . '-' . $convert_createdAt->day 
        .' ' . $convert_createdAt->hour . ':' . $convert_createdAt->minute . ':' . $convert_createdAt->second; 

        $refunds['timezone'] = $convert_date_refund->timezone;
        $data['timezone'] = $convert_createdAt->timezone;

            try {

                $person = $this->person->create($data); 

                $person->refund()->create(
                    [
                        'date' => $refunds['date'],
                        'type' => $refunds['type'],
                        'description' => $refunds['description'],
                        'value' => $refunds['value'],
                        'timezone' => $refunds['timezone'],

                    ]
                );

                return response()->json([
                    'data' => [
                        'msg' => 'Reembolso cadastrado com sucesso'
                    ]
                ], 200);
            } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
            }
    }

    public function update(RefundRequest $request, $id){

        $data['value'] = $request['value'];

        try {
           
            $refund = $this->refund->findOrFail($id);
            $refund->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Reembolso atualizado com sucesso'
                ]
            ], 200);
            
        } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id){  

        try {

            $refund = $this->refund->findOrFail($id);
            $refund->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Reembolso excluido com sucesso'
                ]
            ], 200);
            
        } catch (Exception $e) {
            $message = new ApiMessages($e->getMessage());
            response()->json($message->getMessage(), 401);
        }
        
    }

    public function uploadPhoto(Request $request, $id){
        $image = $request->file('image');

        if($image){
            $imageUpload = [];
            $refund = $this->refund->findOrFail($id);
            $path = $image->store('images', 'public');

            $imageUpload = ['refund_id' => $refund->id, 'image' => $path];


            $refund->photos()->create($imageUpload);

            

            return response()->json([
                'data' => [
                    'msg' => 'Imagem cadastrada com sucesso'
                ]
            ], 200);
        }
        else{
            return ['msg' => 'É necessario inserir uma imagem', 401];  
        }
    }

    public function relatorio(Request $request){

        $report = DB::table('refunds')
                ->select(
                    DB::raw('MONTH(date) as month, YEAR(date) as year'),
                    DB::raw('sum(value) as totalRefunds'),
                    DB::raw('count(id) as refunds')
                )
                ->whereYear('date', $request->year)
                ->whereMonth('date', $request->month)
                ->groupBy(DB::raw('MONTH(date)'))
                ->get();

                return response()->json($report);

    }    

}
