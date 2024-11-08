@extends('products.layouts')

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
                    <a href="{{ route('products.indexCategorias') }}" class="btn btn-primary btn-sm">&larr; Atras</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('categorias.update', $categorias[0]->id) }}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">NOMBRE DE LA CATEGORIA</label>
                        <div class="col-md-6">
                          <input type="text"  pattern="[A-Za-z\s]+" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $categorias[0]->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>


                    <input type="hidden" name="id" value="{{$categorias[0]->id}}">
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Actualizar">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection
