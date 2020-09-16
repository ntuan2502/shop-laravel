<?php

function pricetoVND($price){
    try {
        return number_format($price) . " VND";
    } catch (\Throwable $th) {
        return $price . " VND";
    }
}