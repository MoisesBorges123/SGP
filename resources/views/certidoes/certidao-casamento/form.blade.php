@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards',['header'=>$header])
    
    <div class="container-fluid mt--7">
     
        <div class="row mt-5">
            <div class="col-xl-7 mb-5 mb-xl-0">
      
                <div class="card shadow">
                  
                    <div class='card-header' style="border:0px;">
                        <div class="row align-items-center">
                            <div class="col">
                                @if(!empty($dados))
                                    <h3 class="mb-0">Editar Registro</h3>
                                @else
                                    <h3 class="mb-0">Registrar Casamento</h3>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    <div class='card-body'>
                        @if(!empty($dados))    
                            <form class="form-register" action="{{route('certidao-casamento.update',$dados['id'])}}" method="post" id='form-casamento'>
                            @method('PUT')
                        @else
                            <form class="form-register" action="{{route('certidao-casamento.store')}}" method="post" id='form-casamento'>
                        @endif
                                    
                        @csrf                            
                        @include('alerts.success')
                        @include('alerts.danger')
                        
                            
                                
                            <div class="row">                            
                                    <div class="col-12 {{ $errors->has('nome') ? ' has-danger' : '' }}">
                                        <label for="noivo" class="form-control-label">{{ __('Nome do Noivo') }}</label>
                                        <input class="form-control " type="text" placeholder="Nome do Noivo"  id="noivo" value="{{old('noivo') ?? $dados['noivo'] ?? ''}}" name="noivo">
                                        @include('alerts.feedback', ['field' => 'noivo'])
                                    </div> 
                                    <div class="col-12">
                                        <label for="noiva" class="form-control-label">Nome da Noiva</label>
                                        <input class="form-control" type="text" placeholder="Nome da Noiva"  id="noiva" name="noiva" value='{{old('noiva') ?? $dados['noiva'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'noiva'])
                                    </div>                              
                                    
                                    <div class="col-12">
                                    <label for="data_casamento" class="form-control-label">Data do Casamento</label>
                                        <input class="form-control" type="date"  id="data_casamento" name="data_casamento" value='{{old('data_casamento') ?? $dados['data_casamento'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'data_casamento'])
                                    </div> 
                                    <div class="col-12">
                                        <label for="celebrante" class="form-control-label">Celebrante</label>
                                        <input class="form-control" type="text" placeholder="Nome do Celebrante"  id="celebrante" name="celebrante" value='{{old('celebrante') ?? $dados['celebrante'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'celebrante'])
                                    </div>    
                                    <div class='col-12'>                                   
                                        <div class="form-group">
                                            <label for="local" class="form-control-label">Local do Casamento</label>
                                            <input class="form-control" type="text" placeholder="Nome do local do casamento"  id="local" name="local" value='{{old('local') ?? $dados['local'] ?? ''}}'>
                                        </div>                          
                                    </div>                          
                                    <div class='col-md-6 col-sm-12'>
                                        <div class="form-group">
                                            <label for="livro" class="form-control-label">Livro</label>
                                            <input class="form-control" type="number" id="livro" name="livro" value='{{old('livro') ?? $dados['livro'] ?? ''}}'>
                                        </div>                                                        
                                    </div>
                                    <div class='col-md-6 col-sm-12'>
                                        <div class="form-group">
                                            <label for="folha" class="form-control-label">Folha</label>
                                            <input class="form-control" type="text" maxlength="4" id="folha" name="folha" value='{{old('folha') ?? $dados['folha'] ?? ''}}'>
                                        </div>
                                    </div>
                                    <div class='col-12'>
                                        <div class='form-group'>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value='1' @if(!empty($dados['duvidoso']))checked="true" @endif  name='duvidoso' id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">
                                                    <b>Tive dificuldade para entender esse registro.</b>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                            
                            
                            
                            </div>                                     
                             
                               
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12 text-center">
                            <button class="btn btn-primary" type='submit'>
                                @if(empty($dados)) {{__('Salvar')}} @else {{__('Alterar')}} @endif
                            </button>
                            </div>
                        </div>
                    </div>
                    
                </form>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Ultimos cadastros</h3>
                            </div>
                            <div class="col text-right">
                            <a href="{{route('certidao-casamento.index')}}" class="btn btn-sm btn-primary">Ver Todos</a>
                            </div>
                        </div>
                    </div>
                    @if(!empty($ultimos))
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Noivo</th>
                                        <th scope="col">Noiva</th>
                                        <th scope="col">Data Casamento</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ultimos as $registro)
                                        <tr>
                                            <th scope="row">
                                                {{$registro['noivo']}}
                                            </th>
                                            <td>
                                                {{$registro['noiva']}}
                                            </td>
                                            <td>
                                                {{$registro['data_casamento']}}
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    @else
                    @endif
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
   
@endpush
@push('css')   
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{mix('admin/certidao-casamento/form.css')}}"/>
    

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush