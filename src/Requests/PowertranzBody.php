<?php
namespace SchoolAid\Powertranz\Requests;

use Ramsey\Uuid\Uuid;
use SchoolAid\Powertranz\Entities\PowertranzCreditCard;

class PowertranzBody
{
    public static function fromCreditCard(PowertranzCreditCard $card,
        $transactionId = null,
        $toVoid = false
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
            $card->billingAddress
        );
    }

    public static function capturePowertranzBody(
        string $transactionId,
        float | int $amount,
        string $externalIdentifier
    ) {
        return [
            "TransactionIdentifier" => $transactionId,
            "TotalAmount"           => $amount,
            "ExternalIdentifier"    => $externalIdentifier,
        ];
    }

    public static function refundPowertranzBody(
        string $transactionId,
        float | int $amount,
        string $externalIdentifier
    ) {
        return [
            "Refund"                => true,
            "TransactionIdentifier" => $transactionId,
            "TotalAmount"           => 1,
            "CurrencyCode"          => "320",
            "Source"                => [
                "CardPresent"     => false,
                "CardEmvFallback" => false,
                "ManualEntry"     => false,
                "Debit"           => false,
                "Contactless"     => false,
                "CardPan"         => "",
                "MaskedPan"       => "",
            ],
            "TerminalCode"          => "",
            "TerminalSerialNumber"  => "",
            "ExernalIdentifier"     => $externalIdentifier,
            "AddressMatch"          => false,
        ];
    }

    public static function voidPowertranzBody(
        string $transactionId,
        string $externalIdentifier
    ) {
        return [
            "TransactionIdentifier" => $transactionId,
            "ExternalIdentifier"    => $externalIdentifier,
            "TerminalCode"          => "",
            "TerminalSerialNumber"  => "",
            "AutoReversal"          => true,
        ];
    }

    public static function powertranzBody(
        string $transactionId,
        string $orderId,
        string $cardPan,
        string $cardCvv,
        string $cardExpiration,
        string $cardName,
        string $billingAddress
    ): array {
        $body = [
            "TransactionIdentifier"  => $transactionId,
            "TotalAmount"            => 5,
            "CurrencyCode"           => "320",
            "Tokenize"               => true,
            "ThreeDSecure"           => true,
            "OrderIdentifier"        => $orderId . "",
            "AddressMatch"           => false,
            "AllowPaymentCompletion" => true,
        ];

        $body['BillingAddress'] = [
            'Line1' => $billingAddress,
        ];

        $body["Source"] = [
            "CardPan"        => $cardPan,
            "CardCvv"        => $cardCvv,
            "CardExpiration" => $cardExpiration,
            "CardholderName" => $cardName,
        ];

        $body["ExtendedData"] = [
            "ThreeDSecure"        => [
                "ChallengeWindowSize" => 4,
                "ChallengeIndicator"  => "01",
            ],
            "MerchantResponseUrl" => config('powertranz.callback'),
        ];

        return $body;
    }
}
