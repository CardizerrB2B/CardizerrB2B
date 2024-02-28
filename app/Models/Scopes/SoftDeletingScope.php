<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoftDeletingScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Check if the authenticated user is an admin
        if (request()->route()->middleware('auth:admin') || request()->route()->middleware('auth:super-admin')) {
            // If user is admin or super-admin, don't apply soft delete scope
            return;
        }

        //any other user
        if($model->getTable() == 'master_files')//if the model is master_files then apply the scope
        {
            $builder->whereNull('master_files.deleted_at');
            $builder->whereHas('subCategory', function ($query) {
                $query->whereNull('sub_categories.deleted_at');
                $query->whereHas('category', function ($query) {
                    $query->whereNull('categories.deleted_at');
                });
            });
        }elseif($model->getTable() == 'sub_categories')//if the model is sub_categories then apply the scope        
        {
            $builder->whereNull('sub_categories.deleted_at');
            $builder->whereHas('category', function ($query) {
                $query->whereNull('categories.deleted_at');
            });

        }
        else
        {
            $builder->whereNull($model->getQualifiedDeletedAtColumn());
        }
    }
}
