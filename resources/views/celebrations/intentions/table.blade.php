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
                                <button id='old_intentions' data-link="{{route('intentions.index')}}" class="btn btn-sm btn-default">Filtrar Intenções</button>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                    </div>
    
                    <div>
                        <table class="table align-items-center table-flush table-full tables" id='certidoesTable'>
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
                                        <td class="budget text-center">                                           
                                        <span class="name mb-0 text-sm ">{!! str_replace(' e ',' e ',$dado['intention']) !!}</span>                                                
                                        </td>
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
                                                     <!-- <a class="dropdown-item"  href="{{route('intentions.edit',$dado['id'])}}">Editar</a> -->
                                                    <button class="dropdown-item" id='btn-excluir' data-link="{{route('intentions.destroy',$dado['id'])}}" >Excluir</button>
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
    <meta name="fetch-notice" content="{{ route('notice-intentions.index') }}">  
   
    <!-- Main Style Css -->    
    <link rel="stylesheet" href="{{mix('admin/intentions/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush