<?php

/**
 * Карта кодов шлюзов (из fullvpnservice) — каталог для сидера и UI админки.
 * Реализации подключаются по мере интеграции; секреты только в БД config JSON / env.
 */
return [
    'catalog' => [
        'yookassa' => ['name' => 'ЮKassa', 'group' => 'cards_ru'],
        'tinkoff' => ['name' => 'Т-Банк (Тинькофф)', 'group' => 'cards_ru'],
        'sber' => ['name' => 'Сбер Эквайринг', 'group' => 'cards_ru'],
        'robokassa' => ['name' => 'Robokassa', 'group' => 'aggregators'],
        'cloudpayments' => ['name' => 'CloudPayments', 'group' => 'cards_ru'],
        'qiwi' => ['name' => 'QIWI', 'group' => 'wallets'],
        'stripe' => ['name' => 'Stripe', 'group' => 'intl'],
        'paypal' => ['name' => 'PayPal', 'group' => 'intl'],
        'nowpayments' => ['name' => 'NOWPayments (crypto)', 'group' => 'crypto'],
        'webmoney' => ['name' => 'WebMoney', 'group' => 'wallets'],
        'boosty' => ['name' => 'Boosty', 'group' => 'alt'],
        'overpay' => ['name' => 'Overpay', 'group' => 'aggregators'],
        'overpay_card' => ['name' => 'Overpay Card', 'group' => 'cards_ru'],
        'exnode' => ['name' => 'Exnode (crypto)', 'group' => 'crypto'],
        'pally' => ['name' => 'Pally', 'group' => 'aggregators'],
        'oneplat' => ['name' => 'OnePlat', 'group' => 'aggregators'],
        'platega' => ['name' => 'Platega', 'group' => 'aggregators'],
        'cashera' => ['name' => 'Cashera', 'group' => 'aggregators'],
        'freekassa' => ['name' => 'FreeKassa', 'group' => 'aggregators'],
        'freekassa_sbp' => ['name' => 'FreeKassa СБП', 'group' => 'sbp'],
        'freekassa_card' => ['name' => 'FreeKassa Card', 'group' => 'cards_ru'],
        'freekassa_world_card' => ['name' => 'FreeKassa World Card', 'group' => 'intl'],
        'friendlypay' => ['name' => 'FriendlyPay', 'group' => 'aggregators'],
        'friendlypay_card' => ['name' => 'FriendlyPay Card', 'group' => 'cards_ru'],
        'friendlypay_sbp' => ['name' => 'FriendlyPay СБП', 'group' => 'sbp'],
        'betatransfer' => ['name' => 'BetaTransfer', 'group' => 'aggregators'],
        'bybit_direct' => ['name' => 'Bybit Direct (USDT)', 'group' => 'crypto'],
    ],
    'groups' => [
        'cards_ru' => 'Карты РФ',
        'sbp' => 'СБП',
        'crypto' => 'Крипто',
        'aggregators' => 'Агрегаторы',
        'intl' => 'Международные',
        'wallets' => 'Кошельки',
        'alt' => 'Альтернативные',
    ],
];
