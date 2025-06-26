<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departmentModel extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name', 'description'];
    public $timestamps = true;

    /**
     * Get the name of the department.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the description of the department.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
