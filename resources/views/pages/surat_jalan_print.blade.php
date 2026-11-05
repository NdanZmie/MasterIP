<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sj->no_sj }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --text-color: #000000;
            --border-color: #000000;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            background: #e2e8f0;
            min-height: 100vh;
            padding: 24px 0 60px;
            font-size: 11pt;
            line-height: 1.35;
        }

        /* ── Action Toolbar (Hidden when printing) ── */
        .print-toolbar {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(12px);
            padding: 10px 20px;
            border-radius: 999px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.15);
        }

        .print-toolbar .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-print {
            background: linear-gradient(135deg, #2563eb, #06b6d4);
            color: #fff;
            box-shadow: 0 4px 14px rgba(37,99,235,0.4);
        }
        .btn-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37,99,235,0.5);
        }

        .btn-close {
            background: rgba(255,255,255,0.12);
            color: #f1f5f9;
        }
        .btn-close:hover {
            background: rgba(255,255,255,0.22);
            color: #fff;
        }

        .toolbar-info {
            color: #94a3b8;
            font-size: 0.8rem;
            font-family: 'JetBrains Mono', monospace;
            padding-right: 8px;
            border-right: 1px solid rgba(255,255,255,0.15);
        }

        /* ── A4 Page Sheet ── */
        .page-sheet {
            width: 210mm;
            min-height: 297mm;
            margin: 60px auto 0;
            background: #ffffff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            padding: 14mm 16mm 16mm 16mm;
            position: relative;
            box-sizing: border-box;
        }

        /* ── HEADER NORMAL ── */
        .sj-header {
            width: 100%;
            margin-bottom: 8px;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .logo-box {
            width: 210px;
        }
        .logo-box img {
            width: 180px;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .title-container {
            flex: 1;
            text-align: center;
            padding-right: 60px;
        }

        .main-title {
            font-size: 16pt;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .main-sub-no {
            font-size: 8.5pt;
            font-weight: 400;
            letter-spacing: 0.02em;
            margin-top: 2px;
            color: #1e293b;
        }

        .header-meta-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 16px;
            margin-top: 6px;
            font-size: 9.5pt;
        }

        .company-info .company-name {
            font-weight: 700;
            font-size: 10pt;
            letter-spacing: 0.02em;
        }
        .company-info .dept-name {
            font-weight: 600;
            color: #000;
            margin-bottom: 2px;
        }
        .company-info .address-text {
            color: #000;
            font-size: 9pt;
            line-height: 1.3;
        }

        .meta-details {
            border: 1px solid transparent;
        }
        .meta-table {
            width: 100%;
            font-size: 9.5pt;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .meta-table td.label-col {
            width: 75px;
            font-weight: 600;
            white-space: nowrap;
        }
        .meta-table td.colon-col {
            width: 10px;
            text-align: center;
            font-weight: 600;
        }
        .meta-table td.val-col {
            font-weight: 600;
            text-transform: uppercase;
        }

        /* ── HEADER KHUSUS SJ GO ── */
        .go-header-wrap {
            width: 100%;
            text-align: center;
            margin-bottom: 14px;
        }

        .go-main-title {
            font-size: 12.5pt;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            line-height: 1.35;
            white-space: pre-line;
            color: #000;
        }

        /* ── Main Data Table ── */
        .sj-table-wrap {
            margin-top: 8px;
            width: 100%;
        }

        table.sj-table {
            width: 100%;
            border-collapse: collapse;
            border: 1.5px solid #000;
            font-size: 8.5pt;
        }

        table.sj-table th,
        table.sj-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        table.sj-table th {
            background-color: #ffffff;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            padding: 5px 4px;
            font-size: 8.5pt;
        }

        table.sj-table th.go-th {
            background-color: #d9e1f2 !important;
            font-weight: 800;
            font-size: 8.5pt;
        }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }

        .item-desc-cell {
            font-weight: 700;
            white-space: pre-line;
            line-height: 1.3;
        }

        .keterangan-cell {
            white-space: pre-line;
            line-height: 1.3;
            font-family: inherit;
        }

        /* ── Signatures Section NORMAL ── */
        .signatures-wrap {
            margin-top: 20px;
            width: 100%;
            page-break-inside: avoid;
        }

        .signatures-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            text-align: center;
        }

        .signatures-table td {
            vertical-align: top;
            padding: 4px;
        }

        .sig-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9pt;
            margin-bottom: 50px;
        }

        .sig-name {
            font-weight: 600;
            font-size: 9pt;
            min-height: 18px;
        }

        .sig-sub {
            font-size: 8pt;
            font-style: italic;
            margin-top: 2px;
            color: #1e293b;
        }

        /* ── Signatures Section GO ── */
        .go-date-place {
            text-align: right;
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 16px;
            margin-bottom: 8px;
            padding-right: 15px;
        }

        table.go-signatures-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 9pt;
            border: none;
        }

        table.go-signatures-table th {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 9pt;
            padding-bottom: 6px;
            border: none;
        }

        table.go-signatures-table td {
            vertical-align: top;
            padding: 0 4px;
            border: none;
        }

        .sig-space {
            height: 48px;
        }

        .go-sig-name {
            font-weight: 700;
            font-size: 9pt;
            text-transform: uppercase;
            min-height: 16px;
        }

        .go-sig-title {
            font-weight: 700;
            font-size: 8.5pt;
            text-transform: uppercase;
            margin-top: 2px;
            color: #000;
        }

        /* ── PRINT MEDIA RULES ── */
        @page {
            size: A4 portrait;
            margin: 0; /* Menghilangkan URL dan header browser otomatis */
        }

        @media print {
            html, body {
                background: #fff !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 9pt;
                width: 100% !important;
                height: 100% !important;
            }

            .print-toolbar {
                display: none !important;
            }

            .page-sheet {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 auto !important;
                box-shadow: none !important;
                border: none !important;
                padding: 10mm 14mm 12mm 14mm !important;
                box-sizing: border-box !important;
            }

            table.sj-table {
                border: 1.5px solid #000 !important;
            }
            table.sj-table th,
            table.sj-table td {
                border: 1px solid #000 !important;
            }

            table.sj-table th.go-th {
                background-color: #d9e1f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .signatures-wrap {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Print Controls -->
    <div class="print-toolbar">
        <span class="toolbar-info">{{ $sj->no_sj }} &bull; {{ $sj->tipe_sj === 'GO' ? 'SJ GO TOKO' : 'SJ NORMAL' }}</span>
        <button class="btn btn-print" onclick="triggerPrint()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            Cetak / Print
        </button>
        <button class="btn btn-close" onclick="window.close()">Tutup Jendela</button>
    </div>

    <!-- Paper Sheet Container -->
    <div class="page-sheet">

        @if($sj->tipe_sj === 'GO')
            <!-- HEADER KHUSUS SJ GO -->
            <div class="go-header-wrap">
                <div class="go-main-title">{{ $sj->perihal ?: ('SERAH TERIMA BARANG EDP UNTUK TOKO BARU ' . ($sj->kode_toko ? $sj->kode_toko . ' - ' . $sj->nama_toko : '')) }}</div>
            </div>
        @else
            <!-- HEADER SJ NORMAL -->
            <div class="sj-header">
                <div class="header-top">
                    <div class="logo-box">
                        <img src="{{ asset('SJ/indomaret.png') }}" alt="Indomaret" onerror="this.src='{{ asset('aset/indomaret.png') }}'">
                    </div>
                    <div class="title-container">
                        <div class="main-title">SURAT JALAN</div>
                        <div class="main-sub-no">No : {{ $sj->no_sj }}</div>
                    </div>
                </div>

                <div class="header-meta-grid">
                    <div class="company-info">
                        <div class="company-name">PT. INDOMARCO PRISMATAMA</div>
                        <div class="dept-name">EDP - Departement</div>
                        <div class="address-text">
                            Plaza Batamindo - Jl. Rasamala-Batamindo Industrial Park<br>
                            Kel Muka Kuning, Kec Sei Beduk Kota Batam, Kepulauan Riau - 29433
                        </div>
                    </div>

                    <div class="meta-details">
                        <table class="meta-table">
                            <tr>
                                <td class="label-col">TGL</td>
                                <td class="colon-col">:</td>
                                <td class="val-col">{{ \Carbon\Carbon::parse($sj->tanggal)->translatedFormat('d-M-y') }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Kpd</td>
                                <td class="colon-col">:</td>
                                <td class="val-col">{{ $sj->kepada ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Perihal</td>
                                <td class="colon-col">:</td>
                                <td class="val-col">{{ $sj->perihal ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- MAIN TABLE -->
        <div class="sj-table-wrap">
            <table class="sj-table">
                <thead>
                    @if($sj->tipe_sj === 'GO')
                        <tr>
                            <th class="go-th" style="width: 38px;">NO</th>
                            <th class="go-th" style="width: 330px;">NAMA BARANG</th>
                            <th class="go-th" style="width: 55px;">JML</th>
                            <th class="go-th">KET</th>
                        </tr>
                    @else
                        <tr>
                            <th style="width: 42px;">No</th>
                            <th style="width: 260px;">NAMA BARANG</th>
                            <th style="width: 60px;">JLH</th>
                            <th style="width: 170px;">SN - MAC</th>
                            <th>KETERANGAN</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @php $items = $sj->items ?: []; @endphp
                    @forelse($items as $idx => $it)
                        @if($sj->tipe_sj === 'GO')
                            <tr>
                                <td class="text-center font-bold">{{ $it['no'] ?? ($idx + 1) }}</td>
                                <td class="item-desc-cell">{{ $it['nama_barang'] ?? $it['deskripsi'] ?? '' }}</td>
                                <td class="text-center font-bold">{{ $it['jml'] ?? $it['qty'] ?? '' }}</td>
                                <td class="keterangan-cell">{{ $it['keterangan'] ?? $it['ket'] ?? '' }}</td>
                            </tr>
                        @else
                            <tr>
                                <td class="text-center font-bold">{{ $it['no'] ?? ($idx + 1) }}</td>
                                <td class="item-desc-cell">{{ $it['nama_barang'] ?? '' }}</td>
                                <td class="text-center">{{ $it['jlh'] ?? '' }}</td>
                                <td class="text-left font-mono" style="font-size: 8.5pt;">{{ $it['sn_mac'] ?? '' }}</td>
                                <td class="keterangan-cell">{{ $it['keterangan'] ?? '' }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ $sj->tipe_sj === 'GO' ? 4 : 5 }}" class="text-center" style="padding: 20px; color: #64748b;">(Belum ada rincian item)</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- SIGNATURES SECTION -->
        <div class="signatures-wrap">
            @php $sig = $sj->signatures ?: []; @endphp

            @if($sj->tipe_sj === 'GO')
                <!-- Date for GO -->
                <div class="go-date-place">
                    BATAM, {{ \Carbon\Carbon::parse($sj->tanggal)->translatedFormat('d F Y') }}
                </div>

                <!-- 4 Group Signatures for GO: DISETUJUI (GAM, EDPM), DIKETAHUI (EDPS, GAS), DITERIMA (GA), DIBUAT (EDPADM) -->
                <table class="go-signatures-table">
                    <thead>
                        <tr>
                            <th colspan="2" style="width: 32%;">DISETUJUI</th>
                            <th colspan="2" style="width: 32%;">DIKETAHUI</th>
                            <th style="width: 18%;">DITERIMA</th>
                            <th style="width: 18%;">DIBUAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- DISETUJUI: GAM & EDPM -->
                            <td style="width: 16%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">{{ $sig['gam'] ?? 'AWS' }}</div>
                                <div class="go-sig-title">GAM</div>
                            </td>
                            <td style="width: 16%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">{{ $sig['edpm'] ?? 'MJA' }}</div>
                                <div class="go-sig-title">EDPM</div>
                            </td>

                            <!-- DIKETAHUI: EDPS & GAS -->
                            <td style="width: 16%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">{{ $sig['edps'] ?? 'SETIAWAN' }}</div>
                                <div class="go-sig-title">EDPS</div>
                            </td>
                            <td style="width: 16%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">{{ $sig['gas'] ?? 'BOBBY' }}</div>
                                <div class="go-sig-title">GAS</div>
                            </td>

                            <!-- DITERIMA: GA -->
                            <td style="width: 18%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">
                                    @if(!empty(trim($sig['ga'] ?? '')))
                                        ( {{ $sig['ga'] }} )
                                    @else
                                        ( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )
                                    @endif
                                </div>
                                <div class="go-sig-title">GA</div>
                            </td>

                            <!-- DIBUAT: EDPADM -->
                            <td style="width: 18%;">
                                <div class="sig-space"></div>
                                <div class="go-sig-name">{{ $sig['edpadm'] ?? 'NANDA' }}</div>
                                <div class="go-sig-title">EDPADM</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @else
                <!-- 4 Columns Signature for NORMAL: Disetujui (EDPM), Diketahui (EDPS), Diserahkan (EDP), Diterima (*sertakan NIK) -->
                <table class="signatures-table">
                    <tr>
                        <td style="width: 25%;">
                            <div class="sig-title">Disetujui</div>
                            <div class="sig-name">
                                @if(!empty(trim($sig['edpm'] ?? '')))
                                    ( {{ $sig['edpm'] }} )
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="sig-sub font-bold">EDPM</div>
                        </td>
                        <td style="width: 25%;">
                            <div class="sig-title">Diketahui</div>
                            <div class="sig-name">
                                @if(!empty(trim($sig['edps'] ?? '')))
                                    ( {{ $sig['edps'] }} )
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="sig-sub font-bold">EDPS</div>
                        </td>
                        <td style="width: 25%;">
                            <div class="sig-title">Diserahkan</div>
                            <div class="sig-name">
                                @if(!empty(trim($sig['edp'] ?? '')))
                                    ( {{ $sig['edp'] }} )
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="sig-sub font-bold">EDP</div>
                        </td>
                        <td style="width: 25%;">
                            <div class="sig-title">Diterima</div>
                            <div class="sig-name">
                                @if(!empty(trim($sig['penerima_nama'] ?? '')))
                                    ( {{ $sig['penerima_nama'] }} )
                                @else
                                    &nbsp;
                                @endif
                            </div>
                            <div class="sig-sub">
                                @if(!empty(trim($sig['penerima_nik'] ?? '')))
                                    NIK: {{ $sig['penerima_nik'] }}
                                @else
                                    *sertakan NIK
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
            @endif
        </div>

    </div>

    <script>
        const originalDocTitle = document.title;

        function triggerPrint() {
            document.title = '';
            window.print();
        }

        window.addEventListener('beforeprint', () => {
            document.title = '';
        });

        window.addEventListener('afterprint', () => {
            document.title = originalDocTitle;
        });

        // Auto trigger print when requested with ?autoprint=1
        window.addEventListener('load', () => {
            const params = new URLSearchParams(window.location.search);
            if (params.get('autoprint') === '1') {
                setTimeout(() => {
                    triggerPrint();
                }, 400);
            }
        });
    </script>
</body>
</html>
