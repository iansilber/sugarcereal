<?php

trait RejectedTrait {
	public static function bootPublishedTrait() {
		static::addGlobalScope(new BidRejectedScope);
	}

	public static function withRejected() {
		return with(new static)->newQueryWithoutScope(new BidRejectedScope);
	}
}