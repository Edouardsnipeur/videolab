<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class ResizeImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $file;
    /**
     * @var array
     */
    private $formats;

    /**
     * Create a new job instance.
     *
     * @param File $file
     * @param array $formats
     */
    public function __construct(string $file, Array $formats)
    {
        //
        $this->file = $file;
        $this->formats = $formats;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->formats as $format){
            $curentdate=Carbon::now()->toDateString();
            $manager= new ImageManager();
            $manager->make($this->file)
                ->fit($format,$format)
                ->rotate(45)
                ->save(public_path('uploads/bar'.$curentdate.$format.'.jpg'));
        }
    }
}
