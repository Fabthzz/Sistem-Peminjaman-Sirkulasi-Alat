    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Peminjaman - SPSA</title>
        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                color: #1a1a2e;
                background: #f1f5f9;
            }

            .filter-panel {
                background: white;
                border-bottom: 1px solid #e2e8f0;
                padding: 16px 24px;
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .filter-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 10px;
            }

            .filter-actions {
                display: flex;
                gap: 8px;
            }

            .btn-print {
                background: #F07B1D;
                color: white;
                border: none;
                padding: 8px 20px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 700;
                cursor: pointer;
                font-family: inherit;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .btn-back {
                background: #f1f5f9;
                color: #1e293b;
                border: 1px solid #e2e8f0;
                padding: 8px 16px;
                border-radius: 6px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                font-family: inherit;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 6px;
            }

            .shortcuts {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }

            .shortcuts span {
                font-size: 12px;
                font-weight: 600;
                color: #64748b;
            }

            .shortcut-btn {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 600;
                cursor: pointer;
                font-family: inherit;
                color: #475569;
                transition: all .15s;
            }

            .shortcut-btn:hover {
                background: #F07B1D;
                color: white;
                border-color: #F07B1D;
            }

            .filter-form {
                display: flex;
                align-items: flex-end;
                gap: 12px;
                flex-wrap: wrap;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px 16px;
            }

            .filter-group {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }

            .filter-group label {
                font-size: 10px;
                font-weight: 700;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: .5px;
            }

            .filter-group input,
            .filter-group select {
                border: 1px solid #e2e8f0;
                border-radius: 6px;
                padding: 6px 10px;
                font-size: 12px;
                font-family: inherit;
                outline: none;
                background: white;
                min-width: 140px;
            }

            .filter-group input:focus,
            .filter-group select:focus {
                border-color: #F07B1D;
            }

            .btn-filter {
                background: #F07B1D;
                color: white;
                border: none;
                padding: 7px 16px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: 700;
                cursor: pointer;
                font-family: inherit;
            }

            .btn-reset {
                background: white;
                color: #475569;
                border: 1px solid #e2e8f0;
                padding: 7px 12px;
                border-radius: 6px;
                font-size: 12px;
                font-weight: 600;
                cursor: pointer;
                font-family: inherit;
                text-decoration: none;
                display: inline-block;
            }

            /* ── LAPORAN CONTENT ── */
            .laporan-content {
                background: white;
                margin: 20px auto;
                max-width: 900px;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
            }

            /* HEADER */
            .header {
                text-align: center;
                border-bottom: 3px solid #F07B1D;
                padding-bottom: 14px;
                margin-bottom: 16px;
            }

            .header-logo {
                font-size: 20px;
                font-weight: 900;
                color: #F07B1D;
            }

            .header-title {
                font-size: 15px;
                font-weight: 700;
                margin-top: 4px;
            }

            .header-sub {
                font-size: 11px;
                color: #6c757d;
                margin-top: 2px;
            }

            .header-period {
                font-size: 12px;
                font-weight: 600;
                margin-top: 6px;
                background: #fff3e8;
                display: inline-block;
                padding: 2px 12px;
                border-radius: 20px;
                color: #F07B1D;
            }

            /* INFO */
            .info-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 14px;
                font-size: 11px;
                color: #6c757d;
            }

            /* SUMMARY */
            .summary {
                display: flex;
                gap: 10px;
                margin-bottom: 16px;
            }

            .summary-item {
                flex: 1;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 10px;
                text-align: center;
            }

            .summary-value {
                font-size: 20px;
                font-weight: 800;
            }

            .summary-label {
                font-size: 10px;
                color: #6c757d;
                margin-top: 2px;
            }

            /* TABLE */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead th {
                background: #1e293b;
                color: white;
                padding: 8px 10px;
                font-size: 10px;
                text-align: left;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .5px;
            }

            tbody tr:nth-child(even) {
                background: #f8fafc;
            }

            tbody tr {
                border-bottom: 1px solid #e2e8f0;
            }

            tbody td {
                padding: 8px 10px;
                font-size: 11px;
                vertical-align: middle;
            }

            .badge {
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 10px;
                font-weight: 700;
                display: inline-block;
            }

            .badge-menunggu {
                background: #fef9c3;
                color: #854d0e;
            }

            .badge-disetujui {
                background: #dcfce7;
                color: #166534;
            }

            .badge-dikembalikan {
                background: #e0f2fe;
                color: #0369a1;
            }

            .badge-ditolak {
                background: #fee2e2;
                color: #991b1b;
            }

            /* FOOTER */
            .laporan-footer {
                display: flex;
                justify-content: space-between;
                font-size: 10px;
                color: #6c757d;
                margin-top: 16px;
                padding-top: 12px;
                border-top: 1px solid #e2e8f0;
            }

            /* PRINT */
            @media print {
                body {
                    background: white;
                }

                .filter-panel {
                    display: none !important;
                }

                .laporan-content {
                    margin: 0;
                    padding: 20px;
                    box-shadow: none;
                    border-radius: 0;
                    max-width: 100%;
                }
            }
        </style>
    </head>

    <body>

        {{-- FILTER PANEL (tidak ikut cetak) --}}
        <div class="filter-panel">
            {{-- Baris atas: tombol aksi --}}
            <div class="filter-top">
                <div class="filter-actions">
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn-back">← Kembali</a>
                    <button class="btn-print" onclick="window.print()">🖨️ Cetak</button>
                </div>
                <div class="shortcuts">
                    <span>Filter cepat:</span>
                    <button class="shortcut-btn" onclick="setRange(7)">7 Hari Terakhir</button>
                    <button class="shortcut-btn" onclick="setRange(30)">30 Hari Terakhir</button>
                    <button class="shortcut-btn" onclick="setThisMonth()">Bulan Ini</button>
                    <button class="shortcut-btn" onclick="setLastMonth()">Bulan Lalu</button>
                    <button class="shortcut-btn" onclick="setThisYear()">Tahun Ini</button>
                </div>
            </div>

            {{-- Baris bawah: form filter --}}
            <form method="GET" action="{{ route('admin.laporan.cetak') }}" class="filter-form">
                <div class="filter-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="dari" id="inputDari" value="{{ $dari ?? '' }}">
                </div>
                <div class="filter-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="sampai" id="inputSampai" value="{{ $sampai ?? '' }}">
                </div>
                <div class="filter-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ ($status ?? '') == 'menunggu'     ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ ($status ?? '') == 'disetujui'    ? 'selected' : '' }}>Disetujui</option>
                        <option value="dikembalikan" {{ ($status ?? '') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="ditolak" {{ ($status ?? '') == 'ditolak'      ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Tampilkan</button>
                <a href="{{ route('admin.laporan.cetak') }}" class="btn-reset">Reset</a>
            </form>
        </div>

        {{-- LAPORAN CONTENT (yang dicetak) --}}
        <div class="laporan-content">

            <div class="header">
                <div class="header-logo">📟 SPSA</div>
                <div class="header-title">Laporan Peminjaman Alat</div>
                <div class="header-sub">Sistem Peminjaman & Sirkulasi Alat</div>
                @if($dari || $sampai)
                <div style="margin-top:6px;">
                    <span class="header-period">
                        {{ $dari ? \Carbon\Carbon::parse($dari)->format('d M Y') : 'Awal' }}
                        —
                        {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d M Y') : 'Sekarang' }}
                    </span>
                </div>
                @endif
            </div>

            <div class="info-row">
                <span>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</span>
                <span>Admin: {{ Auth::user()->nama ?? 'Admin' }}</span>
            </div>

            <div class="summary">
                <div class="summary-item">
                    <div class="summary-value">{{ $total }}</div>
                    <div class="summary-label">Total</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value" style="color:#854d0e;">{{ $totalMenunggu }}</div>
                    <div class="summary-label">Menunggu</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value" style="color:#166534;">{{ $totalDisetujui }}</div>
                    <div class="summary-label">Disetujui</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value" style="color:#0369a1;">{{ $totalDikembalikan }}</div>
                    <div class="summary-label">Dikembalikan</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value" style="color:#ef4444; font-size:14px;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Denda</div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jurusan</th>
                        <th>Alat Dipinjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $item->mahasiswa->nama ?? '-' }}</strong></td>
                        <td>-</td>
                        <td>
                            @foreach($item->details as $detail)
                            {{ $detail->alat->nama_alat ?? '-' }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                        <td><span class="badge badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ $item->denda > 0 ? 'Rp '.number_format($item->denda, 0, ',', '.') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:24px; color:#6c757d;">
                            Tidak ada data untuk filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="laporan-footer">
                <span>SPSA - Sistem Peminjaman & Sirkulasi Alat</span>
                <span>Total: {{ $total }} data</span>
            </div>

        </div>

        <script>
            function setRange(days) {
                const today = new Date();
                const from = new Date();
                from.setDate(today.getDate() - days);
                document.getElementById('inputDari').value = from.toISOString().split('T')[0];
                document.getElementById('inputSampai').value = today.toISOString().split('T')[0];
            }

            function setThisMonth() {
                const now = new Date();
                const first = new Date(now.getFullYear(), now.getMonth(), 1);
                const last = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                document.getElementById('inputDari').value = first.toISOString().split('T')[0];
                document.getElementById('inputSampai').value = last.toISOString().split('T')[0];
            }

            function setLastMonth() {
                const now = new Date();
                const first = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                const last = new Date(now.getFullYear(), now.getMonth(), 0);
                document.getElementById('inputDari').value = first.toISOString().split('T')[0];
                document.getElementById('inputSampai').value = last.toISOString().split('T')[0];
            }

            function setThisYear() {
                const year = new Date().getFullYear();
                document.getElementById('inputDari').value = year + '-01-01';
                document.getElementById('inputSampai').value = year + '-12-31';
            }
        </script>

    </body>

    </html>