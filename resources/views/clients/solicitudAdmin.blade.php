@extends('clients.layouts')

@section('content')
<x-app-layout>



    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
    
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif
    
            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Lista de Solicitudes</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">CUIT/DNI</th>
                            <th scope="col">TELEFONO</th>
                            <th scope="col">ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->id }}</td>
                                <td>{{ $solicitud->username }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($solicitud->created_at))}}</td>
                                <td>{{ $solicitud->address  }}</td>
                                <td>{{ $solicitud->cuit}}</td>
                                <td>{{$solicitud->phone }} </td>
                                <td>
                                      <a href="{{ route('clients.solicitudAceptada', $solicitud->id) }}" class="btn btn-success btn-sm"><i class="bi bi-check"></i></a>    

                                    <a href="{{ route('clients.solicitudDenegada', $solicitud->id) }}" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                  
                                </td>
                            </tr>
                            @empty
                                <td colspan="7">
                                    <span class="text-danger">
                                        <strong>Nada por aqui!</strong>
                                    </span>
                                </td>
                            @endforelse
                        </tbody>
                      </table>
    
                   
    
                </div>
            </div>
        </div>    
    </div>

</x-app-layout>    
@endsection