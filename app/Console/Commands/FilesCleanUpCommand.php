<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesCleanUpCommand extends Command
{
    protected $signature = 'files:cleanup {--directory=*} {--age=7}';

    protected $description = 'Cleanup of all the files, not directories, from the specified directories over a certain age.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $directories = $this->option("directory") ? $this->option("directory") : [0 => 'temp'];
        $files = [];
        $daysOld = "-".$this->option("age")." days";
        $age = new Carbon($daysOld);

        foreach ($directories as $directory){
            $files = array_merge($files, Storage::disk("local")->files($directory));
        }
        $deleted_files = [];
        foreach($files as $file){
            $fileAge = Carbon::createFromTimestamp(Storage::disk("local")->lastModified($file));

            if($fileAge < $age){
                Storage::disk("local")->delete($file);
                $deleted_files[] = $file;
            };
        }
        $this->info(count($deleted_files)." files deleted.");
        if(count($deleted_files) > 0){
            foreach($deleted_files as $deleted_file){
                $this->info("Deleted: ".$deleted_file);
            }
        }
    }
}
