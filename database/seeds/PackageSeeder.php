<?php

use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([[
            'title' => 'Trip to Rara',
            'slug' => 'trip-to-rara',
            'description' => 'Trip to beautiful lake Rara',
            'destination' => 'Mugu, Nepal',
            'featured' => '1',
            'special_offer' => '1',
            'images' => 'http://raravillage.com/wp-content/uploads/2017/04/banner6.jpg',
            'inclusions' => 'Free Wifi, 3-Star Hotels, Horse Riding',
            'highlights' => 'Awesome Lake',
            'tags' => 'Lakes, Hiking',
            'duration' => '5',
            'travel_option' => 'Flight, Bus',
            'created_by' => '1'
        ]]);
        DB::table('commence_dates')->insert([
            ['package_id' => '1',
            'commence_date' => '2023-06-27',
            'max_per_commence' => '3',
            'price' => '5000'],
            ['package_id' => '1',
            'commence_date' => '2023-12-27',
            'max_per_commence' => '4',
            'price' => '5000'],
            ['package_id' => '1',
            'commence_date' => '2023-06-27',
            'max_per_commence' => '3',
            'price' => '5000'],
            ['package_id' => '1',
            'commence_date' => '2023-12-27',
            'max_per_commence' => '4',
            'price' => '5000']
        ]);
        DB::table('hotels')->insert([
            ['name' => 'Surkhet Hotel',
            'images' => 'https://s-ec.bstatic.com/images/hotel/max1024x768/121/121816501.jpg',
            'description' => "Great Hotel",
            'inclusions' => 'Free Wifi, Attached Bathroom',
            'address' => 'Surkhet',
            'star_ratings' => '4.5'],

            ['name' => 'Dailekh Hotel',
            'images' => 'https://www.tourismmail.com/public/uploads/2018/08/Stay-Hotel-Valley-View-Surkhet.jpg',
            'description' => "Awesome Dailekh Hotel",
            'inclusions' => 'Free Wifi, Attached Bathroom, Great view',
            'address' => 'Dailekh',
            'star_ratings' => '4'],

            ['name' => 'Kalikot Hotel',
            'images' => 'https://pbs.twimg.com/media/DBioa3XU0AA1AvI.jpg',
            'description' => "Awesome Kalikot Hotel",
            'inclusions' => 'Free Wifi, Attached Bathroom, Friendly Staffs, Great view',
            'address' => 'Kalikot',
            'star_ratings' => '3'],

            ['name' => 'Rara Hotel',
            'images' => 'http://raravillage.com/wp-content/uploads/2017/04/banner6.jpg',
            'description' => "Awesome Rara Hotel",
            'inclusions' => 'Free Wifi, Attached Bathroom, Lake view',
            'address' => 'Rara',
            'star_ratings' => '5'],
        ]);


        DB::table('itinerary')->insert([
            ['package_id' => '1',
            'day' => '1',
            'title' => 'Kathmandu to Surkhet',
            'inclusions' => 'Bus Ride, Siteseeing, Breakfast, Light Snacks, Dinner',
            'images' => 'https://i.ytimg.com/vi/EkEO2EOhu2s/maxresdefault.jpg',
            'description' => 'We will be riding on bus the whole day',
            'key_activities' => 'Bus Ride, Siteseeing',
            'destination_place' => 'Surkhet',
            'end_of_day' => 'hotel:1'],

            ['package_id' => '1',
            'day' => '2',
            'title' => 'Surkhet to Dailekh',
            'inclusions' => 'Bus Ride, Siteseeing, Breakfast, Light Snacks, Dinner',
            'images' => 'https://1hu9t72zwflj44abyp2h0pfe-wpengine.netdna-ssl.com/wp-content/uploads/2016/06/Lord-Narayan-in-Panchadewal-of-Dailekh.jpg',
            'description' => 'We will be riding on bus the whole day',
            'key_activities' => 'Bus Ride, Siteseeing',
            'destination_place' => 'Dailekh',
            'end_of_day' => 'hotel:2'],

            ['package_id' => '1',
            'day' => '3',
            'title' => 'Dailekh to Kalikot',
            'inclusions' => 'Bus Ride, Siteseeing, Breakfast, Light Snacks, Dinner',
            'images' => 'http://3.bp.blogspot.com/-ypilUrL826I/UdWJbLa-OrI/AAAAAAAAAV0/DrWHBCHbj7M/s1600/Kalikot+709.JPG',
            'description' => 'We will be riding on bus the whole day',
            'key_activities' => 'Bus Ride, Siteseeing',
            'destination_place' => 'Kalikot',
            'end_of_day' => 'hotel:3'],

            ['package_id' => '1',
            'day' => '4',
            'title' => 'Kalikot to Rara',
            'inclusions' => 'Bus Ride, Siteseeing, Breakfast, Light Snacks, Dinner',
            'images' => 'https://www.welcomenepal.com/uploads/destination/rara-iw-adventure.jpeg',
            'description' => 'We will be riding on bus the whole day',
            'key_activities' => 'Bus Ride, Siteseeing',
            'destination_place' => 'Rara',
            'end_of_day' => 'hotel:4'],

            ['package_id' => '1',
            'day' => '5',
            'title' => 'Rara to Kathmandu',
            'inclusions' => 'Bus Ride, Siteseeing, Breakfast, Light Snacks, Dinner',
            'images' => 'https://d1ljaggyrdca1l.cloudfront.net/wp-content/uploads/2017/04/Kathmandu-Durbar-Square-nepal-1600x900.jpg',
            'description' => 'We will be riding on bus the whole day',
            'key_activities' => 'Bus Ride, Siteseeing',
            'destination_place' => 'Kathmandu',
            'end_of_day' => 'checkout'],
        ]);

        DB::table('additional_info')->insert([
            ['package_id'=>'1',
            'title'=>'FAQ',
            'description'=>'Yes We Make Your Trip Awesome'
            ],
            ['package_id'=>'1',
            'title'=>'Refund',
            'description'=>'Yes We Refund'
            ],
            ['package_id'=>'1',
            'title'=>'Cancellation',
            'description'=>'Yes Before 1 Month of Commencing Date'
            ],
        ]);

        /*DB::table('designer_meta')->insert([
            ['type'=>'package_inc',
            'name'=>'Free Wifi',
            'slug'=>'free-wifi',
            'description'=>'We Provide Free Wifi'
            ],
            ['type'=>'package_inc',
            'name'=>'3-Star Hotels',
            'slug'=>'3-star-hotels',
            'description'=>'We Provide 3-Star Hotels'
            ],
            ['type'=>'package_inc',
            'name'=>'Horse Riding',
            'slug'=>'horse-riding',
            'description'=>'We Provide Horse Riding'
            ],
            ['type'=>'package_tags',
            'name'=>'Lakes',
            'slug'=>'lakes',
            'description'=>'Packages that includes Lakes'
            ],
            ['type'=>'package_tags',
            'name'=>'Hiking',
            'slug'=>'hiking',
            'description'=>'Packages that includes hiking'
            ],
            ['type'=>'travel_option',
            'name'=>'Bus',
            'slug'=>'bus',
            'description'=>'Travel By Bus'
            ],
            ['type'=>'travel_option',
            'name'=>'Flight',
            'slug'=>'Flight',
            'description'=>'Travel By Plane'
            ],
            ['type'=>'hotel_inc',
            'name'=>'Free Wifi',
            'slug'=>'free-wifi',
            'description'=>'We Provide Free Wifi'
            ],
            ['type'=>'hotel_inc',
            'name'=>'Attached Bathroom',
            'slug'=>'attached-bathroom',
            'description'=>'We Provide Attached Bathroom'
            ],
            ['type'=>'hotel_inc',
            'name'=>'Friendly Staffs',
            'slug'=>'friendly-staffs',
            'description'=>'We Provide Friendly Staffs'
            ],
            ['type'=>'hotel_inc',
            'name'=>'Great view',
            'slug'=>'great-view',
            'description'=>'We Provide Great view'
            ],
        ]);*/
    }
}
