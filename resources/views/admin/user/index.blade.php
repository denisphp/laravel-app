@extends('layouts.adminapp')

@section('content')
    <div id="index">
        @if(!empty($text))
            <div class="container">{!! $text !!}</div>
        @endif
        <div class="container">
            <style>
                #example_grid1 td {
                    white-space: nowrap;
                }
            </style>
            <?= $grid ?>
        </div>
    </div>
@stop