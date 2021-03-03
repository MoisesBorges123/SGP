@extends("layouts.app")

@section('content')
    
@include('layouts.headers.header',["title"=>'Ops! Tenha Calma...   '])
    
    <div class="container-fluid mt--7">
        
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row ">
                            <div class="col-6 ">
                                <h2 class="mb-0">Tenha calma em poucos dias este recuso estará liberado!</h2>                               
                            </div>                           
                           
                        </div>
                        
                    </div>
                    
                    
    
             
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')   
    <script src="{{mix('admin/estacionamento/fluxo/js/table.js')}}"></script>    
@endpush
@push('css')
    <meta name="fetch-notice" content="{{ route('notice-intentions.index') }}">  
    <meta name='parking_index' content="{{route('parking.index')}}">
    <meta name='parking_delete' content="{{route('parking.delete')}}">
    <meta name='time_update' content="{{route('time.update')}}">
    <meta name='parkingOut_show' content="{{route('parking-out.show')}}">
    <meta name='parkingOut_store' content="{{route('parking-out.store')}}">
    <meta name='fetchPrice' content="{{route('table-price.fetch')}}">
    <meta name='printOut' content="http://192.168.1.195/estacionamento_catedral/print/saida/PrintOut.php">
    <meta name='printIn' content="http://192.168.1.195/estacionamento_catedral/print/entrada/PrintIn.php">
    <!-- Main Style Css -->    
    <link rel="stylesheet" href="{{mix('admin/estacionamento/fluxo/css/table.css')}}"/>

    <style>
        .col-12{
            margin-bottom: 20px;
        }
    </style>
@endpush