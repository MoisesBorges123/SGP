
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
                                <h3 class="mb-0">Minhas Entradas</h3>                               
                            </div>                            
                            
                            <div class="col-1">                            
                                <button id="print" data-link="{{route('contagem.printByinterval')}}" class="btn btn-sm btn-primary">Imprimir</button>
                            </div>
                            <div class="col-2 text-right">                            
                                <a href="{{route('contagem.create')}}" class="btn btn-sm btn-primary">Nova entrada</a>
                            </div>
                            <div class="col-1">
                                <button id='btn-filter' data-link="{{route('contagem.index')}}" class="btn btn-sm btn-default">Filtrar Controles</button>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                    </div>
                   
    
                    <div class='card-body align-items-center'>
                        <div class='row'> 
                            <div class="col-12 ">                            
                                <table class="table  table-flush table-full" id='titherTable'>
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Entrada</th>                                    
                                            <th scope="col">Data</th>
                                            <th scope="col">Valor</th>                                    
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($contagens as $dado)
                                            <tr>
                                                <td class="budget">
                                                    <span>{{$dado->categors->nome}}</span>
                                                </td>
                                                <td class="budget">
                                                    <span >{{date('d/m/Y',strtotime($dado->referer))}}</span>                                               
                                                </td>
                                                <td class="budget">
                                                    <span>R$ {{number_format($dado->banknotes->total+$dado->coins->total,2,',','.')}}</span>
                                                </td>                                                                                      
                                                <td class="text-right">
                                                    <a class="btn btn-icon btn-2 btn-primary btn-sm" href="{{route('contagem.show',$dado->id)}}">
                                                        <span class="btn-inner--icon"><i class="fa fa-eye"></i></span>
                                                        
                                                    </a>
                                                    <a class="btn btn-icon btn-2 btn-primary btn-sm" target="_blank" href="{{route('contagem.print',$dado->id)}}">
                                                        <span class="btn-inner--icon"><i class="fa fa-print"></i></span>
                                                        
                                                    </a>
                                                    <a class="btn btn-icon btn-2 btn-warning btn-sm" href="{{route('contagem.edit',$dado->id)}}">
                                                        <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                                        
                                                    </a>
                                                    <button class="btn btn-icon btn-2 btn-danger btn-sm btn-delete" data-link="{{route('contagem.destroy',$dado->id)}}">
                                                        <span class="btn-inner--icon"><i class="fa fa-trash"></i></span>
                                                        
                                                    </button>
                                                   
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
    <script src="{{mix('admin/contagem/js/table.js')}}"></script>
@endpush