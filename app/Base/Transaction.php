<?php


namespace App\Base;


use App\Models\Transaction as TransactionModel;

class Transaction
{

    public $ledger, $payer, $payee, $transactionData, $amount, $transaction, $payer_type, $payee_type, $type;

    /**
     * Transaction constructor.
     * @param $transactionData
     */
    public function __construct($transaction = null)
    {
        $this->setTransactionData($transaction);
    }

    /**
     * @param mixed $transactionData
     */
    public function setTransactionData($transactionData): void
    {
        $this->transactionData = $transactionData;
        switch (gettype($transactionData)) {
            case null;
                break;

            case 'array';
                if (array_key_exists('ledger', $transactionData)) {
                    $this->setLedger($transactionData['ledger']);
                }
                if (array_key_exists('amount', $transactionData)) {
                    $this->setAmount($transactionData['amount']);
                }
                if (array_key_exists('payee_type', $transactionData)) {
                    $this->setPayeeType($transactionData['payee_type']);
                }
                if (array_key_exists('payee_type', $transactionData)) {
                    $this->setPayerType($transactionData['payer_type']);
                }
                if (array_key_exists('payee_id', $transactionData)) {
                    $this->setPayee($transactionData['payee_id']);
                }
                if (array_key_exists('payer_id', $transactionData)) {
                    $this->setPayer($transactionData['payer_id']);
                }

                if (array_key_exists('type', $transactionData)) {
                    $this->setType($transactionData['type']);
                }
                TransactionModel::create($this->getNewTransaction());
                break;

            case 'integer';
                $this->setTransaction(TransactionModel::findOrFail($transactionData));
                break;

            case 'object';
                if (is_a($transactionData, TransactionModel::class)) {
                    $value = $transactionData;
                }
                break;

            default:
        }
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param mixed $payee_type
     */
    public function setPayeeType($payee_type): void
    {
        $this->payee_type = $payee_type;
    }

    /**
     * @param mixed $payer_type
     */
    public function setPayerType($payer_type): void
    {
        $this->payer_type = $payer_type;
    }

    /**
     * @param mixed $payee
     */
    public function setPayee($payee): void
    {
        switch (gettype($payee)) {
            case 'object':
                $this->payee = $payee;
                break;

            case 'integer':
                $this->payee =call_user_func([$this->getPayeeType(), 'find'], $payee);

                break;
        }
    }

    /**
     * @return mixed
     */
    public function getPayeeType(): string
    {
        return $this->payee_type;
    }

    /**
     * @param mixed $payer
     */
    public function setPayer($payer): void
    {

        switch (gettype($payer)) {
            case 'object':
                $this->payer = $payer;
                break;

            case 'integer':
                $this->payer = call_user_func([$this->getPayerType(), 'find'], $payer);
                break;
        }
    }

    /**
     * @return mixed
     */
    public function getPayerType(): string
    {

        return $this->payer_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getNewTransaction()
    {
        return [
            'ledger_id' => $this->getLedger()->id,
            'payer_id' => $this->getPayer()->id,
            'payer_type' => $this->getPayeeType(),
            'payee_id' => $this->getPayee()->id,
            'payee_type' => $this->getPayeeType(),
            'amount' => $this->getAmount(),
            'type' => $this->getType(),
        ];
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
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @return mixed
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $transaction
     */
    public function setTransaction($transaction): void
    {
        $this->transaction = $transaction;
    }

    /**
     * @return mixed
     */
    public function getTransactionData()
    {
        return $this->transactionData;
    }

    /**
     * @return mixed
     */
    public function getTransaction()
    {
        return $this->transaction;
    }


}