@extends('layout.index')

@section('content')
<div class="container mt-5">
    <div class="container">
        <div class="mb-3">
            <h2 class="fw-bold">Edit Data Siswa</h2>
        </div>
        <div class="mb-4">
            <a href="{{ route('students.show', $student->id) }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
                <i class="bi bi-caret-left-fill me-1"></i> Kembali
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

        <div class="card shadow-sm p-4 mb-5 bg-white rounded">
            <form action="{{ route('students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="fw-bold mb-3">Data Siswa</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                               name="nisn" value="{{ old('nisn', $student->student->nisn) }}" required>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">No Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               name="phone" value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="class" class="form-label">Kelas</label>
                        <select class="form-select @error('class') is-invalid @enderror" name="class" required>
                            <option value="">Pilih Kelas</option>
                            <option value="7" {{ old('class', $student->student->class) == '7' ? 'selected' : '' }}>Kelas 7</option>
                            <option value="8" {{ old('class', $student->student->class) == '8' ? 'selected' : '' }}>Kelas 8</option>
                            <option value="9" {{ old('class', $student->student->class) == '9' ? 'selected' : '' }}>Kelas 9</option>
                        </select>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select @error('gender') is-invalid @enderror" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('gender', $student->student->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $student->student->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="birthplace" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('birthplace') is-invalid @enderror" 
                               name="birthplace" value="{{ old('birthplace', $student->student->birthplace) }}">
                        @error('birthplace')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="birthdate" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" 
                               name="birthdate" value="{{ old('birthdate', $student->student->birthdate) }}">
                        @error('birthdate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="fw-bold mb-3 mt-4">Data Wali</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="parent_name" class="form-label">Nama Wali</label>
                        <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                               name="parent_name" value="{{ old('parent_name', optional(optional($student->student->studentParent)->user)->name) }}" required>
                        @error('parent_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="parent_email" class="form-label">Email Wali</label>
                        <input type="email" class="form-control @error('parent_email') is-invalid @enderror" 
                               name="parent_email" value="{{ old('parent_email', optional(optional($student->student->studentParent)->user)->email) }}" required>
                        @error('parent_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="parent_phone" class="form-label">No. Telepon Wali</label>
                        <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                               name="parent_phone" value="{{ old('parent_phone', optional(optional($student->student->studentParent)->user)->phone) }}">
                        @error('parent_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="family_relation" class="form-label">Hubungan dengan Siswa</label>
                        <select class="form-select @error('family_relation') is-invalid @enderror" name="family_relation" required>
                            <option value="">Pilih Hubungan</option>
                            <option value="Ayah" {{ old('family_relation', optional($student->student->studentParent)->family_relation) == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                            <option value="Ibu" {{ old('family_relation', optional($student->student->studentParent)->family_relation) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                            <option value="Wali Lainnya" {{ old('family_relation', optional($student->student->studentParent)->family_relation) == 'Wali Lainnya' ? 'selected' : '' }}>Wali Lainnya</option>
                        </select>
                        @error('family_relation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="parent_address" class="form-label">Alamat Wali</label>
                    <textarea class="form-control @error('parent_address') is-invalid @enderror" 
                              name="parent_address" rows="3">{{ old('parent_address', optional(optional($student->student->studentParent)->user)->address) }}</textarea>
                    @error('parent_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 