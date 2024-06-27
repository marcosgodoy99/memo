@extends('clients.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Client Information
                </div>
                <div class="float-end">
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <label for="username" class="col-md-4 col-form-label text-md-end text-start"><strong>Username:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->username }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start"><strong>Password:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->password }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->address }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="phone" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->phone }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="cuit" class="col-md-4 col-form-label text-md-end text-start"><strong>CUIT:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client->cuit }}
                        </div>
                    </div>
        
            </div>
        </div>
    </div>    
</div>
    
@endsection
