
@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>$title,])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">
                 
                    <form action="{{route('table-price.store')}}" method="POST" >                     
                        @csrf                 
                        <div class='card-header text-center'>                         
                            <h3>Nova Tabela de Preços.</h3>
                            @include('alerts.danger')
                        </div>
                        <div class='card-body'>                           
                            <div class='row mt-3'> 
                               
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Motos</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="moeda_5"><b>15min - 30min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input  type="text" name='mot_15min' id='mot_15min'  class='form-control form-control-primary' value="{{old('mot_15min') ?? !empty($dados['motocycle_price']->min_15) ? number_format($dados['motocycle_price']->min_15,2,',','.') : '0' }}">
                                        
                                      </div>                             
                                </div>  
                                <div class="col-6">
                                    <label for="moeda_10"><b>30min - 59min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='mot_30min' id='mot_30min'  class='form-control form-control-primary money2' value="{{old('mot_30min') ?? !empty($dados['motocycle_price']->min_30) ? number_format($dados['motocycle_price']->min_15,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_25"><b>Acima de 59min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='mot_60min' id='mot_60min'  class='form-control form-control-primary money2' value="{{old('mot_60min') ?? !empty($dados['motocycle_price']->min_60) ? number_format($dados['motocycle_price']->min_60,2,',','.') : '0'}}">                                       
                                        
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_50"><b>Diária</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                       
                                        <input type="text" name='mot_diaria' id='mot_diaria'  class='form-control form-control-primary money2' value="{{old('mot_diaria') ?? !empty($dados['motocycle_price']->diaria) ? number_format($dados['motocycle_price']->diaria,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_100"><b>Pernoite</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                       
                                        <input type="text" name='mot_pernoite' id='mot_pernoite'  class='form-control form-control-primary money2' value="{{old('mot_pernoite') ?? !empty($dados['motocycle_price']->pernoite) ? number_format($dados['motocycle_price']->pernoite,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div> 
                                <div class="col-6">
                                    <label for="moeda_100"><b>Mensalidade</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='mot_mensalidade' id='mot_mensalidade'  class='form-control form-control-primary money2' value="{{old('mot_mensalidade') ?? !empty($dados['motocycle_price']->mensalidade) ? number_format($dados['motocycle_price']->mensalidade,2,',','.') : 0}}">                                       
                                     
                                      </div>                             
                                </div> 
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Carros</span>
                                    </div>
                                </div>                               
                                <div class="col-6">
                                    <label for="nota_2"><b>15min - 30min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='car_15min' id='car_15min'  class='form-control form-control-primary money2' value="{{old('car_15min') ?? !empty($dados['car_price']->min_15) ? number_format($dados['car_price']->min_15,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div>                                
                              
                                <div class="col-6">
                                    <label for="nota_5"><b>30min - 59min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='car_30min' id='car_30min'  class='form-control form-control-primary money2' value="{{old('car_30min') ??!empty($dados['car_price']->min_30) ? number_format($dados['car_price']->min_30,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_10"><b>Acima de 59min</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        
                                        <input type="text" name='car_60min' id='car_60min'  class='form-control form-control-primary' value="{{old('car_60min') ?? !empty($dados['car_price']->min_60) ? number_format($dados['car_price']->min_60,2,',','.') : '0'}}">
                                        
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_20"><b>Díaria</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                       
                                        <input type="text" name='car_diaria' id='car_diaria'  class='form-control form-control-primary money2' value="{{old('car_diaria') ?? !empty($dados['car_price']->diaria) ? number_format($dados['car_price']->diaria,2,',','.') : '0'}}">                                       
                                        
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_50"><b>Pernoite</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                       
                                        <input type="text" name='car_pernoite' id='car_pernoite'  class='form-control form-control-primary money2' value="{{old('car_pernoite') ?? !empty($dados['car_price']->pernoite) ? number_format($dados['car_price']->pernoite,2,',','.') : '0'}}">                                       
                                       
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_100"><b>Mensalidade</b></label>
                                    <div class="input-group mb-3  input-group-sm">                                       
                                        <input type="text" name='car_mensalidade' id='car_mensalidade'  class='form-control form-control-primary money2' value="{{old('car_mensalidade') ?? !empty($dados['car_price']->mensalidade) ? number_format($dados['car_price']->mensalidade,2,',','.') : '0'}}">                                       
                                    </div>                             
                                </div>                             
                              
                            </div>
                        </div>
                        <div class='card-footer justify-content-center text-center'>                         
                            <button class="btn btn-primary text-center" type='submit'>Salvar</button>                       
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<link rel="stylesheet" href="{{mix('admin/estacionamento/table-price/css/form.css')}}"/>

@endpush
@push('js')
    <script src="{{mix('admin/estacionamento/table-price/js/form.js')}}"></script>   
@endpush