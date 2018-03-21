<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ config('app.name','blog') }} | Laporan</title>
	<style type="text/css">
	.page-break {
		page-break-after: always;
	}
	</style>
</head>
<body>
<script type="text/php">
if(isset($pdf)) {
	$x = ($pdf->get_width() / 2) - 25;
	$y = 18;
	$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
	$font = $fontMetrics->get_font("helvetica", "bold");
	$size = 9;
	$color = array(0,0,0);
	$word_space = 0.0;  //  default
	$char_space = 0.0;  //  default
	$angle = 0.0;   //  default
	$pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
}
</script>
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
		{!! $p->content !!}
	<div class="page-break"></div>
@endforeach
</body>
</html>