<div class="col-md-4">
    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
            <form action="{{ route('post.paginate') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search for..." value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-secondary" type="button">Go!</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Categories</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled mb-0">
                        @if(count($categories))
                            @foreach($categories as $c)
                                <li><a href="{{ route('category.per',$c->id) }}">{{ $c->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>