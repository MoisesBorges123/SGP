@extends('layouts.app')

@section('content')

    @include('layouts.headers.header',['title'=>$title,])

    <div class="container-fluid mt--7">        
        <div class="row mt-5 justify-content-center">
            <div class="col-xl-8 mb-5 mb-xl-0">
      
                <div class="card shadow">
                    @if(empty($dados))
                        <form action="{{route('tither.store')}}" method="post" >
                       
                    @else
                        <form action="{{route('tither.update',$dados->id)}}" method="post" >
                        @method('PUT')
                        

                    @endif
                    @csrf
                        <div class='card-header text-center'>
                            @if(!empty($dados))
                                <h3>Editar Ficha de dizimista</h3>
                            @else
                                <h3>Informe a quantidade de cada unidade.</h3>
                            @endif
                            
                        </div>
                        <div class='card-body'>                           
                            <div class='row mt-3'> 
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Moedas</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="moeda_5"><b>R$ 0,05</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='moeda_5' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='moeda_5' id='moeda_5'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm" type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>  
                                <div class="col-6">
                                    <label for="moeda_10"><b>R$ 0,10</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='moeda_10' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='moeda_10' id='moeda_10' class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm" type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_25"><b>R$ 0,25</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='moeda_25' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='moeda_25' id='moeda_25'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm" type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_50"><b>R$ 0,50</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='moeda_50' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='moeda_50' id='moeda_50'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm" type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="moeda_100"><b>R$ 1,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='moeda_100' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='moeda_100' id='moeda_100'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='moeda_100' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div> 
                                <div class="col-12">
                                    <div class="divider-text border-primary">
                                        <span class='border-primary'>Cedulas</span>
                                    </div>
                                </div>                               
                                <div class="col-6">
                                    <label for="nota_2"><b>R$ 2,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_2' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_2' id='nota_2'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_2' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                              
                                <div class="col-6">
                                    <label for="nota_5"><b>R$ 5,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_5' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_5' id='nota_5'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_5' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_10"><b>R$ 10,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_10' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_10' id='nota_10'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_10' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_20"><b>R$ 20,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_20' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_20' id='nota_20'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_20' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_50"><b>R$ 50,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_50' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_50' id='nota_50'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_50' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                                
                                <div class="col-6">
                                    <label for="nota_100"><b>R$ 100,00</b></label>
                                    <div class="input-group mb-3  input-group-sm">
                                        <div class="input-group-prepend">
                                          <button class="btn btn-outline-primary btn-icon btn-sm btn_plus" for='nota_100' type="button" id="button-addon1">
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                          </button>
                                        </div>
                                        <input type="number" name='nota_100' id='nota_100'  class='form-control form-control-primary' value="{{$dados->nome ?? '0'}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-icon btn-sm btn_less" for='nota_100' type="button" id="button-addon2">
                                                <span class="btn-inner--icon"><i class="ni ni-fat-delete"></i></span>
                                            </button>
                                          </div>
                                      </div>                             
                                </div>                             
                              
                                <div  class="col-12">
                                    <label for="nota_100"><b>Cheque (Valor Total R$)</b></label>
                                    <input type="text" name='moeda_100' id='moeda_100'  class='form-control-sm form-control-primary' value="{{$dados->nome ?? '0'}}">
                                </div>
                                
                                

                            </div>
                    
                        </div>
                        <div class='card-footer justify-content-center text-center'>
                            @if(!empty($dados))
                                <a class="btn btn-primary text-center" href='{{url()->previous()}}'>Voltar</a>
                                <button class="btn btn-default text-center" type='submit'>Salvar Alterações</button>
                            @else
                                <button class="btn btn-primary text-center" type='submit'>Salvar</button>
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