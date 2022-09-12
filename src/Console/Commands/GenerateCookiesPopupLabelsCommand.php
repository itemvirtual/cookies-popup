<?php

namespace Itemvirtual\CookiesPopup\Console\Commands;

use Illuminate\Console\Command;

/**
 * USAGE
 * php artisan cookies-popup:generate-labels
 *
 */
class GenerateCookiesPopupLabelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookies-popup:generate-labels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate popup labels translated in es, ca, en';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keysCreated = [];
        $keysAlreadyExist = [];

        foreach ($this->getLabels() as $key => $label) {
            $alreadySavedKey = \App\Models\Label::where('selector', $key)->first();

            if ($alreadySavedKey) {
                array_push($keysAlreadyExist, $key);
            } else {
                $label['selector'] = $key;
                \App\Models\Label::create($label);
                array_push($keysCreated, $key);
            }
        }

        if (count($keysAlreadyExist)) {
            $this->warn('Labels that already exist :');
            foreach ($keysAlreadyExist as $keyAlreadyExist) {
                $this->line($keyAlreadyExist);
            }
        }

        if (count($keysCreated)) {
            $this->info('Labels created:');
            foreach ($keysCreated as $keyCreated) {
                $this->info($keyCreated);
            }
        }

        return Command::SUCCESS;
    }

    private function getLabels()
    {
        return [
            'cookies-popup-title' => [
                'es' => [
                    'text' => 'Aviso de cookies'
                ],
                'ca' => [
                    'text' => 'Avís de cookies'
                ],
                'en' => [
                    'text' => 'Cookie notice'
                ]
            ],
            'cookies-popup-text' => [
                'es' => [
                    'text' => 'Esta Web utiliza Cookies propias y de terceros para intentar ofrecer al usuario la mejor experiencia de uso posible. La información de Cookies se almacena en el navegador y realiza funciones tales como reconocerlo cuando regrese a la Web y ayudar a comprender qué secciones de la web resultan más interesantes y útiles.'
                ],
                'ca' => [
                    'text' => 'Aquesta web utilitza Cookies propies i de tercers per intentar oferir a l\'usuari la millor experiència d\'ús possible. La informació de Cookies s\'emmagatzema al navegador i realitza funcions tals com reconèixer quan torni a la Web i ajudar a compendre quines seccions de la web resulten més interessants i útils.'
                ],
                'en' => [
                    'text' => 'This website uses its own and third-party cookies to offer the user the best possible user experience. Cookie information is stored in the browser and performs functions such as recognizing you when you return to the Web and helping to understand which sections of the web are most interesting and useful.'
                ]
            ],
            'cookies-popup-configure' => [
                'es' => [
                    'text' => 'Configurar'
                ],
                'ca' => [
                    'text' => 'Configurar'
                ],
                'en' => [
                    'text' => 'Configure'
                ]
            ],
            'cookies-popup-accept' => [
                'es' => [
                    'text' => 'Aceptar todas'
                ],
                'ca' => [
                    'text' => 'Acceptar totes'
                ],
                'en' => [
                    'text' => 'Accept all'
                ]
            ],
            'cookies-popup-decline' => [
                'es' => [
                    'text' => 'Rechazar todas'
                ],
                'ca' => [
                    'text' => 'Rebutjar totes'
                ],
                'en' => [
                    'text' => 'Decline all'
                ]
            ],
            'accept-required-cookies-label' => [
                'es' => [
                    'text' => 'Necesarias'
                ],
                'ca' => [
                    'text' => 'Necessàries'
                ],
                'en' => [
                    'text' => 'Required'
                ]
            ],
            'accept-required-cookies-info' => [
                'es' => [
                    'text' => 'Las cookies necesarias son estrictamente esenciales para garantizar el correcto funcionamiento de la web.'
                ],
                'ca' => [
                    'text' => 'Les cookies necessàries són estrictament essencials per a garantir el correcte funcionament del web.'
                ],
                'en' => [
                    'text' => 'Required cookies are strictly essential to ensure the proper functioning of the website.'
                ]
            ],
            'accept-preferences-cookies-label' => [
                'es' => [
                    'text' => 'Preferencias'
                ],
                'ca' => [
                    'text' => 'Preferències'
                ],
                'en' => [
                    'text' => 'Preferences'
                ]
            ],
            'accept-preferences-cookies-info' => [
                'es' => [
                    'text' => 'Las cookies de preferencia permiten que un sitio web recuerde información que cambia la forma en que se comporta o se ve el sitio web, como su idioma preferido o configuraciones personalizadas.'
                ],
                'ca' => [
                    'text' => 'Les cookies de preferència permeten que un lloc web recordi informació que canvia la forma en què es comporta o es veu el lloc web, com el seu idioma preferit o configuracions personalitzades.'
                ],
                'en' => [
                    'text' => 'Preference cookies allow a website to remember information that changes the way the website behaves or looks, such as your preferred language or custom settings.'
                ]
            ],
            'accept-analytical-cookies-label' => [
                'es' => [
                    'text' => 'Analíticas'
                ],
                'ca' => [
                    'text' => 'Analítiques'
                ],
                'en' => [
                    'text' => 'Analytical'
                ]
            ],
            'accept-analytical-cookies-info' => [
                'es' => [
                    'text' => 'Las cookies analíticas nos permiten saber cómo los usuarios interactúan en la web y mejorar su funcionamiento. Nos permiten recopilar datos estadísticos como número de visitas, tráfico web, etc.'
                ],
                'ca' => [
                    'text' => 'Les cookies analítiques ens permeten saber com els usuaris interactuen al web i millorar-ne el funcionament. Ens permeten recopilar dades estadístiques com nombre de visites, tràfic web, etc.'
                ],
                'en' => [
                    'text' => 'Analytical cookies allow us to know how users interact on the web and improve its operation. They allow us to collect statistical data such as number of visits, web traffic, etc.'
                ]
            ],
            'accept-advertising-cookies-label' => [
                'es' => [
                    'text' => 'Publicitarias'
                ],
                'ca' => [
                    'text' => 'Publicitàries'
                ],
                'en' => [
                    'text' => 'Advertising'
                ]
            ],
            'accept-advertising-cookies-info' => [
                'es' => [
                    'text' => 'Las cookies funcionales nos ayudan a configurar funcionalidades como compartir contenidos en redes sociales, recopilar datos estadísticos de navegación y otras prestaciones de terceros. Esta web usa cookies estadísticas.'
                ],
                'ca' => [
                    'text' => 'Les cookies funcionals ens ajuden a configurar funcionalitats com compartir continguts a xarxes socials, recopilar dades estadístiques de navegació i altres prestacions de tercers. Aquesta web usa cookies estadístiques.'
                ],
                'en' => [
                    'text' => 'Functional cookies help us to configure functionalities such as sharing content on social networks, collecting statistical browsing data and other third-party services. This website uses statistical cookies.'
                ]
            ],
            'accept-recaptcha-cookies-label' => [
                'es' => [
                    'text' => ''
                ],
                'ca' => [
                    'text' => ''
                ],
                'en' => [
                    'text' => ''
                ]
            ],
            'accept-recaptcha-cookies-info' => [
                'es' => [
                    'text' => ''
                ],
                'ca' => [
                    'text' => ''
                ],
                'en' => [
                    'text' => ''
                ]
            ],
            'cookies-popup-close' => [
                'es' => [
                    'text' => 'Guardar configuración'
                ],
                'ca' => [
                    'text' => 'Guardar configuració'
                ],
                'en' => [
                    'text' => 'Save settings'
                ]
            ],
        ];

    }
}
