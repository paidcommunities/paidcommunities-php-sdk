<?php

namespace PaidCommunities\Service;

interface ServiceInterface {

	public function request($method, $path);
}