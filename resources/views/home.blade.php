@extends('layouts.app')
@section('title')
    ButikTrend

    @endsection
@section('content')


<script>
    window.user = @json($user ?? null);
</script>
<div id="app">

</div>
@endsection
