@extends('products.layouts')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Product
                </div>
                <div class="float-end">
                    <a href="{{ route('products.indexCategorias') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('categoria.store') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name Categories</label>
                        <div class="col-md-6">
                          <input type="text"  class="form-control @error('name') is-invalid @enderror" pattern="[A-Za-z\s]+" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Categories">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection