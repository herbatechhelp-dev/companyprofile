<!-- resources/views/tests/kraeplin.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tes Kraeplin</h2>
    <div class="card">
        <div class="card-body">
            <p>Instruksi: Isi tabel berikut dengan menjumlahkan angka yang berdekatan.</p>
            
            <form id="kraeplinForm" method="POST" action="{{ route('tests.kraeplin.store') }}">
                @csrf
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="kraeplinTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                @for($i = 1; $i <= 50; $i++)
                                    <th>{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for($row = 0; $row < 27; $row++)
                            <tr>
                                <td><strong>{{ $row + 1 }}</strong></td>
                                @for($col = 0; $col < 50; $col++)
                                <td>
                                    <input type="text" 
                                           name="results[{{ $row }}][{{ $col }}]" 
                                           class="form-control form-control-sm" 
                                           maxlength="2"
                                           oninput="validateInput(this)">
                                </td>
                                @endfor
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Simpan Hasil</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function validateInput(input) {
    // Hanya menerima angka atau string kosong
    input.value = input.value.replace(/[^0-9]/g, '');
    
    // Batasi panjang maksimal 2 digit
    if (input.value.length > 2) {
        input.value = input.value.slice(0, 2);
    }
}

// Auto move to next input
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 2) {
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const nextInput = inputs[index + 1];
                if (nextInput) {
                    nextInput.focus();
                }
            }
        });
    });
});
</script>
@endsection