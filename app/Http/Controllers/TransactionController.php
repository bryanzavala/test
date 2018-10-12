<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['naturaleza']) && isset($_GET['beneficiario'])) {
            $transactions = Transaction::where([['naturaleza', $_GET['naturaleza']], ['beneficiario', $_GET['beneficiario']]])->get();
        } else {
            $transactions = Transaction::all();
        }
        $data = Transaction::all();
        return view('welcome', compact('transactions', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = substr($request->fecha, 2, 2) . substr($request->fecha, 5, 2) . '-' . $request->bancos . '-431' . substr($request->fecha, 8, 2) . '-000' . rand(1, 9) . '.00';
        $transaction = new Transaction();
        $transaction->id = $id;
        $transaction->fecha = $request->fecha;
        $transaction->beneficiario = $request->beneficiario;
        $transaction->salidas = $request->salidas;
        $transaction->saldo = $request->saldo;
        $transaction->bancos = $request->bancos;
        $transaction->tipo_mov = $request->tipo_mov;
        $transaction->empresa = $request->empresa;
        $transaction->naturaleza = $request->naturaleza;
        $transaction->save();
        if ($transaction) {
            return redirect()->route('home')->with('data', ['status' => 'success', 'message' => 'Registro creado correctamente.']);
        }
        return redirect()->route('home')->with('data', ['status' => 'error', 'message' => 'Hubo un error al crear el registro.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        dd($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->fecha = $request->fecha;
        $transaction->beneficiario = $request->beneficiario;
        $transaction->salidas = $request->salidas;
        $transaction->saldo = $request->saldo;
        $transaction->bancos = $request->bancos;
        $transaction->tipo_mov = $request->tipo_mov;
        $transaction->empresa = $request->empresa;
        $transaction->naturaleza = $request->naturaleza;
        $transaction->save();
        if ($transaction) {
            return redirect()->route('home')->with('data', ['status' => 'success', 'message' => 'Registro actualizado correctamente.']);
        }
        return redirect()->route('home')->with('data', ['status' => 'error', 'message' => 'Hubo un error al actualizar el registro.']);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction) {
            $transaction->delete();
            return redirect()->route('home')->with('data', ['status' => 'success', 'message' => 'Registro borrado correctamente.']);
        }
        return redirect()->route('home')->with('data', ['status' => 'error', 'message' => 'Hubo un error al borrar el registro.']);          
    }
}
