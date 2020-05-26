<?php

use App\Provider;
use App\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       // Model::unguard();

        $providers= [
        	'Thế giới di động' =>  'https://brasol.vn/public/ckeditor/uploads/tin-tuc/1-logo-the-gioi-di-song-dien-may-xanh.jpg',
        	'Fpt shop' => 'https://internetvietnam.net/wp-content/uploads/2019/08/logo-fpt.jpg',
        	'CellphoneS'=> 'hhttps://cellphones.com.vn/media/cps-images/logo-s.png',
            'Viettel Store' => 'http://dongphucvnxk.com/wp-content/uploads/2019/08/logo-viettelstore.png',
            'Hoàng hà mobile' => 'https://yt3.ggpht.com/a/AGF-l7_vDv3ioYCJv786Pwuz6yR8fnQoNZiVriWjrg=s900-c-k-c0xffffffff-no-rj-mo',
            'Điện máy chợ lớn' => '',
        ];
        foreach ($providers as $key => $value){
        	Provider::firstOrCreate([
        		'provider_name'=>$key,
                'link_logo'=>$value
        	]);
        };
       // Model::reguard();
    }
}
