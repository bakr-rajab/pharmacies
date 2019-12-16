@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Pharmacist </div>

                <div class="card-body">
                    {!! Form::open(['route' => ['pharmacists.store'], 'method' => 'POST']) !!}
                        <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name','',['required' => 'required','class' => 'form-control','placeholder'=>'Enter name']) !!}
                        </div>
                        <div class="form-group">
                    {!! Form::label('email', 'E-Mail Address', ['class' => 'form-controle']) !!}
                    {!! Form::email('email', null, ['required' => 'required','class' => 'form-control','placeholder'=>'Enter name']) !!}
                        </div>
                        <div class="form-group">
                    {!! Form::submit('Create Pharmacist', ['class' => 'form-control btn btn-outline-primary']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
