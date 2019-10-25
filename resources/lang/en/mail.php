<?php

// phpcs:disable

return [
  'reservation' => [
    'paid' => [
      'subject' => 'Your tickets',
      'greeting' => 'Hello :name',
      'body' => 'Thank you for your order! Below are your ticket codes that you need to show at the cinema entrance.',
    ],
    'canceled' => [
      'subject' => 'Your order',
      'greeting' => 'Hello :name',
      'body' => 'Your order has been canceled. If an error has occurred, go back to ordering on the website and see if your seats are still vacant.',
    ],
    'deleted' => [
      'subject' => 'Your reservation',
      'greeting' => 'Hello :name',
      'body' => 'Your reservation has been automatically removed and the seats opened for others to book. If you still want to book your tickets, then head back over on the website.',
    ],
  ]
];
