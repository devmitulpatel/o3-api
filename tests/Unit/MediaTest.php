<?php

namespace Tests\Unit;

use Illuminate\Database\QueryException;
use Storage;
use App\Models\Media;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MediaTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();
    }

    /** @test */
    public function files_can_be_uploaded()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('image.jpg');

        $media = Media::make('uploads')->upload($file);

        Storage::assertExists($media->path);

        $this->assertSame(Storage::get($media->path), $file->get());
    }

    /** @test */
    public function it_can_not_be_created_if_user_is_not_authenticated()
    {
        $file = UploadedFile::fake()->image('image.jpg');

        $this->expectException(QueryException::class);

        $media = Media::make('uploads')->upload($file);

        $this->assertDatabaseMissing($media->getTable(), $media->toArray());
    }

    /** @test */
    public function it_can_be_tagged()
    {
        $media = Media::factory()->create();

        $media->tag('test')->save();

        $this->assertSame($media->tag, 'test');
    }

    /** @test */
    public function file_should_be_removed_on_deleting_media()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('image.jpg');

        $media = Media::make('uploads')->upload($file);

        $media->delete();

        Storage::assertMissing($media->path);

        $this->assertDatabaseMissing($media->getTable(), $media->toArray());
    }

    /** @test */
    public function it_should_have_32_char_unique_id()
    {
        $media = Media::factory()->create();

        $this->assertSame(32, strlen($media->id));
    }

    /** @test */
    public function it_should_have_user()
    {
        $this->signIn();

        $file = UploadedFile::fake()->image('image.jpg');

        $media = Media::make('uploads')->upload($file);

        $this->assertTrue($media->user->is(auth()->user()));
    }
}
