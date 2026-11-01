<?php

namespace Database\Seeders;

use App\Models\User;
use Celios\Core\Enums\PageType;
use Celios\Core\Models\Form;
use Celios\Core\Models\Menu;
use Celios\Core\Models\MenuItem;
use Celios\Core\Models\Page;
use Celios\Core\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DamianaSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. ADMIN USER
        // ==========================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@damianainkart.host'],
            [
                'name' => 'Damiana InkArt',
                'username' => 'damiana',
                'password' => Hash::make('password'),
            ]
        );

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        if (! $admin->hasRole('super_admin')) {
            $admin->assignRole($superAdminRole);
        }

        // ==========================================
        // 2. BOOKING FORM
        // ==========================================
        $bookingForm = Form::updateOrCreate(
            ['slug' => 'tattoo-booking'],
            [
                'title' => [
                    'en' => 'Book an appointment',
                    'sr' => 'Zakažite termin',
                ],
                'description' => [
                    'en' => 'Share your tattoo concept, placement, and preferred timeline below.',
                    'sr' => 'Podelite vašu ideju, poziciju tetovaže i željeni datum ispod.',
                ],
                'submit_button_text' => [
                    'en' => 'Send Inquiry &raquo;',
                    'sr' => 'Pošalji Upit &raquo;',
                ],
                'success_message' => [
                    'en' => 'Thank you! Your tattoo inquiry has been received. Damiana will contact you shortly.',
                    'sr' => 'Hvala vam! Vaš upit za tetovažu je uspešno poslat. Damiana će vas uskoro kontaktirati.',
                ],
                'recipient_emails' => ['ines.damjanovic7@gmail.com'],
                'send_confirmation_email' => true,
                'confirmation_email_subject' => [
                    'en' => 'We received your tattoo inquiry • DamianaInkArt',
                    'sr' => 'Vaš upit za tetovažu je primljen • DamianaInkArt',
                ],
                'confirmation_email_body' => [
                    'en' => '<p>Thank you for reaching out! We received your concept and will get back to you with availability and details.</p>',
                    'sr' => '<p>Hvala vam na javljanju! Primili smo vašu ideju i javićemo vam se sa terminima i detaljima.</p>',
                ],
                'is_active' => true,
                'fields' => [
                    [
                        'key' => 'name',
                        'type' => 'text',
                        'label' => ['en' => 'Your Name', 'sr' => 'Vaše Ime'],
                        'placeholder' => ['en' => 'Name*', 'sr' => 'Ime*'],
                        'required' => true,
                        'width' => '6',
                    ],
                    [
                        'key' => 'email',
                        'type' => 'email',
                        'label' => ['en' => 'E-mail Address', 'sr' => 'Email Adresa'],
                        'placeholder' => ['en' => 'E-mail*', 'sr' => 'Email*'],
                        'required' => true,
                        'width' => '6',
                    ],
                    [
                        'key' => 'phone',
                        'type' => 'tel',
                        'label' => ['en' => 'Phone / WhatsApp', 'sr' => 'Broj Telefona / WhatsApp'],
                        'placeholder' => ['en' => 'Phone*', 'sr' => 'Telefon*'],
                        'required' => true,
                        'width' => '6',
                    ],
                    [
                        'key' => 'budget',
                        'type' => 'select',
                        'label' => ['en' => 'Estimated Budget', 'sr' => 'Okvirni Budžet'],
                        'placeholder' => ['en' => 'Budget (optional)', 'sr' => 'Budžet (opciono)'],
                        'options' => "Under 150€\n150€ - 300€\n300€ - 500€\n500€+",
                        'required' => false,
                        'width' => '6',
                    ],
                    [
                        'key' => 'tattoo_idea',
                        'type' => 'textarea',
                        'label' => ['en' => 'Tattoo Concept & Placement', 'sr' => 'Opis Ideje i Mesto na Telu'],
                        'placeholder' => ['en' => 'Describe your idea, placement, and size in detail...*', 'sr' => 'Opišite detaljno svoju ideju, mesto na telu i okvirnu veličinu...*'],
                        'required' => true,
                        'width' => '12',
                    ],
                    [
                        'key' => 'preferred_date',
                        'type' => 'date',
                        'label' => ['en' => 'Preferred Date', 'sr' => 'Željeni Datum'],
                        'placeholder' => ['en' => 'Preferred date*', 'sr' => 'Željeni datum*'],
                        'required' => true,
                        'width' => '6',
                    ],
                    [
                        'key' => 'reference_images',
                        'type' => 'file',
                        'label' => ['en' => 'Reference Images / Sketches', 'sr' => 'Slike Reference / Skice'],
                        'allowed_types' => 'jpg, jpeg, png, webp',
                        'required' => false,
                        'width' => '6',
                    ],
                ],
            ]
        );

        // Sample Portfolio Media in Curator
        $sampleItems = [
            [
                'name' => 'botanical-spine',
                'path' => 'https://images.unsplash.com/photo-1598371839696-5c5bb00bdc28?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Botanical Spine Ornament',
                'alt' => 'Dark organic spine tattoo by Damiana',
                'description' => 'Custom anatomical spine composition with dark organic textures.',
                'caption' => 'tattoo',
            ],
            [
                'name' => 'geometrical-flow-arm',
                'path' => 'https://images.unsplash.com/photo-1611501275019-9b5cda994e8d?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Geometrical Flow Arm',
                'alt' => 'Fine line dark ornamental forearm tattoo',
                'description' => 'Symmetrical ornament flowing along forearm muscles.',
                'caption' => 'tattoo',
            ],
            [
                'name' => 'occult-hand-sigil',
                'path' => 'https://images.unsplash.com/photo-1562962230-16e4623d36e6?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Occult Hand Sigil',
                'alt' => 'Dark blackwork hand tattoo piece',
                'description' => 'Fine needle blackwork with high-contrast shading.',
                'caption' => 'tattoo',
            ],
            [
                'name' => 'organic-rib-flora',
                'path' => 'https://images.unsplash.com/photo-1542385151-efd9000785a0?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Organic Rib Flora',
                'alt' => 'Organic branch design on ribs',
                'description' => 'Dark botanical contours designed specifically for client ribcage.',
                'caption' => 'tattoo',
            ],
            [
                'name' => 'dark-crow-wingspan',
                'path' => 'https://images.unsplash.com/photo-1560707303-4e980ce876ad?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Dark Crow Wingspan',
                'alt' => 'Back tattoo wingspan by Damiana',
                'description' => 'Feather textures blended with geometric linework.',
                'caption' => 'tattoo',
            ],
            [
                'name' => 'abstract-shoulder-flow',
                'path' => 'https://images.unsplash.com/photo-1568515045052-f9a854d70bfd?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Abstract Shoulder Flow',
                'alt' => 'Custom shoulder tattoo by DamianaInkArt',
                'description' => 'Fluid black linework accentuating shoulder and clavicle anatomy.',
                'caption' => 'tattoo',
            ],
            // Sketches
            [
                'name' => 'dark-botanical-sketch-1',
                'path' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Dark Botanical Sketch #1',
                'alt' => 'Available sketch #1',
                'description' => 'Original flash concept available for tattooing.',
                'caption' => 'sketch',
            ],
            [
                'name' => 'ornamental-sigil-sketch-2',
                'path' => 'https://images.unsplash.com/photo-1550537687-c91072c4792d?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Ornamental Sigil Sketch #2',
                'alt' => 'Available sketch #2',
                'description' => 'Original flash concept available for tattooing.',
                'caption' => 'sketch',
            ],
            [
                'name' => 'geometric-anatomy-sketch-3',
                'path' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80',
                'title' => 'Geometric Anatomy Sketch #3',
                'alt' => 'Available sketch #3',
                'description' => 'Original flash concept available for tattooing.',
                'caption' => 'sketch',
            ],
        ];

        $mediaIds = [];
        foreach ($sampleItems as $item) {
            $m = \App\Models\Media::firstOrCreate(
                ['name' => $item['name']],
                [
                    'disk' => 'public',
                    'visibility' => 'public',
                    'path' => $item['path'],
                    'width' => 1200,
                    'height' => 1200,
                    'size' => 200000,
                    'type' => 'image/jpeg',
                    'ext' => 'jpg',
                    'alt' => $item['alt'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'caption' => $item['caption'],
                ]
            );
            $mediaIds[] = $m->id;
        }

        // ==========================================
        // 3. HOME PAGE
        // ==========================================
        $home = Page::updateOrCreate(
            ['type' => PageType::HOME->value],
            [
                'title' => [
                    'en' => 'DamianaInkArt Studio | Professional Tattoo & Visual Art',
                    'sr' => 'DamianaInkArt Studio | Autorske Tetovaže i Vizuelna Umetnost',
                ],
                'slug' => [
                    'en' => 'home',
                    'sr' => 'home',
                    'it' => 'home',
                ],
                'is_visible' => true,
                'content' => [
                    [
                        'type' => 'hero_section',
                        'data' => [
                            'heading' => [
                                'en' => 'DamianaInkArt Studio',
                                'sr' => 'DamianaInkArt Studio',
                            ],
                            'subtitle' => [
                                'en' => 'pleasure spiked with pain since 2020',
                                'sr' => 'pleasure spiked with pain since 2020',
                            ],
                            'button_text' => [
                                'en' => 'Book Now &raquo;',
                                'sr' => 'Zakaži Termin &raquo;',
                            ],
                            'button_url' => '#booking',
                            'badge_text' => [
                                'en' => 'Novi Sad, Serbia',
                                'sr' => 'Novi Sad, Srbija',
                            ],
                        ],
                    ],
                    [
                        'type' => 'author_bio',
                        'data' => [
                            'name' => [
                                'en' => 'About me',
                                'sr' => 'O meni',
                            ],
                            'title' => [
                                'en' => 'Damiana — Painter & Tattoo Artist',
                                'sr' => 'Damiana — Slikarka i Tattoo Umetnica',
                            ],
                            'bio' => [
                                'en' => "Hey stranger, I'm Damiana - a painter, a tattoo artist and the hands behind CRUCIO studio!\nI've been drawing literally my whole life, I went to college at the Academy of arts where I studied painting and shortly after that I realised that tattoos are my medium. My mission is to create something that was always meant to grow on your skin.",
                                'sr' => "Hej, ja sam Damiana - slikarka, tattoo umetnica i energija iza CRUCIO studija!\nCrtam bukvalno ceo život. Završila sam Akademiju umetnosti na smeru slikarstvo i ubrzo shvatila da su tetovaže moj pravi medijum. Moja misija je da stvorim nešto što je oduvek trebalo da raste na tvojoj koži.",
                            ],
                            'extended_bio' => [
                                'en' => "Art has always been my language.\nBefore tattooing, I painted - exploring dark textures, the emotional weight of organic forms, and energy of symmetry and patterns that create and unify all things, so tattooing became the natural extension of that world.\n\nMy style is rooted in - dark organic forms and flowing compositions that move with the body, textures inspired by nature, dark ornaments that emphasize symmetry, geometry and flowing patterns that complement the anatomy of the body.\nI'm drawn to pieces that are not just illustrations placed on the skin, but designs that grow with your anatomy.",
                                'sr' => "Umetnost je oduvek bila moj jezik.\nPre tetoviranja sam slikala - istražujući tamne teksture, emotivnu snagu organskih formi i energiju simetrije i obrazaca koji spajaju sve oko nas. Tetoviranje je postalo prirodan nastavak tog sveta.\n\nMoj stil je ukorenjen u tamnim organskim formama, kompozicijama koje teku sa telom, teksturama inspirisanim prirodom i ornamentima koji naglašavaju geometriju i anatomiju.\nPrivlače me radovi koji nisu samo crtež na koži, već dizajn koji živi i raste sa tvojim telom.",
                            ],
                            'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                        ],
                    ],
                    [
                        'type' => 'gallery_block',
                        'data' => [
                            'title' => [
                                'en' => 'Gallery Preview',
                                'sr' => 'Odabrani Radovi',
                            ],
                            'columns' => '3',
                            'enable_lightbox' => true,
                            'images' => $mediaIds,
                        ],
                    ],
                    [
                        'type' => 'form_block',
                        'data' => [
                            'form_id' => $bookingForm->id,
                            'show_title' => true,
                            'show_description' => true,
                        ],
                    ],
                ],
            ]
        );

        // ==========================================
        // 4. GALLERY PAGE
        // ==========================================
        Page::updateOrCreate(
            ['slug->en' => 'gallery'],
            [
                'type' => PageType::STANDARD->value,
                'title' => [
                    'en' => 'Tattoo & Sketch Portfolio | DamianaInkArt',
                    'sr' => 'Portfolio Tetovaža i Skica | DamianaInkArt',
                ],
                'slug' => [
                    'en' => 'gallery',
                    'sr' => 'galerija',
                    'it' => 'galleria',
                ],
                'is_visible' => true,
                'content' => [
                    [
                        'type' => 'gallery_block',
                        'data' => [
                            'title' => [
                                'en' => 'Tattoo & Sketch Portfolio',
                                'sr' => 'Portfolio Tetovaža i Skica',
                            ],
                            'columns' => '3',
                            'enable_lightbox' => true,
                            'images' => $mediaIds,
                        ],
                    ],
                ],
            ]
        );

        // ==========================================
        // 5. FAQ PAGE
        // ==========================================
        $faqItems = [
            [
                'question' => [
                    'en' => 'How do I book an appointment?',
                    'sr' => 'Kako da zakažem termin?',
                ],
                'answer' => [
                    'en' => 'You can contact me via Instagram, email, or the booking form on this site. Please share your idea, preferred placement, approximate dimensions, and budget.',
                    'sr' => 'Možete me kontaktirati putem Instagrama, emaila ili forme za zakazivanje na sajtu. Opišite svoju ideju, željeno mesto na telu, okvirnu veličinu i budžet.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Do you do custom designs?',
                    'sr' => 'Da li radite unikatne (custom) dizajne?',
                ],
                'answer' => [
                    'en' => 'All of my work is custom designed! I don’t copy reference photos, but rather create unique compositions tailored to the natural curves of your body.',
                    'sr' => 'Sav moj rad je autorski! Ne kopiram reference sa interneta, već kreiram jedinstvene kompozicije prilagođene prirodnim linijama vašeg tela.',
                ],
            ],
            [
                'question' => [
                    'en' => 'What are consultations for?',
                    'sr' => 'Čemu služe konsultacije?',
                ],
                'answer' => [
                    'en' => 'If you have trouble coming to a final idea, you can always reach out and we’ll shape it together. If online consultations aren’t enough, we can book a live consultation. Consultations are completely free and non-binding.',
                    'sr' => 'Ukoliko imate dilemu oko konačne ideje, uvek se možemo čuti i uobličiti je zajedno. Ako onlajn razgovor nije dovoljan, zakazujemo uživo konsultacije u studiju. Konsultacije su besplatne i neobavezujuće.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Do you require a deposit?',
                    'sr' => 'Da li je depozit obavezan?',
                ],
                'answer' => [
                    'en' => 'Deposits are mandatory to secure your appointment. They are non-refundable in case of cancellation, but can be transferred to a rescheduled date if notice is given in advance.',
                    'sr' => 'Depozit je obavezan kako biste rezervisali svoj termin. Depozit je nepovratan u slučaju otkazivanja, ali ga možete preneti na novi termin ukoliko blagovremeno najavite pomeranje.',
                ],
            ],
            [
                'question' => [
                    'en' => 'How much does a tattoo cost?',
                    'sr' => 'Koliko košta tetovaža?',
                ],
                'answer' => [
                    'en' => 'Pricing heavily depends on the scale of the design, body placement, and level of detail. Share your idea through the booking form and I will provide an accurate price estimate.',
                    'sr' => 'Cena zavisi od veličine tetovaže, pozicije na telu i nivoa detalja. Pošaljite opis ideje kroz formu za zakazivanje i dobićete okvirnu procenu.',
                ],
            ],
            [
                'question' => [
                    'en' => 'How should I prepare for my tattoo appointment?',
                    'sr' => 'Kako da se pripremim za sesiju tetoviranja?',
                ],
                'answer' => [
                    'en' => 'Be well hydrated, get a good night of sleep, and eat a substantial meal before arriving. Please avoid alcohol, caffeine spikes, and psychoactive substances.',
                    'sr' => 'Važno je da budete dobro odmorni, hidrirani i da obavezno jedete pre dolaska. Molimo vas da izbegavate alkohol i psihoaktivne supstance.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Can I bring a friend to the appointment?',
                    'sr' => 'Mogu li povesti nekoga sa sobom?',
                ],
                'answer' => [
                    'en' => 'Yes, but please let me know in advance so we can ensure a comfortable, quiet, and focused studio atmosphere.',
                    'sr' => 'Da, ali me obavestite unapred kako bismo organizovali prostor i održali mirnu atmosferu za rad.',
                ],
            ],
            [
                'question' => [
                    'en' => 'How do I take care of my tattoo?',
                    'sr' => 'Kako da pravilno negujem novu tetovažu?',
                ],
                'answer' => [
                    'en' => 'Following aftercare instructions is crucial for optimal healing. You will receive a free tattoo care kit with all necessary products and detailed printed instructions upon completing your session.',
                    'sr' => 'Pravilna nega je ključna za dugovečnost i izgled tetovaže. Nakon sesije dobićete besplatan set za negu sa svim proizvodima i štampanim uputstvima.',
                ],
            ],
            [
                'question' => [
                    'en' => 'Are touch-ups free?',
                    'sr' => 'Da li su korekcije besplatne?',
                ],
                'answer' => [
                    'en' => 'Free touch-ups apply to tattoos that have been properly cared for according to the given instructions during the healing phase.',
                    'sr' => 'Besplatne korekcije važe za tetovaže koje su tretirane striktno prema datim uputstvima za negu tokom perioda zarastanja.',
                ],
            ],
        ];

        Page::updateOrCreate(
            ['slug->en' => 'faq'],
            [
                'type' => PageType::STANDARD->value,
                'title' => [
                    'en' => 'FAQ & Consultations | DamianaInkArt',
                    'sr' => 'Često Postavljana Pitanja | DamianaInkArt',
                ],
                'slug' => [
                    'en' => 'faq',
                    'sr' => 'faq',
                    'it' => 'faq',
                ],
                'is_visible' => true,
                'content' => [
                    [
                        'type' => 'faq_block',
                        'data' => [
                            'section_tag' => [
                                'en' => 'Information',
                                'sr' => 'Informacije',
                            ],
                            'heading' => [
                                'en' => 'Frequently Asked Questions',
                                'sr' => 'Često Postavljana Pitanja',
                            ],
                            'subtitle' => [
                                'en' => 'Everything you need to know about booking, consultations, deposits, and aftercare.',
                                'sr' => 'Sve što treba da znate o zakazivanju, konsultacijama, depozitima i negi.',
                            ],
                            'items' => $faqItems,
                        ],
                    ],
                ],
            ]
        );

        // ==========================================
        // 6. TERMS PAGE
        // ==========================================
        Page::updateOrCreate(
            ['type' => PageType::TERMS_AND_CONDITIONS->value],
            [
                'title' => [
                    'en' => 'Terms & Privacy | DamianaInkArt Studio',
                    'sr' => 'Uslovi i Privatnost | DamianaInkArt Studio',
                ],
                'slug' => [
                    'en' => 'terms',
                    'sr' => 'uslovi',
                    'it' => 'termini',
                ],
                'is_visible' => true,
                'content' => [
                    [
                        'type' => 'text_block',
                        'data' => [
                            'body' => [
                                'en' => "<h2>Studio Policies & Booking Terms</h2><p>Welcome to DamianaInkArt Studio. By booking a consultation or appointment, you agree to the following terms:</p><h3>1. Deposit Policy</h3><p>To reserve an appointment, a non-refundable deposit is required. If you need to reschedule, you must provide notice at least 48 hours prior to your scheduled time to transfer your deposit to a new session date.</p><h3>2. Copyright & Artwork Ownership</h3><p>All sketches, concept drawings, and tattoo designs created by Damiana remain the exclusive intellectual and artistic property of DamianaInkArt. Reproducing, copying, or tattooing these designs elsewhere is strictly prohibited.</p><h3>3. Age & Health Requirements</h3><p>Clients must be at least 18 years of age. Please inform the artist in advance regarding any relevant medical conditions, allergies, or medications.</p>",
                                'sr' => "<h2>Pravila Studija i Uslovi Zakazivanja</h2><p>Dobrodošli u DamianaInkArt studio. Zakazivanjem konsultacija ili termina prihvatate sledeće uslove:</p><h3>1. Politika Depozita</h3><p>Za rezervaciju termina obavezan je nepovratni depozit. Ukoliko morate promeniti datum, neophodno je da se javite najmanje 48 sati pre zakazanog termina kako bi depozit bio prebačen na novi datum.</p><h3>2. Autorska Prava na Dizajn</h3><p>Sve skice, koncepti i crteži koje Damiana kreira ostaju isključivo autorsko vlasništvo studija DamianaInkArt. Zabranjeno je kopiranje ili tetoviranje ovih dizajna kod drugih umetnika.</p><h3>3. Starost i Zdravstveni Uslovi</h3><p>Klijenti moraju imati najmanje 18 godina. Obavezno obavestite umetnicu o svim medicinskim stanjima ili alergijama pre početka sesije.</p>",
                            ],
                        ],
                    ],
                ],
            ]
        );

        // ==========================================
        // 7. MENUS & NAVIGATION TREES
        // ==========================================
        $headerMenu = Menu::firstOrCreate(
            ['key' => 'primary'],
            ['name' => 'Header Navigation']
        );

        // Clean existing items before repopulating
        MenuItem::where('menu_id', $headerMenu->id)->delete();

        $headerLinks = [
            ['title' => ['en' => 'Home', 'sr' => 'Početna'], 'url' => ['en' => '/en', 'sr' => '/sr'], 'order' => 1],
            ['title' => ['en' => 'Gallery', 'sr' => 'Galerija'], 'url' => ['en' => '/en/gallery', 'sr' => '/sr/galerija'], 'order' => 2],
            ['title' => ['en' => 'FAQ', 'sr' => 'FAQ'], 'url' => ['en' => '/en/faq', 'sr' => '/sr/faq'], 'order' => 3],
            ['title' => ['en' => 'Terms', 'sr' => 'Uslovi'], 'url' => ['en' => '/en/terms', 'sr' => '/sr/uslovi'], 'order' => 4],
            ['title' => ['en' => 'Book Now', 'sr' => 'Zakaži'], 'url' => ['en' => '/en#booking', 'sr' => '/sr#booking'], 'order' => 5],
        ];

        foreach ($headerLinks as $link) {
            MenuItem::create([
                'menu_id' => $headerMenu->id,
                'order' => $link['order'],
                'title' => $link['title'],
                'custom_url' => $link['url'],
                'is_visible' => true,
            ]);
        }

        // ==========================================
        // 8. SET ACTIVE THEME TO DAMIANA-INK
        // ==========================================
        Setting::updateOrCreate(
            ['key' => 'active_theme'],
            ['value' => 'damiana-ink', 'type' => 'text']
        );

        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => 'DamianaInkArt Studio', 'type' => 'text']
        );

        Setting::updateOrCreate(
            ['key' => 'theme_menu_locations'],
            ['value' => json_encode(['primary' => $headerMenu->id, 'footer' => $headerMenu->id]), 'type' => 'json']
        );

        // ==========================================
        // 9. IMPORT REAL MIGRATED IMAGES IF AVAILABLE
        // ==========================================
        if (file_exists(storage_path('app/import/damiana-images.json'))) {
            \Illuminate\Support\Facades\Artisan::call('damiana:import-images');
        }
    }
}
