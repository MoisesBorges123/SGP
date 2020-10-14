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
                                <h3 class="mb-0">Casamentos Registradas</h3>
                                
                            </div>
                            <div class="col-4 text-right">
                            <a href="{{route('certidao-casamento.create')}}" class="btn btn-sm btn-primary">Registrar Crisma</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                    </div>
    
                    <div>
                        <table class="table align-items-center table-flush" id='certidoesTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Noivo</th>
                                    <th scope="col">Noiva</th>
                                    <th scope="col">Data do Casamento</th>
                                    <th scope="col">Celebrante</th>                                                                        
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dados as $dado)
                           
                                    <tr>
                                        <th scope="row">                                           
                                        <span class="name mb-0 text-sm">{{$dado['noivo']}}</span>                                                
                                        </th>
                                        <td class="budget">
                                            <span>{{$dado['noiva']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['data_casamento']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['celebrante']}}</span>                        
                                        </td>                                       
                                        
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                   
                                                    <a class="dropdown-item"  href="{{route('certidao-casamento.show',$dado['id'])}}">Registro Completo</a>
                                                    <a class="dropdown-item btn-emitir" href="{{route('certidao-casamento.export',$dado['id'])}}">Emitir</a>                                                    
                                                    <a class="dropdown-item" href="{{route('certidao-casamento.edit',$dado['id'])}}">Editar</a>
                                                    <a class="dropdown-item btn-delete" data-url="{{route('certidao-casamento.destroy',$dado['id'])}}" href="#">Excluir</a>
                                                    -
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach    
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
    </d>
@endsection

@push('js')
       <script src="{{mix('js/certidao/certidao-casamento/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="url-search-finalidades" content="{{ route('finalidades-certidao.index') }}">   
    <link rel="stylesheet" href="{{mix('admin/certidao-casamento/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush