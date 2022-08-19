<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Document extends Model implements \Finite\StatefulInterface
{
    use HasFactory;

   public $workflowUser;
    public $transitionReason;
    protected $machine;

    protected $fillable = [
        'user_id',
        'original_filename'

    ];


    protected $statusArray = [
        'submitted' => 'Borrador',
        'received' => 'Recibido',
        'invoiced' => 'Facturado',
        'pre-invoiced' => 'Pre Facturado',
        'paid-vehicle' => 'Pagado a Vehículo',
        'paid-trailer' => 'Pagado a Remolque',
        'undefined' => 'No definido'
    ];


    protected $workflowConfig = [
        'class' => '\App\Models\Document',
        'states' => [
            'submitted' => ['type' => \Finite\State\StateInterface::TYPE_INITIAL, 'properties' => []],
            'onprocessing' => ['type' => \Finite\State\StateInterface::TYPE_NORMAL, 'properties' => []],
            'processed' => ['type' => \Finite\State\StateInterface::TYPE_NORMAL, 'properties' => []],
        ],
        'transitions' => [
            'document-processing' => ['from' => ['submitted'], 'to' => 'onprocessing'],
            'document-processed' => ['from' => ['onprocessing'], 'to' => 'processed'],
        ],
        'callbacks' => [
            // 'after' => [
            //     [
            //         'do' => ['\App\Models\Document', 'auditStates'],
            //     ],
            // ],
        ],
    ];

    public function initWorkflow(\App\Models\User $user)
    {
        $this->workflowUser = $user;
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


    public function getFiniteState()
    {
        return $this->status;
    }
    public function setFiniteState($state)
    {
        $this->status = $state;
    }

       public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


}
