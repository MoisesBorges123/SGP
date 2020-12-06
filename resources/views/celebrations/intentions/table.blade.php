@extends("layouts.app")

@section('content')
    @include('layouts.headers.cards',["header"=>$header])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6">
                                <h3 class="mb-0">Intenções Agendadas</h3>                               
                            </div>                            
                            <div class="col-1">                            
                                <button id='sextou' data-link="{{route('intentions.print')}}" class="btn btn-sm btn-danger">#Sextou!!</button>
                            </div>
                            <div class="col-1">                            
                                <button id="print" data-link="{{route('intentions.print')}}" class="btn btn-sm btn-primary">Imprimir</button>
                            </div>
                            <div class="col-2 text-right">                            
                                <a href="{{route('intentions.create')}}" class="btn btn-sm btn-primary">Nova Intenção</a>
                            </div>
                            <div class="col-1">
                                <button id='old_intentions' data-link="{{route('intentions.index')}}" class="btn btn-sm btn-default">Intenções Antigas</button>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                    </div>
    
                    <div>
                        <table class="table align-items-center table-flush" id='certidoesTable'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Tipo</th>                                    
                                    <th scope="col">Intenção</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Horário</th>
                                    <th scope="col">Solicitante</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dados as $dado)
                                    <tr>
                                        <td class="budget">
                                            <span>{{$dado['typeIntention']}}</span>
                                        </td>
                                        <th scope="row">                                           
                                        <span class="name mb-0 text-sm">{{$dado['intention']}}</span>                                                
                                        </th>
                                        <td class="budget">
                                            <span>{{$dado['data']}}</span>
                                        </td>
                                        <td class="budget">
                                            <span>{{$dado['hora']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['claimant']}}</span>
                                        </td>
                                        <td>
                                            <span>{{$dado['phone']}}</span>                        
                                        </td>                                        
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"  href="{{route('certidao-batismo.show',$dado['id'])}}">Registro Completo</a>
                                                    <a class="dropdown-item btn-emitir" data-url_notitfy="{{route('notificacao-certidao-batismo.store')}}"  data-url="{{route('certidao.emitir',['batizado',$dado['id']])}}">Emitir</a>
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
    <script src="{{mix('admin/intentions/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="url-search-finalidades" content="{{ route('finalidades-certidao.index') }}">  
   
    <!-- Main Style Css -->    
    <link rel="stylesheet" href="{{mix('admin/certidao-batismo/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush