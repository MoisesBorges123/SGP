@if(isset($errors) && count($errors)>0)
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $erro)
            <p>{{$erro}}</p>
        @endforeach
    </div>
@endif

@if(!empty(session('erro')))
    <div class="alert alert-danger" role="alert">        
            <p>{{session('erro')}}</p>
    </div>
@endif