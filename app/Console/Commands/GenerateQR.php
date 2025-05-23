<?php

namespace App\Console\Commands;

use App\Models\Activities;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQR extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:generate {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate QR';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // teacher for testing
        $teacherId = auth()->id();

        if (! $teacherId) {
            $teacher = User::where('username', 'teacherTest')->first();
            if (! $teacher) {
                throw new \Exception('Default teacher user not found');
            }
            $teacherId = $teacher->id;
        }

        // activityName choose
        $name = $this->argument('name') ?? 'attendance @' . now()->format('H:i');

        $activity = Activities::create([
            'activityName' => $name,
            'qrCode' => (string) Str::uuid(),
            'createdBy' => $teacherId,
        ]);

        $this->info("QR generated! Token: " . $activity->qrCode);
        return 0;
    }
}
