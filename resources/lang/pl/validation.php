<?php
	return [
		'custom' => [
		    'post_id' => [
		        'required' => 'Wybierz stanowisko',
		    ],
		    'department_id' => [
		        'required' => 'Wybierz dział',
		    ],
		    'email' => [
		        'email' => 'Nieprawidłowy adres email',
		    ],
		    'answers' => [
		        '*' => 'Nieprawidłowa odpowiedź na pytanie.',
		    ],
		    'category_id' => [
		        '*' => 'Nieprawidłowa kategoria pytania.',
		    ],
		    'question_type_id' => [
		        '*' => 'Nieprawidłowy typ pytania.',
		    ],
		    'pl' => [
		        '*' => 'Nieprawidłowa polska treść.',
		    ],
		    'en' => [
		        '*' => 'Nieprawidłowa angielska treść.',
		    ],
		    'name_pl' => [
		        '*' => 'Nieprawidłowa polska nazwa.',
		    ],
		    'name_en' => [
		        '*' => 'Nieprawidłowa angielska nazwa.',
		    ],
		    'description_pl' => [
		        '*' => 'Nieprawidłowa polska treść.',
		    ],
		    'description_en' => [
		        '*' => 'Nieprawidłowa angielska treść.',
		    ],
		    'order' => [
		        'integer' => 'Kolejność musi być liczbą.',
		    ],
		    'name' => [
		        '*' => 'Nieprawidłowa nazwa.',
		    ],
		    'questions' => [
		        '*' => 'Proszę wybrać pytania.',
		    ],
		    'value' => [
		        'value' => 'Wartość musi być liczbą.',
		        'unique' => 'Ta wartość istnieje już w tej skali. Podaj inną wartość.',
		        'required' => 'Wartość jest wymagana.',
		    ],
		    'scale_id' => [
		        'required_if' => 'Skala jest wymagana, jeżeli pytanie ma typ :value',
		    ],
		    'question_id' => [
		        'required' => 'Przypisz do pytania.',
		    ],
		    'password' => [
		        'min' => 'Hasło musi mieć min. 8 znaków.',
		        'confirmed' => 'Oba hasła muszą być identyczne.',
		    ],

		    
	],

	'values' => [
        'question_type_id' => [
			'1' => 'Jednokrotny wybór ze skali.',
        ],
    ],

];