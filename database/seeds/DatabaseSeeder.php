<?php

use Illuminate\Database\Seeder;
use App\Models\ { User, Address, Category, Country, Product, Colissimo, Range, Shop, State, Page, Order };
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Country::insert([
            ['name' => 'France', 'tax' => 0.2],
            ['name' => 'Belgique', 'tax' => 0.2],
            ['name' => 'Suisse', 'tax' => 0],
            ['name' => 'Canada', 'tax' => 0],
        ]);
        Range::insert([
            ['max' => 1],
            ['max' => 2],
            ['max' => 3],
            ['max' => 100],
        ]);
        Colissimo::insert([
            ['country_id' => 1, 'range_id' => 1, 'price' => 7.25],
            ['country_id' => 1, 'range_id' => 2, 'price' => 8.95],
            ['country_id' => 1, 'range_id' => 3, 'price' => 13.75],
            ['country_id' => 1, 'range_id' => 4, 'price' => 0],
            ['country_id' => 2, 'range_id' => 1, 'price' => 15.5],
            ['country_id' => 2, 'range_id' => 2, 'price' => 17.55],
            ['country_id' => 2, 'range_id' => 3, 'price' => 22.45],
            ['country_id' => 2, 'range_id' => 4, 'price' => 0],
            ['country_id' => 3, 'range_id' => 1, 'price' => 15.5],
            ['country_id' => 3, 'range_id' => 2, 'price' => 17.55],
            ['country_id' => 3, 'range_id' => 3, 'price' => 22.45],
            ['country_id' => 3, 'range_id' => 4, 'price' => 0],
            ['country_id' => 4, 'range_id' => 1, 'price' => 27.65],
            ['country_id' => 4, 'range_id' => 2, 'price' => 38],
            ['country_id' => 4, 'range_id' => 3, 'price' => 55.65],
            ['country_id' => 4, 'range_id' => 4, 'price' => 0],
        ]);
        State::insert([
            ['name' => 'Attente chèque', 'slug' => 'cheque', 'color' => 'blue', 'indice' => 1],
            ['name' => 'Attente mandat administratif', 'slug' => 'mandat', 'color' => 'blue', 'indice' => 1],
            ['name' => 'Attente virement', 'slug' => 'virement', 'color' => 'blue', 'indice' => 1],
            ['name' => 'Attente paiement par carte', 'slug' => 'carte', 'color' => 'blue', 'indice' => 1],
            ['name' => 'Attente paiement paypal', 'slug' => 'paypal', 'color' => 'blue', 'indice' => 1],
            ['name' => 'Erreur de paiement', 'slug' => 'erreur', 'color' => 'red', 'indice' => 0],
            ['name' => 'Annulé', 'slug' => 'annule', 'color' => 'red', 'indice' => 2],
            ['name' => 'Mandat administratif reçu', 'slug' => 'mandat_ok', 'color' => 'green', 'indice' => 3],
            ['name' => 'Paiement accepté', 'slug' => 'paiement_ok', 'color' => 'green', 'indice' => 4],
            ['name' => 'Expédié', 'slug' => 'expedie', 'color' => 'green', 'indice' => 5],
            ['name' => 'Remboursé', 'slug' => 'rembourse', 'color' => 'red', 'indice' => 6],
        ]);
        Shop::insert([
            [
                'name' => 'KopaChic',
                'address' => '15 rue Montesquieu 33000 Bordeaux',
                'email' => 'kopachic@fgainza.fr',
                'phone' => '06 10 20 30 40',
                'holder' => 'STE HAURT',
                'bic' => 'CMCIFRPP',
                'iban' => 'FR7612548029989876543210917',
                'bank' => 'Credit Mutuel',
                'bank_address' => 'Place de la Mairie 33400 Talence',
                'facebook' => 'https://www.facebook.com/KopaChic',
                'home' => 'Informations'
            ],
        ]);
        factory(User::class, 20)
          ->create()
          ->each(function ($user) {
              $user->addresses()->createMany(
                  factory(Address::class, mt_rand(2, 3))->make()->toArray()
              ); 
        });
        $user = User::find(1);
        $user->firstname = 'Admin';
        $user->name = 'Admin';
        $user->email = 'admintest@fgainza.fr';
        $user->admin = true;
        $user->save();

        $users = User::all();
        foreach($users as $e){
           $addresses = $e->addresses;
           $e->principale = $addresses->first()->id;
           $e->save();
            foreach($addresses as $address){
                DB::table('address_user')->insert(array(
                    'user_id' => $e->id,
                    'address_id' => $address->id
                ));
            }
        }

        // factory(Product::class, 6)->create();
        factory(Category::class, 5)->create()->each(function ($category) {
            $i = rand(2, 7);
            while (--$i) {
                $category->products()->save(factory(Product::class)->make());
            }
        });

        $items = [
            ['livraisons', 'Livraisons'],
            ['mentions-legales', 'Mentions légales'],
            ['conditions-generales-de-vente', 'Conditons générales de vente'],
            ['politique-de-confidentialite', 'Politique de confidentialité'],
            ['respect-environnement', 'Respect de l\'environnement'],
            ['mandat-administratif', 'Mandat administratif'],
        ];
        foreach($items as $item) {
            factory(Page::class)->create([
                'slug' => $item[0],
                'title' => $item[1],
            ]);
        }
        factory(Order::class, 30)
          ->create()
          ->each(function ($order) {
              $address = $order->user->addresses()->take(1)->get()->makeHidden(['id', 'user_id'])->toArray();
              $order->adresses()->create($address[0]);
              if(mt_rand(0, 1)) {
                  $address = $order->user->addresses()->skip(1)->take(1)->get()->makeHidden(['id', 'user_id'])->toArray();
                  $address[0]['facturation'] = false;
                  $order->adresses()->create($address[0]);
              }
              $countryId = $address[0]['country_id'];
              $total = 0;
              $product = Product::find(mt_rand(1, 3));
              $quantity = mt_rand(1, 3);
              $price = $product->price * $quantity;
              $total = $price;
              $order->products()->create(
                  [
                      'name' => $product->name,
                      'total_price_gross' => $price,
                      'quantity' => $quantity,
                  ]
              );
              if(mt_rand(0, 1)) {
                  $product = Product::find(mt_rand(4, 6));
                  $quantity = mt_rand(1, 3);
                  $price = $product->price * $quantity;
                  $total += $price;
                  $order->products()->create(
                      [
                          'name' => $product->name,
                          'total_price_gross' => $price,
                          'quantity' => $quantity,
                      ]
                  );
              }
              if($order->payment === 'carte' && $order->state_id === 8) {
                  $order->payment_infos()->create(['payment_id' => (string) Str::uuid()]);
              }
              $order->tax = $countryId > 2 ? 0 : .2;
              $order->total = $total;
              $order->save();
        });
    }
}
