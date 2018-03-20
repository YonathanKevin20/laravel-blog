<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ config('app.name','blog') }} | Report</title>
	<style type="text/css">
	.page-break {
		page-break-after: always;
	}
	</style>
</head>
<body>
@foreach($posts as $p)
	<h1>{{ $p->title }}</h1>
		<p>by {{ $p->user->name }}</p>
		<hr>
		<p>{{ $p->created_at->format('M d, Y \a\t h:i A') }}
			<span style="float: right;">{{ $p->category->name }}</span>
		</p>
		<hr>
		<!--
		<img src="{{ asset('storage'.substr($p->image,6)) }}" alt="{{ $p->image }}" width="10%">
		-->
		<p>{!! $p->content !!}</p>
	<div class="page-break"></div>
@endforeach
</body>
</html>