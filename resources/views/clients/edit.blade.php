@extends('clients.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Editar
                </div>
                <div class="float-end">
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('clients.update', $clients[0]->id) }}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="username" class="col-md-4 col-form-label text-md-end text-start">Nombre de cliente</label>
                        <div class="col-md-6">
                          <input type="username" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ $clients[0]->username }}">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start">Direccion</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ $clients[0]->address }}</textarea>
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="cuit" class="col-md-4 col-form-label text-md-end text-start">CUIT/DNI</label>
                        <div class="col-md-6">
                          <input type="number" class="form-control @error('cuit') is-invalid @enderror" id="cuit" name="cuit" value="{{ $clients[0]->cuit }}">
                            @if ($errors->has('cuit'))
                                <span class="text-danger">{{ $errors->first('cuit') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="phone" class="col-md-4 col-form-label text-md-end text-start">Telefono</label>
                        <div class="col-md-6">
                          <input type="number"  class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $clients[0]->phone }}">
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="users_id" value="{{$clients[0]->users_id}}">
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Actualizar">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection
