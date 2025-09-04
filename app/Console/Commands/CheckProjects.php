<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Transactions;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckProjects extends Command
{
    protected $signature = 'projects:check-completion';
    protected $description = 'Check projects deadlines and release payments if no dispute';

    public function handle()
    {
        $projects = Project::where('status', 'قيد التنفيذ')
            ->whereHas('offers', function ($query) {
                $query->where('status', 2);
            })
            ->with([
                'duration',
                'offers' => function ($query) {
                    $query->where('status', 2)
                        ->with('user');
                }
            ])->get();

        foreach ($projects as $project) {

            $acceptedOffer = $project->offers->first();
            $projectDuration = $project->duration;

            if (!$acceptedOffer || !$projectDuration) {
                continue;
            }

            $durationTranslation = $projectDuration->duration_name
                ->where('locale', 'en')
                ->first();

            if ($durationTranslation) {
                $endDate = match ($projectDuration->duration_name) {
                    'Days' => Carbon::parse($acceptedOffer->updated_at)->addDays($projectDuration->number),
                    'Week' => Carbon::parse($acceptedOffer->updated_at)->addWeeks($projectDuration->number),
                    'Month' => Carbon::parse($acceptedOffer->updated_at)->addMonths($projectDuration->number),
                    default => null,
                };
            }

            $finalDate = $endDate?->addDays(10);

            if ($finalDate && now()->greaterThan($finalDate) && $project->disputes()->count() == 0) {

                DB::beginTransaction();
                try {
                    // تغيير حالة المشروع
                    $project->update(['status' => 'مكتمل']);

                    // تحديث العمولة
                    Transactions::where('user_id', $project->receiver_user_id)
                        ->where('project_id', $project->id)
                        ->where('type', 'commission')
                        ->update(['status' => 'completed']);

                    // إنشاء معاملة لمقدم الخدمة
                    Transactions::create([
                        'user_id'     => $project->receiver_user_id,
                        'project_id'  => $project->id,
                        'amount'      => $project->prise,
                        'type'        => 'credit',
                        'status'      => 'completed',
                        'description' => 'Automatic release after project completion',
                    ]);

                    DB::commit();
                    $this->info("✅ Project {$project->id} marked as completed and payment released.");

                } catch (\Throwable $e) {
                    DB::rollBack();
                    $this->error("❌ Failed to process project {$project->id}: " . $e->getMessage());
                }
            }
        }
    }
}
