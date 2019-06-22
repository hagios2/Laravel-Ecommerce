<?php

function format_price($price)
{
    setlocale(LC_MONETARY, 'en_US');
    return money_format('%i', $price);
}
