<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'michal@mediaeffectivegroup.pl',
            'password' => '$2y$10$6kgU2gWgUQpj0WiUVt72/eaqOeUsU7UO6izxnKDsqVLvgJvBqsflS',
        ]);

        $survey = App\Survey::create([
            'finished' => 0,
            'pl'  => ['title' => 'Ogólnopolskie Badanie Kompetencji HR Biznes Partnerów 2019', 'description' => 'Opis pl'],
            'en'  => ['title' => 'HR Business Partners Competences Study', 'description' => 'Opis en'],
            'uuid' => (string) Str::uuid(),
        ]);

        $question_types = [
        	0 => [
        		'name' => 'Radio',
                'display_name' => 'Jednokrotny wybór ze skali',
            	'options' => 0,
        	],
        	1 => [
        		'name' => 'Select',
                'display_name' => 'Jednokrotny wybór z listy rozwijanej (wymaga dodania opcji pytania)',
            	'options' => 1,
        	],
        	2 => [
        		'name' => 'String',
                'display_name' => 'Otwarte: krótka odpowiedź (zdanie)',
            	'options' => 0,
        	],
        	3 => [
        		'name' => 'Text',
                'display_name' => 'Otwarte: długa odpowiedź (kilka zdań)',
            	'options' => 0,
        	],
        ];

        foreach($question_types as $key => $value) {
        	App\QuestionType::create([
                'name' => $value["name"],
	            'display_name' => $value["display_name"],
	            'options' => $value["options"],
	        ]);
        }

        $question_categories = [
        	1 => [
        		'pl' => 'Partner strategiczny',
        		'en' => 'Strategic partner',
        	],
        	2 => [
        		'pl' => 'Odkrywca talentów',
        		'en' => 'Capability builder',
        	],
        	3 => [
        		'pl' => 'Mistrz zmian i kultury organizacyjnej',
        		'en' => 'Master of change and organizational culture',
        	],
        	4 => [
        		'pl' => 'Innowator i integrator HR',
        		'en' => 'Innovator and integrator HR',
        	],
        	5 => [
        		'pl' => 'Orędownik technologii i analizy danych',
        		'en' => 'Technology and data analysis proponent',
        	],
        	6 => [
        		'pl' => 'Zaufany partner',
        		'en' => 'Trusted partner',
        	],
        	7 => [
        		'pl' => 'Jak oceniasz efektywność wykorzystywanych w firmie narzędzi informatycznych, wspierających następujące procesy:',
        		'en' => 'How would you rate the effectivity of IT tools in the following HR processes?',
        	],
            8 => [
                'pl' => 'Dodatkowe pytania:',
                'en' => 'Additional questions:',
            ],
        ];

        foreach($question_categories as $key => $value) {
        	App\Category::create([
	            'pl'  => ['name' => $value['pl']],
	            'en'  => ['name' => $value['en']],
	        ]);
        }

        $scales = [
            0 => [
                'name' => 'Opis zachowań',
            ],
            1 => [
                'name' => 'Efektywność narzędzi IT',
            ],
        ];

        foreach($scales as $key => $value) {
            App\Scale::create([
                'name' => $value['name'],
            ]);
        }

        $scale_values = [
        	0 => [
                'scale_id' => '1',
        		'value' => '0',
        		'pl' => 'Brak kompetencji. Nie prezentuje takich zachowań.',
            	'en' => 'Lack of competency – does not presents this behavior.',
        	],
        	1 => [
                'scale_id' => '1',
        		'value' => '1',
        		'pl' => 'Prezentuje zachowanie często poniżej Twoich oczekiwań.',
            	'en' => 'Presents this behavior often below your expectations.',
        	],
        	2 => [
                'scale_id' => '1',
        		'value' => '2',
        		'pl' => 'Prezentuje zachowanie na podstawowym poziomie, rzadko poniżej Twoich oczekiwań.',
            	'en' => 'Presents this behaviour on basic level, rarely below your expectations.',
        	],
        	3 => [
                'scale_id' => '1',
        		'value' => '3',
        		'pl' => 'Prezentuje zachowanie na dobrym poziomie, zwykle zgodnie z Twoimi oczekiwaniami.',
            	'en' => 'Presents this behaviour on good level, in line with your expectations.',
        	],
        	4 => [
                'scale_id' => '1',
        		'value' => '4',
        		'pl' => 'Prezentuje zachowanie na bardzo dobrym poziomie, często powyżej Twoich oczekiwań.',
            	'en' => 'Presents this behaviour on very good level, often exceeds your expectations.',
        	],
        	5 => [
                'scale_id' => '1',
        		'value' => '5',
        		'pl' => 'Prezentuje zachowanie na doskonałym poziomie, zawsze powyżej Twoich oczekiwań.',
            	'en' => 'Presents this behavior on excellent level, always exceeding your expectations.',
        	],
            6 => [
                'scale_id' => '2',
                'value' => '0',
                'pl' => 'brak narzędzi',
                'en' => 'lack of tools',
            ],
            7 => [
                'scale_id' => '2',
                'value' => '1',
                'pl' => 'niedostatecznie',
                'en' => 'not effective tools',
            ],
            8 => [
                'scale_id' => '2',
                'value' => '2',
                'pl' => 'dobrze',
                'en' => 'relevant tools',
            ],
            9 => [
                'scale_id' => '2',
                'value' => '3',
                'pl' => 'bardzo dobrze',
                'en' => 'well functioning tool',
            ],
            10 => [
                'scale_id' => '2',
                'value' => '4',
                'pl' => 'idealnie',
                'en' => 'very good, effective tools',
            ],
        	
        ];

        foreach($scale_values as $key => $value) {
        	App\ScaleValue::create([
                'scale_id' => $value['scale_id'],
	            'value' => $value['value'],
	            'pl'  => ['name' => $value['pl']],
	            'en'  => ['name' => $value['en']],
	        ]);
        }

        //posts
        $posts = [
        	0 => [
        		'pl' => 'Zarząd',
            	'en' => 'Management Board',
        	],
        	1 => [
        		'pl' => 'Kadra Zarządzająca raportująca do Zarządu',
            	'en' => 'Management staff reporting to the Management Board',
        	],
        	2 => [
        		'pl' => 'Kadra Kierownicza',
            	'en' => 'Managers',
        	],
        	3 => [
        		'pl' => 'Szef HR',
            	'en' => 'Head of HR',
        	],
        	4 => [
        		'pl' => 'HR Biznes Partner',
            	'en' => 'HR Business Partner',
        	],
        	5 => [
        		'pl' => 'Pozostałe stanowiska HR',
            	'en' => 'HR Business Partner',
        	],
        	6 => [
        		'pl' => 'Inne',
            	'en' => 'Other',
        	],
        ];

        foreach($posts as $key => $value) {
        	App\Post::create([
	            'pl'  => ['name' => $value['pl']],
	            'en'  => ['name' => $value['en']],
	        ]);
        }

        //departments
        $departments = [
        	0 => [
        		'pl' => 'Biuro Zarządu',
            	'en' => 'Board Office',
        	],
        	1 => [
        		'pl' => 'Sprzedaż / Handlowy / Komercyjny',
            	'en' => 'Sales / Commercial  / Trade',
        	],
        	2 => [
        		'pl' => 'Marketing / Rozwój Produktu / Social Media',
            	'en' => 'Marketing / Product Development / Social Media',
        	],
        	3 => [
        		'pl' => 'E-commerce / Digital',
            	'en' => 'E-commerce / Digital',
        	],
        	4 => [
        		'pl' => 'Zakupy',
            	'en' => 'Procurement',
        	],
        	5 => [
        		'pl' => 'Finanse / Kontroling / Analizy / BI',
            	'en' => 'Finance / Controlling / Business Analytics / BI',
        	],
        	6 => [
        		'pl' => 'Produkcja',
            	'en' => 'Production',
        	],
        	7 => [
        		'pl' => 'Łańcuch Dostaw',
            	'en' => 'Supply Chain',
        	],
        	8 => [
        		'pl' => 'IT',
            	'en' => 'IT',
        	],
        	9 => [
        		'pl' => 'R&D',
            	'en' => 'R&D',
        	],
        	10 => [
        		'pl' => 'Compliance / Audyt',
            	'en' => 'Compliance / Audit',
        	],
        	11 => [
        		'pl' => 'Prawny',
            	'en' => 'Legal',
        	],
        	12 => [
        		'pl' => 'HR',
            	'en' => 'HR',
        	],
        	13 => [
        		'pl' => 'Serwis - Utrzymanie Ruchu - Techniczny',
            	'en' => 'Service - Maintenance - Technical',
        	],
        	14 => [
        		'pl' => 'Wydawniczy',
            	'en' => 'Publishing',
        	],
        	15 => [
        		'pl' => 'Obsługa Klienta / Call Center',
            	'en' => 'Customer service / Call Center',
        	],
        	16 => [
        		'pl' => 'Inny',
            	'en' => 'Other',
        	],
        ];

        foreach($departments as $key => $value) {
        	App\Department::create([
	            'pl'  => ['name' => $value['pl']],
	            'en'  => ['name' => $value['en']],
	        ]);
        }


        $questions = [
            1 => [
                'category_id' => 1,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Posługuje się językiem biznesu (wskaźniki, liczby, mało żargonu).',
                'en' => 'Uses business language (facts and figures, no HR jargon, etc.).',
            ],
            2 => [
                'category_id' => 1,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Przedstawia biznesowe uzasadnienie dla proponowanych rozwiązań HR.',
                'en' => 'Presents business rationales to proof benefits of HR solutions and programs.',
            ],
            3 => [
                'category_id' => 1,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Wykorzystuje wiedzę o zewnętrznych warunkach biznesu w rekomendowanych Ci rozwiązaniach.',
                'en' => 'Uses knowledge of the external factors which influence the business in recommended solutions.',
            ],
            4 => [
                'category_id' => 1,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Rekomenduje działania minimalizujące ryzyka i bariery.',
                'en' => 'Recommends actions which minimalizes risks and barriers.',
            ],
            5 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Adekwatnie posługuje się szerokim wachlarzem narzędzi rozwojowych.',
                'en' => 'Adequately uses a wide range of development tools.',
            ],
            6 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Wykorzystuje nowoczesne techniki uczenia się (np. gry) do podnoszenia kompetencji Twoich pracowników. ',
                'en' => 'Uses modern learning techniques (i.e. games) for building competency level in your team.',
            ],
            7 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Identyfikuje pożądane kompetencje dla realizacji Twoich celów biznesowych.',
                'en' => 'Identifies the most desired competences needed to achieve your business goals.',
            ],
            8 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Pozyskuje wartościowych i pożądanych pracowników.',
                'en' => 'Has the ability to attract people with desired competencies and qualifications.',
            ],
            9 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Aktywnie i skutecznie wspiera budowanie zaangażowania Twojego zespołu.',
                'en' => 'Actively and effectively supports level of engagement of your team.',
            ],
            10 => [
                'category_id' => 2,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Jest zaangażowany w zarządzanie wynikami Twojego zespołu.',
                'en' => 'Is involved in performance management of your team.',
            ],
            11 => [
                'category_id' => 3,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'W przypadku zmian w organizacji jest zaangażowany w proces jej planowania i wdrażania.',
                'en' => 'In case of organizational change, s/he involved in its planning and implementation process.',
            ],
            12 => [
                'category_id' => 3,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Działa w kierunku wzmocnienia pożądanej kultury organizacji w oparciu o strategię firmy.',
                'en' => 'Acts toward strengthening the desired organisational culture, based on the business strategy.',
            ],
            13 => [
                'category_id' => 3,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'W przypadku zmian w organizacji prawidłowo identyfikuje i wykorzystuje korzyści i efekty.',
                'en' => 'In case of organizational change, s/he identifies and utilise correctly its benefits and results.',
            ],
            14 => [
                'category_id' => 3,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'W przypadku zmian w organizacji mierzy jej efekty w obszarze HR.',
                'en' => 'In case of organizational change, s/he measures its effectiveness in HR area.',
            ],
            15 => [
                'category_id' => 3,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Jest dla Ciebie wsparciem w przeprowadzeniu zespołu przez zmianę.',
                'en' => 'Contributes to your change management activities towards your team.',
            ],
            16 => [
                'category_id' => 4,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Buduje sprawne kanały i narzędzia informacyjne również angażując odpowiednie osoby.',
                'en' => 'Creates effective information channels and tools, involving relevant stakeholders.',
            ],
            17 => [
                'category_id' => 4,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Dba o konsekwentną realizację strategii i polityki HR, traktując wszystkich klientów wewnętrznych tak samo.',
                'en' => 'Takes care of a consequent and consistent implementation of HR strategy and policies, treating internal clients equally.',
            ],
            18 => [
                'category_id' => 4,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Rozwiązując bieżące problemy weryfikuje adekwatność procesów i systemów.',
                'en' => 'While working on HR solutions, verifies the need of adjustment relevant HR processes and systems.',
            ],
            19 => [
                'category_id' => 4,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Zarządza oczekiwaniami pracowników, z uwzględnieniem możliwości i dobra organizacji.',
                'en' => 'Manages employees’ expectations, taking into account possibilities and needs of the organization.',
            ],
            20 => [
                'category_id' => 4,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Śledzi innowacje i trendy w HR oraz proponuje Ci ich wykorzystanie, adekwatnie do potrzeb.',
                'en' => 'Watches the latest innovations and trends in HR and suggests its implementation, adequately to your needs.',
            ],

            21 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Wykorzystuje i wdraża nowoczesne narzędzia technologiczne w procesach i rozwiązaniach HR.',
                'en' => 'Uses and implements modern technology tools in HR processes and solutions.',
            ],
            22 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Korzysta z dostępnych danych i na ich podstawie prezentuje Ci właściwe i potrzebne wnioski.',
                'en' => 'Is using all available data and draws adequate and useful conclusions on their basis.',
            ],
            23 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Poszukuje właściwych wskaźników do mierzenia skuteczności działań i identyfikacji przyczyn problemów.',
                'en' => 'Is looking for relevant indicators to measure effectivity of HR solutions and to find root cause of the problems.',
            ],
            24 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Na podstawie analizy danych prognozuje i rekomenduje działania profilaktyczne.',
                'en' => 'Based on data analysis, forecasts and recommends preventive actions.',
            ],
            25 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Używa mediów społecznościowych w celach biznesowych i wzmacniania współpracy.',
                'en' => 'Uses social media for business purposes and to strengthen cooperation in the team.',
            ],

            26 => [
                'category_id' => 5,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Używa nowoczesnych aplikacji i narzędzi technologicznych do komunikowania się.',
                'en' => 'Uses modern applications and technology communication tools.',
            ],
            27 => [
                'category_id' => 6,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'W obliczu przeszkód jest aktywna/y i zaangażowana/y, nie poddaje się, dobrze kontroluje swoje emocje.',
                'en' => 'In case of obstacles and difficult situations, is active and engaged, does not give up; well controls his/her emotions.',
            ],
            28 => [
                'category_id' => 6,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Swoją postawą i osobistym przykładem wpływa pozytywnie na Ciebie i innych współpracowników.',
                'en' => 'His/her attitude has positive influence on you and the other employees.',
            ],
            29 => [
                'category_id' => 6,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Buduje relację opartą na zaufaniu. Jest transparentny i etyczny.',
                'en' => 'Builds relations based on a mutual trust. Has high integrity and ethics.',
            ],
            30 => [
                'category_id' => 6,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Bada i rozumie Twoje potrzeby biznesowe i w oparciu o nie rekomenduje rozwiązania.',
                'en' => 'Identifies and understands your business needs and based on them recommends solutions.',
            ],
            31 => [
                'category_id' => 6,
                'question_type_id' => 1,
                'scale_id' => 1,
                'pl' => 'Umie przekazać trudne informacje/ decyzje, uzasadnia i argumentuje w oparciu o fakty i dane.',
                'en' => 'Shows ability to deliver difficult information or decisions. Justifies them based on the facts and figures.',
            ],
            32 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Administracja HR (płace, urlopy, formalności)',
                'en' => 'HR administration (payroll, holidays, employment documentation)',
            ],
            33 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Rekrutacja',
                'en' => 'Recruitment',
            ],
            34 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Onboarding pracowników',
                'en' => 'Onboarding',
            ],
            35 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Rozwój i szkolenia',
                'en' => 'Development and trainings',
            ],
            36 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Performance management / ustalanie i monitoring celów',
                'en' => 'Performance management / goals setting and monitoring',
            ],
            37 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Zaangażowanie pracowników',
                'en' => 'Employee engagement',
            ],
            38 => [
                'category_id' => 7,
                'question_type_id' => 1,
                'scale_id' => 2,
                'pl' => 'Komunikacja wewnętrzna',
                'en' => 'Internal communication',
            ],
            39 => [
                'category_id' => 8,
                'question_type_id' => 4,
                'scale_id' => null,
                'required' => 0,
                'pl' => 'Jakie procesy HR w Waszej firmie powinny być udoskonalone z wykorzystaniem nowych technologii?',
                'en' => 'Which HR processes in your company shall be optimize by IT tools?',
            ],
            40 => [
                'category_id' => 8,
                'question_type_id' => 4,
                'scale_id' => null,
                'required' => 0,
                'pl' => 'Dodatkowe uwagi / komentarze',
                'en' => 'Additional comments',
            ],
        ];


        foreach($questions as $key => $value) {

            if(!isset($value['required'])) {
                App\Question::create([
                    'category_id' => $value['category_id'],
                    'question_type_id' => $value['question_type_id'],
                    'scale_id' => $value['scale_id'],
                    'pl'  => ['name' => $value['pl']],
                    'en'  => ['name' => $value['en']],
                ]);
            } else {
                App\Question::create([
                    'category_id' => $value['category_id'],
                    'question_type_id' => $value['question_type_id'],
                    'scale_id' => $value['scale_id'],
                    'required' => $value['required'],
                    'pl'  => ['name' => $value['pl']],
                    'en'  => ['name' => $value['en']],
                ]);
            }
            
        }

        //$questions = factory(App\Question::class, 10)->create();

        $survey->questions()->saveMany(App\Question::All());

        //$entries = factory(App\Entry::class, 30)->create();

       // $status = factory(App\Status::class)->create([
       //   'name' => 'Przyjęte',
       //   'color' => '#ff4444',
       //  ]);

    }
}
