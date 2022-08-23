<?php

namespace App\Console\Commands;

use App\Models\Cable;
use App\Models\Material;
use App\Models\Terminal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ListDeleteMaterialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'material:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina relacion con familia de materiales en materiales previamente eliminados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $families = Material::TYPES;
        foreach ($families as $family) {
            $model = "App\Models\\" . Str::ucfirst($family);
            $this->deleteMaterial($model, $family);
        }
        return 0;
    }

    public function deleteMaterial($model, $family)
    {
        $relation = $family == 'terminal' ? 'materialId' : 'material';
        $familyMaterials = $model::whereDoesntHave($relation)->get();
        $familyMaterials->each(function ($familyMaterial) use ($family) {
            $familyMaterial->delete();
            $this->info($family . ' ' . $familyMaterial->id . ' removed successfully');
        });
    }
}
