<?php

namespace App\Http\Controllers;

use App\Helpers\Whatsapp;
use App\Models\Member;
use App\Models\Seminar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Notification as ModelsNotification;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class KomiController extends Controller
{
    public function index(Request $request)
    {
        return view('komi.index', [
            'member' => Member::all()
        ]);
    }

    public function register(Request $request)
    {
        return view('komi.register');
    }

    public function getPeserta(Request $request)
    {
        if ($request->has('phone')) {
            $phone = $request->input('phone');
            $phone = preg_replace('/\D/', '', $phone);
            $phone = preg_replace('/^0/', '62', $phone);
            $peserta = Seminar::where('phone', trim($phone))->first();
            if ($peserta) {
                return response()->json([
                    'status' => 'success',
                    'phone' => $phone,
                    'data' => $peserta
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'phone' => $phone,
                    'message' => 'Peserta tidak ditemukan'
                ]);
            }
        }
        return $request->all();
    }

    public function createMember(Request $request)
    {
        $peserta = Seminar::where('phone', $request->input('phone'))->first();

        $member = Member::firstWhere('email', $peserta->email);
        if ($member) {
            return redirect()->back()->with('warning', 'Anda sudah terdaftar');
        }

        $unix = Member::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() ?? 0;
        $unix = $unix + 1;
        $nilai = $unix + 150000;
        $data = [
            'sapaan' => $peserta->sapaan,
            'panggilan' => $peserta->panggilan,
            'nama' => $peserta->nama,
            'phone' => $peserta->phone,
            'email' => $peserta->email,
            'profesi' => $peserta->profesi,
            'kota' => $peserta->kota,
            'kota_id' => $peserta->kota_id,
            'provinsi' => $peserta->provinsi,
            'provinsi_id' => $peserta->provinsi_id,
            'b_tanggal' => $peserta->b_tanggal,
            'b_bulan' => $peserta->b_bulan,
            'b_tahun' => $peserta->b_tahun,
            'nilai' => $nilai
        ];
        $member = Member::create($data);
        $notif = ModelsNotification::firstWhere('slug', 'register member komi');
        if ($member) {
            $data['nilai'] = number_format($data['nilai']);
            DB::table('zu2_antrians')->insert([
                'phone' => $peserta->phone,
                'user_id' => 2,
                'device_id' => $notif->device_id,
                'status' => 1,
                'type' => 'wa',
                'message' => ReplaceArray($data, $notif->text)
            ]);
            // notification('register member komi')->data($member)->phone($peserta->phone)->save('zu2_antrians');
        }
        return redirect()->back()->with('success', 'Registrasi member KOMI berhasil');
    }


    /**
     * Menjadikan Member Komi menjadi User
     */
    public function approve(Request $request, Member $member)
    {

        $user = User::firstWhere('email', $member->email);
        // return $member;
        if (!$user) {
            $user = User::create([
                'nama' => $member->nama,
                'sapaan' => $member->sapaan,
                'panggilan' => $member->panggilan,
                'phone' => $member->phone,
                'profesi' => $member->profesi,
                'provinsi' => $member->provinsi,
                'prov_id' => $member->prov_id,
                'kota' => $member->kota,
                'kota_id' => $member->kota_id,
                'b_tanggal' => $member->b_tanggal,
                'b_bulan' => $member->b_bulan,
                'b_tahun' => $member->b_tahun,
                'status' => 1,
                'note' => 'Member KOMI',
                'email' => $member->email,
                'role_id' => 4, // Referral
                'kode_ref'=>  $member->phone,
                'password' => Hash::make('12345678')
            ]);
        }

        $member->update([
            'approve' => 'approved',
            'bayar' => $request->bayar,
        ]);

        notification('approve member komi')->data($user)->phone($member->phone)->send();

        return redirect()->back()->with('success', 'Member KOMI berhasil dijadikan user');
    }


    public function exportToExcel()
    {
        $data = Member::take(2)->get([
            'sapaan',
            'panggilan',
            'nama',
            'phone',
            'email',
            'profesi',
            'kota',
            'provinsi',
            'b_tanggal AS tanggal_lahir',
            'b_bulan AS bulan_lahir',
            'b_tahun AS tahun_lahir',
        ]);


        return (new FastExcel($data))->download('member-komi.xlsx');
    }

    
}
