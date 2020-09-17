<?php

function pricetoVND($price){
    try {
        return number_format($price) . " VND";
    } catch (\Throwable $th) {
        return $price . " VND";
    }
}

function remove_thousand_seperator($price){
    return str_replace(',', '', $price);
}