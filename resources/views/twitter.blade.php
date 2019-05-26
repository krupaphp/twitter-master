@extends('layouts.app')

@section('content')

<div class="container">

     <form method="POST" action="{{ route('search.tweet') }}" enctype="multipart/form-data">


        {{ csrf_field() }}


        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label>Username:</label>
            <textarea class="form-control" name="screen_name"placeholder="twitterdev, adhirnews" ><?php echo isset($screen_name['screen_name']) ? $screen_name['screen_name'] : '';?></textarea>
        </div>
        <div class="form-group"> 
            <button class="btn btn-success">Search Tweet for User</button>
        </div>
    </form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="50px">No</th>
                <th>Twitter Id</th>
                <th>Created At</th>
                <th>Source</th>
                <th>Message</th>
                <th>Username</th>
                <th>Link</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($data))
                @foreach($data as $key => $value)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $value['id'] }}</td>
                        <td>{{ $value['created_at'] }}</td>
                        <td>{{ 'Twitter' }}</td>
                        <td>{{ $value['text'] }}</td>
                        <td>{{ $value['user']['name'] }}</td>
                        <td><a href="https://twitter.com/<?php echo $screen_name['screen_name'];?>/status/{{ $value['id'] }}"></a>https://twitter.com/<?php echo $screen_name['screen_name'];?>/status/{{ $value['id'] }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">There are no data.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


@endsection
