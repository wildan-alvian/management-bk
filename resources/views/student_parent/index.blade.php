@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Wali Murid</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('student-parents.index') }}" class="d-flex" id="filterForm">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/NIK">
            <button type="submit" class="btn btn-outline-secondary me-2">
                <i class="bi bi-search"></i>
            </button>
        </form>
        
            <!-- Button dropdown icon -->
            <div class="dropdown d-flex align-items-center">
                @if(request('search'))
                  <a href="{{ route('student-parents.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle-fill"></i>
                  </a>
                @endif
              </div>
              
              <style>
                #filterDropdown::after {
                  display: none;
                }
              </style>
              

            @can('create-student-parent')
                <a href="{{ route('student-parents.create') }}" class="btn btn-add">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Wali Murid
                </a>
            @endcan
        </div>
    </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! nl2br(e(session('success'))) !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 5%;">No.</th>
                        <th style="width: 15%;">NIK</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 20%;">No. Telepon</th>
                        <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($studentParents as $index => $studentParent)
                        <tr>
                            <td class="text-center">{{ $studentParents->firstItem() + $index }}</td>
                            <td>{{ $studentParent->id_number }}</td>
                            <td>{{ $studentParent->name }}</td>
                            <td>{{ $studentParent->email }}</td>
                            <td>{{ $studentParent->phone }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <a class="btn btn-sm" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $studentParent->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $studentParent->id }}">
                                        @can('view-student-parent')
                                        <a class="dropdown-item" href="{{ route('student-parents.show', $studentParent->id) }}">
                                            <i class="bi bi-eye me-2"></i>Detail
                                        </a>
                                        @endcan
                                        @can('edit-student-parent')
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $studentParent->id }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                        @endcan
                                        @can('delete-student-parent')
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $studentParent->id }}">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                        @endcan
                                    </div>
                                </div>

                                @can('edit-student-parent')
                                    @include('student_parent.partials._edit_modal', ['studentParent' => $studentParent])
                                @endcan
                                @can('delete-student-parent')
                                    @include('student_parent.partials._delete_modal', ['studentParent' => $studentParent])
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                @if(request('search') || request('class_filter'))
                                    Tidak ada siswa yang ditemukan dengan kata kunci atau filter tersebut.
                                @else
                                    Tidak ada data siswa yang tersedia.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $studentParents->appends(request()->query())->links() }}
        </div>
        @endsection
