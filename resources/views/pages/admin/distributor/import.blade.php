@extends('layout.admin.main')

@section('title', 'Import Data Distributor')

@section('content')
<div class="container mt-4">
    <h2>Import Data Distributor</h2>
    <hr>

    <!-- Form Upload File -->
    <div class="card">
        <div class="card-header">
            <h5>Unggah File</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('distributors.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Pilih File (.xlsx / .csv)</label>
                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">

                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Import</button>
            </form>
        </div>
    </div>

    <!-- Notifikasi -->
    @if (session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Kesalahan -->
    @if (session('import_errors'))
        <div class="card mt-4">
            <div class="card-header">
                <h5>Kesalahan pada Data</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Baris</th>
                            <th>Atribut</th>
                            <th>Pesan Kesalahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('import_errors') as $error)
                            <tr>
                                <td>{{ $error['row'] }}</td>
                                <td>{{ $error['attributes'] }}</td>
                                <td>{{ $error['errors'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection