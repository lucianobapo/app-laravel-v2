<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Contact;
use App\Models\ItemOrder;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Product;

use App\Models\SharedOrderPayment;
use App\Models\SharedOrderType;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Cache\Repository as CacheRepository;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class DeliveryController extends Controller {

    /**
     * @var CacheRepository
     */
    private $cache;

    /**
     * TotalCart
     * @var integer
     */
    private $totalCart = 0;
    /**
     * CartView
     * @var \Illuminate\View\View
     */
    private $cartView;

    /**
     * @param CacheRepository $cache
     * @param RuntimeFormat $format
     */
    public function __construct(CacheRepository $cache) {
//        $this->middleware('auth',['except'=> ['index','show']]);
//        $this->middleware('guest',['only'=> ['index','show']]);

        $this->cache = $cache;
        $this->cartView = view('delivery.partials.cartVazio');
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function index(Product $product, $host){
        $this->prepareCart($host);
        if(count($products = $product->all())) {
            $panelBody = view('delivery.partials.productList', compact('products', 'host'));
        } else {
            $panelBody = trans('delivery.index.semProdutos');
        }
        return view('delivery.index', compact('host'))->with([
            'cartView' => $this->cartView,
            'totalCart' => $this->totalCart,
            'panelTitle' => trans('delivery.index.panelTitle'),
            'panelBody' => $panelBody,
        ]);
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addCart(Request $request, $host){
        $data = $request->all();
        foreach($data['quantidade'] as $key => $value){
            if (!$value>0) continue;
            Cart::add($key, $data['nome'][$key], $value, $data['valor'][$key]);
            if(!$request->ajax()) flash()->success(trans('delivery.flash.itemAdd'));
        }
        if($request->ajax()) return Response::json( [
            'view' => view('delivery.partials.cart', compact('host'))->with([
                'cart' => Cart::content()->toArray(),
            ])->render(),
            'total' => formatBRL(Cart::total()),
            'btnPedido' => link_to_route('delivery.pedido', trans('delivery.nav.cartBtn'), $host, ['class'=>'btn btn-success']),
        ]);
        else return redirect(route('delivery.index', $host));
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function pedido(Product $product, $host, Request $request){

        if (Auth::guest()) {
            $panelListaEnderecos = '';
            $panelGuest = view('delivery.partials.panelGuestLogin', compact('host'));
        } else {
            $panelListaEnderecos = view('delivery.partials.pedidoListEnderecos')->with([
                'enderecos' => Address::where([
                    'partner_id' => Partner::firstByAttributes([
                        'user_id' => Auth::user()->id,
                    ])->id,
                ])->get(),
            ]);
            $panelGuest = '';
        }

        if (Session::has('cart')){
            $this->prepareCart($host);

            $panelBody = view('delivery.partials.pedidoList', compact('product', 'host'))->with([
                'cart' => Cart::content()->toArray(),
            ]);

            $panelFormBody = view('delivery.partials.pedidoForm', compact('product', 'host'))->with([
                'cart' => Cart::content()->toArray(),
                'totalCartUnformatted' => Cart::total(),
                'panelListaEnderecos' => $panelListaEnderecos,
            ]);
            return view('delivery.pedido', compact('host'))->with([
                'cartView' => $this->cartView,
                'totalCart' => $this->totalCart,
                'panelTitle' => trans('delivery.pedidos.panelTitle'),
                'panelBody' => $panelBody,

                'panelFormBody' => $panelFormBody,
                'panelGuest' => $panelGuest,

            ]);

        } else {
            $panelBody = view('delivery.partials.pedidoVazio', compact('host'));
            return view('delivery.pedido', compact('host'))->with([
                'cartView' => $this->cartView,
                'totalCart' => $this->totalCart,
                'panelTitle' => trans('delivery.pedidos.panelTitle'),
                'panelBody' => $panelBody,
                'panelFormBody' => '',
                'panelGuest' => $panelGuest,
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function emptyCart($host){
        if (Session::has('cart')) Session::forget('cart');

        return redirect(route('delivery.index', $host));
    }

    /**
     * Prepara o carrinho de compras
     * @param $host
     */
    private function prepareCart($host){
        if (Session::has('cart')){
            $this->totalCart = formatBRL(Cart::total());
            $this->cartView = view('delivery.partials.cart', compact('host'))->with([
                'cart' => Cart::content()->toArray(),
            ]);
        }
    }

    public function addOrder(Request $request, $host,
                             ItemOrder $itemOrder,
                             Product $product, SharedOrderType $sharedOrderType,
                             SharedOrderPayment $sharedOrderPayment){

        $attributes = $request->all();
//        dd($attributes);

        //Adicionando a Ordem
        $addedOrder = $this->getAddedOrder($attributes);

        //Atributos da ordem
        $sharedOrderType->firstOrCreate(['tipo'=>'ordemVenda'])->orders()->save($addedOrder);
        $sharedOrderPayment->firstOrCreate(['pagamento'=>$attributes['pagamento']])->orders()->save($addedOrder);

        // Adicionando Partner
        $addedPartner = $this->getAddedPartner($attributes);
        $addedPartner->orders()->save($addedOrder);

        //Adicionando o endereço
        $addedPartner->addresses()->save($this->getAddedAddress($attributes));

        //Adicionando os contatos
        if (!empty($attributes['email'])) {
            $addedPartner->contacts()->save(
                Contact::firstOrCreate([
                    'mandante' => 'teste',
                    'partner_id' => $addedPartner->id,
                    'contact_type' => 'email',
                    'contact_data' => $attributes['email']
                ]) );
        }
        if (!empty($attributes['telefone'])) {
            $addedPartner->contacts()->save(
                Contact::firstOrCreate([
                    'mandante' => 'teste',
                    'partner_id' => $addedPartner->id,
                    'contact_type' => 'telefone',
                    'contact_data' => $attributes['telefone']
                ]) );
        }


        //Adicionando os itens do pedido
        foreach ($attributes['quantidade'] as $key => $quantidade) {
            $addedItemOrder = $this->getAddedItemOrder($quantidade, $attributes['valor_unitario'][$key]);
            $addedOrder->orderItems()->save($addedItemOrder);
            $product->find($key)->itemOrders()->save($addedItemOrder);
        }

        flash()->success(trans('delivery.flash.pedidoAdd', ['pedido' => $addedOrder->id, 'email' => $addedPartner->contacts()->where(['contact_type'=>'email'])->first()->contact_data]));
        if (Session::has('cart')) Session::forget('cart');
        return redirect(route('delivery.index', $host));

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getAddedAddress(array $attributes)
    {
        if ( (Auth::guest()) || empty($attributes['address_id']) ){
            $addressAttribute = [
                'mandante' => 'teste',
                'cep' => $attributes['cep'],
                'logradouro' => $attributes['logradouro'],
                'numero' => $attributes['numero'],
            ];
            if (!empty($attributes['complemento'])) $addressAttribute['complemento'] = $attributes['complemento'];
            if (!empty($attributes['bairro'])) $addressAttribute['bairro'] = $attributes['bairro'];
            if (!empty($attributes['cidade'])) $addressAttribute['cidade'] = $attributes['cidade'];
            if (!empty($attributes['estado'])) $addressAttribute['estado'] = $attributes['estado'];
            if (!empty($attributes['observacao'])) $addressAttribute['obs'] = $attributes['observacao'];

//        return $address->create($addressAttribute);
            return new Address($addressAttribute);
        } else {
            return Address::find($attributes['address_id']);
        }
    }

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getAddedPartner($attributes)
    {
//        $partnerAttribute = [
//            'mandante' => 'teste',
//            'nome' => $attributes['nome'],
//        ];
//        if (!empty($attributes['data_nascimento'])) $partnerAttribute['data_nascimento'] = $attributes['data_nascimento'];
//        if (!empty($attributes['cpf'])) $partnerAttribute['cpf'] = $attributes['cpf'];
//        return (new Partner)->create($partnerAttribute);
//        return (new Partner)->getAddedPartner($attributes);
        if (Auth::guest()){
            $partnerAttribute = [
                'mandante' => 'teste',
                'nome' => $attributes['nome'],
            ];
            if (!empty($attributes['data_nascimento'])) $partnerAttribute['data_nascimento'] = $attributes['data_nascimento'];
            if (!empty($attributes['cpf'])) $partnerAttribute['cpf'] = $attributes['cpf'];
            return Partner::create($partnerAttribute);
        } else {
            return Partner::firstByAttributes(['user_id' => Auth::user()->id]);
        }

    }

    /**
     * @param $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getAddedOrder($attributes)
    {
        $orderAttribute = [
            'mandante' => 'teste',
            'valor_total' => $attributes['total'],
        ];
        if (!empty($attributes['troco'])) $orderAttribute['troco'] = $attributes['troco'];
        return new Order($orderAttribute);
    }

    /**
     * @param $quantidade
     * @param $valor
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function getAddedItemOrder($quantidade, $valor)
    {
        $itemOrderAttribute = [
            'mandante' => 'teste',
            'quantidade' => $quantidade,
            'valor_unitario' => $valor,
        ];
        return new ItemOrder($itemOrderAttribute);
    }

}
