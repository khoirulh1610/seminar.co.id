<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Mitra;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Share variable ke semua views

        view()->composer('*', function ($view) {
            $now = Carbon::now();
            if (Auth::check()) {
                if (Auth::user()->role_id == 1) {
                    $seminar = Event::all();
                } else {
                    $user = User::find(Auth::id())->load('mitra');
                    $ids_mitra = $user->mitra->pluck('id');
                    $mitras = Mitra::with('produks.events')->whereIn('id', $ids_mitra)->get();
                    $seminar = collect([]);
                    foreach ($mitras as $mitra) {
                        foreach ($mitra->produks as $produk) {
                            foreach ($produk->events as $event) {
                                $seminar->push($event);
                            }
                        }
                    }
                }
                $view->with('seminar_mitra', $seminar->groupBy('jenis_seminar'));
            }
            $view->with('now', $now);
        });
    }
}
