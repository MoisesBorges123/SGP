@extends('layouts.app')

@section('content')
@include('layouts.headers.cards',['header'=>$header])

    <div class="container-fluid mt--7">        
        <div class="row mt-5">
            <div class="col-xl-6 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    <div id="app">
                        <intention-tab v-on:select_intentions="selectIntention" intencao = "{{$intention[0]['intention_group'] ?? ''}}"></intention-tab>
                    
                        <div class='card-header' style="border:0px;">
                            <div class="row align-items-center">
                                <div class="col">
                                    @if(!empty($intention))
                                        <h2 class="mb-0">Editar Intenção - @{{ intentionSelected }}</h2>
                                    @else
                                        <h3 class="mb-0" v-if="intentionSelected">Nova Intenção - @{{ intentionSelected }} </h3>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class='card-body'>
                            @if(!empty($intention))    
                                <form class="form-register" action="{{route('intentions.update',$intention[0]['id'])}}" method="post" id='form-intentions'>
                                @method('PUT')
                            @else
                                <form class="form-register" action="{{route('intentions.store')}}" method="post" id='form-intentions'>
                            @endif
                                                                    
                            @csrf  
                            @include('alerts.success')
                            @include('alerts.danger')
                            <thanksgiven 
                                v-if="intentionSelected == 'Ação de Graças'"
                                pessoa='' 
                                telefone='{{old('telefone') ?? ''}}' 
                                data_agendamento='{{old('data_agendamento') ?? $intention[0]['data_american'] ?? ''}}' 
                                hora_agendamento='{{old('hora_agendamento') ?? $intention[0]['hora'] ?? ''}}' 
                                agendado_por='{{ old('agendado_por') ?? $intention[0]['claimant'] ?? ''}}' 
                                observacao='{{ old('observacao') ?? $intention[0]['observations'] ?? ''}}'
                                esposo='{{ old('esposa') ?? $intention[0]['esposa'] ?? ''}}'
                                esposa='{{ old('esposo') ?? $intention[0]['esposo'] ?? ''}}'
                                curso='{{ old('curso') ?? $intention[0]['complement'] ?? ''}}'
                                type='{{$intention[0]['typeIntention'] ?? ''}}'
                                anos = '{{$intention[0]['complement'] ?? ''}}'
                            ></thanksgiven>
                            <deads
                            v-if="intentionSelected == 'Falecimento'"                           
                            falecido='{{ old('falecido') ?? $intention[0]['intention'] ?? ''}}'
                                data_agendamento='{{ old('data_agendamento') ?? $intention[0]['data_american'] ?? ''}}'
                                hora_agendamento=' {{ old('hora_agendamento') ?? $intention[0]['hora'] ?? ''}}'
                                agendado_por='{{ old('agendado_por') ?? $intention[0]['claimant'] ?? ''}}' 
                                observacao='{{ old('observacao') ?? $intention[0]['observations'] ??'' }}'
                                telefone='{{old('telefone') ?? $intention[0]['phone'] ?? ''}}'
                                type='{{$intention[0]['typeIntention'] ?? ''}}'                                
                            ></deads>
                            <health  v-if="intentionSelected == 'Saúde'"
                                pessoa='{{old('pessoa') ?? ''}}'
                                data_agendamento=''
                                hora_agendamento=''
                                agendado_por='' 
                                telefone='(33) 3333-3333'
                            ></health>
                            
                            <div class="row">
                                <div class="col-12 text-center">
                                    @if(empty($intention))
                                        <button class="btn btn-primary" type='submit'>Salvar</button>
                                    @else
                                        <a class="btn btn-danger" href="{{route('intentions.index')}}">Cancelar</a>
                                        <button class="btn btn-primary" type='submit'>Altera</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                    </div>
                    
                </form>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Intenções para <b>HOJE</b> </h3>
                            </div>
                            <div class="col text-right">
                            <a href="{{route('intentions.index')}}" class="btn btn-sm btn-primary">Todas Intenções</a>
                            </div>
                        </div>
                    </div>
                    @if(!empty($intentionsToday))
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Intenção</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Requerente</th>
                                        <th scope="col">Telefone</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($intentionsToday as $registro)
                                        <tr>
                                            <th scope="row">
                                                {{$registro['typeIntention']}}
                                            </th>
                                            <td>
                                                {{$registro['intention']}}
                                            </td>
                                            <td>
                                                {{$registro['claimant']}}
                                            </td>
                                            <td>
                                                {{$registro['phone']}}
                                            </td>
                                        </tr>
                                        
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    @else
                    @endif
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')   
    <script src="{{mix('admin/intentions/form.js')}}"></script>	
@endpush
@push('css')   
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{mix('admin/intentions/form.css')}}"/>    

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush