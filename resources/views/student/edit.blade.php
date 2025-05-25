@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-pencil-square me-2"></i>Edit Data Siswa
    </h4>
    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
        <i></i>
        Kembali
    </a>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Data Siswa Section -->
                <div class="col-12">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-person-vcard me-2"></i>
                        Data Siswa
                    </h5>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nisn" class="form-label">NISN</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                            <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                   id="nisn" name="nisn" value="{{ old('nisn', $student->student->nisn) }}" required>
                        </div>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $student->name) }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $student->email) }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">No Telepon</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="class" class="form-label">Kelas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                            <select class="form-select @error('class') is-invalid @enderror" id="class" name="class" required>
                                <option value="">Pilih Kelas</option>
                                <option value="7" {{ old('class', $student->student->class) == '7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="8" {{ old('class', $student->student->class) == '8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="9" {{ old('class', $student->student->class) == '9' ? 'selected' : '' }}>Kelas 9</option>
                            </select>
                        </div>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('gender', $student->student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender', $student->student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birthplace" class="form-label">Tempat Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control @error('birthplace') is-invalid @enderror" 
                                   id="birthplace" name="birthplace" value="{{ old('birthplace', $student->student->birthplace) }}">
                        </div>
                        @error('birthplace')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror" 
                                   id="birthdate" name="birthdate" value="{{ old('birthdate', $student->student->birthdate) }}">
                        </div>
                        @error('birthdate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="address" class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-house"></i></span>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Data Wali Section -->
                <div class="col-12 mt-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-people me-2"></i>
                        Data Wali
                    </h5>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="student_parent_id" class="form-label">Wali</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <select class="form-select select2 @error('student_parent_id') is-invalid @enderror"
                                    id="student_parent_id" name="student_parent_id" required>
                                @if($student->student->studentParent)
                                    <option value="{{ $student->student->studentParent->id }}" selected>
                                        {{ $student->student->studentParent->user->id_number }} - {{ $student->student->studentParent->user->name }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        @error('student_parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#student_parent_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Cari wali berdasarkan NIK atau nama...',
        allowClear: true,
        ajax: {
            url: '{{ route("students.parents") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || ''
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            text: item.id_number + ' - ' + item.name
                        }
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0
    });

    // Trigger fetch data saat select dibuka pertama kali
    let guardiansFetched = false;
    $('#student_parent_id').on('select2:open', function (e) {
        if (!guardiansFetched) {
            $('.select2-search__field').val('').trigger('input');
            guardiansFetched = true;
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.input-group .select2-container {
    flex: 1 1 auto;
    width: 1% !important;
}
.input-group .select2-selection--single {
    height: 100% !important;
    padding: 0.375rem 0.75rem;
    border: 1px solid #e2e8f0 !important;
}
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    display: flex;
    align-items: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.select2-container--bootstrap-5 .select2-selection--single .select2-selection__clear {
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
}
</style>
@endpush 