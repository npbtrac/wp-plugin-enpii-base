@extends('enpii-base::layouts/main')

@section('content')
	<h1><?php the_title(); ?></h1>
	<div class="page">
		<?php the_content(); ?>
	</div>
@endsection
