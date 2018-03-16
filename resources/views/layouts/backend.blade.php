<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name','blog') }} | @yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/bootstrap3.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link href="{{ asset('datatables/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Froala -->
    <link href="{{ asset('froala/css/froala_editor.pkgd.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{{ config('app.name','blog') }}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('user.edit',Auth::id()) }}"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->name }}</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            @include('layouts._sidemenu')
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">@yield('title')</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                @yield('content')
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap3.min.js') }}"></script>

    <!-- Datatables -->
    <script src="{{ asset('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap.min.js') }}"></script>

    <!-- Froala -->
    <script src="{{ asset('froala/js/froala_editor.pkgd.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

    <script type="text/javascript">
    $(function() {
        $('textarea#editor').froalaEditor({
            toolbarButtons: ['fullscreen','|','undo', 'redo' ,'|','bold','italic','underline','strikeThrough','subscript','superscript','|','align','formatOL','formatUL','outdent', 'indent','clearFormatting','insertTable','html'],
            quickInsertTags: ['']
        });
    });
    </script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>

    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>

    <script type="text/javascript">
        function ConfirmDelete() {
            var x = confirm('Are you sure?');
            if(x) return true;
            else return false;
        }
        
        function Verification(id,status) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                type: 'POST',
                url: '{{ url('back/verification').'/' }}'+id,
                data: {status: status, _method: 'PATCH'},
                success: function(data) {
                    if(data.status == 1) {
                        alert('Verification Accepted');
                        $('#post-table').DataTable().ajax.reload();
                    }
                    else {
                        alert('Verification Rejected');
                    }
                }
            });
        }

        function Revision() {
            id = $('#post_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                type: 'POST',
                url: '{{ url('back/revision').'/' }}'+id,
                data: {note: $('#note').val(), _method: 'PATCH'}
            }).always(function() {
                $('#modalmodal').modal('hide');
            });
            $('#post-table').DataTable().ajax.reload();
        }

        function Approval(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                dataType: 'JSON',
                type: 'POST',
                url: '{{ url('back/approval').'/' }}'+id,
                data: {_method: 'PATCH'},
                success: function(data) {
                    alert('Approval Accepted');
                    $('#post-table').DataTable().ajax.reload();
                }
            });
        }

        function check_chief_btn(status) {
            if(status != '0') {
                return 'disabled';
            }
        }

        function check_leader_btn(status) {
            if(status != '1') {
                return 'disabled';
            }
        }

        function post_status(status) {
            if(status == '3') {
                return '<span class="label label-success">Published</span>';
            }
            else if(status == '2') {
                return '<span class="label label-danger">Revising</span>';
            }
            else if(status == '1') {
                return '<span class="label label-info">Waiting</span>';
            }
            else {
                return '<span class="label label-warning">Pending</span>';
            }
        }
    </script>

    @stack('scripts')

</body>

</html>