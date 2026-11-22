<?php

namespace Tests\Feature;

use App\Jobs\CreatePhotoTumbnailJob;
use App\Model\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class UpgradeCompatibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'auth.access_code' => '']);
        DB::purge('sqlite');
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('screen_name');
            $table->string('view_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->text('token')->nullable();
            $table->text('token_sec')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->unsignedBigInteger('event_admin_id');
            $table->text('event_detail')->nullable();
            $table->text('description')->nullable();
            $table->text('icon_path')->nullable();
            $table->dateTime('event_period_start');
            $table->dateTime('event_period_end');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id('event_participants_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('photos', function (Blueprint $table) {
            $table->id('photo_id');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->string('store_path');
            $table->timestamps();
            $table->softDeletes();
        });

        User::create([
            'user_id' => 1,
            'screen_name' => 'tester',
            'password' => Hash::make('password'),
            'token' => 'token',
            'token_sec' => 'secret',
        ]);
    }

    public function test_login_and_event_list(): void
    {
        $this->get('/login')->assertOk();
        $this->post('/login', ['screen_name' => 'tester', 'password' => 'password'])
            ->assertRedirect('/event/joined');
        $this->assertAuthenticated();
        $this->getJson('/api/event/list/joined')->assertOk()->assertJsonPath('body', []);
    }

    public function test_event_creation_with_icon(): void
    {
        Storage::fake('local');
        $image = new \Imagick();
        $image->newImage(10, 10, new \ImagickPixel('red'), 'jpeg');

        $response = $this->withHeaders(['X-User-Token' => 'token', 'X-User-Token-Sec' => 'secret'])
            ->postJson('/api/event/create', [
                'eventName' => 'album',
                'eventPeriodStart' => '2026-01-01',
                'eventPeriodEnd' => '2026-12-31',
                'icon' => UploadedFile::fake()->createWithContent('icon.jpg', $image->getImageBlob()),
            ]);

        $response->assertOk()->assertJsonPath('body.eventName', 'album');
        Storage::assertExists($response->json('body.iconPath'));
        $this->assertDatabaseHas('event_participants', ['event_id' => $response->json('body.eventId'), 'user_id' => 1]);
    }

    public function test_photo_processing_and_zip_download(): void
    {
        Storage::fake('local');
        Event::fake();

        DB::table('events')->insert([
            'event_id' => 1,
            'event_name' => 'album',
            'event_admin_id' => 1,
            'event_period_start' => '2026-01-01 00:00:00',
            'event_period_end' => '2026-12-31 23:59:59',
        ]);
        DB::table('event_participants')->insert(['event_id' => 1, 'user_id' => 1]);

        $image = new \Imagick();
        $image->newImage(10, 10, new \ImagickPixel('red'), 'jpeg');
        Storage::put('photos/example', $image->getImageBlob());
        Storage::makeDirectory('thumbnails/photos');
        (new CreatePhotoTumbnailJob('photos/example', 'thumbnails/photos', 'example', 1, 1, 'photos'))->handle();
        Storage::assertExists('thumbnails/photos/example');
        $this->assertDatabaseHas('photos', ['event_id' => 1, 'user_id' => 1, 'store_path' => 'photos/example']);

        $this->withoutExceptionHandling();
        $response = $this->withHeaders(['X-User-Token' => 'token', 'X-User-Token-Sec' => 'secret'])
            ->get('/api/event/zip/1');
        $response->assertOk();
        $zipPath = tempnam(sys_get_temp_dir(), 'pict-zip-');
        try {
            file_put_contents($zipPath, $response->streamedContent());
            $zip = new ZipArchive();
            $this->assertTrue($zip->open($zipPath));
            $this->assertNotFalse($zip->getFromName('tester/example.jpg'));
            $zip->close();
        } finally {
            unlink($zipPath);
        }
    }
}
