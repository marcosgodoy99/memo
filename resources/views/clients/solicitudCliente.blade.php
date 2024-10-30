@extends('clients.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                </div>
                <div class="float-end">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.solicitudStore') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="username" class="col-md-4 col-form-label text-md-end text-start">NOMBRE CLIENTE</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" pattern="[A-Za-z\s]+" name="username" value="{{ old('username') }}">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start">DIRECCION</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="cuit" class="col-md-4 col-form-label text-md-end text-start">CUIT/DNI</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('cuit') is-invalid @enderror" id="cuit" name="cuit" value="{{ old('cuit') }}">
                                @if ($errors->has('cuit'))
                                <span class="text-danger">{{ $errors->first('cuit') }}</span>
                                @endif
                            </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="phone" class="col-md-4 col-form-label text-md-end text-start">TELEFONO</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="users_id" class="col-md-4 col-form-label text-md-end text-start"></label>
                        <div class="col-md-6">
                        <input type="hidden" name="users_id" id="users_id" value="{{$id}}">
                          @if ($errors->has('users_id'))
                              <span class="text-danger">{{ $errors->first('users_id') }}</span>
                          @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Client">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection
