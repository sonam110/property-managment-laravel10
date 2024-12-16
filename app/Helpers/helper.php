<?php
use App\Models\PartnerBankDetail;
function getIndianCurrency($amount) {
    $words = array(
        0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four",
        5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine",
        10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen", 14 => "Fourteen",
        15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen",
        20 => "Twenty", 30 => "Thirty", 40 => "Forty", 50 => "Fifty",
        60 => "Sixty", 70 => "Seventy", 80 => "Eighty", 90 => "Ninety"
    );

    $suffixes = array("", "Thousand", "Million", "Billion", "Trillion");

    if ($amount == 0) {
        return "Zero Rupees";
    }

    $amount = number_format($amount, 2, ".", "");
    list($integerPart, $decimalPart) = explode(".", $amount);
    $integerPart = (int)$integerPart;
    $decimalPart = (int)$decimalPart;

    $wordsArray = array();
    $place = 0;

    while ($integerPart > 0) {
        $chunk = $integerPart % 1000;
        if ($chunk > 0) {
            $wordsArray[] = convertChunkToWords($chunk) . " " . $suffixes[$place];
        }
        $integerPart = (int)($integerPart / 1000);
        $place++;
    }

    $finalWords = implode(" ", array_reverse($wordsArray)) . " Rupees";
    return ucfirst($finalWords); // Capitalize the first letter of the currency word
}

function convertChunkToWords($chunk) {
    $words = array(
        0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four",
        5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine",
        10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen", 14 => "Fourteen",
        15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen",
        20 => "Twenty", 30 => "Thirty", 40 => "Forty", 50 => "Fifty",
        60 => "Sixty", 70 => "Seventy", 80 => "Eighty", 90 => "Ninety"
    );

    if ($chunk < 20) {
        return $words[$chunk];
    } elseif ($chunk < 100) {
        $tens = (int)($chunk / 10) * 10;
        $ones = $chunk % 10;
        return $words[$tens] . ($ones ? " " . $words[$ones] : "");
    } else {
        $hundreds = (int)($chunk / 100);
        $remainder = $chunk % 100;
        return $words[$hundreds] . " Hundred" . ($remainder ? " " . convertChunkToWords($remainder) : "");
    }
}


/*function getIndianCurrency(float $number)
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
}*/

function formatIndianCurrency($amount) {
    // Remove any existing formatting (e.g., commas) and convert to float
    $amount = floatval($amount);

    // Convert the amount to string and split the integer and decimal parts
    $integerPart = floor(round($amount,0));
    $decimalPart = round(($amount - $integerPart) * 100);

    // Format the integer part with Indian numbering system
    $integerStr = (string)$integerPart;
    $len = strlen($integerStr);

    if ($len > 3) {
        $lastThree = substr($integerStr, -3);
        $remainingDigits = substr($integerStr, 0, $len - 3);
        $formattedIntegerPart = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . ',' . $lastThree;
    } else {
        $formattedIntegerPart = $integerStr;
    }

    // Add decimal part and currency symbol
    return '₹ ' . $formattedIntegerPart;
}

function formatIndianCurrencyPdf($amount) {
  // Remove any existing formatting (e.g., commas) and convert to float
    $amount = floatval($amount);

    // Convert the amount to string and split the integer and decimal parts
    $integerPart = floor($amount);
    $decimalPart = round(($amount - $integerPart) * 100);

    // Format the integer part with Indian numbering system
    $integerStr = (string)$integerPart;
    $len = strlen($integerStr);

    if ($len > 3) {
        $lastThree = substr($integerStr, -3);
        $remainingDigits = substr($integerStr, 0, $len - 3);
        $formattedIntegerPart = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remainingDigits) . ',' . $lastThree;
    } else {
        $formattedIntegerPart = $integerStr;
    }

    // Add decimal part and currency symbol
    return '₹ ' . $formattedIntegerPart . '.' . str_pad($decimalPart, 2, '0', STR_PAD_LEFT);
}


function partnetBankDetail($id,$type){
    $for_type = '1';
    if($type=='rent'){
        $for_type = '1';
    }
    if($type=='cam'){
        $for_type = '2';
    }
     if($type=='utility' || $type =='electricity'){
        $for_type = '2';
    }
    $bankDetail = PartnerBankDetail::where('user_id',$id)->where('for_type',$for_type)->first();
    return (!empty($bankDetail)) ? $bankDetail : NULL;


}


