
@extends("layouts.app")

@section('content')
@include('layouts.headers.header', [
    'title' => __('Meu Casamento') . ' ',
    'description' => 'Casamento de '.$dados['noivo'].' e '.$dados['noiva'],
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
                            <a href="{{route('certidao-casamento.index')}}" class="btn btn-sm btn-primary"> 
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
                                        <label>Noivo:</label>
                                        <span>{{$dados['noivo']}}</span>
                                    </div>                                   
                                    <div class="col-md-12">
                                        <label>Noiva:</label>
                                        <span>{{$dados['noiva']}}</span>
                                    </div>                                   
                                    <div class="col-md-4 col-sm-6">
                                        <label>Casaram-se em:</label>
                                        <span>{{$dados['data_casamento']}}</span>
                                    </div>
                                    <div class="col-md-12"></div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Livro:</label>
                                        <span>{{$dados['livro']}}</span>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <label>Pagina:</label>
                                        <span>{{$dados['pagina']}}</span>
                                    </div>
                                    <div class='col-md-12 subtitle'>
                                        <h4>Celebrante:</h4>
                                    </div>  
                                    <div class="col-md-12">
                                        <label>Bispo/Padre/Diácono:</label>
                                        <span>{{$dados['celebrante']}}</span>                        
                                    </div>
                                                                   
                                </div>
                            </div>
                            <div class="col-md-4">                                
                                <img src="{{asset('img/system/vetor_married.png')}}" alt="">                                
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
	<script src="{{mix('js/certidao/certidao-casamento/table.js')}}"></script>
@endpush
@push('css')    
    <link rel="stylesheet" href="{{mix('admin/certidao-casamento/details.css')}}"/>
@endpush