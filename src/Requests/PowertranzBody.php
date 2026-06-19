<?php

namespace SchoolAid\Powertranz\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use Ramsey\Uuid\Uuid;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;

class PowertranzBody
{
    public static function fromCreditCard(PowertranzCreditCard $card,
        $transactionId = null,
        $toVoid = false,
        $amount = 5,
    ): array {
        if ($toVoid) {
            return self::voidPowertranzBody($transactionId, $card->id);
        }

        return self::powertranzBody(
            $transactionId ?? Uuid::uuid4(),
            $card->orderId(),
            $card->pan,
            $card->cvv,
            $card->expiryDate,
            $card->name,
            $card->billingAddress,
            $amount
        );
    }

    public static function capturePowertranzBody(
        string $transactionId,
        float|int $amount,
        string $externalIdentifier
    ) {
        return [
            'TransactionIdentifier' => $transactionId,
            'TotalAmount' => $amount,
            'ExternalIdentifier' => $externalIdentifier,
        ];
    }

    public static function refundPowertranzBody(
        string $transactionId,
        float|int $amount,
        string $externalIdentifier
    ) {
        return [
            'Refund' => true,
            'TransactionIdentifier' => $transactionId,
            'TotalAmount' => 1,
            'CurrencyCode' => '320',
            'Source' => [
                'CardPresent' => false,
                'CardEmvFallback' => false,
                'ManualEntry' => false,
                'Debit' => false,
                'Contactless' => false,
                'CardPan' => '',
                'MaskedPan' => '',
            ],
            'TerminalCode' => '',
            'TerminalSerialNumber' => '',
            'ExernalIdentifier' => $externalIdentifier,
            'AddressMatch' => false,
        ];
    }

    public static function voidPowertranzBody(
        string $transactionId,
        string $externalIdentifier
    ) {
        return [
            'TransactionIdentifier' => $transactionId,
            'ExternalIdentifier' => $externalIdentifier,
            'TerminalCode' => '',
            'TerminalSerialNumber' => '',
            'AutoReversal' => true,
        ];
    }

    public static function removeTildes(string $text): string
    {
        return strtr($text, [
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Ñ' => 'N', 'ñ' => 'n',
        ]);
    }

    public static function powertranzBody(
        string $transactionId,
        string $orderId,
        string $cardPan,
        string $cardCvv,
        string $cardExpiration,
        string $cardName,
        string $billingAddress,
        float $amount,
        string $email = '',
        string $phone = '',
    ): array {

        $data = compact(
            'transactionId', 'orderId', 'cardPan', 'cardCvv', 'cardExpiration', 'cardName',
            'billingAddress', 'amount', 'email', 'phone'
        );

        $cardName = self::removeTildes($cardName);
        $billingAddress = self::removeTildes($billingAddress);

        $isToken = !preg_match('/^\d{13,19}$/', $cardPan);

        $rules = [
            'transactionId' => ['required', 'uuid'],
            'orderId' => ['required'],
            'cardExpiration' => ['required', 'regex:/^\d{2}(0[1-9]|1[0-2])$/'],
            'amount' => ['numeric'],
        ];

        if (!$isToken) {
            $rules['cardPan'] = ['required', new CardNumber];
            $rules['cardCvv'] = ['required', new CardCvc($cardPan)];
        }

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $body = [
            'TransactionIdentifier' => $transactionId,
            'TotalAmount' => $amount,
            'CurrencyCode' => '320',
            'Tokenize' => true,

            'OrderIdentifier' => $orderId.'',
            'AddressMatch' => false,
            'AllowPaymentCompletion' => true,
        ];

        $body['BillingAddress'] = [
            'Line1' => $billingAddress,
            'EmailAddress' => $email,
            'PhoneNumber' => $phone,
        ];

        $body['Source'] = [
            'CardCvv' => $cardCvv,
            'CardExpiration' => $cardExpiration,
            'CardholderName' => $cardName,
        ];
        // support for tokenized cards transactions
        if ($isToken) {
            $body['Source']['Token'] = $cardPan;
            $body['ThreeDSecure'] = true;
        } else {
            $body['Source']['CardPan'] = $cardPan;
            $body['ThreeDSecure'] = true;
        }

        $body['ExtendedData'] = [
            'ThreeDSecure' => [
                'ChallengeWindowSize' => 4,
                'ChallengeIndicator' => '01',
            ],
            'MerchantResponseUrl' => config('powertranz.callback'),
        ];

        return $body;
    }

    public static function riskMgmtPowertranzBody(
        string $transactionId,
        string $referenceId,
        string $cardPan,
        string $cardCvv,
        string $cardExpiration,
        string $cardName,
    ): array {

        $data = compact(
            'transactionId', 'referenceId', 'cardPan', 'cardCvv', 'cardExpiration', 'cardName'
        );

        $cardName = self::removeTildes($cardName);

        $rules = [
            'transactionId' => ['required', 'uuid'],
            'cardPan' => ['required', new CardNumber],
            'cardCvv' => ['required', new CardCvc($cardPan)],
            'cardExpiration' => ['required', 'regex:/^\d{2}(0[1-9]|1[0-2])$/'],
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $body = [
            'TransactionIdentifier' => $transactionId,
            'OrderIdentifier' => $referenceId,
            'Tokenize' => true,
            'TotalAmount' => 0,
            'ThreeDSecure' => true,
            'CurrencyCode' => '320',
            'Source' => [
                'CardPan' => $cardPan,
                'CardCvv' => $cardCvv,
                'CardExpiration' => $cardExpiration,
                'CardholderName' => $cardName,
            ],
            'ExtendedData' => [
                'ThreeDSecure' => [
                    'ChallengeWindowSize' => 4,
                    'ChallengeIndicator' => '01',
                ],
                'MerchantResponseUrl' => config('powertranz.callback').'?referenceId='.$referenceId,
            ],
        ];

        return $body;
    }
}
