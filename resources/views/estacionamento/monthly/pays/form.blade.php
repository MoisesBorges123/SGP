
@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>'Renovar Mensalidade'])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    @if(empty($dados))
                        <form action="{{route('monthly-pay.store')}}" method="post" >
                       
                    @else
                        <form action="{{route('monthly-pay.update',$dados['id'] ?? '')}}" method="post" >
                        @method('PUT')
                        

                    @endif
                    @csrf
                        <div class='card-header text-center'>                       
                            <h3>Renovar Mensalidade</h3>
                            <p>Os campos com * são de preenchimento obrigatório.</p>
                        </div>
                        <div class='card-body'>                           
                            <div class='row mt-3'>
                                @if(!empty($dados))
                                <div class="col-12 text-center">
                                    <h2 class='h1'>Veículo: {{$dados['placa']}}</h2>
                                </div>  
                                <div class="col-12 text-center">
                                    <h3><b>{{$dados['owner']}}</b></h3>
                                </div>
                                @else
                                <div class='col-12 text-center mb-5'>
                                    <label>Placa</label>&nbsp;&nbsp;
                                    <select class="js-example-basic-single" name="placa" id='id_placa' data-link='{{route('monthly-pay.show','')}}'>
                                        <option value=''>Selecione uma placa</option>
                                       {!! $option !!}
                                    </select>
                                </div>
                                @endif
                                
                                <div class="col-12">
                                    <label>Categoria</label>
                                    <div class="form-radio mt-2">
                                        <div class="custom-control custom-radio mb-3 radio-inline" >
                                            <input value="1" name="tipo_veiculo" disabled='true'
                                            @if(!empty($dados['tipo_veiculo']))
                                                @if($dados['tipo_veiculo']=='Carro')
                                                    checked = "true"    
                                                @endif                                                                                        
                                            @endif
                                              class="custom-control-input" id="carro" type="radio">
                                            <label class="custom-control-label" for="carro">Carro</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3 radio-inline">
                                            <input  value="2" name="tipo_veiculo"  class="custom-control-input" id="moto" type="radio" disabled='true' 
                                            @if(!empty($dados['tipo_veiculo']))
                                                @if($dados['tipo_veiculo']=='Moto')
                                                    checked = "true" 
                                                @endif                                                               
                                            @endif 
                                            >
                                            <label class="custom-control-label" for="moto">Moto</label>
                                        </div>  
                                    </div>
                                </div> 
                                
                                <div class="col-6">                                    
                                    <label for="valor">Valor</label>
                                    <input type="text" name='valor' id='id_valor' class='form-control' disabled='true' value="{{$dados['valor'] ?? ''}}">                                    
                                </div>
                                <div class="col-6">
                                    <label for="valor">Desconto</label>
                                    <input type="text" name='discount' id='id_desconto' class='form-control money2' value="{{$dados['discount'] ?? ''}}">
                                </div>
                                <!-- Campo apenas informativo para o usuário -->
                                <div class="col-6 valor_pagar">
                                    <label for="valor">Valor a Pagar</label>
                                    <input type="text" name='total' id='id_total' class='form-control' disabled='true' value="{{$dados['valor_pagar'] ?? ''}}">
                                </div>
                                <div class="col-6 dinheiro">
                                    <label for="id_cash">Dinheiro</label>
                                    <input type="text" name='cash' id='id_pago' class='form-control money2'  value="{{$dados->money ?? ''}}">
                                    <input type='hidden' name='table_price' id='id_table_price'>
                                </div>
                                <div class="col-12  justificativa">
                                    <label for="valor">*Justificativa</label>
                                    <textarea name='justify' required id='id_justificativa' rows='5' class='form-control'>{{$dados['justify'] ?? ''}}</textarea>
                                </div>
                                <div class="col-12">                                    
                                    <label for="troco">Troco</label>
                                    <input type="text" name='troco' id='id_troco' class='form-control heading-title text-warning' disabled='true' value="{{$dados->valor ?? ''}}">                                    
                                    <input type='hidden' name='parking_id' id='id_parking'>
                                </div>
                            </div>
                    
                        </div>
                        <div class='card-footer justify-content-center text-center'>
                            @if(!empty($dados))
                                <a class="btn btn-primary text-center" href='{{url()->previous()}}'>Voltar</a>
                                <button class="btn btn-default text-center" type='submit'>Salvar Alterações</button>
                            @else
                                <button class="btn btn-primary text-center" type='submit'>Renovar !!</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{mix('admin/estacionamento/monthly/renew/css/form.css')}}"/>
    <meta name='fetchPrice' content="{{route('table-price.fetch')}}">
@endpush
@push('js')
    <script src="{{mix('admin/estacionamento/monthly/renew/js/form.js')}}"></script>
    @if(!empty($dados))
        <script>
            $(document).ready(function(){
                
                $('#search_cep').trigger('click');
            });
        </script>
    @endif
@endpush