@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($user->roles_id ==1)
                        Anda login sebagai admin
                    @else
                        Anda login sebagai user 
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
