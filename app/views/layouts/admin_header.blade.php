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
                    <li><a href="{{URL::to('/admin/home')}}">Home</a></li>
                    {{ HTML::clever_menu(array('admin.summary.index'), 'Info' ) }}
                    <ul class="dropdown-menu" role="menu">
                        {{ HTML::clever_link('admin.summary.index', 'Manage Info' ) }}
                    </ul>
                    </li>
                    {{ HTML::clever_menu(array('admin.brands.index','admin.groups.index','admin.users.index'), 'User' ) }}
                    <ul class="dropdown-menu" role="menu">
                        {{ HTML::clever_link('admin.brands.index', 'Manage Brands' ) }}
                        {{ HTML::clever_link('admin.groups.index', 'Manage Groups' ) }}
                        {{ HTML::clever_link('admin.users.index', 'Manage Users' ) }}
                    </ul>
                    </li>
                    <!-- {{ HTML::clever_menu(array('admin.channels.index'), 'Channel' ) }}
                        <ul class="dropdown-menu" role="menu">
                            {{ HTML::clever_link('admin.channels.index', 'Manage Channels' ) }}
                        </ul>
                    </li>   
                    {{ HTML::clever_menu(array('admin.branch.index'), 'Branch' ) }}
                        <ul class="dropdown-menu" role="menu">
                            {{ HTML::clever_link('admin.branch.index', 'Manage Branches' ) }}

                        </ul>
                    </li> -->

                    {{-- <li><a class="pull-right btn btn-small btn-warning" href="{{ URL::to('logout') }}">Logout ({{ Auth::user()->username }})</a></li> --}}
                    {{-- <li class="dropdown">
    					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
    					<ul class="dropdown-menu">
    						<li><a href="#">Action</a></li>
    						<li><a href="#">Another action</a></li>
    						<li><a href="#">Something else here</a></li>
    						<li class="divider"></li>
    						<li class="dropdown-header">Nav header</li>
    						<li><a href="#">Separated link</a></li>
    						<li><a href="#">One more separated link</a></li>
    					</ul>
    				</li> --}}
                </ul>
                <ul class="nav navbar-nav pull-right">
                    {{-- <li><a href="{{ URL::to('/admin/product_type/select') }}"><span class="glyphicon glyphicon-refresh"></span> {{ Session::get('product_type_name') }}</a></li> --}}
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="modal" data-target="#btn-user"><span class="glyphicon glyphicon-user" style="font-size: 15px;"></span></a>
                    </li>
                </ul>
                <!--
                <ul class="nav navbar-nav navbar-right">                    
                    <li> <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->username}}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ URL::to('admin/profile/edit') }}">Edit Profile</a></li>  
                            <li><a href="{{ URL::to('logout') }}">Logout</a></li>                        
                        </ul>
                    </li>  
                </ul>
                -->
            </div>
            <!--/.nav-collapse -->
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
                    <a href="{{ URL::to('admin/profile/edit') }}">Edit Profile</a><br>
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