@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>$title,])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">                    
                        <div class='card-header text-center'>                           
                            <h3>Detalhamento...</h3>                         
                            
                        </div>
                        <div class='card-body'>   

                            <div class='row mt-3'>
                               
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Moedas</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="moeda_5"><b>R$ 0,05 x {{$contagem->coins->m5}} = R$ {{number_format($contagem->coins->m5 * 0.05,2,',','.')}}</b></label>
                                                                
                                </div>  
                                <div class="col-6">
                                    <label for="moeda_10"><b>R$ 0,10 x {{ $contagem->coins->m10}}  = R$ {{number_format($contagem->coins->m10 * 0.1,2,',','.')}}</b></label>
                                                               
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_25"><b>R$ 0,25 x {{ $contagem->coins->m25}} = R$ {{number_format($contagem->coins->m25 * 0.25,2,',','.')}}</b></label>
                                                                 
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_50"><b>R$ 0,50 x {{ $contagem->coins->m50}} = R$ {{number_format($contagem->coins->m50 * 0.50,2,',','.')}}</b></label>
                                                              
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_100"><b>R$ 1,00 x {{ $contagem->coins->m100}} = R$ {{number_format($contagem->coins->m100 * 1,2,',','.')}}</b></label>
                                                                 
                                </div> 
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Cedulas</span>
                                    </div>
                                </div>                               
                                <div class="col-6">
                                    <label for="nota_2"><b>R$ 2,00 x {{$contagem->banknotes->n2}} = R$ {{number_format($contagem->banknotes->n2 * 2,2,',','.')}}</b></label>
                                                              
                                </div>                                
                              
                                <div class="col-6">
                                    <label for="nota_5"><b>R$ 5,00 x {{$contagem->banknotes->n5}} = R$ {{number_format($contagem->banknotes->n5 * 5,2,',','.')}}</b></label>
                                                                 
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_10"><b>R$ 10,00 x {{$contagem->banknotes->n10}} = R$ {{number_format($contagem->banknotes->n10 * 10,2,',','.')}}</b></label>
                                                                
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_20"><b>R$ 20,00 x {{$contagem->banknotes->n20}} = R$ {{number_format($contagem->banknotes->n20 * 20,2,',','.')}}</b></label>
                                                            
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_50"><b>R$ 50,00 x {{$contagem->banknotes->n50}} = R$ {{number_format($contagem->banknotes->n50 * 50,2,',','.')}}</b></label>
                                                              
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_100"><b>R$ 100,00 x {{$contagem->banknotes->n100}} = R$ {{number_format($contagem->banknotes->n100 * 100,2,',','.')}}</b></label>
                                                                
                                </div>                             
                                <div class="col-6">
                                    <label for="nota_100"><b>Cheque: R$ {{number_format($contagem->banknotes->check_paper,2,',','.')}}</b></label>
                                                                
                                </div>                             
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Total</span>
                                        <div class="col-6">
                                            <h2 for="nota_100"><b>Resultado: R$ {{number_format($contagem->banknotes->total+$contagem->coins->total,2,',','.')}}</b></h2>
                                                                        
                                        </div>                             
                                    </div>
                                </div>                                 
                                <div class="col-12">
                                    <span id="total"  title="Total">R$ {{number_format($contagem->banknotes->total+$contagem->coins->total,2,',','.')}}</span>
                                </div>
                            </div>
                        </div>
                        <div class='card-footer justify-content-center text-center'>
                            @if(!empty($dados))
                                <a class="btn btn-primary text-center" href='{{url()->previous()}}'>Voltar</a>
                                <button class="btn btn-default text-center" type='submit'>Salvar Alterações</button>
                            @else
                                <a class="btn btn-primary text-center" href='{{route('contagem.print',$contagem->id)}}'>Imprimir</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{mix('admin/contagem/css/form.css')}}"/>
@endpush
@push('js')
    <script src="{{mix('admin/contagem/js/form.js')}}"></script>   
@endpush