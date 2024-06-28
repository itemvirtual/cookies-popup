<?php

namespace Itemvirtual\CookiesPopup\Console\Commands;

use App\Models\Label;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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
    protected $signature = 'cookies-popup:generate-labels
                            {--D|database : Create labels in DB}
                            {--L|laravel-version= : Laravel version}';

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
        $saveInDatabase = $this->option('database');
        $laravelVersion = $this->option('laravel-version');

        if ($saveInDatabase) {
            $this->saveToDatabase($laravelVersion);
        } else {
            $this->saveToLangFiles();
        }
        return Command::SUCCESS;
    }

    private function saveToDatabase($laravelVersion)
    {
        $keysCreated = [];
        $keysAlreadyExist = [];


        if ($laravelVersion && $laravelVersion < 11) {
            $labels = $this->getLabels();
        } else {
            $labels = $this->getNewLabels();
        }

        foreach ($labels as $key => $label) {
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

    private function saveToLangFiles()
    {
        $arLang = [];
        foreach ($this->getLabels() as $selector => $translations) {
            foreach ($translations as $locale => $translation) {
                $arLang[$locale][$selector] = $translation['text'];
            }
        }

        foreach ($arLang as $locale => $label) {
            (new Filesystem())->ensureDirectoryExists(base_path('lang/' . $locale));
            $file = base_path('lang/' . $locale . '/cookies-popup.php');
            $translationFile = fopen($file, 'w') or die('Unable to open file!');

            fwrite($translationFile, '<?php ' . PHP_EOL . PHP_EOL . 'return [' . PHP_EOL);

            foreach ($label as $selector => $value) {
                $value = str_replace('"', '\'', $value);
                $value = addslashes($value);
                $value = str_replace('&nbsp;', ' ', $value);
                fwrite($translationFile, "\t" . '\'' . $selector . '\' => \'' . $value . '\',' . PHP_EOL);
            }
            fwrite($translationFile, '];');
            fclose($translationFile);

            if (app()->runningInConsole()) {
                chmod($file, 0766);
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
                ],
                'fr' => [
                    'text' => 'Avis sur les cookies'
                ],
                'it' => [
                    'text' => 'Avviso sui cookie'
                ],
                'eu' => [
                    'text' => 'Cookie oharra'
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
                ],
                'fr' => [
                    'text' => 'Ce site web utilise des cookies internes et des cookies tiers pour essayer d\'offrir à l\'utilisateur la meilleure expérience possible. Les informations des cookies sont stockées dans le navigateur et remplissent des fonctions telles que vous reconnaître lorsque vous revenez sur le site et nous aider à comprendre quelles parties du site sont les plus intéressantes et les plus utiles'
                ],
                'it' => [
                    'text' => 'Questo sito utilizza cookie propri e di terze parti per offrire all\'utente la migliore esperienza utente possibile. Le informazioni sui cookie sono memorizzate nel browser e svolgono funzioni come riconoscerti quando ritorni sul Web e aiutare a capire quali sezioni del Web sono più interessanti e utili.'
                ],
                'eu' => [
                    'text' => 'Webgune honek cookie propioak eta hirugarrenenak erabiltzen ditu erabiltzaileari ahalik eta erabilera-esperientziarik onena eskaintzen saiatzeko. Cookie-en informazioa nabigatzailean gordetzen da, eta hainbat funtzio betetzen ditu, hala nola webgunera itzultzen denean hura ezagutzea eta webguneko zein atal diren interesgarrienak eta erabilgarrienak ulertzen laguntzea.'
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
                ],
                'fr' => [
                    'text' => 'Configuration'
                ],
                'it' => [
                    'text' => 'Configura'
                ],
                'eu' => [
                    'text' => 'Konfiguratu'
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
                ],
                'fr' => [
                    'text' => 'Accepter tout'
                ],
                'it' => [
                    'text' => 'Accettare tutti'
                ],
                'eu' => [
                    'text' => 'Onartu guztiak'
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
                ],
                'fr' => [
                    'text' => 'Refuser tout'
                ],
                'it' => [
                    'text' => 'Rifiuta tutto'
                ],
                'eu' => [
                    'text' => 'Guztiak baztertu'
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
                ],
                'fr' => [
                    'text' => 'Requis'
                ],
                'it' => [
                    'text' => 'Necessaria'
                ],
                'eu' => [
                    'text' => 'Beharrezko'
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
                ],
                'fr' => [
                    'text' => 'Les cookies nécessaires sont strictement essentiels pour garantir le bon fonctionnement du site web.'
                ],
                'it' => [
                    'text' => 'I cookie obbligatori sono strettamente necessari per garantire il corretto funzionamento del sito web.'
                ],
                'eu' => [
                    'text' => 'Beharrezkoak diren cookieak ezinbestekoak dira webguneak behar bezala funtzionatzen duela bermatzeko.'
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
                ],
                'fr' => [
                    'text' => 'Préférences'
                ],
                'it' => [
                    'text' => 'Preferenze'
                ],
                'eu' => [
                    'text' => 'Lehentasunak'
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
                ],
                'fr' => [
                    'text' => 'Les cookies de préférence permettent à un site Web de mémoriser des informations qui modifient le comportement ou l\'apparence du site Web, telles que votre langue préférée ou vos paramètres personnalisés.'
                ],
                'it' => [
                    'text' => 'I cookie delle preferenze consentono a un sito Web di ricordare le informazioni che cambiano il modo in cui il sito Web si comporta o appare, come la lingua preferita o le impostazioni personalizzate.'
                ],
                'eu' => [
                    'text' => 'Hobespeneko cookie-ek webguneak webgunearen portaera edo itxura aldatzen duen informazioa gogoratzea ahalbidetzen dute, hala nola zure hizkuntza hobetsia edo ezarpen pertsonalizatuak.'
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
                ],
                'fr' => [
                    'text' => 'Analytiques'
                ],
                'it' => [
                    'text' => 'Analitica'
                ],
                'eu' => [
                    'text' => 'Analitikak'
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
                ],
                'fr' => [
                    'text' => 'Les cookies analytiques nous permettent de savoir de quelle manière les utilisateurs interagissent sur le site et d\'améliorer son fonctionnement. Ils nous permettent de recueillir des données statistiques telles que le nombre de visites, le trafic web, etc.'
                ],
                'it' => [
                    'text' => 'I cookie analitici ci permettono di sapere come gli utenti interagiscono sul web e ne migliorano il funzionamento. Ci consentono di raccogliere dati statistici come numero di visite, traffico web, ecc.'
                ],
                'eu' => [
                    'text' => 'Cookie analitikoek aukera ematen digute erabiltzaileek webgunean nola elkarreragiten duten jakiteko eta haien funtzionamendua hobetzeko. Datu estatistikoak biltzeko aukera ematen digute, hala nola bisita kopurua, web trafikoa, etab.'
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
                ],
                'fr' => [
                    'text' => 'Publicité'
                ],
                'it' => [
                    'text' => 'Pubblicità'
                ],
                'eu' => [
                    'text' => 'Publizitatea'
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
                ],
                'fr' => [
                    'text' => 'Les cookies fonctionnels nous aident à configurer des fonctionnalités telles que le partage de contenu sur les réseaux sociaux, la collecte de données statistiques de navigation et d\'autres services tiers. Ce site utilise des cookies statistiques.'
                ],
                'it' => [
                    'text' => 'I cookie funzionali ci aiutano a configurare funzionalità come la condivisione di contenuti sui social network, la raccolta di dati statistici di navigazione e altri servizi di terze parti. Questo sito utilizza cookie statistici.'
                ],
                'eu' => [
                    'text' => 'Cookie funtzionalek funtzionalitateak konfiguratzen laguntzen digute, hala nola sare sozialetan edukia partekatzea, nabigazioko datu estatistikoak biltzea eta hirugarrenen beste zerbitzu batzuk. Webgune honek cookie estatistikoak erabiltzen ditu.'
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
                ],
                'fr' => [
                    'text' => ''
                ],
                'it' => [
                    'text' => ''
                ],
                'eu' => [
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
                ],
                'fr' => [
                    'text' => ''
                ],
                'it' => [
                    'text' => ''
                ],
                'eu' => [
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
                ],
                'fr' => [
                    'text' => 'Enregistrer les paramètres'
                ],
                'it' => [
                    'text' => 'Salva le impostazioni'
                ],
                'eu' => [
                    'text' => 'Gorde ezarpenak'
                ]
            ],
            'cookies-configure-link' => [
                'es' => [
                    'text' => 'Configurar cookies'
                ],
                'ca' => [
                    'text' => 'Configurar cookies'
                ],
                'en' => [
                    'text' => 'Manage cookies'
                ],
                'fr' => [
                    'text' => 'Paramétrer les cookies'
                ],
                'it' => [
                    'text' => 'Gestisci i cookie'
                ],
                'eu' => [
                    'text' => 'Kudeatu cookie-ak'
                ]
            ],
        ];

    }

    private function getNewLabels()
    {
        $transformedArray = [];

        foreach ($this->getLabels() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $lang => $text) {
                    $transformedArray[$key]['text'][$lang] = $text['text'];
                }
            }
        }

        return $transformedArray;
    }
}
