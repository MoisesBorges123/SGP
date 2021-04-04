@extends("layouts.app")

@section('content')
    
    @include('layouts.headers.cards',["header"=>$header])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6 ">
                                <h2 class="mb-0">Painel Estacionamento</h2>                               
                            </div>                           
                           
                        </div>
                        
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="row">                                   
                                    <div class="col-12">
                                        <form>
                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <h3><b>ENTRADA</b></h3>
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Placa</label>
                                                    <input type="text" list='vehicles' class="form-control form-control-primary color-class form-control-uppercase placa" maxlength="10" name="placa_entrada" id="placa_entrada" placeholder="AAA-0000">
                                                    <datalist id="vehicles">{!! $vehicles !!}}</datalist>
                                                </div>                                        
                                                <div class="col-md-4"> 
                                                <button style="margin-top:26px;" class="btn btn-info" data-url="{{route('parking.store')}}" type="button" id="btn-entrar">Salvar</button>
                        
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-radio mt-4">
                                                        <div class="custom-control custom-radio mb-3 radio-inline" >
                                                            <input value="rotativo" name="modalidade" checked="checked" class="custom-control-input" id="rotativo" type="radio">
                                                            <label class="custom-control-label" for="rotativo">Rotativo</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-3 radio-inline">
                                                            <input  value="diaria" name="modalidade"  class="custom-control-input" id="diaria" type="radio">
                                                            <label class="custom-control-label" for="diaria">Diaria</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-3 radio-inline">
                                                            <input  value="pernoite" name="modalidade"  class="custom-control-input" id="pernoite" type="radio">
                                                            <label class="custom-control-label" for="pernoite">Pernoite</label>
                                                        </div>
                                                       
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-radio mt-4">
                                                        <div class="custom-control custom-radio mb-3 radio-inline" >
                                                            <input value="1" name="tipo_veiculo" checked="checked" class="custom-control-input" id="carro" type="radio">
                                                            <label class="custom-control-label" for="carro">Carro</label>
                                                        </div>
                                                        <div class="custom-control custom-radio mb-3 radio-inline">
                                                            <input  value="2" name="tipo_veiculo"  class="custom-control-input" id="moto" type="radio">
                                                            <label class="custom-control-label" for="moto">Moto</label>
                                                        </div>                                              
                                                       
                                                    </div>
                                                </div>                                     
                                            </div>
                                        </form>
                                    </div>
                                   
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class='text-center'>SAÍDA</h3>
                                            </div>
                                            <div class="col-8">
                                                <select class="form-control form-control-danger" id="placa_saida">
                                                    <option value=''>Selecione uma placa...</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button type='button' id='btn-pg-sair' class="btn btn-outline-primary">Pagar</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>                                
                            </div>
                            <div class="col-7">
                                    <h3 class='text-center mb-3 '>Carros Estacionados</h3>
                                    <table class="table align-items-center table-flush table-full tables table-responsive" id='minha_tabela'>
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Carro</th>                                    
                                                <th scope="col">Categoria</th>                                    
                                                <th scope="col">Entrada</th>
                                                <th scope="col">Valor</th>
                                                <th scope="col">Ações</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody id='tbody_minha_table'></tbody>
                                    </table>
                                
                            </>
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
    <script src="{{mix('admin/estacionamento/fluxo/js/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="fetch-notice" content="{{ route('notice-intentions.index') }}">  
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
    </style>
@endpush