<?php

namespace App\Console\Commands;

use App\Models\Seminar;
use App\Models\User;
use Illuminate\Console\Command;

class MigrasiSeminarUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Menambahkan user di tabel seminar ke tabel user dengan password default 12345678";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo "Migrasi Seminar User\n";
        $phones = Seminar::select('phone')
            ->groupBy('phone')
            // ->take(5)
            ->get();
        echo "Jumlah data yang akan di migrasi: " . $phones->count() . "\n";
        $pass = bcrypt('12345678');
        foreach ($phones as $key => $val) {
            $peserta = Seminar::firstWhere('phone', $val->phone);
            // dump($peserta);
            try {
                $user = User::create([
                    'nama' => $peserta->nama,
                    'sapaan' => $peserta->sapaan,
                    'panggilan' => $peserta->panggilan,
                    'email' => $peserta->email,
                    'password' => $pass,
                    'phone' => $peserta->phone,
                    'role_id' => 4,
                    'prov_id' => $peserta->prov_id,
                    'provinsi' => $peserta->provinsi,
                    'kota_id' => $peserta->kota_id,
                    'kota' => $peserta->kota,
                    'b_tahun' => $peserta->b_tahun,
                    'b_bulan' => $peserta->b_bulan,
                    'b_tanggal' => $peserta->b_tanggal,
                    'ref' => $peserta->ref,
                    'profesi' => $peserta->profesi,
                    'note' => 'Migrasi dari seminar 25-05-2022',
                ]);
                echo "{$key}. {$peserta->phone} {$peserta->nama} \n";
                sleep(0.5);
            } catch (\Throwable $th) {
                echo "{$key}. {$peserta->phone} {$th->getMessage()} \n";
            }
        }

        return 0;
    }
}
