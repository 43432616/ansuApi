

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Nº</title>
    <style type="text/css">
        @page {
            margin: 0.5cm 0.5cm;

        }

        body {
            font-family: "verdana";
            font-size: 12px;
        }

        .cabecera {
            width: 100%;
        }

        .cabecera td {
            width: 33%;
            text-align: center;
        }

        .cabecera p {
            padding: 0;
            margin: 0;
        }

        .cabecera td:nth-child(1) {
            text-align: left;
        }

        .cabecera td:nth-child(3) {
            border: solid 1px #85929E;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
        }

        .cabecera td:nth-child(3) p {
            margin: 10px 0;
        }

        .datos {
            width: 100%;
            margin-top: 10px;
        }

        .datos p {
            margin: 5px 0;
        }

        .datos span {
            font-weight: bold;
            width: 70px;
            display: inline-block;
            line-height: 10px;
            padding-top: 2px;
        }

        .datos td {
            border: solid 1px #AEB6BF;
            padding: 5px;
        }

        .datos td:nth-child(1) {
            margin: 10px 0;
            width: 67%;
        }

        .productos {
            width: 100%;
            margin: 10px 0;
        }

        .productos td {
            border: 1px solid #ccc;
            padding: 7px 3px;
        }

        .productos thead td {

            text-align: center;
            background-color: #EAEDED;
            font-weight: bold;
        }

        .productos tfoot td {

            padding: 3px 3px;
        }

        .marcaagua {
            display: block;
            color: #F4F6F6;
            position: absolute;
            z-index: -10000;
            font-size: 150px;
            transform: rotate(-45deg);
            top: 150px;
            left: 10;
        }

        .fondo {
            background-color: #EAEDED;
        }

        .qrrr {
            display: block;
            float: left;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <table class="cabecera">
        <tr>
            <td>
                <img src="{{ public_path('storage/img/logo.jpg') }}" width=220>
            </td>
            <td>
                <p>ANSUR SHOP</p>
                <p>RUC:20610630431</p>
                <p>Arequipa-Arequipa-Arquipa</p>
                <p>Cel. 976 097 096</p>
            </td>
            <td>
                <p>RUC: 12345678912</p>
                <p>NOTA DE VENTA </p>
                <p>N°: F001 - {{str_pad($pedido->id, 8, "0", STR_PAD_LEFT)}}</p>
            </td>
        </tr>
    </table>
    <table class="datos" cellspacing="0">
        <tr class="row">
            <td>
                <p><span>Señor(es)</span> {{strtoupper($pedido->cliente->persona->apellidos)}}  {{strtoupper($pedido->cliente->persona->nombres)}}</p>
                <p><span>Dni/Ruc</span> {{$pedido->cliente->persona->numdoc}}</p>
                <p><span>Direccion</span> Jr. Fredi Aliaga 415</p>
            </td>
            <td>
               
                <p><span>Fecha</span> {{$pedido->fecha_pedido}}</p>
                <p><span>Moneda</span> Soles</p>
            </td>
        </tr>
    </table>
    <table class="productos" cellspacing="0">
        <thead>
            <tr>
                <td>ID</td>
                <td style="width:59%">Description</td>
                <td>Cant</td>
                <td>P.U</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
          @php

            $totalfactura =0;
            @endphp
            @foreach ($pedido->detalles as $deta)
            @php

            $costodeta = $deta->cantidad * $deta->costo_unitario;
            $totalfactura+=$costodeta;
            @endphp
            <tr>
                <td>{{$deta->id}}</td>
                <td>{{ $deta->articulo->nombre}} </td>
                <td>{{$deta->cantidad}}</td>
                <td>{{$deta->costo_unitario}}</td>
                <td>{{number_format($costodeta ,2)}}</td>
            </tr>
            @endforeach 

        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" rowspan="3">
                    <p>Son:</p>
                    <p>{{convertiraletras($totalfactura)}}</p>
                </td>
                <td class="fondo">Sub total</td>
                <td>{{number_format($totalfactura,2)}}</td>
            </tr>
            <tr>

                <td class="fondo">IGV 18%</td>
                <td>0.00</td>
            </tr>
            <tr>

                <td class="fondo">Total</td>
                <td>{{number_format($totalfactura,2)}}</td>
            </tr> 
        </tfoot>
    </table>
    <p>
    </p>
    <p>
    </p>
    <h1 class="marcaagua">
        PAGADO
    </h1>

    <div>
        <p>Estamos trabajando por un mejor servicio</p>
        
    </div>

    
</body>

</html>