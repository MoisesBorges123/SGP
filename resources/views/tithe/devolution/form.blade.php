
@extends('layouts.app')

@section('content')
    @include('layouts.headers.header',[$title='Minha Ficha'])

    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow" id='ficha'>
                    <div class="card-header border-0 text-white">
                        <div class="row ">
                            <div class="col-10">
                                <h2 class="mb-0 text-white">{{$dados['dizimista']['nome']}}</h2>                               
                            </div>
                            <div class='col-2'>
                                <a href='{{route('tither.edit',$dados['dizimista']['id'])}}' class="btn btn-primary">Editar</a>
                            </div>                           
                            <div class="col-12">
                                <span id="titulo-nascimento">Nascido(a) em {{date('d/m/Y',strtotime($dados['dizimista']['data_nascimento']))}}</span>
                                <span>Dízimista desde {{date('d/m/Y',strtotime($dados['dizimista']['data_cadastro']))}}</span>
                            </div>
                            
                            <div class="col-12">
                                <span id="titulo-telefone">Telefone: {{$dados['dizimista']['telefone']}}</span>                    
                                <span> / E-mail: {{$dados['dizimista']['email']}}</span>                                
                            </div>                            
                            <div class="col-md-12">
                                <span id="titulo-endereco">{{$dados['dizimista']['rua']}}, nº {{$dados['dizimista']['numero']}}, {{$dados['dizimista']['apartamento']}} {{$dados['dizimista']['bairro']}}, cep: {{$dados['dizimista']['cep']}} {{$dados['dizimista']['cidade']}}/ {{$dados['dizimista']['estado']}}</span>                    
                            </div>
                            <div class="col-12">
                                <h3 class='text-white'>Registro: {{$dados['dizimista']['situacao']}}</h3>
                            </div>
                        </div>
                        
                    </div>
                   
                        
  
      
        <div class="card-body">
            @if($dados['dizimista']['situacao']=='Ativo')
            <div class="table-responsive">
                <table class="table table-striped table-flush table-hover" id="devolucoes">
                    <thead style="font-size: 14px;">
                        <tr>
                            <th>Código</th>                            
                            <th>Ano</th>
                            <th>Janeiro</th>
                            <th>Fevereiro</th>
                            <th>Março</th>
                            <th>Abril</th>
                            <th>Maio</th>
                            <th>Junho</th>
                            <th>Julho</th>
                            <th>Agosto</th>
                            <th>Setembro</th>
                            <th>Outubro</th>
                            <th>Novembro</th>
                            <th>Dezembro</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 12px;">
                        @foreach($dados['devolution']['tabela_devolucoes'] as $anos)
                        <tr>
                            
                            @foreach($anos as $mes)
                            <td class="tabledit-view-mode"><span class="tabledit-span"> {{$mes}}</span>
                                @if($mes=='R$ 0,00')
                                    <input class="tabledit-input form-control input-sm money" type="text" name="{{$mes}}" value=''>
                                @else
                                    <input class="tabledit-input form-control input-sm money" type="text" name="{{$mes}}" value='{{$mes}}'>
                                @endif
                                
                            </td>
                            @endforeach
                        <tr>
                        @endforeach                    
                        
                    </tbody>
                </table>
            </div>
            @else
            <div class='row'>
                <div class='col-md-6'>
                    <p style='font-size: 30px;' >O cadastro foi <b>excluido!</b> &nbsp;&nbsp;<i style='font-size: 100px;' class="ion-sad" ></i></p>
                    
                </div>
            </div>
            @endif
           <!-- <button type="button" class="btn btn-primary waves-effect waves-light add" onclick="add_year();">Adicionar Linha
            </button>-->
        </div>

    <!--Edit With Click card end -->
    
                    

                    
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
@push('css')
    <meta name='url-save-devolution' content="{{route('devolution.save',$dados['dizimista']['id'])}}"/>
    <link rel="stylesheet" href="{{mix('admin/tithe/devolution/css/form.css')}}"/>
@endpush
@push('js')
    <script src="{{mix('admin/tithe/devolution/js/form.js')}}"></script>
@endpush