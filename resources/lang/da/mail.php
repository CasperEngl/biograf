<?php

// phpcs:disable

return [
  'reservation' => [
    'paid' => [
      'subject' => 'Dine billetter',
      'greeting' => 'Hej :name',
      'body' => [
        '## Tak for din bestilling!',
        'Herunder er dine billetkoder, som du skal fremvise ved indgangen til biografen.',
      ]
    ],
    'canceled' => [
      'subject' => 'Din bestilling',
      'greeting' => 'Hej :name',
      'body' => 'Din bestilling er blevet annulleret. Hvis der er sket en fejl, så gå tilbage til bestillingen på hjemmesiden, og se om ikke dine pladser stadig er ledige.',
    ],
    'deleted' => [
      'subject' => 'Din reservation',
      'greeting' => 'Hej :name',
      'body' => 'Din reservation er blevet automatisk slettet og pladserne åbnet op for at andre kan bestille dem. Hvis du alligevel gerne vil bestille billetterne, så skal du blot gå tilbage til bestillingen på hjemmesiden.',
    ],
  ]
];
