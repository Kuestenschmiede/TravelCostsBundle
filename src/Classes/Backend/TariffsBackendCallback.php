<?php

namespace con4gis\TravelCostsBundle\Classes\Backend;

class TariffsBackendCallback
{
    public function storeBasePrice($varValue)
    {
        if (!str_contains($varValue, ",")) {
            return $varValue;
        }

        return str_replace(",", ".", $varValue);
    }

    public function loadBasePrice($varValue)
    {
        if (!str_contains($varValue, ".")) {
            return $varValue;
        }

        return str_replace(".", ",", $varValue);
    }
}