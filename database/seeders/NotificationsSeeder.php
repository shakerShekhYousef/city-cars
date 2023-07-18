<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UuidUuid;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // 'uuid',
		// 'title',
		// 'body',
		// 'sender',
		// 'receiver',
		// 'notification_type',
		// 'request'
        Notification::updateOrCreate([
            'uuid' => UuidUuid::uuid4()->toString(),
            'title' => "Request Accepted",
            'body' => "Your request is accepted",
            'sender' => "1",
            'receiver' => "1",
            'notification_type' => "request_accepted",
            'request' => "1",
        
        ]);

      

       

    }
}
