
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
       @if(!empty($header))
            <!-- Card stats -->
            <div class="row">
                @foreach($header as $card)
               
                    <x-card-header 
                        
                        headerText="{!! $card['headerText'] !!}" 
                        headerNumber="{!! $card['headerNumber'] !!}" 
                        bodyIcon="{!! $card['bodyIcon'] !!}"  
                        color="{{  $card['color']  }}"   
                        footerNumber=""
                        footerIcon=""
                        footerText="{!!  $card['footerText']  ?? '' !!}" 
                        url="{{$card['url']}}"
                        identify="{{$card['identify'] ?? ''}}"
                        > 
                    </x-card-header>
                @endforeach
            </div>
            
        @endif
        </div>
    </div>
</div>