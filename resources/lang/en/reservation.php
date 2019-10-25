<?php

// phpcs:disable

return [
    'status' => [
        'paid' => 'Paid',
        'canceled' => 'Canceled',
        'pending' => 'Pending',
        'denied' => 'Denied',
        'error' => [
            'missing' => 'Reservation has expired',
            'ticket_seat_count' => 'Ticket and seat count musst be equal',
        ],
    ],
    'text' => [
        'paid' => 'Thank you for your order! We\'ll send you an email with your ticket codes, that you will need to produce at the entrance. We hope <strong>:film</strong> lives up to your expectations.',
        'canceled' => 'Your order was canceled. If this was a mistake, then we would advise you to click :link to re-order your tickets.',
        'pending' => 'Bestillingen er ikke gået igennem endnu.',
        'denied' => 'Der skete en fejl. Dit kreditkort er blevet afvist, men du kan prøve igen ved at klikke :link',
    ],
    'update' => [
        'email' => 'Email',
        'submit' => 'Update',
        'title' => [
            'default' => 'Login or give us your email, so we can send you your tickets',
            'with-email' => 'Use email',
            'with-login' => 'Use login',
        ],
    ],
];
