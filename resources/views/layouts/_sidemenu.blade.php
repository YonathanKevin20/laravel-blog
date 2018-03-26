<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            @if(Auth::user()->role == 'leader')
            <li class="sidebar-search">
                <form action="{{ route('post.search') }}" method="GET">
                    <div class="input-group custom-search-form">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </li>
            <li>
                <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('post.index') }}"><i class="fa fa-file-o fa-fw"></i> Post</a>
            </li>
            <li>
                <a href="{{ route('category.index') }}"><i class="fa fa-tag fa-fw"></i> Category</a>
            </li>
            <li>
                <a href="{{ route('comment.index') }}"><i class="fa fa-comment fa-fw"></i> Comment</a>
            </li>
            <li>
                <a href="{{ route('subscriber.index') }}"><i class="fa fa-users fa-fw"></i> Subscriber</a>
            </li>
            @elseif(Auth::user()->role == 'chief')
            <li>
                <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('post.index') }}"><i class="fa fa-file-o fa-fw"></i> Post</a>
            </li>
            <li>
                <a href="{{ route('category.index') }}"><i class="fa fa-tag fa-fw"></i> Category</a>
            </li>
            @elseif(Auth::user()->role == 'editor')
            <li>
                <a href="{{ route('home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('post.index') }}"><i class="fa fa-file-o fa-fw"></i> Post</a>
            </li>
            @endif
        </ul>
    </div>
</div>