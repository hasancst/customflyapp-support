@extends('tema::layout')

@section('title', 'Redaksi')

@section('konten')
<div class="editorial-page">
    <div style="background: linear-gradient(135deg, #014A7A 0%, #002D4B 100%); padding: 120px 8%; text-align: center; color: #fff; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 1;">
            <h1 style="font-size: 4.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -3px; line-height: 1;">Redaksi</h1>
            <p style="font-size: 1.5rem; opacity: 0.9; max-width: 900px; margin: 0 auto; line-height: 1.6; font-weight: 500;">Tim di balik setiap konten berkualitas yang Anda baca.</p>
        </div>
    </div>

    <div class="container" style="margin-top: -50px; margin-bottom: 100px; position: relative; z-index: 2;">
        <div style="background: #fff; padding: 60px; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); border: 1px solid var(--border);">
            <div style="text-align: center; max-width: 800px; margin: 0 auto 60px;">
                <h2 style="font-size: 2.5rem; color: var(--primary); margin-bottom: 20px;">Independen & Profesional</h2>
                <p style="color: var(--text-muted); font-size: 1.1rem; line-height: 1.8;">Kami bekerja dengan standar jurnalistik tinggi untuk memastikan setiap informasi hukum yang Anda terima adalah fakta yang valid dan objektif.</p>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div style="padding: 30px; border-radius: 20px; background: #f8fafc; border: 1px solid var(--border); text-align: center;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">Pemimpin Redaksi</h3>
                    <p style="font-weight: 700; font-size: 1.2rem; margin-bottom: 5px;">Budi Santoso, S.H., M.H.</p>
                    <small style="color: var(--text-muted);">budi@pinterhukum.id</small>
                </div>
                <div style="padding: 30px; border-radius: 20px; background: #f8fafc; border: 1px solid var(--border); text-align: center;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">Redaktur Pelaksana</h3>
                    <p style="font-weight: 700; font-size: 1.2rem; margin-bottom: 5px;">Siti Aminah, S.H.</p>
                    <small style="color: var(--text-muted);">siti@pinterhukum.id</small>
                </div>
                <div style="padding: 30px; border-radius: 20px; background: #f8fafc; border: 1px solid var(--border); text-align: center;">
                    <h3 style="color: var(--primary); margin-bottom: 10px;">Sekretaris Redaksi</h3>
                    <p style="font-weight: 700; font-size: 1.2rem; margin-bottom: 5px;">Dewi Sartika</p>
                    <small style="color: var(--text-muted);">dewi@pinterhukum.id</small>
                </div>
            </div>

            <div style="margin-top: 50px;">
                <h4 style="font-size: 1.5rem; margin-bottom: 25px; color: var(--text-main); text-align: center;">Staf Redaksi</h4>
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px;">
                    <span style="background: #ebf5ff; color: var(--primary); padding: 10px 25px; border-radius: 50px; font-weight: 600;">Andi Wijaya</span>
                    <span style="background: #ebf5ff; color: var(--primary); padding: 10px 25px; border-radius: 50px; font-weight: 600;">Eko Prasetyo</span>
                    <span style="background: #ebf5ff; color: var(--primary); padding: 10px 25px; border-radius: 50px; font-weight: 600;">Maya Indah</span>
                    <span style="background: #ebf5ff; color: var(--primary); padding: 10px 25px; border-radius: 50px; font-weight: 600;">Rizky Pratama</span>
                    <span style="background: #ebf5ff; color: var(--primary); padding: 10px 25px; border-radius: 50px; font-weight: 600;">Lisa Permata</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
