@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="card">
                <div class="card-header border-0">
                    <h3 class='mb-0'>Vencimentos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                        <th scope="col" class="sort" data-sort="name">Nome</th>
                        <th scope="col" class="sort" data-sort="status">Placa</th>
                        <th scope="col" class="sort" data-sort="budget">Veículo</th>
                        <th scope="col">Data Vencimento</th>
                        <th scope="col" class="sort" data-sort="completion">Dias restantes</th>
                        <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody class="list">
                            @forelse ($dados['mensalistas_ativos'] as $item)
                          
                            
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">                       
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{$item['owner']}}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                {{$item['placa']}}
                            </td>
                        <td>
                            <span class="badge badge-dot mr-4">
                                <i class="bg-warning"></i>
                                <span class="status">{{$item['typevehicle']}}</span>
                            </span>
                        </td>
                        <td>
                            {{$item['day_left']}}
                        </td>
                        <td>
                            {{$item['day_left']}}
                        </td>
                        <td>
                        <div class="d-flex align-items-center">
                        <span class="completion mr-2">{{$item['days_left']}}</span>
                        <div>
                        <div class="progress">
                            @php
                            $percentual = ($item['day_left']/30)*100;
                            @endphp
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{$item['day_left']}}" aria-valuemin="0" aria-valuemax="30" style="width: {{$percentual}}%;"></div>
                        </div>
                        </div>
                        </div>
                        </td>
                        <td class="text-right">
                        <div class="dropdown show">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-160px, 32px, 0px);">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                        </div>
                        </td>
                        </tr>
                        @empty
                            @endforelse
                        </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush