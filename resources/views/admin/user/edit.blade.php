@extends('layouts.adminapp')

@section('content')
    <div id="edit">
        <h1>Edit User# {{ $user->id }}</h1>
        <!-- if there are creation errors, they will show here -->

        {{ Form::model($user, ['route' => ['admin.users.update', $user->id], 'method' => 'POST']) }}

        <div class="form-group">
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
            @if ($errors->has('name'))
                <span class="error">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="form-group">
            {{ Form::label('email', 'Email') }}
            {{ Form::email('email', null, ['class' => 'form-control']) }}
            @if ($errors->has('email'))
                <span class="error">{{ $errors->first('email') }}</span>
            @endif
        </div>

        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}

        {{ Form::close() }}
    </div>
@stop