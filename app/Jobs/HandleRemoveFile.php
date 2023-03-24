<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleRemoveFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $folderName;
    public function __construct($folderName)
    {
        $this->folderName = $folderName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (file_exists(storage_path('app/' . $this->folderName))) {
            unlink(storage_path('app/' . $this->folderName));
        }
    }
}
