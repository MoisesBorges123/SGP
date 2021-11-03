@extends("layouts.app")

@section('content')
    
    @include('layouts.headers.header',["title"=>'Histórico de caixa'])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6 ">
                                <h2 class="mb-0"></h2>                               
                            </div>                           
                           
                        </div>
                        
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-12">
                                    <h3 class='text-center mb-3 '>Caixa Detalhado</h3>
                                    <table class="table align-items-center table-flush table-full text-center" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Código</th>                                    
                                                <th scope="col">Valor</th>                                    
                                                <th scope="col">Descontos</th>
                                                <th scope="col">Resultado</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Horário</th>
                                                <th scope="col">Ações</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id='tbody_minha_table'>
                                            @foreach ($payments as $payment)
                                                
                                                <tr>
                                                    <td>{{$payment->id}}</td>
                                                    <td>R$ {{number_format($payment->value,2,',','.')}}</td>
                                                    <td>R$ {{number_format($payment->discount,2,',','.')}}</td>
                                                    <td>R$ {{number_format(($payment->value-$payment->discount),2,',','.')}}</td>
                                                    <td>{{$payment->modality}}</td>
                                                    <td>{{date('H:i:s',strtotime($payment->created_at))}}</td>
                                                    <td class='text-center'>
                                                        <span 
                                                        class='btn-details'
                                                        data-owner='{{$payment->park->vehicle_info->person_info->nome ?? 'Não Cadastrado'}}'
                                                        data-vehicle='{{$payment->park->vehicle_info->placa}}'                                                        
                                                        ><i class='fas fa-eye'></i></span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>
                    </div>
    
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')   
    <script src='{{mix('admin/estacionamento/cash-history/details.js')}}'></script>
@endpush
@push('css')
   <!-- <meta name="fetch-notice" content="{{ route('notice-intentions.index') }}">  
    <meta name='parking_index' content="{{route('parking.index')}}">
    <meta name='parking_delete' content="{{route('parking.delete')}}">
    <meta name='time_update' content="{{route('time.update')}}">
    <meta name='parkingOut_show' content="{{route('parking-out.show')}}">
    <meta name='parkingOut_store' content="{{route('parking-out.store')}}">
    <meta name='fetchPrice' content="{{route('table-price.fetch')}}">
    <meta name='parkingReportCashier' content="{{route('report.reportDaily')}}">
    <meta name='fetchHeader' content="{{route('parking.fetch.header')}}">
    <meta name='printOut' content="http://192.168.0.21/estacionamento_catedral/print/saida/PrintOut.php">
    <meta name='printIn' content="http://192.168.0.21/estacionamento_catedral/print/entrada/PrintIn.php">
    <meta name='printReportCashier' content="http://192.168.0.21/estacionamento_catedral/print/report/DayliCashier.php">
    <!-- Main Style Css -->    
    <link rel="stylesheet" href="{{mix('admin/estacionamento/fluxo/css/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
        .btn-details:hover{
            cursor: pointer;
        }
    </style>
@endpush