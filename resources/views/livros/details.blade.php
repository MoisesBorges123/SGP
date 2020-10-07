@php
    /**
     * Variaveis
     * $dados->numero  
     * 
     */

@endphp
@extends("layouts.app")

@section('content')
    @include('layouts.headers.header',["title"=>'Livro '.$dados['livro']->numero])
    
    <div class="container-fluid mt--7">
     
        <!--Cabeçalho -->
       <div class='row'>
           <div class="col-5">
               <div class="card border-0">
                   <div>
                       <div>
                           <div class='card bg-gradient-primary text-muted mb-0'>
                               <div class='text-white'>
                                   <div class="row">
                                       <div class="col-4 m-auto pl-4">
                                           <img class='img-full' src="{{asset('img/system/icons/livro.svg')}}" alt="">                               
                                       </div>
                                       <div class="col-8 m-auto">
                                           <h1 class='text-uppercase'>Detalhes</h1>
                                           <div>
                                               <span>Total paginas: </span>
                                               <span>
                                                   <b>{{$dados['totalPaginas']}}</b>
                                               </span> 
                                               <div>
                                                   <span>Espaço em disco:</span>
                                                   <span>
                                                       <b>{{$dados['espacoDisco']}}</b> 
                                                   </span>
                                               </div>     
                                               <div>
                                                   <span>Fotos Cadastradas</span>
                                                   <span>
                                                       <b>{{$dados['fotosCadastradas']}}</b> 
                                                   </span>
                                               </div>    
       
                                           </div>
                                       </div>
                                       
                                   </div>
                               </div>
                               
                           </div>                                 
                           
                       </div>                 
                   </div>
               </div>
           </div>
           <div class="col-5">
               <div class="card border-0">
                   <div>
                       <div>
                           <div class='card bg-gradient-info text-muted mb-0 border-0'>
                               <a href="{{route('paginas.index','livro='.$dados['livro']->id)}}" class='text-white'>
                                   <div class="row">
                                       <div class="col-4 m-auto pl-4 border-">
                                           <img class='img-full' src="{{asset('img/system/icons/ic_backup_48px.svg')}}" alt="">                               
                                       </div>
                                       <div class="col-8 m-auto">
                                           <h1 class='text-uppercase'>Fazer Upload!</h1>
                                           <div>
                                               <p>Clique aqui para adicionar mais fotos ao livro.</p>
       
                                           </div>
                                       </div>
                                       
                                   </div>
                               </a>
                               
                           </div>                                 
                           
                       </div>                 
                   </div>
               </div>               
           </div>

       </div>
        <!--Fim Cabeçalho -->     
        <div class="row mt-4">
            <div class="col">
                <div class="card shadow">
                    
                  
    
                    <div>
                        <div class="row">
                            <div class="col-9 text-center mt-5 mb-5">
                                <h2>Lista de fotos já registradas</h2>
                            </div>
                            <div class="col-3 text-right mt-3 pr-1">
                                <a href={{route('livros.index')}} class="btn btn-sm btn-primary"> 
                                    <div>
                                        <i class='ni ni-bold-left'></i>
                                        <span>Voltar</span>
                                    </div>                                    
                                </a>
                            </div>
                        </div>
                        <table class="table align-items-center table-flush" id='bookTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Arquivo</th>
                                    <th scope="col">Tamanho</th>
                                    <th scope="col">Página</th>                                    
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($dados['fotos']))
                                    @foreach($dados['fotos'] as $dado)
                                        <tr>
                                            <td>{{$dado->foto}}</td>
                                            <td>{{number_format($dado->tamanho/1048576,2,'.',',')}}MB</td>                                            
                                            <td>{{$dado->nome_pagina}}</td>                                            
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                                                        <a class="dropdown-item text-default"  href="#">
                                                            <span class='icones icones-eye-19 icones-16'></span> 
                                                            <span>Visualizar</span>
                                                        </a>
                                                        <a class="dropdown-item text-default" href="#">
                                                            <span class='icones icones-ic_delete_forever_48px icones-16'></span>Excluir
                                                        </a>                                                                                                        
                                                    
                                                    </div>
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
    <script src="{{mix('admin/livros/js/table.js')}}"></script>    
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
    <link rel="stylesheet" href="{{mix('admin/livros/css/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush