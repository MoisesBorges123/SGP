@extends("layouts.app")

@section('content')
    @include('layouts.headers.header',["title"=>'Upload de Imagem'])
    
    <div class="container-fluid mt--7">
     
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center ">
                            <div class='col-8 text-center'>                                
                            <h2>1-Escolha uma <b>página</b> para fazer upload</h2>
                            </div>
                           
                        </div>
                    </div>
                    
                  
    
                    <div>
                        <table class="table align-items-center table-flush" id='bookTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Numero</th>
                                    <th scope="col">Nº Fotos</th>
                                    <th scope="col">Tamanho (Mb)</th>
                                    <th scope="col">Observações</th>                                    
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($dados))
                                    @foreach($dados as $pagina)
                                        <tr>
                                            <td>{{$pagina['pagina']}}</td>
                                            <td>{{$pagina['qtdeFotos']}}</td>                                            
                                            <td>{{number_format($pagina['tamanho']/1048576,2,'.',',')}}MB</td>
                                            <td>{{$pagina['observacao'] ?? "Sem comentários."}}</td>
                                            <td>
                                                <div class=''>
                                                    @if(!empty(request()->route('excluir')))
                                                        <a href="{{route('upload-livros.create','pagina='.$pagina['id'].'&excluir=1')}}" class="btn btn-primary">
                                                                Upload <i class='ni ni-bold-right'></i>
                                                        </a>
                                                    @else
                                                        <a href="{{route('upload-livros.create','pagina='.$pagina['id'])}}" class="btn btn-primary">
                                                                Upload <i class='ni ni-bold-right'></i>
                                                        </a>
                                                @endif

                                                </div>
                                            </td>
                                        </tr>  
                                    @endforeach
                                @endif                                
                            </tbody>
                        </table>
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
    <script src="{{mix('admin/livros/paginas/js/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="url-'index'-book" content="{{ route('livros.index') }}">
    <meta name="url-store-book" content="{{ route('livros.store') }}">
    
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/opensans-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/roboto-font.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
    <!-- datepicker -->
    <link rel="stylesheet" type="text/css" href="{{asset('admin/form-steps/css/jquery-ui.min.css')}}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('admin/form-steps/css/style.css')}}"/>
    <link rel="stylesheet" href="{{mix('admin/livros/paginas/css/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush