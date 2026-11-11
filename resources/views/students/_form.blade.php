@csrf
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">NIS</label>
        <input type="text" name="nis" value="{{ old('nis', $student->nis ?? '') }}"
               class="form-control @error('nis') is-invalid @enderror">
        @error('nis') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" value="{{ old('nama', $student->nama ?? '') }}"
               class="form-control @error('nama') is-invalid @enderror">
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $student->jenis_kelamin ?? '') == 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $student->jenis_kelamin ?? '') == 'P')>Perempuan</option>
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir"
               value="{{ old('tanggal_lahir', isset($student) ? $student->tanggal_lahir->format('Y-m-d') : '') }}"
               class="form-control @error('tanggal_lahir') is-invalid @enderror">
        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Kelas</label>
        <input type="text" name="kelas" value="{{ old('kelas', $student->kelas ?? '') }}" placeholder="contoh: X IPA 1"
               class="form-control @error('kelas') is-invalid @enderror">
        @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Email (opsional)</label>
        <input type="email" name="email" value="{{ old('email', $student->email ?? '') }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Alamat (opsional)</label>
        <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $student->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
</div>