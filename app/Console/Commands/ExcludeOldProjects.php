<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Carbon\Carbon;

class ExcludeOldProjects extends Command
{
   
    protected $signature = 'projects:exclude-old';

    
    protected $description = 'Command description';

    
    public function handle()
    {
        $dateLimit = Carbon::now()->subDays(30);

        $projects = Project::where('status', 'قيد الانتظار')
            ->where('created_at', '<=', $dateLimit)
            ->get();

        foreach ($projects as $project) {
            $project->status = 'مستبعد';
            $project->save();
        }

        $this->info(count($projects) . ' projects have been excluded.');
    
    }
}
