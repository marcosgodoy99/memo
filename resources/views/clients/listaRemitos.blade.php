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
    
            <div class="card">
                <div class="card-header">Lista de Remitos</div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">NUMERO DE REMITO</th>
                            <th scope="col">NOMBRE CLIENTE</th>
                            <th scope="col">FECHA DEL REMITO</th>
                            <th scope="col">DIRECCION</th>
                            <th scope="col">CUIT</th>
                            <th scope="col">ACCIONES</th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($remitos as $remito)
                            <tr>
                                <td>{{ $remito->numberRemito }}</td>
                                <td>{{ $remito->nameClient }}</td>
                                <td>{{ date('d/m/Y H:i', strtotime($remito->created_at))}}</td>
                                <td>{{ $remito->address }}</td>
                                <td>{{ $remito->cuit }}</td>
                                <td>

                                    <a href="{{ route('clients.RemitosPDF', $remito->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i></a>    

                                    <a href="{{ route('clients.RemitosPDFDescarga', $remito->id) }}" class="btn btn-success btn-sm"><i class="bi bi-download"></i></a>
                                </td>
                            </tr>
                            @empty
                                <td colspan="7">
                                    <span class="text-danger">
                                        <strong>Ningun Remito encontrado!</strong>
                                    </span>
                                </td>
                            @endforelse
                        </tbody>
                      </table>
    
                      {{ $remitos->links() }}
    
                </div>
            </div>
        </div>    
    </div>

</x-app-layout>    
@endsection