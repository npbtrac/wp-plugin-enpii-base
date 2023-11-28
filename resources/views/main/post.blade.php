@extends('enpii-base::layouts/main')

@section('content')
	<h1><?php the_title() ?></h1>
	<div class="post">
		<?php the_content() ?>
	</div>
@endsection
