<?php
namespace SchoolAid\Powertranz\Entities;

use Ramsey\Uuid\Uuid;

class PowertranzCreditCard
{
    public function __construct(
        public string $id,
        public string $pan,
        public string $cvv,
        public string $expiryDate,
        public string $name,
        public string $billingAddress = "Guatemala",
    ) {}

    public function orderId(): string
    {
        return "INT-" . Uuid::uuid4() . "-" . $this->id;
    }
}
