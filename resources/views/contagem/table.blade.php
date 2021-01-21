@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards',['header'=>$header])

    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6">
                                <h3 class="mb-0">Meus Dizimistas</h3>                               
                            </div>                           
                          
                        </div>
                        
                    </div>
                   
    
                    <div class='card-body align-items-center'>
                        <div class='row'> 
                            <div class="col-12 ">                            
                                <table class="table  table-flush table-full tables" id='titherTable'>
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nome</th>                                    
                                            <th scope="col">Endereço</th>
                                            <th scope="col">Telefone</th>                                    
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($dados as $dado)
                                            <tr>
                                                <td class="budget">
                                                    <span>{{$dado->nome}}</span>
                                                </td>
                                                <td class="budget text-center">                                           
                                                <span class="name mb-0 text-sm ">{{$dado->rua.', '.$dado->bairro.', '.$dado->numero}}
                                                    @if(!empty($dado->apartamento))
                                                    {{' (APTO '.$dado->apartamento.')'}}
                                                    @endif
                                                    {{', '.$dado->cidade.'/ '.$dado->estado_sigla}}</span>                                                
                                                </td>
                                                <td class="budget">
                                                    <span>{{$dado->telefone}}</span>
                                                </td>                                                                                      
                                                <td class="text-right">
                                                    <div class="dropdown">
                                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                            <a class="dropdown-item"  href="{{route('tither.edit',$dado->id)}}">Editar</a> 
                                                            <a class="dropdown-item"  href="{{route('tither.edit',$dado->id)}}">Devolver Dízimo</a> 
                                                            <button class="dropdown-item" id='btn-excluir' data-link="{{route('tither.destroy',$dado->id)}}" >Excluir</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach    
                                    </tbody>
                                </table>
                            </div>
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
@push('css')
    <link rel="stylesheet" href="{{mix('admin/tithe/tither/css/table.css')}}"/>
@endpush
@push('js')
    <script src="{{mix('admin/tithe/tither/js/table.js')}}"></script>
@endpush