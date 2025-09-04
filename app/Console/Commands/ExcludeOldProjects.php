<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExcludeOldProjects extends Command
{

    protected $signature = 'projects:exclude-old';


    protected $description = 'Command description';


    public function handle()
    {
        $dateLimit = Carbon::now()->subDays(30);

        DB::beginTransaction();
        try {
            $projects = Project::where('status', 'قيد الانتظار')
                ->where('created_at', '<=', $dateLimit)
                ->get();

            foreach ($projects as $project) {
                $project->status = 'مستبعد';
                $project->save();
            }

            $this->info(count($projects) . ' projects have been excluded.');
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error("❌ Failed to process project {$project->id}: " . $e->getMessage());
        }
    }
}
