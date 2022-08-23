<?php

namespace App\Console\Commands;

use App\Models\Material;
use Illuminate\Console\Command;

class DeleteFamilyMaterialCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'families:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina materiales sin relacion con su familia';

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
        $materials = Material::all();
        $families = Material::TYPES; 
        
        $materials->each(function (Material $material) use ($families) {
            $model = $families[$material->family];  
            if (!$material->$model) { 
                $material->delete();
                $this->info('Eliminado el material codigo:' . $material->code);
            }
        });
        return 0;
    }
}
