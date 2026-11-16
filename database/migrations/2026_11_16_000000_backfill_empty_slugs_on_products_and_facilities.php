<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Isi slug yang masih kosong (data lama sebelum kolom slug ditambahkan).
 * Halaman publik memanggil route('...detail', $model->slug); slug kosong
 * membuat halaman daftar error 500.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['products', 'facilities'] as $table) {
            $rows = DB::table($table)
                ->where(fn ($q) => $q->whereNull('slug')->orWhere('slug', ''))
                ->get(['id', 'name']);

            foreach ($rows as $row) {
                $base = Str::slug($row->name) ?: Str::singular($table) . '-' . $row->id;
                $slug = $base;
                $i = 2;

                while (DB::table($table)->where('slug', $slug)->where('id', '!=', $row->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }

                DB::table($table)->where('id', $row->id)->update(['slug' => $slug]);
            }
        }
    }

    public function down(): void
    {
        // Tidak dikembalikan: slug yang sudah terisi tetap aman dipakai.
    }
};
