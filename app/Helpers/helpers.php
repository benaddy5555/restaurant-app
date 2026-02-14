<?php

if (!function_exists('formatCurrency')) {
    /**
     * Format currency amount with proper Moroccan Dirham formatting
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    function formatCurrency($amount, $currency = 'MAD')
    {
        $config = config('currency');
        
        $formatted = number_format(
            $amount, 
            $config['decimals'], 
            $config['decimal_separator'], 
            $config['thousands_separator']
        );
        
        if ($config['position'] === 'before') {
            return $config['symbol'] . ' ' . $formatted;
        } else {
            return $formatted . ' ' . $config['symbol'];
        }
    }
}

if (!function_exists('currencySymbol')) {
    /**
     * Get currency symbol
     *
     * @return string
     */
    function currencySymbol()
    {
        return config('currency.symbol', 'MAD');
    }
}
