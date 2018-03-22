@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('content')
@if(Auth::user()->role == 'editor')
	<div class="row">
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-green">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="huge">{{ count($published_data) }}</div>
							<div>Published</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="huge">{{ count($waiting_data) }}</div>
							<div>Waiting</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-red">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="huge">{{ count($revising_data) }}</div>
							<div>Revising</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
		<div class="col-lg-3 col-md-6">
			<div class="panel panel-yellow">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12 text-center">
							<div class="huge">{{ count($pending_data) }}</div>
							<div>Pending</div>
						</div>
					</div>
				</div>
				<a href="#">
					<div class="panel-footer">
						<span class="pull-left">View Details</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div>
				</a>
			</div>
		</div>
	</div>
@else
	<div class="row">
		<div class="col-md-3 col-md-offset-6">
		    @php
		    $month[''] = 'Month';
		    $month[1] = 'January';
		    $month[2] = 'February';
		    $month[3] = 'March';
		    $month[4] = 'April';
		    $month[5] = 'May';
		    $month[6] = 'June';
		    $month[7] = 'July';
		    $month[8] = 'August';
		    $month[9] = 'September';
		    $month[10] = 'October';
		    $month[11] = 'November';
		    $month[12] = 'December';
		    @endphp
		    {{ Form::select('bulan',$month,'',['class'=>'form-control']) }}
		</div>
		<div class="col-md-3">
			@php
			$year[''] = 'Year';
			@endphp
		    @foreach ($years as $y)
		    	@php
		    	$year[$y->tahun] = $y->tahun;
		    	@endphp
		    @endforeach
		    {{ Form::select('tahun',$year,'',['class'=>'form-control']) }}
		</div>
	</div>
	<br>
	<div class="row">
	    <div class="col-md-12">
	    	<div id="postcharts" style="width:100%; height:400px;"></div>
	    </div>
	</div>
@endif
@endsection

@if(Auth::user()->role != 'editor')
@push('scripts')
<script type="text/javascript">
function changeYear(chart) {
	if($('[name="tahun"]').val() != '') {
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
			},
			type: 'POST',
			url: '{{ route('chart.pertahun') }}',
			data: $('[name="tahun"]').serialize(),
			dataType: 'JSON',
			success: function(data) {
				chart.series[0].setData(data[0]);
				chart.series[1].setData(data[1]);
				chart.series[2].setData(data[2]);
			}
		});
	}
}

function changeMonth(chart) {
	if($('[name="bulan"]').val() != '') {
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
			},
			type: 'POST',
			url: '{{ route('chart.perbulan') }}',
			data: $('[name="bulan"]').serialize(),
			dataType: 'JSON',
			success: function(data) {
				chart.series[0].setData(data[0]);
				chart.series[1].setData(data[1]);
				chart.series[2].setData(data[2]);
				chart.series[3].setData(data[3]);
			}
		});
	}
}

var revising_data = @json($revising_data);
var pending_data = @json($pending_data);
var waiting_data = @json($waiting_data);
var published_data = @json($published_data);
var options = {
    chart: {
        renderTo: 'postcharts',
        type: 'column'
    },
    title: {
    	text: 'Data Post'
    },
    xAxis: {
    	type: 'category',
    	crosshair: true
    },
    yAxis: {
    	title: {
    		text: 'Jumlah'
    	}
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    series: [{
    	name: 'Revising',
    	data: revising_data,
    	color: '#d9534f'
    },{
    	name: 'Pending',
    	data: pending_data,
    	color: '#f0ad4e'
    },{
    	name: 'Waiting',
    	data: waiting_data,
    	color: '#5bc0de'
    },{
    	name: 'Published',
    	data: published_data,
    	color: '#5cb85c'
    }]
};

$(document).ready(function() {
	var chart = new Highcharts.Chart(options);

	$('[name="tahun"]').change(function() {
		changeYear(chart);
	});

	$('[name="bulan"]').change(function() {
		changeMonth(chart);
	});
});
</script>
@endpush
@endif