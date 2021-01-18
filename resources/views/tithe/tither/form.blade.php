@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>$title,])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    @if(empty($dados))
                        <form action="{{route('tither.store')}}" method="post" >
                       
                    @else
                        <form action="{{route('tither.update',$dados->id)}}" method="post" >
                        @method('PUT')
                        

                    @endif
                    @csrf
                        <div class='card-header text-center'>
                            @if(!empty($dados))
                                <h3>Editar Ficha de dizimista</h3>
                            @else
                                <h3>Insira abaixo os dados do novo dizimista</h3>
                            @endif
                            <p>Os campos com * são de preenchimento obrigatório.</p>
                        </div>
                        <div class='card-body'>                           
                            <div class='row mt-3'>
                                <div class="col-12">
                                    <label for="name"><b>*Nome</b></label>
                                    <input type="text" name='nome' id='name' placeholder="Nome completo" class='form-control' value="{{$dados->nome ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="birthday">Data Nascimento</label>
                                    <input type="date" name='data_nascimento' id='birthday' class='form-control' value="{{$dados->data_nascimento ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="phone"><b>*Telefone</b></label>
                                    <input type="text" v-mask="['(##) ####-####', '(##) #####-####']" name='telefone' placeholder="(00) 0000-0000" id='phone' class='form-control' value="{{$dados->telefone ?? ''}}">
                                </div>
                                <div class="col-12">
                                    <label for="email">E-mail</label>
                                    <input type="email" name='email' id='email' class='form-control' value="{{$dados->email ?? ''}}">
                                </div>
                                <div class="col-8">
                                    <label>CEP</label>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <input type="text" class="form-control" v-mask="[' #####-###']" placeholder="CEP" name='cep' id='cep' value="{{$dados->cep ?? ''}}">
                                        <div class="input-group-append" data-url='{{route('search_cep')}}' id='search_cep'>
                                            <a  class="input-group-text">
                                                <i class="fas fa-search" id='icon_busca_cep'></i>&nbsp;
                                                <i>Buscar</i>
                                            </a>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <label for="street">Rua/Avenida/Travessa</label>                                
                                    <input type="text" class="form-control" name='rua' id='street' value="{{$dados->rua ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="neighborood">Bairro</label>                                
                                    <input type="text" class="form-control" name='bairro' id='neighborood' value="{{$dados->bairro ?? ''}}">
                                </div>
                                <div class="col-3">
                                    <label for="number">Número</label>                                
                                    <input type="text" class="form-control" name='numero' id='number' value="{{$dados->numero ?? ''}}">
                                </div>
                                <div class="col-3">
                                    <label for="number">APTO</label>                                
                                    <input type="text" class="form-control" name='apartamento' id='apto' value="{{$dados->apartamento ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="city">Cidade</label>                                
                                    <input type="text" class="form-control" name='cidade' id='city' value="{{$dados->cidade ?? ''}}">
                                </div>
                                <div class="col-6">
                                    <label for="state">Estado</label>                                
                                    <input type="text" class="form-control" name='estado' id='state' value="{{$dados->nome_estado ?? ''}}">
                                    <input type="hidden" name='ibge' id='ibge' value="{{$dados->ibge ?? ''}}">
                                    <input type="hidden" name='dd_local' id='dd_local' value="{{$dados->dd_local ?? ''}}">                                    
                                    <input type="hidden" name='complemento' id='complement' value="{{$dados->complement1 ?? ''}}">
                                </div>
                                <div class="col-12">
                                    <label for="complemento2">Complemento</label>
                                    <textarea name="complemento2" class='form-control' placeholder="Informe algum ponto de referencia ou informação adicional" id="complement" cols="12" rows="10">{!! $dados->complement2  ?? '' !!}</textarea>
                                </div>
                                

                            </div>
                    
                        </div>
                        <div class='card-footer justify-content-center text-center'>
                            @if(!empty($dados))
                                <a class="btn btn-primary text-center" href='{{url()->previous()}}'>Voltar</a>
                                <button class="btn btn-default text-center" type='submit'>Salvar Alterações</button>
                            @else
                                <button class="btn btn-primary text-center" type='submit'>Salvar</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{mix('admin/tithe/tither/css/form.css')}}"/>
@endpush
@push('js')
    <script src="{{mix('admin/tithe/tither/js/form.js')}}"></script>
    @if(!empty($dados))
        <script>
            $(document).ready(function(){
                
                $('#search_cep').trigger('click');
            });
        </script>
    @endif
@endpush