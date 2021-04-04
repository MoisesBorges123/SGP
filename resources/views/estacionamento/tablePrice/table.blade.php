@extends("layouts.app")

@section('content')
    
@include('layouts.headers.header',['title'=>$title,])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6">
                                <h3 class="mb-0">Preços</h3>                               
                            </div> 
                        </div>
                        
                    </div>
                    
                    <div class="col-12">
                    </div>
    
                    <div>
                       <table class="table align-items-center table-flush table-full tables" id='certidoesTable'>
                            <thead class="thead-light">
                                <tr>                                                                      
                                    <th scope="col" class='text-center'>ID</th>
                                    <th scope="col">Vigência</th>                                    
                                    <th scope="col" class='text-center'>Preços</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($dados as $dado)
                                    <tr>                                        
                                       
                                        <td class="budget text-center">
                                            <span>{{$dado['id']}}</span>
                                        </td>
                                        <td class="budget">
                                            <span>{{$dado['created_at']}}</span>
                                        </td>
                                        <td class='precos'>
                                            <div class="row">
                                                <div class="col-6 cars-price">
                                                    <div class="row">
                                                        <div class="col-12 "><b>Preços Carro</b></div>
                                                        <div class="col-6">
                                                            Até 15 min.: {{$dado['carPrice']['min_15']}}<br>
                                                            Acima de 15 min.: {{$dado['carPrice']['min_30']}}<br>
                                                            Acima de 30 min.: {{$dado['carPrice']['min_60']}}
                                                        </div>
                                                        <div class="col-6">
                                                            Diária: {{$dado['carPrice']['diaria']}}<br>
                                                            Pernoite: {{$dado['carPrice']['pernoite']}}<br>
                                                            Mensalidade: {{$dado['carPrice']['mensalidade']}}
                                                        </div>
                                                    </div>
                                                    
                                                </div>                                                
                                                <div class="col-6 motocycles-price">
                                                    <div class="row">
                                                        <div class="col-12"><b>Preços Moto</b></div>
                                                        <div class="col-6">
                                                            Até 15 min.: {{$dado['motocyclePrice']['min_15']}}<br>
                                                            Acima de 15 min.: {{$dado['motocyclePrice']['min_30']}}<br>
                                                            Acima de 30 min.: {{$dado['motocyclePrice']['min_60']}}
                                                        </div>
                                                        <div class="col-6">
                                                            Diária: {{$dado['motocyclePrice']['diaria']}}<br>
                                                            Pernoite: {{$dado['motocyclePrice']['pernoite']}}<br>
                                                            Mensalidade: {{$dado['motocyclePrice']['mensalidade']}}
                                                        </div>
                                                    </div>
                                                    
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

@push('css')
<link rel="stylesheet" href="{{mix('admin/estacionamento/table-price/css/table.css')}}"/>

@endpush
@push('js')
    <script src="{{mix('admin/estacionamento/table-price/js/table.js')}}"></script>   
@endpush