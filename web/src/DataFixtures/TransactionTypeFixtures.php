<?php

namespace App\DataFixtures;

use App\Entity\TransactionType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $transactionTypes = [
            [
                "Maintenance Fees",
                "Regular payments made by residents for the upkeep of common areas, amenities, and general maintenance."
            ],
            [
                "Special Assessments",
                "Additional charges levied on residents for specific projects or unexpected repairs that are not covered by the regular maintenance fees."
            ],
            [
                "Utility Payments",
                "Charges for utilities such as water, electricity, gas, or trash collection services that may be managed by the community."
            ],
            [
                "Security Fees",
                "Payments specifically for the security services provided within the gated community, including guards, monitoring systems, etc."
            ],
            [
                "Amenity Usage Fees",
                "Charges for using specific community amenities like the clubhouse, gym, tennis courts, swimming pool, etc., often on a per-use or membership basis."
            ],
            [
                "Lease/Rental Payments",
                "Payments made by residents who lease or rent property within the gated community."
            ],
            [
                "Fines/Penalties",
                "Payments made as penalties for violations of community rules, such as noise complaints, unauthorized construction, or improper waste disposal."
            ],
            [
                "Parking Fees",
                "Charges for parking spaces, particularly for additional vehicles or guest parking."
            ],
            [
                "Event Fees",
                "Payments for attending or organizing events within the community, such as social gatherings, workshops, or community fairs."
            ],
            [
                "Service Fees",
                "Payments for additional services provided by the community, such as pest control, landscaping, housekeeping, etc."
            ],
            [
                "Reserve Fund Contributions",
                "Allocated funds for future large-scale repairs or replacements, such as roof repairs, pavement, or major infrastructure upgrades."
            ],
            [
                "Insurance Payments",
                "Payments for community insurance, which might cover common areas, general liability, or other collective policies."
            ],
            [
                "Transfer Fees",
                "Fees associated with the transfer of property ownership within the gated community, often paid during the sale of a property."
            ],
            [
                "Guest/Visitor Fees",
                "Fees for allowing guests or visitors to use certain facilities or stay within the community for an extended period."
            ],
            [
                "Construction/Modification Fees",
                "Charges for approvals and inspections related to construction, renovations, or modifications made to properties within the community."
            ]
        ];

        foreach ($transactionTypes as $key => $transactionType) {
            $transaction = new TransactionType();
            $transaction->setName($transactionType[0]);
            $transaction->setDescription($transactionType[1]);

            $manager->persist($transaction);

            $this->addReference("transactionType{$key}", $transaction);
        }

        $manager->flush();
    }
}