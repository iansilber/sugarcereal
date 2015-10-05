<?php

use Illuminate\Database\Query\Builder as BaseBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\\Database\Eloquent\ScopeInterface;

class BidRejectedScope implements ScopeInterface {
	public function apply(Builder $builder, Model $model) {
		$builder->where('rejected', '!=', 1);
	}
}