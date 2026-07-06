@extends('admin.layout')

@section('judul', 'Open New Ticket')

@section('konten')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 25px;">
        <h2 style="margin: 0;"><i class="fas fa-plus-circle"></i> Create New Ticket</h2>
        <p style="color: #64748b; margin-top: 5px;">Fill in the form below to open a new support ticket.</p>
    </div>

    <form action="/admin/tiket/tambah" method="POST">
        @csrf
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Subject / Issue Title</label>
            <input type="text" name="judul" required placeholder="e.g. Login Issue or Billing Question">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category</label>
                <select name="category_id" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->parent_id ? '↳ ' : '' }}{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Priority</label>
                <select name="prioritas" required>
                    <option value="rendah">Low</option>
                    <option value="sedang" selected>Medium</option>
                    <option value="tinggi">High (Urgent)</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Detailed Message</label>
            <textarea name="pesan" rows="8" required placeholder="Please describe your issue in detail..."></textarea>
        </div>

        <div style="display: flex; gap: 15px; border-top: 1px solid #e2e8f0; padding-top: 25px;">
            <button type="submit" class="btn"><i class="fas fa-save"></i> Create Ticket</button>
            <a href="/admin/tiket" class="btn btn-outline" style="border-color: #cbd5e1; color: #64748b;">Cancel</a>
        </div>
    </form>
</div>

<style>
    input, select, textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        outline: none;
        transition: 0.3s;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
</style>
@endsection
