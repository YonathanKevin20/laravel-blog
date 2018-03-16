<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            @if(Auth::user()->role == 'leader')
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
            @elseif(Auth::user()->role == 'chief')
            <li>
                <a href="{{ route('post.index') }}"><i class="fa fa-file-o fa-fw"></i> Post</a>
            </li>
            <li>
                <a href="{{ route('category.index') }}"><i class="fa fa-tag fa-fw"></i> Category</a>
            </li>
            @elseif(Auth::user()->role == 'editor')
            <li>
                <a href="{{ route('post.index') }}"><i class="fa fa-file-o fa-fw"></i> Post</a>
            </li>
            @endif
        </ul>
    </div>
</div>