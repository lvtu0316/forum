<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    <ul class="nav navbar-nav">
        <li><a href="{{route('threads.index')}}">话题</a></li>
        <li><a href="/threads?popularity=1">热门</a> </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-hidden="true"
               aria-expended="false" >频道<span class="caret">  </span></a>
            <ul class="dropdown-menu">
                @foreach($channels as $channle)
                    <li><a href="{{route('threads.channel',$channle->slug)}}">{{$channle->name}}</a ></li>
                @endforeach
            </ul>
        </li>
        &nbsp;
    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @guest
            <li><a href="{{ route('login') }}">登录</a></li>
            <li><a href="{{ route('register') }}">注册</a></li>
        @else
            <li><a href="/threads/create">新建话题</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu">
                    <li><a href="{{route('profile.show',auth()->user()->name)}}">个人中心</a> </li>
                    <li><a href="/threads?by={{ auth()->user()->name }}">我的</a> </li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            退出
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endguest
    </ul>
</div>
