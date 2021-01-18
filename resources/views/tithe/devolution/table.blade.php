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
                   
    
                    <div class='card-body '>
                        <div class='row'> 
                            <div class="col-12 ">                            
                                <table class="table table-flush table-full" id='titherTable'>
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nome</th>                                    
                                            <th scope="col">Endereço</th>
                                                                                
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($dados as $dado)
                                            <tr>
                                                <td class="budget">
                                                    <span>{{$dado->nome}}</span>
                                                </td>
                                                <td class="budget ">                                           
                                                <span class="name mb-0 text-sm ">{{$dado->rua.', '.$dado->bairro.', '.$dado->numero}}
                                                    @if(!empty($dado->apartamento))
                                                    {{' (APTO '.$dado->apartamento.')'}}
                                                    @endif
                                                    {{', '.$dado->cidade.'/ '.$dado->estado_sigla}}</span>                                                
                                                </td>                                                                                                                                    
                                                <td class="text-right">
                                                    <a href='{{route('devolution.create',['dizimista'=>$dado->id])}}' class='btn btn-outline-secondary'>Fazer Devolução</a>
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
    <link rel="stylesheet" href="{{mix('admin/tithe/devolution/css/table.css')}}"/>
@endpush
@push('js')
    <script src="{{mix('admin/tithe/devolution/js/table.js')}}"></script>
@endpush