<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        /*
        $request->validate([
            'numdoc' => 'required|unique:clientes,numdoc',
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required',
            'correo' => 'required|unique:clientes,numdoc',
            'password' => 'required',
        ]);*/
        $idCliente = $request->cliente_id; // Suponiendo que el ID del cliente es 1
        $milisegundos = substr((string) (round(microtime(true) * 1000)), -5); // Obtener los últimos 5 dígitos de los milisegundos actuales
        $codigo = "AR" . $idCliente .$milisegundos;
        $pedido= new Pedido();
        $pedido->numero=$codigo;
        $pedido->estado=0;
        $pedido->tipo_entrega=$request->tipo_entrega;
        $pedido->forma_pago=0;
        $pedido->numero_operacion=$request->numero_operacion;
        $pedido->fecha_pedido=Carbon::now();;
        $pedido->fecha_entrega=$request->tipo_entrega==1?Carbon::now()->addDays(2)->toDateString():Carbon::now()->addDays(3)->toDateString();
        $pedido->costo_envio=$request->costo_envio;
        $pedido->cliente_id=$request->cliente_id;
        $pedido->almacen_id=$request->almacen_id;
        $pedido->save();
        $detalles=$request->detalles;
        foreach($detalles as $deta){
            $detaP=new PedidoDetalle();
            $detaP->cantidad=$deta['cantidad'];
            $detaP->costo_unitario=$deta['precio'];
            $detaP->detalle='no';
            $detaP->articulo_id=$deta['id'];
            $detaP->pedido_id=$pedido->id;
            $detaP->save();
        }
        return response()->json([
            'success' => true,
            'data' => $pedido,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    public function seleccionaAlmacen(Request $request){
        $pedido=Pedido::find($request->pedido_id);

        $pedido->almacen_id=$request->almacen_id;
        $pedido->save();
        return response()->json([
            'success' => true,
            'data' => $pedido,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }

    public function generaTokenPago(Request $request){

        $request->validate([
            'monto' => 'required',
            'email' => 'required',

        ]);
        $client = new Client();

        $response = $client->request('POST', 'https://api.micuentaweb.pe/api-payment/V4/Charge/CreatePayment', [
            'auth' => ['89289758', 'testpassword_7vAtvN49E8Ad6e6ihMqIOvOHC6QV5YKmIXgxisMm0V7Eq'],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "amount" => $request->monto,
                "currency" => "PEN",
                "orderId" => "myOrderId-999999",
                "customer" => [
                    "email" => $request->email
                ]
            ]
        ]);

        // Obtener el cuerpo de la respuesta
        $body = $response->getBody()->getContents();

        // Devolver la respuesta de la API (puedes procesar $body según tus necesidades)
        return response()->json($body);
    }

    public function validarPago(Request $request){
        $jsonData = $request->clientAnswer; // Aquí debes colocar el JSON que recibiste desde el formulario
        
        // Decodificar el JSON a un arreglo asociativo
     
        // Acceder al valor del campo 'uuid' dentro del nodo 'transactions'
        if (isset($jsonData['transactions'][0]['uuid'])) {
            $transactionUuid = $jsonData['transactions'][0]['uuid'];
            // Utiliza $transactionUuid según sea necesario (por ejemplo, imprímelo)
        }
        $client = new Client();

        $response = $client->request('POST', 'https://api.micuentaweb.pe/api-payment/V4/Transaction/Validate', [
            'auth' => ['89289758', 'testpassword_7vAtvN49E8Ad6e6ihMqIOvOHC6QV5YKmIXgxisMm0V7Eq'],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                "uuid" => $transactionUuid
            ]
        ]);

        // Obtener el cuerpo de la respuesta
        $body = $response->getBody()->getContents();

        // Devolver la respuesta de la API (puedes procesar $body según tus necesidades)
        return response()->json($body);
    }

    public function generaPdfPedido(Request $request){
        $pedido=Pedido::with('cliente.persona')->with('detalles.articulo')->with('almacen')->find($request->id);
        $pdf= Pdf::loadView('pedidoPdf',compact('pedido'));
        return $pdf->stream('invoice.pdf');
    }
}
