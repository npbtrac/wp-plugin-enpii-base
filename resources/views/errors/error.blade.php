@php
	try {
		$http_code = $exception->getStatusCode();
	} catch (\Exception $e) {
		$http_code = 500;
	}

	$errors = [
		'401' => __('Unauthorized'),
		'403' => __('Forbidden'),
		'404' => __('Not Found'),
		'419' => __('Page Expired'),
		'429' => __('Too Many Requests'),
		'500' => __('Server Error'),
		'503' => __('Service Unavailable'),
	];
	$error_message = !empty($errors[$http_code]) ? $errors[$http_code] : __('Error');
@endphp

@extends('errors/layout-minimal-error')

@section('title', sprintf(__('WP App Error %s'), $http_code))
@section('code', $http_code)
@section('message', $error_message)
