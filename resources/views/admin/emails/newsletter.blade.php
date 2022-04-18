@extends('admin.layouts.emails.blank')

@section('content')
{!! $newsletter->message !!}
@endsection
