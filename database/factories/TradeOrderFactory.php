<?php

namespace Database\Factories;

use App\Models\ListedCoin;
use App\Models\Team;
use App\Models\TradeOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class TradeOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TradeOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $side = random_int(0, 1);

        $stop_fee = .6;

        $btc_price = random_int(25000000, 30000000);
        $btc_stop = $btc_price + (($btc_price / 100) * $stop_fee);

        $brl_price = random_int(320, 355);
        $brl_stop = $brl_price + (($brl_price / 100) * $stop_fee);

        $algo_price = random_int(90000, 100000);
        $algo_stop = $algo_price + (($algo_price / 100) * $stop_fee);

        $expires = now()->addMinutes(5)->toDateTimeString();


        $quotes = [[
            'quote_currency' => ListedCoin::CURRENCY_BRL,
            'base_currency' => ListedCoin::CURRENCY_BTC,
            'symbol' => 'BRLBTC',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $btc_price,
            'stop_price' => $btc_stop,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(10000, 1000000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ],
        [
            'quote_currency' => ListedCoin::CURRENCY_BTC,
            'base_currency' => ListedCoin::CURRENCY_BRL,
            'symbol' => 'BTCBRL',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $brl_price,
            'stop_price' => $brl_stop,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(50000, 80000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ],[
            'quote_currency' => ListedCoin::CURRENCY_BTC,
            'base_currency' => ListedCoin::CURRENCY_ALGO,
            'symbol' => 'BTCALGO',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $algo_price,
            'stop_price' => $algo_price,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(50000, 80000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ],
        [
            'quote_currency' => ListedCoin::CURRENCY_BRL,
            'base_currency' => ListedCoin::CURRENCY_ALGO,
            'symbol' => 'BRLALGO',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $algo_price,
            'stop_price' => $algo_stop,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(250000, 350000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ],[
            'quote_currency' => ListedCoin::CURRENCY_ALGO,
            'base_currency' => ListedCoin::CURRENCY_BRL,
            'symbol' => 'ALGOBRL',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $algo_price,
            'stop_price' => $algo_stop,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(250000, 350000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ],[
            'quote_currency' => ListedCoin::CURRENCY_ALGO,
            'base_currency' => ListedCoin::CURRENCY_BTC,
            'symbol' => 'ALGOBTC',
            'side' => $side,
            'type' => TradeOrder::TYPE_LIMIT,
            'status' => TradeOrder::STATUS_OPEN,
            'price' => $btc_price,
            'stop_price' => $btc_stop,
            'comission' => $side ? .4 : .2,
            'amount' => random_int(250000, 350000),
            'order_id' => $this->faker->uuid,
            'expires_at' => $expires,
        ]];

        return $quotes[random_int(0, count($quotes) - 1)];
    }

}
