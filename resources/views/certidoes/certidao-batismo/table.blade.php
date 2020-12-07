@extends("layouts.app")

@section('content')
    @include('layouts.headers.cards',["header"=>$header])
    
    <div class="container-fluid mt--7">
     
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center ">
                            <div class="col-8">
                                <h3 class="mb-0">Batizados Registrados</h3>
                                
                            </div>
                            <div class="col-4 text-right">
                            <a href="{{route('certidao-batismo.create')}}" class="btn btn-sm btn-primary">Registrar Batizado</a>
                            </div>
                        </div>
                    </div>
                <div class="row">                    
                    <div class="col-12">
                        <table class="table align-items-center table-flush" id='certidoesTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Pai</th>
                                    <th scope="col">Mãe</th>
                                    <th scope="col">Padrinho</th>
                                    <th scope="col">Madrinha</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dados as $dado)
                                    <tr>
                                        <th scope="row">                                           
                                        <span class="name mb-0 text-sm">{{$dado['crianca']}}</span>                                                
                                        </th>
                                        <td class="budget">
                                            <span>{{$dado['pai']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['mae']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['padrinho']}}</span>                        
                                        </td>
                                        <td>
                                            <span>{{$dado['madrinha']}}</span>
                                        </td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"  href="{{route('certidao-batismo.show',$dado['id'])}}">Registro Completo</a>
                                                <button class="dropdown-item btn-emitir" data-url_notitfy="{{route('notificacao-certidao-batismo.store')}}"  data-url="{{route('certidao.emitir',['batizado',$dado['id']])}}">Emitir</button>
                                                    <a class="dropdown-item" href="#">Registrar Notificação</a>
                                                <a class="dropdown-item" href="{{route('certidao-batismo.edit',$dado['id'])}}">Editar</a>
                                                <a class="dropdown-item btn-delete" data-url="{{route('certidao-batismo.destroy',$dado['id'])}}" href="#">Excluir</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach    
                            </tbody>
                        </table>
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
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{asset('admin/form-steps/js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/jquery.steps.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/jquery-ui.min.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/main.js')}}"></script>
	<script src="{{asset('admin/form-steps/js/main.js')}}"></script>
    <script src="{{mix('js/certidao/certidao-batismo/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="url-search-finalidades" content="{{ route('finalidades-certidao.index') }}">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/opensans-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/roboto-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/jquery-ui.min.css')}}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('admin/form-steps/css/style.css')}}"/>
    <link rel="stylesheet" href="{{mix('admin/certidao-batismo/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush