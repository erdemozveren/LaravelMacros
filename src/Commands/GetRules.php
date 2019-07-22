<?php

namespace erdemozveren\LaravelMacros\Commands;

use Illuminate\Console\Command;
use erdemozveren\LaravelMacros\Helpers\Generator;
class GetRules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravelmacros:getrules {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get validation rules for given table';

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
     * @return mixed
     */
    public function handle()
    {
        $table=$this->argument("table");
        $g=new Generator($table);
        $this->info("Generating validating rules for <bg=blue>".$table."</>");
        $rules=$g->validationRules()["rules"];
        $this->info('<fg=red>protected $rules = [</>');
        foreach ($rules as $key => $value) {
            $this->line("\t<fg=cyan>\"$key\"</>=><fg=cyan>\"$value\"</>,");
        }
        
        $this->line('<fg=red>];</>');
        $this->info("Those are just basic rules that generated from column info,<bg=red>check before using them.</>");
    }
    
}
