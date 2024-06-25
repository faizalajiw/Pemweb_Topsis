<!-- resources/views/normalisasi/index.blade.php -->

@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('contents')
    <div class="container">
        <h2>Hasil Pembagi</h2>

        {{-- Add this section to inspect variables --}}
        {{-- {{ dd($normalisasi, $kriterias, $alternatifs, $pembagi) }} --}}

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    @foreach ($kriterias as $kriteria)
                        <th style="text-align: center;">{{ $kriteria->kode_kriteria_as_string }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach ($kriterias as $kriteria)
                        {{-- Check if the key exists in the $normalisasi array --}}
                        @if (isset($hasil[$kriteria->kode_kriteria]))
                            <td style="text-align: center;">
                                {{ number_format($hasil[$kriteria->kode_kriteria], 3, ',', '.') }}
                            </td>
                        @else
                            <td style="text-align: center;">-</td>
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>

        <h2>Tabel Normalisasi</h2>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Alternatif</th>
                    @foreach ($kriterias as $kriteria)
                        <th style="text-align: center;">{{ $kriteria->kode_kriteria_as_string }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatifs as $alternatif)
                    <tr>
                        <td style="text-align: center;">{{ $alternatif->nama_alternatif }}</td>
                        @foreach ($kriterias as $kriteria)
                            {{-- Check if the key exists in the $normalisasi array --}}
                            @if (isset($normalisasi[$alternatif->kode_alternatif][$kriteria->kode_kriteria]))
                                <td style="text-align: center;">
                                    {{ number_format($normalisasi[$alternatif->kode_alternatif][$kriteria->kode_kriteria], 3, ',', '.') }}
                                </td>
                            @else
                                <td style="text-align: center;">-</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Tabel Ternormalisasi Terbobot</h2>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Alternatif</th>
                    @foreach ($kriterias as $kriteria)
                        <th style="text-align: center;">{{ $kriteria->kode_kriteria_as_string }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($alternatifs as $alternatif)
                    <tr>
                        <td style="text-align: center;">{{ $alternatif->nama_alternatif }}</td>
                        @foreach ($kriterias as $kriteria)
                            {{-- Check if the key exists in the $normalisasi array --}}
                            @if (isset($y[$alternatif->kode_alternatif][$kriteria->kode_kriteria]))
                                <td style="text-align: center;">
                                    {{ number_format($y[$alternatif->kode_alternatif][$kriteria->kode_kriteria], 3, ',', '.') }}
                                </td>
                            @else
                                <td style="text-align: center;">-</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Solusi Ideal Positif (A+) dan Ideal Negatif (A-)</h2>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Type</th>
                    @foreach ($kriterias as $kriteria)
                        <th>{{ $kriteria->kode_kriteria_as_string }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>A+</td>
                    @foreach ($kriterias as $kriteria)
                        {{-- Pengecekan keberadaan atribut 'benefit' --}}
                        @if ($kriteria->attribute == 'benefit')
                            {{-- Pastikan bahwa $benefit_Aplus[$kriteria->kode_kriteria] berisi nilai --}}
                            <td>{{ number_format($Aplus[$kriteria->kode_kriteria], 3, ',', '.') }}</td>
                        @elseif ($kriteria->attribute == 'cost')
                            <td>{{ number_format($Aplus[$kriteria->kode_kriteria], 3, ',', '.') }}</td>
                        @else
                            <td>-</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>A-</td>
                    @foreach ($kriterias as $kriteria)
                        {{-- Pengecekan keberadaan atribut 'benefit' --}}
                        @if ($kriteria->attribute == 'benefit')
                            {{-- Pastikan bahwa $benefit_Amin[$kriteria->kode_kriteria] berisi nilai --}}
                            <td>{{ number_format($Amin[$kriteria->kode_kriteria], 3, ',', '.') }}</td>
                        @elseif ($kriteria->attribute == 'cost')
                            <td>{{ number_format($Amin[$kriteria->kode_kriteria], 3, ',', '.') }}</td>
                        @else
                            <td>-</td>
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>

        <h2>Jarak Solusi Ideal Positif dan Negatif</h2>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Alternatif</th>
                    <th style="text-align: center;">D+</th>
                    <th style="text-align: center;">D-</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Dplus as $alternatifIndex => $jarakPlus)
                    <tr>
                        <td style="text-align: center;">A{{ $alternatifIndex }}</td>
                        <td style="text-align: center;">{{ $jarakPlus }}</td>
                        <td style="text-align: center;">{{ $Dmin[$alternatifIndex] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Nilai Preferensi dan Ranking</h2>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">Alternatif</th>
                    <th style="text-align: center;">Nilai Preferensi (V)</th>
                    <th style="text-align: center;">Ranking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rank as $alternatif => $jarak)
                    <tr>
                        <td style="text-align: center;">A{{ $alternatif }}</td>
                        <td style="text-align: center;">{{ $preferensi[$alternatif] }}</td>
                            {{-- Check if the key exists in the $normalisasi array --}}
                        <td style="text-align: center;"> {{ $jarak }}</td> 
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection
