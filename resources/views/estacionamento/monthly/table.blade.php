@extends("layouts.app")

@section('content')
    
    @include('layouts.headers.cards',["title"=>'Mensalistas'])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6">
                                <h3 class="mb-0">Mensalistas</h3>                               
                            </div>                            
                           
                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                    </div>
    
                    <div>
                        <table class="table align-items-center table-flush table-full" id='certidoesTable'>
                            <thead class="thead-light text-left">
                                <tr>
                                                                        
                                    <th scope="col">Responsável</th>                                    
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Placa</th>
                                    <th scope="col">Início</th>
                                    <th scope="col">Encerramento</th>
                                    <th scope="col">Temp. P/ Encer.</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class='text-left'>
                                
                                @foreach($dados as $dado)
                                    <tr>
                                        
                                        <td class="budget">
                                            <span data-tooltip="{{$dado['id']}}">{{$dado['responsavel']}}</span>
                                        </td>
                                        
                                        <td class="budget">
                                            <span>{{$dado['telefone']}}</span>
                                        </td>
                                        <td class="budget">
                                            <span data-tooltip="{{$dado['tipo_veiculo']}}">{{$dado['placa']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['inicio']}}</span>                        
                                        </td>                                        
                                        <td>
                                            <span>{{$dado['encerramento']}}</span>                        
                                        </td>                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="completion mr-2">{{$dado['intervalo']}}</span>
                                                <div>
                                                    <div class="progress">
                                                        <div class="progress-bar {{$dado['classe']}}" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: {{$dado['progresso']}}%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">                                                     
                                                    <a class="dropdown-item" id='btn-renovacao' href="{{route('monthly-pay.create',['tipo_veiculo'=>$dado['tipo_veiculo'],'placa'=>$dado['placa'],'owner'=>$dado['responsavel'],'date_end'=>$dado['encerramento'],'id_parking'=>$dado['id']])}}">Renovar</a>
                                                    <button class="dropdown-item print" data-link="{{route('monthly-pay.print',['id_parking'=>$dado['id']])}}">Imprimir</button>
                                                    <button class="dropdown-item btn-delete" data-link="{{route('monthly-pay.destroy',$dado['id'])}}">Excluir</button>
                                                </div>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach    
                            </tbody>
                        </table>
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
    
    <script src="{{mix('admin/estacionamento/monthly/js/table.js')}}"></script>
@endpush
@push('css')
    
   
    <!-- Main Style Css -->   
    <link rel="stylesheet" href="{{mix('admin/estacionamento/monthly/css/table.css')}}"/> 
    <meta name='printMonthly' content="http://192.168.0.21/estacionamento_catedral/print/mensalidade/PrintMonthly.php">

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush