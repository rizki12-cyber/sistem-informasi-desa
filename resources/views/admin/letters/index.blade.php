@extends('layouts.admin')

@section('title', 'Kelola Surat')
@section('page-title', 'Kelola Surat')

@section('content')
<style>
    .page-head { margin-bottom: 28px; }
    .page-head .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #8a9a8a; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500; }
    .page-head .breadcrumb a { color: #8a9a8a; text-decoration: none; }
    .page-head .breadcrumb a:hover { color: #d4af37; }
    .page-head .breadcrumb .sep { color: #d0d8d0; }
    .page-head .breadcrumb .current { color: #d4af37; }
    .page-head h1 { font-size: 24px; font-weight: 700; color: #0a1a0a; margin: 0 0 4px; }
    .page-head p { font-size: 14px; color: #6a7a6a; margin: 0; }

    .stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-box { background: #fff; border-radius: 16px; padding: 20px 22px; border: 1px solid #eef3ee; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .stat-box:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.05); border-color: rgba(212,175,55,0.3); }
    .stat-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
    .stat-box.total::before { background: linear-gradient(90deg, #d4af37, #f0d060); }
    .stat-box.pending::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .stat-box.processing::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-box.ready::before { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .stat-box .stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; margin-bottom: 12px; }
    .stat-box.total .stat-icon { background: rgba(212,175,55,0.1); color: #d4af37; }
    .stat-box.pending .stat-icon { background: rgba(59,130,246,0.1); color: #3b82f6; }
    .stat-box.processing .stat-icon { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .stat-box.ready .stat-icon { background: rgba(34,197,94,0.1); color: #22c55e; }
    .stat-box .stat-number { font-size: 28px; font-weight: 800; color: #0a1a0a; line-height: 1.1; }
    .stat-box .stat-label { font-size: 12px; color: #8a9a8a; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

    .card { background: #fff; border-radius: 18px; border: 1px solid #eef3ee; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.03); }
    .card-toolbar { padding: 20px 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; border-bottom: 1px solid #f0f5f0; background: linear-gradient(180deg, #fafcfa, #fff); }
    .card-toolbar .toolbar-left { display: flex; align-items: center; gap: 14px; }
    .card-toolbar .icon-box { width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, rgba(212,175,55,0.15), rgba(212,175,55,0.05)); display: flex; align-items: center; justify-content: center; color: #d4af37; font-size: 18px; }
    .card-toolbar h3 { font-size: 16px; font-weight: 700; color: #0a1a0a; margin: 0; display: flex; align-items: center; gap: 10px; }
    .card-toolbar h3 .count { background: #f0f5f0; color: #6a7a6a; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 50px; }
    .card-toolbar p { font-size: 12px; color: #8a9a8a; margin: 2px 0 0; }

    .filter-bar { padding: 16px 24px; border-bottom: 1px solid #f0f5f0; background: #fafcfa; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
    .filter-tab { padding: 7px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; color: #6a7a6a; background: #fff; border: 1px solid #eef3ee; text-decoration: none; transition: all 0.3s ease; }
    .filter-tab:hover { border-color: #d4af37; color: #d4af37; }
    .filter-tab.active { background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; border-color: #d4af37; }
    .filter-tab .badge-count { display: inline-block; margin-left: 6px; background: rgba(0,0,0,0.08); padding: 1px 7px; border-radius: 50px; font-size: 10px; }
    .filter-tab.active .badge-count { background: rgba(0,0,0,0.15); }

    .search-form { display: flex; gap: 8px; margin-left: auto; }
    .search-form input { padding: 8px 16px; border: 2px solid #eef3ee; border-radius: 10px; font-size: 13px; background: #fff; min-width: 240px; }
    .search-form input:focus { outline: none; border-color: #d4af37; box-shadow: 0 0 0 4px rgba(212,175,55,0.08); }
    .search-form button { padding: 8px 18px; border-radius: 10px; background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; border: none; font-weight: 700; font-size: 13px; cursor: pointer; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    table thead { background: #f8faf8; }
    table th { padding: 14px 24px; text-align: left; font-size: 11px; font-weight: 700; color: #6a7a6a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eef3ee; white-space: nowrap; }
    table td { padding: 16px 24px; border-bottom: 1px solid #f5f8f5; vertical-align: middle; font-size: 14px; color: #2d3a2d; }
    table tbody tr { transition: background 0.2s ease; cursor: pointer; }
    table tbody tr:hover td { background: #fafcfa; }
    table tbody tr:last-child td { border-bottom: none; }

    .info-title { font-size: 14px; font-weight: 600; color: #0a1a0a; margin-bottom: 4px; }
    .info-desc { font-size: 12px; color: #8a9a8a; line-height: 1.5; }
    .ticket-code { display: inline-block; background: #f0f5f0; padding: 3px 10px; border-radius: 6px; font-family: 'Courier New', monospace; font-size: 11px; font-weight: 700; color: #6a7a6a; margin-bottom: 4px; }

    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 50px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
    .badge .dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .badge-pending { background: linear-gradient(135deg, #dbeafe, #bfdbfe); color: #1e40af; }
    .badge-pending .dot { background: #3b82f6; animation: pulse-dot 2s infinite; }
    .badge-processing { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; }
    .badge-processing .dot { background: #f59e0b; }
    .badge-ready { background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; }
    .badge-ready .dot { background: #22c55e; }
    .badge-rejected { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; }
    .badge-rejected .dot { background: #ef4444; }
    @keyframes pulse-dot { 0%,100% { opacity:1; } 50% { opacity:0.5; } }

    .date-cell { font-size: 13px; color: #6a7a6a; display: flex; align-items: center; gap: 8px; white-space: nowrap; }
    .date-cell i { color: #d4af37; }

    .actions { display: flex; gap: 6px; justify-content: flex-end; }
    .action-btn { width: 34px; height: 34px; border-radius: 10px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.25s ease; font-size: 13px; text-decoration: none; }
    .action-btn.view { background: #e3f2fd; color: #1565c0; }
    .action-btn.view:hover { background: #bbdefb; transform: translateY(-2px); }
    .action-btn.delete { background: #fef2f2; color: #991b1b; }
    .action-btn.delete:hover { background: #fee2e2; transform: translateY(-2px); }

    .empty-state { text-align: center; padding: 80px 40px; }
    .empty-state .icon-circle { width: 100px; height: 100px; margin: 0 auto 24px; border-radius: 50%; background: linear-gradient(135deg, #f0f5f0, #e8efe8); display: flex; align-items: center; justify-content: center; font-size: 42px; color: #c8dcc8; }
    .empty-state h3 { font-size: 20px; font-weight: 700; color: #0a1a0a; margin-bottom: 8px; }
    .empty-state p { font-size: 14px; color: #7a8a7a; max-width: 400px; margin: 0 auto; }

    .pagination-wrap { padding: 20px 24px; border-top: 1px solid #f0f5f0; display: flex; justify-content: center; }
    .pagination-wrap nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
    .pagination-wrap nav a, .pagination-wrap nav span { padding: 8px 14px; border: 1px solid #eef3ee; border-radius: 10px; color: #4a5a4a; text-decoration: none; font-size: 13px; font-weight: 600; min-width: 38px; text-align: center; background: #fff; }
    .pagination-wrap nav a:hover { background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; border-color: #d4af37; }
    .pagination-wrap nav span[aria-current="page"] { background: linear-gradient(135deg, #f0d060, #d4af37); color: #0a1a0a; border-color: #d4af37; }

    @media (max-width: 992px) { .stats-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-box { padding: 16px; }
        .stat-box .stat-number { font-size: 22px; }
        .filter-bar { flex-direction: column; align-items: stretch; }
        .search-form { margin-left: 0; }
        .search-form input { flex: 1; min-width: 0; }
        table th, table td { padding: 10px 12px; font-size: 12px; }
    }
</style>

<div class="page-head">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="sep">/</span>
        <span class="current">Surat Menyurat</span>
    </div>
    <h1>Kelola Surat Menyurat</h1>
    <p>Kelola permohonan surat keterangan dari warga</p>
</div>

<div class="stats-row">
    <div class="stat-box total">
        <div class="stat-icon"><i class="fas fa-inbox"></i></div>
        <div class="stat-number">{{ $stats['total'] }}</div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat-box pending">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div class="stat-number">{{ $stats['pending'] }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-box processing">
        <div class="stat-icon"><i class="fas fa-spinner"></i></div>
        <div class="stat-number">{{ $stats['processing'] }}</div>
        <div class="stat-label">Diproses</div>
    </div>
    <div class="stat-box ready">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div class="stat-number">{{ $stats['ready'] }}</div>
        <div class="stat-label">Siap</div>
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <div class="toolbar-left">
            <div class="icon-box"><i class="fas fa-file-signature"></i></div>
            <div>
                <h3>Daftar Permohonan Surat <span class="count">{{ $letters->total() }} item</span></h3>
                <p>Semua permohonan surat yang masuk dari warga</p>
            </div>
        </div>
    </div>

    <div class="filter-bar">
        <div class="filter-tabs">
            <a href="{{ route('admin.letters.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                Semua <span class="badge-count">{{ $stats['total'] }}</span>
            </a>
            <a href="{{ route('admin.letters.index', ['status' => 'pending']) }}" class="filter-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                Menunggu <span class="badge-count">{{ $stats['pending'] }}</span>
            </a>
            <a href="{{ route('admin.letters.index', ['status' => 'processing']) }}" class="filter-tab {{ request('status') === 'processing' ? 'active' : '' }}">
                Diproses <span class="badge-count">{{ $stats['processing'] }}</span>
            </a>
            <a href="{{ route('admin.letters.index', ['status' => 'ready']) }}" class="filter-tab {{ request('status') === 'ready' ? 'active' : '' }}">
                Siap <span class="badge-count">{{ $stats['ready'] }}</span>
            </a>
        </div>

        <form class="search-form" method="GET" action="{{ route('admin.letters.index') }}">
            @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / NIK / no. permohonan...">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    @if($letters->isNotEmpty())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pemohon</th>
                        <th>Jenis Surat</th>
                        <th style="width: 160px;">Status</th>
                        <th style="width: 180px;">Tanggal</th>
                        <th style="width: 120px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($letters as $letter)
                        <tr onclick="window.location='{{ route('admin.letters.show', $letter) }}'">
                            <td>
                                <div class="ticket-code">{{ $letter->request_number }}</div>
                                <div class="info-title">{{ $letter->name }}</div>
                                <div class="info-desc">NIK: {{ $letter->nik }}</div>
                            </td>
                            <td>
                                <div class="info-title">{{ $letter->letterType->name ?? '-' }}</div>
                                <div class="info-desc">{{ Str::limit($letter->purpose, 40) }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $letter->status_badge }}">
                                    <span class="dot"></span>
                                    {{ $letter->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $letter->created_at->translatedFormat('d M Y, H:i') }}
                                </div>
                            </td>
                            <td onclick="event.stopPropagation();">
                                <div class="actions">
                                    <a href="{{ route('admin.letters.show', $letter) }}" class="action-btn view" title="Lihat detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.letters.destroy', $letter) }}" method="POST" style="display:inline;" id="delete-form-{{ $letter->id }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="action-btn delete" onclick="confirmDelete('delete-form-{{ $letter->id }}', '{{ $letter->request_number }}')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap">{{ $letters->links() }}</div>
    @else
        <div class="empty-state">
            <div class="icon-circle"><i class="fas fa-file-signature"></i></div>
            <h3>Belum Ada Permohonan Surat</h3>
            <p>Permohonan surat dari warga akan muncul di sini.</p>
        </div>
    @endif
</div>
@endsection