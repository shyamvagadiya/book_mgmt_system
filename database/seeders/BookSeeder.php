<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fakerapi.it/api/v1/books?_quantity=100",// your preferred link
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            foreach(json_decode($response)->data as $data)
            {
                $data=(array) $data;
                $addBook=new \App\Models\Book;
                $addBook->title=$data["title"];
                $addBook->author=$data["author"];
                $addBook->genre=$data["genre"];
                $addBook->description=$data["description"];
                $addBook->isbn=$data["isbn"];
                $addBook->image=$data["image"];
                $addBook->published=$data["published"];
                $addBook->publisher=$data["publisher"];
                $addBook->save();
            }
        }
    }
}
