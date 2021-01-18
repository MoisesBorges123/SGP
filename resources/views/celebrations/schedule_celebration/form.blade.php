@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards',['header'=>$header])
    
    <div class="container-fluid mt--7">        
        <div class="row mt-5">
            <div class="col-xl-3">
                <button class="btn btn-danger" id='btn_speech'> Gravar</button>
            </div>
            <div class="col-xl-12">
                <p id="results_speak"></p>
            </div>
            <div class="col-xl-6 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    <div id="app">
                        <intention-tab v-on:select_intentions="selectIntention"></intention-tab>
                    
                        <div class='card-header' style="border:0px;">
                            <div class="row align-items-center">
                                <div class="col">
                                    @if(!empty($dados))
                                        <h3 class="mb-0">Editar Intenção</h3>
                                    @else
                                        <h3 class="mb-0" v-if="intentionSelected">Nova Intenção - @{{ intentionSelected }} </h3>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class='card-body'>
                            @if(!empty($dados))    
                                <form class="form-register" action="{{route('intentions.update',$dados['id'])}}" method="post" id='form-intentions'>
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
                                data_agendamento='{{old('data_agendamento') ?? ''}}' 
                                hora_agendamento='{{old('hora_agendamento') ?? ''}}' 
                                agendado_por='{{ old('agendado_por') ?? ''}}' 
                                observacao='{{ old('observacao') ?? ''}}'
                                esposo='{{ old('esposa') ?? ''}}'
                                esposa='{{ old('esposo') ?? ''}}'
                                curso='{{ old('curso') ?? ''}}'
                            ></thanksgiven>
                            <deads
                            v-if="intentionSelected == 'Falecimento'"                           
                            falecido='{{ old('falecido') ?? ''}}'
                                data_agendamento='{{ old('data_agendamento') ?? ''}}'
                                hora_agendamento=' {{ old('hora_agendamento') ?? '' }}'
                                agendado_por='{{ old('agendado_por') ?? ''}}' 
                                observacao='{{ old('observacao') ?? '' }}'
                                telefone='{{old('telefone') ?? ''}}'
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
                                    <button class="btn btn-primary" type='submit'>Salvar</button>
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
    <script src="{{mix('admin/schedule_celebration/speech_recognize.js')}}" async></script>	
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