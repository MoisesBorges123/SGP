@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>'Novo Mensalista',])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    @if(empty($dados))
                        <form action="{{route('monthly.store')}}" id='form_monthly' method="post" >
                       
                    @else
                        <form action="{{route('monthly.update',$dados->id)}}" method="post" >
                        @method('PUT')
                        

                    @endif
                    @csrf
                        <div class='card-header text-center'>
                            @if(!empty($dados))
                                <h3>Editar cadastro de Mensalista</h3>
                            @else
                                <h3>Insira abaixo os dados do novo mensalista</h3>
                            @endif
                            <p>Os campos com * são de preenchimento obrigatório.</p>
                        </div>
                        <div class='card-body'>                           
                            <div class='row mt-3'>
                                <div class="col-12">
                                    <label for="name"><b>*Nome</b></label>
                                    <input type="text" required name='nome' id='name' placeholder="Nome completo" class='form-control' value="{{$dados->nome ?? ''}}">
                                </div>
                                
                                <div class="col-6">
                                    <label for="phone"><b>*Telefone</b></label>
                                    <input type="text" required v-mask="['(##) ####-####', '(##) #####-####']" name='phone' placeholder="(00) 0000-0000" id='phone' class='form-control' value="{{$dados->telefone ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="email">E-mail</label>
                                    <input type="email" name='email' id='email' class='form-control' value="{{$dados->email ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="placa">*Veículo (PLACA)</label>
                                    <input type="text" required name='placa' class='form-control placa' value="{{$dados->placa ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label>Categoria</label>
                                    <div class="form-radio mt-2">
                                        <div class="custom-control custom-radio mb-3 radio-inline" >
                                            <input value="1" name="tipo_veiculo"  class="custom-control-input" id="carro" type="radio">
                                            <label class="custom-control-label" for="carro">Carro</label>
                                        </div>
                                        <div class="custom-control custom-radio mb-3 radio-inline">
                                            <input  value="2" name="tipo_veiculo"  class="custom-control-input" id="moto" type="radio">
                                            <label class="custom-control-label" for="moto">Moto</label>
                                        </div>  
                                    </div>
                                </div> 
                                
                                <div class="col-6">                                    
                                    <label for="valor">Valor</label>
                                    <input type="text" name='valor' id='id_valor' class='form-control' disabled='true' value="{{$dados->valor ?? ''}}">                                    
                                    <input type="hidden" name='preco' id='id_preco' value="{{$dados->valor ?? ''}}">                                    
                                </div>
                                <div class="col-6">
                                    <label for="valor">Desconto</label>
                                    <input type="text" name='discount' id='id_desconto' class='form-control money2' value="{{$dados->valor ?? ''}}">
                                </div>
                                <!-- Campo apenas informativo para o usuário -->
                                <div class="col-6 valor_pagar">
                                    <label for="valor">Valor a Pagar</label>
                                    <input type="text" name='total' id='id_total' class='form-control' disabled='true' value="{{$dados->valor ?? ''}}">
                                </div>
                                <div class="col-6 dinheiro">
                                    <label for="id_cash">Dinheiro</label>
                                    <input type="text" name='cash' id='id_pago' class='form-control money2'  value="{{$dados->money ?? ''}}">
                                    <input type='hidden' name='table_price' id='id_table_price'>
                                </div>
                                <div class="col-12  justificativa">
                                    <label for="valor">*Justificativa</label>
                                    <textarea name='justify' required id='id_justificativa' rows='5' class='form-control'></textarea>
                                </div>
                                <div class="col-12">                                    
                                    <label for="troco">Troco</label>
                                    <input type="text" name='troco' id='id_troco' class='form-control heading-title text-warning' disabled='true' value="{{$dados->valor ?? ''}}">                                    
                                </div>
                            </div>
                    
                        </div>
                        <div class='card-footer justify-content-center text-center'>
                            @if(!empty($dados))
                                <a class="btn btn-primary text-center" href='{{url()->previous()}}'>Voltar</a>
                                <button class="btn btn-default text-center" type='submit'>Salvar Alterações</button>
                            @else
                                <button class="btn btn-primary text-center pagar" type='button'>Pagar e salvar</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{mix('admin/estacionamento/monthly/css/form.css')}}"/>
    <meta name='fetchPrice' content="{{route('table-price.fetch')}}">
    <meta name='openGave' content="http://192.168.0.21/estacionamento_catedral/print/opengave/opening.php">
@endpush
@push('js')
    <script src="{{mix('admin/estacionamento/monthly/js/form.js')}}"></script>
    @if(!empty($dados))
        <script>
            $(document).ready(function(){
                
                $('#search_cep').trigger('click');
            });
        </script>
    @endif
@endpush