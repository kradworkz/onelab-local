<?php

namespace App\Http\Controllers\Finance;

use App\Models\Request as R;
use App\Models\FinanceTransaction;
use App\Models\FinanceOrseries;
use App\Models\FinanceReceipt;
use App\Models\FinanceCheque;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\Finance\TransactionResource;
use App\Http\Resources\Finance\TransactionRequestResource;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        $data = FinanceTransaction::orderBy('id','ASC')->paginate(5);
        return TransactionResource::collection($data);
    }

    public function list(Request $request)
    {
        $type = $request->input('type');
        $keyword = $request->input('keyword');

        $data = FinanceTransaction::where('collection_id','=',$type)
        ->where(function ($query) use ($keyword) {
            $query->where('transaction_no', 'LIKE', '%'.$keyword.'%')
            ->orWhereHas('customer',function($query) use ($keyword) {
                $query->where('address', 'LIKE', '%'.$keyword.'%');
            });
        })
        ->orderBy('id','ASC')->paginate(5);

        return TransactionResource::collection($data);
    }

    public function customer($id)
    {
        $data = FinanceTransaction::where('customer_id', $id)->where('status','Pending')->first();
        return new TransactionResource($data);
    }

    public function request($id)
    {
        $data = R::where('customer_id', $id)->where('status','Waiting')->get();
        return TransactionRequestResource::collection($data);
    }

    public function payment(TransactionRequest $request)
    {
        \DB::transaction(function () use ($request){
            $lists = $request->input('lists');
            $transaction_id = $request->input('transaction');

            $transaction = FinanceTransaction::findOrFail($transaction_id);
            if($transaction->status == 'Pending'){
                $transaction->payment_id = $request->input('payment');
                $transaction->status = 'Paid';

                if($transaction->save())
                {   

                    if($request->input('payment_type') == 'Cheque'){
                        $cheque = new FinanceCheque;
                        $cheque->bank = $request->input('bank');
                        $cheque->account_number= $request->input('number');
                        $cheque->amount = $request->input('amount');
                        $cheque->cheque_date = $request->input('chequedate');
                        $cheque->transaction_id = $transaction_id;
                        $cheque->save();
                    }

                    $or = FinanceOrseries::where('status', 0)->first();
                    $r = FinanceReceipt::where('orseries_id',$or->id)->orderBy('created_at','DESC')->first();
                    (!empty($r) > 0) ? $ornumber = $r->ornumber + 1 : $ornumber = $or->start ;
                    
                    $receipt = new FinanceReceipt;
                    $receipt->ornumber = $ornumber;
                    $receipt->orseries_id = $or->id;
                    $receipt->deposit_id = $request->input('deposit');
                    $receipt->transaction_id = $transaction_id;
                    $receipt->save();

                    foreach($lists as $list)
                    {
                        $data = R::find($list['id']);
                        $data->status = 'Confirmed';
                        $data->save();

                        $data->cartable()->create([
                            'total' => str_replace(',','',$list['total']),
                            'subtotal' => str_replace(',','',$list['subtotal']),
                            'discount' => str_replace(',','',$list['discount']),
                            'type' => 'Request',
                            'transaction_id' => $transaction_id
                        ]);
                    }
                }
            }
        });
    }
}
