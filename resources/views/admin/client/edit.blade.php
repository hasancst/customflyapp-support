@extends('admin.layout')

@section('judul', 'Edit Client')

@section('konten')
<div class="card">
    <h3><i class="fas fa-user-edit"></i> Edit Client</h3>
    
    <form action="/admin/client/update/{{ $client->id }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Name <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $client->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                @error('name')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email <span style="color: #ef4444;">*</span></label>
                <input type="email" name="email" value="{{ old('email', $client->email) }}" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                @error('email')
                    <small style="color: #ef4444;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Shop ID</label>
                <input type="text" name="shop_id" value="{{ old('shop_id', $client->shop_id) }}" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">App</label>
                <select name="app" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="">-- Pilih App --</option>
                    <option value="Uploadfly" {{ old('app', $client->app) == 'Uploadfly' ? 'selected' : '' }}>Uploadfly</option>
                    <option value="IMCST" {{ old('app', $client->app) == 'IMCST' ? 'selected' : '' }}>IMCST</option>
                    <option value="Amazonify" {{ old('app', $client->app) == 'Amazonify' ? 'selected' : '' }}>Amazonify</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Plan</label>
                <input type="text" name="plan" value="{{ old('plan', $client->plan) }}" placeholder="e.g., Basic, Pro, Enterprise" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Country (2-letter code)</label>
                <input type="text" name="country" value="{{ old('country', $client->country) }}" maxlength="2" placeholder="e.g., US, ID, GB" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; text-transform: uppercase;">
                <small style="color: #64748b;">ISO 3166-1 alpha-2 code</small>
            </div>

            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Status <span style="color: #ef4444;">*</span></label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                    <option value="active" {{ old('status', $client->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $client->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="suspended" {{ old('status', $client->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <small style="color: #64748b;">
                <strong>Created:</strong> {{ $client->created_at->format('d M Y H:i') }} | 
                <strong>Last Updated:</strong> {{ $client->updated_at->format('d M Y H:i') }}
            </small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn"><i class="fas fa-save"></i> Update Client</button>
            <a href="/admin/client" class="btn" style="background: #64748b;"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </form>
</div>
@endsection
