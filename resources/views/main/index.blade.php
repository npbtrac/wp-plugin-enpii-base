@extends('enpii-base::layouts/main')

@section('content')
	<h1><?php echo 'WP App'; ?></h1>
	<p>{{ $message }}</p>
	{{
		wp_app_html()->div( esc_html( 'WP App Homepage </div> content' ) );
	}}
@endsection
