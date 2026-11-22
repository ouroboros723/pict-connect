<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class MigrationCompatibilityTest extends TestCase
{
    public function test_mysql_schema_creation_does_not_use_explicit_transactions(): void
    {
        // MySQL commits DDL implicitly, so an explicit transaction cannot be committed afterward.
        $migrations = [
            '2023_08_07_005038_create_photos_table' => ['CreatePhotosTable', 'photos'],
            '2023_08_07_005038_create_sns_id_lists_table' => ['CreateSnsIdListsTable', 'sns_id_lists'],
            '2023_08_07_005038_create_users_table' => ['CreateUsersTable', 'users'],
            '2023_08_08_205118_create_events_table' => ['CreateEventsTable', 'events'],
            '2023_09_04_135541_create_event_participants_table' => ['CreateEventParticipantsTable', 'event_participants'],
            '2023_09_07_203648_create_event_join_tokens_table' => ['CreateEventJoinTokensTable', 'event_join_tokens'],
            '2023_09_13_230144_create_album_access_authorities_table' => ['CreateAlbumAccessAuthoritiesTable', 'album_access_authorities'],
            '2023_09_13_232654_create_album_photos_table' => ['CreateAlbumPhotosTable', 'album_photos'],
            '2023_09_13_235110_create_album_masters_table' => ['CreateAlbumMastersTable', 'album_masters'],
            '2023_09_14_233714_create_guest_logins_table' => ['CreateGuestLoginsTable', 'guest_logins'],
        ];

        $database = DB::getFacadeRoot();
        $schema = Schema::getFacadeRoot();

        try {
            foreach ($migrations as $file => [$class, $table]) {
                require_once database_path("migrations/{$file}.php");
                Schema::shouldReceive('create')->once()->with($table, Mockery::type('Closure'));
                DB::shouldReceive('statement')->once()->with(Mockery::pattern("/^ALTER TABLE {$table} COMMENT /"));
                (new $class())->up();
            }
        } finally {
            DB::swap($database);
            Schema::swap($schema);
        }
    }
}
