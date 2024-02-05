<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Counteragent;
use App\Models\CounteragentBalanceOperation;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        if (\Auth::id() == 326) {
            return redirect()->route('cashier.label-product.index');
        }
        return view('cashier.main');
    }

    public function show(Counteragent $counteragent)
    {
//        $orders = Order::query()
//            ->join('stores','stores.id','orders.store_id')
//            ->where('stores.counteragent_id',$counteragent->id)
//            ->whereIn('payment_status_id',[2,3])
//            ->where('status_id',3)
//            ->orderBy('orders.id')
//            ->select('orders.*')
//            ->get();

        $operations = CounteragentBalanceOperation::query()
            ->whereCounteragentId($counteragent->id)
            ->latest()
            ->paginate(30);


        return \view('cashier.counteragent.show', compact('counteragent', 'operations'));
    }

    public function addBalance(Request $request)
    {
        $counteragent = Counteragent::findOrFail($request->get('counteragent_id'));
        $orders = $counteragent->orders()->where('payment_status_id', 2)->get();
        $balance = $request->get('balance');
        $order_ids = [];
        foreach ($orders as $order) {
            if ($balance <= 0) {
                break;
            }
            //если есть остаток
            if ($order->payment_partial) {
                $debtPrice = $order->purchase_price - $order->payment_partial;
                //если остаток менше чем сумма оплаты
                if ($debtPrice > $balance) {
                    $order->payment_partial += $balance;
                    $order->save();
                    $order_ids[] = $order->id;
                    break;
                }
                //оплата
                $order->payment_partial = null;
                $order->payment_status_id = 1;
                $order->save();

                $order_ids[] = $order->id;
                $balance -= $debtPrice;

                continue;
            }
            //остаток +
            if ($order->purchase_price >= $balance) {
                //add to payment_purchase
                $order->payment_partial += $balance;
                $order->save();


                $balance = 0;
                $order_ids[] = $order->id;
                break;
            } else {
                //payment success
                $order->payment_status_id = 1;
                $order->save();

                $balance -= $order->purchase_price;

                $order_ids[] = $order->id;
            }
        }


        CounteragentBalanceOperation::create([
            'counteragent_id' => $request->get('counteragent_id'),
            'user_id' => \Auth::id(),
            'debt' => $request->get('debt'),
            'balance' => $request->get('balance'),
            'comment' => $request->get('comment'),
            'orders' => $order_ids
        ]);


        return redirect()->back();
    }

}
