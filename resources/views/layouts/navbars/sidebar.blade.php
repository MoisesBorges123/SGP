<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Buscar') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            @if(auth()->user()->name != 'Estacionamento')
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Início') }}
                    </a>
                </li>
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            @endif
            <h6 class="navbar-heading text-muted">Estacionamento</h6>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('parking.create') }}">
                        <i class="ni ni-bus-front-12 text-primary"></i> <b class='text-primary'>{{ __('Entrada / Saída') }}</b>
                    </a>
                </li>     
                <li class="nav-item">
                    <a class="nav-link text-default" href="#mensalistas" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                         <i class="fas fa-warehouse"></i>
                        <span class="nav-link-text text-primary">{{ __('Mensalistas') }}</span>
                    </a>

                    <div class="collapse " id="mensalistas">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('monthly.create') }}">
                                    {{ __('Novo Mensalista') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('monthly.index') }}">
                                    {{ __('Mensalidades Ativas') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('monthly-pay.create') }}">
                                    {{ __('Efetuar Pagamento') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-default" href="#tablePrice" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-money-coins"></i>
                        <span class="nav-link-text text-primary">{{ __('Preços') }}</span>
                    </a>

                    <div class="collapse " id="tablePrice">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('table-price.create') }}">
                                    {{ __('Novos Preços') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('table-price.index') }}">
                                    {{ __('Tabela de Preços') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                

            </ul>
            @if(auth()->user()->name != 'Estacionamento')
            <h6 class="navbar-heading text-muted">Registros</h6>
            
            <ul class="navbar-nav">     
                <li class="nav-item">
                    <a class="nav-link active text-default" href="#registros" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-archive-2"></i>
                        <span class="nav-link-text text-primary">{{ __('Batismo') }}</span>
                    </a>

                    <div class="collapse " id="registros">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-batismo.create') }}">
                                    {{ __('Registrar Batizado') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-batismo.index') }}">
                                    {{ __('Batizados Registrados') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-default" href="#registros-crisma" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-archive-2"></i>
                        <span class="nav-link-text text-primary">{{ __('Crisma') }}</span>
                    </a>

                    <div class="collapse " id="registros-crisma">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-crisma.create') }}">
                                    {{ __('Registrar Crisma') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-crisma.index') }}">
                                    {{ __('Crismas Registradas') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-default" href="#registros-casamento" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-archive-2"></i>
                        <span class="nav-link-text text-primary">{{ __('Casamento') }}</span>
                    </a>

                    <div class="collapse " id="registros-casamento">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-casamento.create') }}">
                                    {{ __('Registrar Casamento') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('certidao-casamento.index') }}">
                                    {{ __('Casamentos Registrados') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                

            </ul>            
            <ul class="navbar-nav">     
                <li class="nav-item">
                    <a class="nav-link text-default" href="#livros" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-books"></i>
                        <span class="nav-link-text text-primary">{{ __('Livros') }}</span>
                    </a>

                    <div class="collapse " id="livros">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('livros.index') }}">
                                    {{ __('Meus Livros') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                

            </ul>
            <h6 class="navbar-heading text-muted">Missas</h6>
            <ul class="navbar-nav">     
                <li class="nav-item">
                    <a class="nav-link text-default" href="#intentions" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-single-copy-04"></i>
                        <span class="nav-link-text text-primary">{{ __('Intenções') }}</span>
                    </a>

                    <div class="collapse " id="intentions">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('intentions.create') }}">
                                    {{ __('Nova Intenção') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('intentions.index') }}">
                                    {{ __('Ver Intenções') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                

            </ul>
            <h6 class="navbar-heading text-muted">Dízimo</h6>
            <ul class="navbar-nav">     
                <li class="nav-item">
                    <a class="nav-link text-default" href="#tither" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-single-02"></i>
                        <span class="nav-link-text text-primary">{{ __('Dizimista') }}</span>
                    </a>

                    <div class="collapse " id="tither">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tither.create') }}">
                                    {{ __('Novo Dizimista') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('tither.index') }}">
                                    {{ __('Meus Dizimistas') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('devolution.index') }}">
                        <i class="ni ni-favourite-28 text-danger"></i> <b class='text-danger'>{{ __('Devolver') }}</b>
                    </a>
                </li>
            </ul>
            <h6 class="navbar-heading text-muted">Financeiro</h6>
            <ul class="navbar-nav">     
                <li class="nav-item">
                    <a class="nav-link text-default" href="#contagem" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-single-02"></i>
                        <span class="nav-link-text text-primary">{{ __('Contagem') }}</span>
                    </a>

                    <div class="collapse " id="contagem">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contagem.create') }}">
                                    {{ __('Contar') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contagem.index') }}">
                                    {{ __('Meus Controles') }}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </li>
                
            </ul>
            @endif
        </div>
    </div>
</nav>