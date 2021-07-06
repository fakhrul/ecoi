    <div class="navbar navbar-white navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><img src="{{ URL::asset('assets/images/ecoi_small.png') }}" style="vertical-align:middle;"> {{ Config::get('app.name') }}</a>
                <div>  
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>         
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{URL::to('/home')}}">Home</a></li>
                    {{ HTML::clever_menu(array('users.index'), 'User' ) }}
                        <ul class="dropdown-menu" role="menu">
                            {{--HTML::clever_link('groups.index', 'Manage Groups' ) --}}
                            {{ HTML::clever_link('users.index', 'Manage User' ) }}
                        </ul>
                    </li>                      
                    {{ HTML::clever_menu(array('branch.index'), 'Branch' ) }}
                        <ul class="dropdown-menu" role="menu">
                            {{-- HTML::clever_link('brands.index', 'Manage Brands' ) --}}
                            {{-- HTML::clever_link('channels.index', 'Manage Channels' ) --}}
                            {{ HTML::clever_link('branch.index', 'Manage Branch' ) }}
                        </ul>
                    </li>
                    {{ HTML::clever_menu(array('summary.index'), 'Summary' ) }}
                        <ul class="dropdown-menu" role="menu">
                            {{ HTML::clever_link('summary.index', 'Manage Summary' ) }}
                        </ul>
                    </li>              
                </ul>
                <ul class="nav navbar-nav pull-right">
                    <!--<li><a href="{{ URL::to('product_type/select') }}"><span class="glyphicon glyphicon-refresh"></span> {{ Session::get('product_type_name') }}</a></li>-->
                    @if(Auth::user()->channel)
                    <li><a href="{{ URL::to('branch/select') }}"><span class="glyphicon glyphicon-refresh"></span> @if (Session::has('branch_name')) {{ HTML::show_branch(Session::get('branch_name')) }} @else Select Branch @endif </a></li>
                    @endif
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="modal" data-target="#btn-user"><span class="glyphicon glyphicon-user" style="font-size: 15px;"></span></a>
                    </li>
                </ul>             
            </div><!--/.nav-collapse -->
        </div>   
    </div>

    <div id="btn-user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->username}}</h4>
                </div>
                <div class="modal-body">
                    <a href="{{ URL::to('profile/edit') }}">Edit Profile</a><br>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-primary" href="{{ URL::to('logout') }}"><span class="glyphicon glyphicon-off"></span> Logout</a>
                </div>
            </div>
        </div>
    </div>  

    <!-- loading panel -->
        <div id="loading_panel" class="loading loading-content-effect">
            <div class="loading-content">
            <h4><img src="{{ URL::asset('assets/images/loading.gif') }}" style="margin-top:-4px;">&nbsp;&nbsp;Loading...</h4>
            </div>
        </div>
        <div class="loading-backdrop"></div>
    <!-- loading panel -->