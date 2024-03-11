<?php

namespace App\Service;

class Collection
{
    public const OWNER_STATUS = [
        '1' => "Yes - I'm the owner",
        '2' => "No - I'm an agent / wholesaler",
    ];

    public const SELLING_REASON = [
        '1' => "Pre-Foreclosure",
        '2' => "Relocation",
        '3' => "Emergency Reasons",
        '4' => "Financial Reasons",
        '5' => "Selling a Vacant / Non-Occupied House",
        '6' => "Sell And Rent Instead",
        '7' => "Sell Without an Agent",
        '8' => "Inherited Property",
        '9' => "Tired of Being a Landlord",
        '10' => "Retirement Elsewhere",
    ];

    public const LISTED = [
        '1' => "No - It is not listed",
        '2' => "Yes - It is listed on MLS / Zillow / Redfin",
    ];
}