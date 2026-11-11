@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')
{{-- Tabs --}}
<div class="tabs-nav">
    <a href="{{ route('students.index', array_filter(['q' => request('q')])) }}"
       class="tab-item {{ !request('jk') ? 'active' : '' }}">
        <i class="bi bi-list-ul"></i> Semua <span class="count">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('students.index', array_filter(['jk' => 'L', 'q' => request('q')])) }}"
       class="tab-item {{ request('jk') == 'L' ? 'active' : '' }}">
        <i class="bi bi-gender-male"></i> Laki-laki <span class="count">{{ $counts['L'] }}</span>
    </a>
    <a href="{{ route('students.index', array_filter(['jk' => 'P', 'q' => request('q')])) }}"
       class="tab-item {{ request('jk') == 'P' ? 'active' : '' }}">
        <i class="bi bi-gender-female"></i> Perempuan <span class="count">{{ $counts['P'] }}</span>
    </a>
</div>

<div class="panel has-tabs">
    {{-- Filter + tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center gap-3 mb-3 filter-row">
        <form method="GET" class="filter-box">
            @if (request('jk')) <input type="hidden" name="jk" value="{{ request('jk') }}"> @endif
            <i class="bi bi-funnel"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIS / kelas">
        </form>
        <a href="{{ route('students.create') }}" class="btn-pill"><i class="bi bi-plus-lg me-1"></i> Siswa baru</a>
    </div>

    {{-- Tabel --}}
    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th style="width:44px"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                    <th>NIS</th>
                    <th>Nama siswa</th>
                    <th>Jenis kelamin</th>
                    <th>Kelas</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Dibuat</th>
                    <th>Diperbarui</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input row-check"
                                   value="{{ $student->id }}"
                                   data-edit="{{ route('students.edit', $student) }}">
                        </td>
                        <td>#{{ $student->nis }}</td>
                        <td class="fw-semibold">{{ $student->nama }}</td>
                        <td>
                            @if ($student->jenis_kelamin === 'L')
                                <span class="chip chip-blue">Laki-laki</span>
                            @else
                                <span class="chip chip-orange">Perempuan</span>
                            @endif
                        </td>
                        <td>{{ $student->kelas }}</td>
                        <td>{{ $student->email ?? '-' }}</td>
                        <td title="{{ $student->alamat }}">
                            {{ $student->alamat ? \Illuminate\Support\Str::limit($student->alamat, 30) : '-' }}
                        </td>
                        <td>{{ $student->created_at->translatedFormat('d M Y') }}</td>
                        <td>{{ $student->updated_at->diffForHumans() }}</td>
                        <td class="text-end">
                            <a href="{{ route('students.edit', $student) }}" class="row-btn" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data {{ $student->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="row-btn del" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-muted py-5">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $students->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Bar aksi melayang (muncul saat ada checkbox dipilih) --}}
<div id="bulkBar" class="bulk-bar">
    <button type="button" id="clearSel" class="bulk-x" title="Batalkan pilihan"><i class="bi bi-x-lg"></i></button>
    <span class="bulk-count" id="selCount">0</span>
    <span>siswa dipilih</span>
    <button type="button" class="bulk-btn" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
    <a id="editBtn" class="bulk-btn disabled"><i class="bi bi-pencil"></i> Edit</a>
    <button type="button" id="deleteBtn" class="bulk-btn danger"><i class="bi bi-trash"></i> Hapus</button>
</div>

<form id="bulkForm" method="POST" action="{{ route('students.bulk-destroy') }}">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
    const checkAll = document.getElementById('checkAll');
    const bar      = document.getElementById('bulkBar');
    const editBtn  = document.getElementById('editBtn');
    const rows     = () => [...document.querySelectorAll('.row-check')];

    function refresh() {
        const checked = rows().filter(c => c.checked);

        rows().forEach(c => c.closest('tr').classList.toggle('selected', c.checked));
        document.getElementById('selCount').textContent = checked.length;
        bar.classList.toggle('show', checked.length > 0);

        // Tombol Edit hanya aktif jika tepat 1 siswa dipilih
        if (checked.length === 1) {
            editBtn.href = checked[0].dataset.edit;
            editBtn.classList.remove('disabled');
        } else {
            editBtn.removeAttribute('href');
            editBtn.classList.add('disabled');
        }

        checkAll.checked = checked.length > 0 && checked.length === rows().length;
        checkAll.indeterminate = checked.length > 0 && checked.length < rows().length;
    }

    rows().forEach(c => c.addEventListener('change', refresh));

    checkAll.addEventListener('change', () => {
        rows().forEach(c => c.checked = checkAll.checked);
        refresh();
    });

    document.getElementById('clearSel').addEventListener('click', () => {
        rows().forEach(c => c.checked = false);
        refresh();
    });

    document.getElementById('deleteBtn').addEventListener('click', () => {
        const checked = rows().filter(c => c.checked);
        if (!checked.length) return;
        if (!confirm(`Yakin hapus ${checked.length} data siswa?`)) return;

        const form = document.getElementById('bulkForm');
        checked.forEach(c => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = c.value;
            form.appendChild(input);
        });
        form.submit();
    });
</script>
@endpush