@extends("layouts.app")

@section('content')
    @include('layouts.headers.header',["title"=>'Meus Livros'])
    
    <div class="container-fluid mt--7">
     
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center ">
                            <div class='col-8 text-center'>                                
                                <h2>Livros Cadastrados</h2>
                            </div>
                            <div class="col-4 text-right">
                                <button id='btn-add-book' class="btn btn-sm btn-primary">Novo Livro</button>
                            </div>
                        </div>
                    </div>
                    
                  
    
                    <div>
                        <table class="table align-items-center table-flush" id='bookTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Numero</th>
                                    <th scope="col">Período</th>
                                    <th scope="col">Sacramento</th>
                                    <th scope="col">Observações</th>                                    
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($livros))
                                    @foreach($livros as $dado)
                                        <tr>
                                            <td>{{str_pad($dado->numero,4,'0',STR_PAD_LEFT).substr($dado->nome_sacramento,0,1)}}</td>
                                            <td>{{date('d/m/Y',strtotime($dado->data_inicio))}} a {{date('d/m/Y',strtotime($dado->data_fim))}}</td>                                            
                                            <td>{{$dado->nome_sacramento}}</td>
                                            <td>{{$dado->observacao ?? "Sem comentários."}}</td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item text-default"  href="{{route('livros.show',$dado->id)}}">
                                                        <i class='icones icones-eye-19 icones-16'></i>Detalhes
                                                        </a>
                                                        <button 
                                                            class="dropdown-item btn-excluir" 
                                                            data-numeroLivro='{{str_pad($dado->numero,4,'0',STR_PAD_LEFT).substr($dado->nome_sacramento,0,1)}}' 
                                                            data-url="{{ route('livros.destroy',$dado->id) }}"
                                                            data-livro='{{$dado->id}}'  
                                                            href="#"
                                                        >
                                                           <i class='icones icones-ic_delete_forever_48px icones-16'></i> Excluir
                                                        </button>
                                                        <a class="dropdown-item" href="{{route('paginas.index','livro='.$dado->id)}}">
                                                            <i class='icones icones-ic_backup_48px icones-16'></i> Fazer Upload
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