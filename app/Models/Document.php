<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Document extends Model implements \Finite\StatefulInterface
{
    use HasFactory;
    private $state;
    protected $machine;

    protected $fillable = [
        'user_id',
        'original_filename'

    ];


    public function getFiniteState()
    {
        return $this->state;
    }

    public function setFiniteState($state)
    {
        $this->state = $state;
    }

    protected $workflowConfig = [
        'class' => '\App\Models\Document',
        'states' => [
            'submitted' => ['type' => \Finite\State\StateInterface::TYPE_INITIAL, 'properties' => []],
            'onprocessing' => ['type' => \Finite\State\StateInterface::TYPE_NORMAL, 'properties' => []],
            'processed' => ['type' => \Finite\State\StateInterface::TYPE_FINAL, 'properties' => []],
        ],
        'transitions' => [
            'receive' => ['from' => ['submitted'], 'to' => 'onprocessing'],
            'processing' => ['from' => ['submitted'], 'to' => 'onprocessing'],
            'done' => ['from' => ['onprocessing'], 'to' => 'processed'],

        ],

    ];

    public function initWorkflow()
    {
        $this->machine = new \Finite\StateMachine\StateMachine();

        $loader = new \Finite\Loader\ArrayLoader($this->workflowConfig);
        $loader->load($this->machine);

        $this->machine->setObject($this);
        $this->machine->initialize();
    }

    /**
     * Intercepts calls to $this->machine.
     *
     * @param $name
     * @param $args
     */
    public function workflow($name, $args)
    {
        $returnValue = null;
        //  dd($this->machine);
        switch (count($args)) {
            case 0:
                $returnValue = $this->machine->{$name}();
                break;
            case 1:
                $returnValue = $this->machine->{$name}($args[0]);
                break;
            case 2:
                $returnValue = $this->machine->{$name}($args[0], $args[1]);
                break;
        }

        return $returnValue;
    }
}
