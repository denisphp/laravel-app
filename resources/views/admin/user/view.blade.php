@extends('layouts.adminapp')

@section('content')
    <div id="view">
        <h1>User# {{ $user->id }}</h1>

        <table class="table">
            <tbody>
                <tr>
                    <th>ID</th>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@stop