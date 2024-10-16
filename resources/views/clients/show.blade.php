@extends('clients.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Informacion de los clientes
                </div>
                <div class="float-end">
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <label for="username" class="col-md-4 col-form-label text-md-end text-start"><strong>Username:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->username }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->address }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="cuit" class="col-md-4 col-form-label text-md-end text-start"><strong>Cuit:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->cuit }}
                        </div>
                    </div>

                    {{-- <div class="row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Email:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->email }}
                        </div>
                    </div> --}}

                    <div class="row">
                        <label for="phone" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->phone }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="created_at" class="col-md-4 col-form-label text-md-end text-start"><strong>Fecha de ingreso:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->created_at }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="users_id" class="col-md-4 col-form-label text-md-end text-start"><strong>ID del Usuario:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $client[0]->users_id }}
                        </div>
                    </div>
        
            </div>
        </div>
    </div>    
</div>
    
@endsection
