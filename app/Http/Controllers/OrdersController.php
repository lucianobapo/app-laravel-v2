<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;
use Moltin\Currency\Currency as Currency;
use Moltin\Currency\Format\Runtime as RuntimeFormat;
use Moltin\Currency\Exchange\OpenExchangeRates as OpenExchange;

class OrdersController extends Controller {

    private $currency;

    public function __construct(RuntimeFormat $format) {
//        $this->middleware('auth',['except'=> ['index','show']]);
//        $this->middleware('guest',['only'=> ['index','show']]);

        $exchange = new OpenExchange(config('services.openExchangeRates.appId'));
        $format->available['BRL'] = [
            'format'      => 'R${price}',
            'decimal'     => ',',
            'thousand'    => '.'
        ];
        $this->currency = new Currency($exchange, $format);

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Order $order)
	{
        return view('orders.index')->with([
            'orders' => $order->all(),
            'currency' => $this->currency,
        ]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
