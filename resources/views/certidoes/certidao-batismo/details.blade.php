
@extends("layouts.app")

@section('content')
@include('layouts.headers.header', [
    'title' => __('Meu Batismo') . ' ',
    'description' => 'Batizado de '.$dados['crianca'],
    'class' => 'col-lg-7'
])
    
    <div class="container-fluid mt--7">
     
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h2 class="mb-0">Registro Completo</h2>
                                
                            </div>
                            <div class="col-3 text-right">
                            <a href="{{route('certidao-batismo.index')}}" class="btn btn-sm btn-primary"> 
                                <i class="ni ni-bold-left"></i> Voltar
                             </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class='row' id="dados">                            
                                    <div class="col-md-12">
                                        <label>Nome:</label>
                                        <span>{{$dados['crianca']}}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Nasceu em:</label>
                                        <span>{{$dados['nascimento']}}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Batizou em:</label>
                                        <span>{{$dados['batizado']}}</span>
                                    </div>
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Livro:</label>
                                        <span>{{$dados['batizado']}}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Pagina:</label>
                                        <span>{{$dados['batizado']}}</span>
                                    </div>
                                    <div class='col-md-12 subtitle'>
                                        <h4>Filho(a) de:</h4>
                                    </div>  
                                    <div class="col-md-12">
                                        <label>Pai:</label>
                                        <span>{{$dados['pai']}}</span>                        
                                    </div>
                                    <div class='col-12'>
                                        <label>Mãe:</label>
                                        <span>{{$dados['mae']}}</span>
                                    </div>
                                    <div class='col-md-12 subtitle'>
                                        <h4>Foram padrinhos:</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Padrinho:</label>
                                        <span>{{$dados['padrinho']}}</span>                        
                                    </div>
                                    <div class='col-md-12'>
                                        <label>Madrinha</label>
                                        <span>{{$dados['madrinha']}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">                                
                                <img src="{{asset('img/system/vetor_baptism.png')}}" alt="">                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-center" aria-label="...">
                            <button class='btn btn-primary'>Pagina do Livro</button>
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
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/opensans-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/roboto-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/jquery-ui.min.css')}}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('admin/form-steps/css/style.css')}}"/>
    <link rel="stylesheet" href="{{mix('admin/certidao-batismo/details.css')}}"/>
@endpush