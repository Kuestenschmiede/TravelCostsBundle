<?php

namespace con4gis\TravelCostsBundle\Classes\Backend;

use Contao\StringUtil;

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

    public function saveSimpleArrayValue($value)
    {
        // select field saves value as serialized array
        if (is_string($value) && str_contains($value, "a:")) {
            $value = StringUtil::deserialize($value, true);
        }

        if (is_array($value)) {
            $value = implode(",", $value);
        }

        return $value;
    }

    public function loadSimpleArrayValue($value)
    {
        if (is_string($value) && str_contains($value, ",")) {
            $value = explode(",", $value);
        }

        return $value;
    }

    public function saveJsonValue($value)
    {
        if (is_string($value) && str_contains($value, "a:")) {
            $value = StringUtil::deserialize($value, true);
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        return $value;
    }

    public function loadJsonValue($value)
    {
        if (is_string($value) && strlen($value) > 0) {
            $value = json_decode($value, true);
        }

        return $value;
    }
}