<div class="col-xl-3 col-lg-6">
    <div class="card card-stats mb-4 mb-xl-0">
        <div class="card-body {{ $identify }}" >
            <div class="row">
                <div class="col-8">
                <h5 class="card-title text-uppercase text-muted mb-0">
                    @if(!empty($url))
                        <a href="{{$url ?? ''}}">
                            {!! $headerText ?? ''!!}                            
                        </a>
                    @else
                       <div class='btn-link'>
                           {!! $headerText ?? ''!!}
                       </div>
                        
                    @endif
                </h5>
                    <span class="h2 font-weight-bold mb-0">{{$headerNumber ?? ''}}</span>
                </div>
                <div class="col-4">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow {{  $color ?? '' }}">
                        {!! $bodyIcon ?? '' !!}
                    </div>
                </div>
            </div>
            <p class="mt-3 mb-0 text-muted text-sm">
            <span class="text-danger mr-2">{{$footerIcon ?? ''}} {{$footerNumber ?? ''}}</span>
            <span class="text-nowrap">{!! $footerText ?? '' !!}</span>
            </p>
        </div>
    </div>
</div>