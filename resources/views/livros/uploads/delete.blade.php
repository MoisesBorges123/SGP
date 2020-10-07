@extends('layouts.app')

@section('content')
    @include('layouts.headers.header',['title'=>'Upload de Imagem'])
    
    <div class="container-fluid mt--7">
     
        <div class="row mt-5">
            <div class="col-xl-7 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class='card-header' style="border:0px;">
                        <div class="row align-items-center">
                            <div class="col">                                
                                <h3 class="mb-0">Fazer Delete da página {{$dados->numero}}</h3>                                
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('paginas.index','livro='.$dados->livro)}}" id='btn-add-book' class="btn btn-sm btn-primary">Voltar</a>
                            </div>  
                        </div>
                    </div>
                    <div class='card-body'>                        
                        <div class="row">
                            <div class="col-12 text-center">
                                <label class="label" data-toggle="tooltip" title="Fazer upload da pagina.">
                                    <img class="rounded" id="avatar" src="{{asset('img/system/upload.png')}}" alt="avatar">
                                    <h2>Clique para fazer o <b>upload</b></h2>
                                    <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                                  </label>
                                  <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                  </div>
                                  <div class="alert" role="alert"></div>

                            </div>
                        </div>                        
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Cortar e fazer upload</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <div class="img-container">
                                  <img id="image" src="{{asset('img/system/upload.png')}}">
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="crop">Salvar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                               
                   
                            
                    </div>
                    
                </form>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Imagens dessa página</h3>
                            </div>
                                                      
                        </div>
                    </div>
                    @if(!empty($imagens))
                    <div class='card-body'>
                        <div class='row galeria-img'>                            
                            @foreach($imagens as $key=>$imagem)
                                <div class="col-4">  
                                <a class="example-image-link" href="{{asset('storage/'.$imagem->caminho.'/'.$imagem->foto)}}" data-lightbox="image-1" data-title="Tamanho {{number_format($imagem->tamanho/1048576,2,'.',',')}}MB">
                                        <span class="badge badge-md badge-circle badge-floating badge-warning over-badge border-white">{{++$key}}</span>                                  
                                        <img src="{{asset('storage/'.$imagem->caminho.'/'.$imagem->foto)}}" alt="" class="img-1">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>    
                    @else
                        <div class='row'>
                            <div class="col-4 img-2">
                                <h3>Nenhuma imagem foi cadastrada.</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')    
	<script src="{{mix('admin/livros/uploads/js/form.js')}}"></script>
@endpush
@push('css')    
    <!-- Main Style Css -->
    <meta name='pagina' content='{{$dados->numero}}' />
    <meta name='livro' content='{{$dados->livro}}' />
    <meta name='url-paginas' content='{{route('paginas.index','livro='.$dados->livro)}}' />>
    <meta name='url-upload-store' content="{{route('upload-livros.store')}}"/>
    <link rel="stylesheet" href="{{mix('admin/livros/uploads/css/form.css')}}"/>
@endpush