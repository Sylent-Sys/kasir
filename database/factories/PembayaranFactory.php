<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Pembayaran;
use App\Models\TransaksiDetail;
use App\Models\User;

class PembayaranFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pembayaran::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'transaksi_detail_id' => TransaksiDetail::factory(),
            'bayar' => $this->faker->numberBetween(0, 10000),
            'kembalian' => $this->faker->numberBetween(0, 10000),
        ];
    }
}
