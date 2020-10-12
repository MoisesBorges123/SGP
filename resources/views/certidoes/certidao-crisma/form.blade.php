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
                                    <h3 class="mb-0">Registrar Crisma</h3>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    <div class='card-body'>
                        @if(!empty($dados))    
                            <form class="form-register" action="{{route('certidao-crisma.update',$dados['id'])}}" method="post" id='form-crisma'>
                            @method('PUT')
                        @else
                            <form class="form-register" action="{{route('certidao-crisma.store')}}" method="post" id='form-crisma'>
                        @endif
                                    
                        @csrf                            
                        @include('alerts.success')
                        @include('alerts.danger')
                        
                            
                                
                            <div class="row">                            
                                    <div class="col-12 {{ $errors->has('nome') ? ' has-danger' : '' }}">
                                        <label for="crismando" class="form-control-label">{{ __('Nome do Crismando') }}</label>
                                        <input class="form-control " type="text" placeholder="Nome do Crismando"  id="crianca" value="{{old('crismando') ?? $dados['crismando'] ?? ''}}" name="crismando">
                                        @include('alerts.feedback', ['field' => 'crismando'])
                                    </div> 
                                    
                                    <div class="col-12">
                                    <label for="data_crisma" class="form-control-label">Data da Crisma</label>
                                        <input class="form-control" type="date"  id="data_crisma" name="data_crisma" value='{{old('data_crisma') ?? $dados['data_crisma'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'data_crisma'])
                                    </div> 
                                    <div class="col-12">
                                        <label for="pai" class="form-control-label">Nome do Pai</label>
                                        <input class="form-control" type="text" placeholder="Nome da Pai"  id="pai" name="pai" value='{{old('pai') ?? $dados['pai'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'pai'])
                                    </div>                              
                                    <div class="col-12">
                                        <label for="mae" class="form-control-label">Nome da Mãe</label>
                                        <input class="form-control" type="text" placeholder="Nome da Mãe"  id="mae" name="mae" value='{{old('mae') ?? $dados['mae'] ?? ''}}'>
                                        @include('alerts.feedback', ['field' => 'pai'])
                                    </div>    
                                    <div class='col-12'>                                   
                                        <div class="form-group">
                                            <label for="padrinho" class="form-control-label">Nome do Padrinho/Madrinha</label>
                                            <input class="form-control" type="text" placeholder="Nome do Padrinho"  id="padrinho" name="padrinho" value='{{old('padrinho') ?? $dados['padrinho'] ?? ''}}'>
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
                                <button class="btn btn-primary" type='submit'>Salvar</button>
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
                            <a href="{{route('certidao-batismo.index')}}" class="btn btn-sm btn-primary">Ver Todos</a>
                            </div>
                        </div>
                    </div>
                    @if(!empty($ultimos))
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Criança</th>
                                        <th scope="col">Pai</th>
                                        <th scope="col">Mãe</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ultimos as $registro)
                                        <tr>
                                            <th scope="row">
                                                {{$registro['crianca']}}
                                            </th>
                                            <td>
                                                {{$registro['pai']}}
                                            </td>
                                            <td>
                                                {{$registro['mae']}}
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
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{asset('admin/form-steps/js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/jquery.steps.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/main.js')}}"></script>
@endpush
@push('css')
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/opensans-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/roboto-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/jquery-ui.min.css')}}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{mix('admin/certidao-batismo/form.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/form-steps/css/style.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush