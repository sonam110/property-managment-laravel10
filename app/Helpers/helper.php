<?php



function getIndianCurrency(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . '' : '';
    return ($Rupees ? $Rupees . ' ' :'').$paise;
}

function formatIndianCurrency($amount) {
    // Remove any existing formatting (e.g., commas) and convert to float
    $amount = floatval($amount);
    
    // Convert the amount to string and split the integer and decimal parts
    $integerPart = floor($amount);
    $decimalPart = round(($amount - $integerPart) * 100);
    
    // Format the integer part
    $formattedIntegerPart = number_format($integerPart, 0, '.', ',');
    
    // Split formatted integer part into parts for Indian numbering system
    $parts = explode(',', $formattedIntegerPart);
    $lastPart = array_pop($parts);
    
    // Combine parts for Indian format (with lakhs and crores)
    if (count($parts) > 1) {
        $formattedIntegerPart = implode(',', $parts) . ',' . $lastPart;
    }
    
    // Add decimal part and currency symbol
    return '₹ ' . $formattedIntegerPart . '.' . str_pad($decimalPart, 2, '0', STR_PAD_LEFT);
}
function formatIndianCurrencyPdf($amount) {
    // Remove any existing formatting (e.g., commas) and convert to float
    $amount = floatval($amount);
    
    // Convert the amount to string and split the integer and decimal parts
    $integerPart = floor($amount);
    $decimalPart = round(($amount - $integerPart) * 100);
    
    // Format the integer part
    $formattedIntegerPart = number_format($integerPart, 0, '.', ',');
    
    // Split formatted integer part into parts for Indian numbering system
    $parts = explode(',', $formattedIntegerPart);
    $lastPart = array_pop($parts);
    
    // Combine parts for Indian format (with lakhs and crores)
    if (count($parts) > 1) {
        $formattedIntegerPart = implode(',', $parts) . ',' . $lastPart;
    }
    
    // Add decimal part and currency symbol
    return 'Rs.' . $formattedIntegerPart . '.' . str_pad($decimalPart, 2, '0', STR_PAD_LEFT);
}


