<?php


namespace App\Base;



use App\Models\Ledger as LedgerModel;
use App\Models\Transaction as TransactionModel;

class Ledger
{
    public $ledgerData, $owner,$ledger,$type,$balance,$transactions,$total_credit,$total_debit;
    private string $ownerKey="owner_id";

    public function __construct($ledger=null){
        $this->setLedgerData($ledger);
    }


    public function loadTransaction($type=null){

        switch ($type){
            case null:
                $this->setTransactions(TransactionModel::where('ledger_id',$this->getLedger()->id)->orWhere('payee_id',$this->getOwner()->id)->orWhere('payer_id',$this->getOwner()->id)->get());
                $this->setTotalCredit($this->getTransactions()->where('type',1)->sum('amount'));
                $this->setTotalDebit($this->getTransactions()->where('type',0)->sum('amount'));
                break;

            case 'credit':
               $this->setTransactions(TransactionModel::where('ledger_id',$this->getLedger()->id)->where('payee_id',$this->getOwner()->id)->where('type',1)->get());
               $this->setTotalCredit($this->getTransactions()->sum('amount'));
                break;

            case 'debit':
                $this->setTransactions(TransactionModel::where('ledger_id',$this->getLedger()->id)->where('payer_id',$this->getOwner()->id)->where('type',0)->get());
                $this->setTotalDebit($this->getTransactions()->sum('amount'));
                break;
        }
        return $this;

    }



    public function transaction($type,$amount,$payee){
        $transaction=[
            'ledger'=>$this->getLedger(),
            'amount'=>$amount
        ];
        switch (strtolower($type)){

            case 'credit':
                $transaction['payee_id']=$this->getOwner()->id;
                $transaction['payee_type']=get_class($this->getOwner());
                $transaction['payer_id']=$payee;
                $transaction['payer_type']=get_class($payee );
                $transaction['type']=1;
        //        $this->credit($amount);
                break;

            case 'debit':
                $transaction['payee_id']=$payee;
                $transaction['payee_type']=get_class($payee);
                $transaction['payer_id']=$this->getOwner()->id;
                $transaction['payer_type']=get_class($this->getOwner());
                $transaction['type']=0;
        //        $this->debit($amount);
                break;

        }


        $transaction=resolve(Transaction::class,['transaction'=>$transaction]);
        dd($transaction);

    }

    public function credit($amount):self{
        $this->getLedger()->update(['balance'=>$this->getLedger()->balance+$amount]);
        $this->getLedger()->save();
        return $this;
    }

    public function debit($amount):self{
        $this->getLedger()->update(['balance'=>$this->getLedger()->balance-$amount]);
        $this->getLedger()->save();
        return $this;
    }



    /**
     * @return mixed|null
     */
    public function getLedgerData()
    {
        return $this->ledgerData;
    }

    /**
     * @param mixed|null $ledgerData
     */
    public function setLedgerData($ledgerData): void
    {
        switch (gettype($ledgerData)){
            case null;
                break;

            case 'array';

                if(!array_key_exists($this->getOwnerKey(),$ledgerData) && auth()->check()) {
                    $ledgerData[$this->getOwnerKey()] = auth()->id();
                }
                if(array_key_exists('type',$ledgerData)) {
                    $this->setType($ledgerData['type']);
                }
                if(array_key_exists('balance',$ledgerData)){
                    $this->setBalance($ledgerData['balance']);
                }

                $this->setOwner($ledgerData[$this->getOwnerKey()]);


                $value=($this->checkLedgerExist())?$this->getLedger():LedgerModel::create($ledgerData);

                break;

            case 'integer';
                $this->setLedger(LedgerModel::findOrFail($ledgerData));
                break;

            case 'object';
                if(is_a($ledgerData,LedgerModel::class))$value=$ledgerData;
                break;

            default:

        }

        $this->ledgerData = $ledgerData;
    }

    private function checkLedgerExist(){
        $this->setLedger(LedgerModel::find($this->getOwner()->id)??null);
        return ($this->getLedger())?true:false;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $this->getType()->where('id',$owner)->first();
    }

    /**
     * @return mixed
     */
    public function getLedger()
    {
        return $this->ledger;
    }

    /**
     * @param mixed $ledger
     */
    public function setLedger($ledger): void
    {
        $this->ledger = $ledger;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = resolve($type);
    }

    /**
     * @return string
     */
    public function getOwnerKey(): string
    {
        return $this->ownerKey;
    }

    /**
     * @param string $ownerKey
     */
    public function setOwnerKey(string $ownerKey): void
    {
        $this->ownerKey = $ownerKey;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     */
    public function setTransactions($transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * @return mixed
     */
    public function getTotalCredit()
    {
        return $this->total_credit;
    }

    /**
     * @param mixed $total_credit
     */
    public function setTotalCredit($total_credit): void
    {
        $this->total_credit = $total_credit;
    }

    /**
     * @return mixed
     */
    public function getTotalDebit()
    {
        return $this->total_debit;
    }

    /**
     * @param mixed $total_debit
     */
    public function setTotalDebit($total_debit): void
    {
        $this->total_debit = $total_debit;
    }





}