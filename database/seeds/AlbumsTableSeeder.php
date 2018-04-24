<?php

use Illuminate\Database\Seeder;
use App\Album;
use App\Photo;
use Faker\Factory;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$self = $this;
    	\File::deleteDirectory(storage_path('app'), true);
        factory(Album::class, 20)
        	->create()
        	->each(function($album) use ($self) {
        		$self->generatePhotos($album);
        	});
    }

    private function generatePhotos(Album $album)
    {
		$albumDir = storage_path("app\\{$album->id}");
		
		\File::makeDirectory($albumDir);

		$faker = Factory::create();

		factory(Photo::class, 5)
        	->make()
        	->each(function($photo) use ($album, $faker, $albumDir) {
        		$photo->album_id = $album->id;
        		$photo->file_name = $faker->image($albumDir, 640, 480, 'technics', false);
        		$photo->save();
        	});
    }
}
